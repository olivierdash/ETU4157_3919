<?php

namespace app\models;

use Flight;
use PDO;

/**
 * ResourceDispatcher
 * Gère la simulation du dispatch de ressources pour chaque ville
 * avec 3 modes: FIFO (date), quantité minimum, et proportionnalité
 */
class ResourceDispatcher
{
    private $db;

    public function __construct()
    {
        $this->db = Flight::db();
    }

    /**
     * Récupère toutes les demandes de ressources groupées par type et ville
     * 
     * @return array
     */
    public function getAllDemandes()
    {
        $sql = "SELECT 
                    r.id AS ressource_id,
                    r.nom AS ressource_nom,
                    t.nom AS type_nom,
                    t.id AS type_id,
                    v.id AS ville_id,
                    v.nom AS ville_nom,
                    d.quantite,
                    d.date_don,
                    d.id AS don_id
                FROM dons d
                JOIN ressources r ON d.id_ressource = r.id
                JOIN type t ON r.type_id = t.id
                JOIN ville v ON r.ville_id = v.id
                ORDER BY t.id, d.date_don";
        
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère la quantité disponible pour une ressource
     * 
     * @param int $ressourceId
     * @return int
     */
    public function getAvailableQuantity($ressourceId)
    {
        $sql = "SELECT SUM(quantite) as total FROM dons WHERE id_ressource = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$ressourceId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int) ($result['total'] ?? 0);
    }

    /**
     * Mode 1: Dispatch par ordre de date (FIFO - First In First Out)
     * Le premier qui a demandé reçoit en premier
     * 
     * @return array
     */
    public function dispatchByDate()
    {
        $demandes = $this->getAllDemandes();
        $dispatch = [];

        // Grouper par ressource
        $ressources = [];
        foreach ($demandes as $demande) {
            $ressourceId = $demande['ressource_id'];
            if (!isset($ressources[$ressourceId])) {
                $ressources[$ressourceId] = [
                    'nom' => $demande['ressource_nom'],
                    'type' => $demande['type_nom'],
                    'quantite_totale' => $this->getAvailableQuantity($ressourceId),
                    'demandes' => []
                ];
            }
            $ressources[$ressourceId]['demandes'][] = $demande;
        }

        // Traiter chaque ressource
        foreach ($ressources as $ressourceId => $ressource) {
            $quantite_restante = $ressource['quantite_totale'];
            
            // Les demandes sont déjà triées par date
            foreach ($ressource['demandes'] as $demande) {
                $quantite_demandee = $demande['quantite'];
                
                if ($quantite_restante <= 0) {
                    $quantite_allouee = 0;
                } else if ($quantite_restante >= $quantite_demandee) {
                    $quantite_allouee = $quantite_demandee;
                } else {
                    $quantite_allouee = $quantite_restante;
                }
                
                $dispatch[] = [
                    'ressource_nom' => $ressource['nom'],
                    'type' => $ressource['type'],
                    'ville_demandeuse' => $demande['ville_nom'],
                    'date_demande' => $demande['date_don'],
                    'quantite_demandee' => $quantite_demandee,
                    'quantite_allouee' => $quantite_allouee,
                    'mode' => 'FIFO (Par date)'
                ];
                
                $quantite_restante -= $quantite_allouee;
            }
        }

        return $dispatch;
    }

    /**
     * Mode 2: Dispatch par ordre de quantité
     * La ville qui demande le moins reçoit en premier
     * 
     * @return array
     */
    public function dispatchByQuantity()
    {
        $demandes = $this->getAllDemandes();
        $dispatch = [];

        // Grouper par ressource
        $ressources = [];
        foreach ($demandes as $demande) {
            $ressourceId = $demande['ressource_id'];
            if (!isset($ressources[$ressourceId])) {
                $ressources[$ressourceId] = [
                    'nom' => $demande['ressource_nom'],
                    'type' => $demande['type_nom'],
                    'quantite_totale' => $this->getAvailableQuantity($ressourceId),
                    'demandes' => []
                ];
            }
            $ressources[$ressourceId]['demandes'][] = $demande;
        }

        // Traiter chaque ressource
        foreach ($ressources as $ressourceId => $ressource) {
            $quantite_restante = $ressource['quantite_totale'];
            
            // Trier les demandes par quantité croissante
            usort($ressource['demandes'], function($a, $b) {
                return $a['quantite'] - $b['quantite'];
            });
            
            foreach ($ressource['demandes'] as $demande) {
                $quantite_demandee = $demande['quantite'];
                
                if ($quantite_restante <= 0) {
                    $quantite_allouee = 0;
                } else if ($quantite_restante >= $quantite_demandee) {
                    $quantite_allouee = $quantite_demandee;
                } else {
                    $quantite_allouee = $quantite_restante;
                }
                
                $dispatch[] = [
                    'ressource_nom' => $ressource['nom'],
                    'type' => $ressource['type'],
                    'ville_demandeuse' => $demande['ville_nom'],
                    'date_demande' => $demande['date_don'],
                    'quantite_demandee' => $quantite_demandee,
                    'quantite_allouee' => $quantite_allouee,
                    'mode' => 'Par quantité croissante'
                ];
                
                $quantite_restante -= $quantite_allouee;
            }
        }

        return $dispatch;
    }

    /**
     * Mode 3: Dispatch par proportionnalité
     * Formule: (quantité demandée) / (quantité disponible * total des quantités demandées)
     * 
     * @return array
     */
    public function dispatchByProportionality()
    {
        $demandes = $this->getAllDemandes();
        $dispatch = [];

        // Grouper par ressource
        $ressources = [];
        foreach ($demandes as $demande) {
            $ressourceId = $demande['ressource_id'];
            if (!isset($ressources[$ressourceId])) {
                $ressources[$ressourceId] = [
                    'nom' => $demande['ressource_nom'],
                    'type' => $demande['type_nom'],
                    'quantite_totale' => $this->getAvailableQuantity($ressourceId),
                    'demandes' => []
                ];
            }
            $ressources[$ressourceId]['demandes'][] = $demande;
        }

        // Traiter chaque ressource
        foreach ($ressources as $ressourceId => $ressource) {
            $quantite_disponible = $ressource['quantite_totale'];
            
            // Calculer le total des quantités demandées
            $total_demandes = 0;
            foreach ($ressource['demandes'] as $demande) {
                $total_demandes += $demande['quantite'];
            }

            // Calculer la proportion pour chaque demande
            if ($total_demandes > 0) {
                foreach ($ressource['demandes'] as $demande) {
                    $proportion = $demande['quantite'] / $total_demandes;
                    $quantite_allouee = floor($quantite_disponible * $proportion);
                    
                    $dispatch[] = [
                        'ressource_nom' => $ressource['nom'],
                        'type' => $ressource['type'],
                        'ville_demandeuse' => $demande['ville_nom'],
                        'date_demande' => $demande['date_don'],
                        'quantite_demandee' => $demande['quantite'],
                        'quantite_allouee' => $quantite_allouee,
                        'proportion' => round($proportion * 100, 2),
                        'mode' => 'Proportionnalité'
                    ];
                }
            }
        }

        return $dispatch;
    }

    /**
     * Récupère les résultats du dispatch pour un mode spécifique
     * 
     * @param string $mode ('fifo', 'quantity', 'proportionality')
     * @return array
     */
    public function getDispatchByMode($mode = 'fifo')
    {
        return match($mode) {
            'fifo', 'date' => $this->dispatchByDate(),
            'quantity' => $this->dispatchByQuantity(),
            'proportionality' => $this->dispatchByProportionality(),
            default => $this->dispatchByDate()
        };
    }

    /**
     * Récupère un résumé comparatif des 3 modes de dispatch
     * 
     * @return array
     */
    public function getComparativeDispatch()
    {
        return [
            'fifo' => $this->dispatchByDate(),
            'quantity' => $this->dispatchByQuantity(),
            'proportionality' => $this->dispatchByProportionality()
        ];
    }
}
?>
