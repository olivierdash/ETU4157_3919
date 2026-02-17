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
     * Récupère toutes les DEMANDES (ressources) groupées par type de ressource
     * Chaque ressource peut être demandée par plusieurs villes
     */
    public function getDemandes()
    {
        $sql = "SELECT 
                    r.id AS ressource_id,
                    r.nom AS ressource_nom,
                    t.nom AS type_nom,
                    t.id AS type_id,
                    v.id AS ville_id,
                    v.nom AS ville_nom,
                    COUNT(d.id) AS nb_dons,
                    SUM(d.quantite) AS quantite_disponible,
                    MIN(d.date_don) AS date_premiere_demande,
                    MAX(d.date_don) AS date_derniere_demande
                FROM ressources r
                JOIN type t ON r.type_id = t.id
                JOIN ville v ON r.ville_id = v.id
                LEFT JOIN dons d ON d.id_ressource = r.id
                GROUP BY r.id, t.id
                ORDER BY t.id, r.nom, v.nom";
        
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Mode 1: Dispatch par ordre de date (FIFO - First In First Out)
     * Toutes les demandes triées par date globalement
     */
    public function dispatchByDate()
    {
        $demandes = $this->getDemandes();
        $dispatch = [];

        // Grouper par type+nom de ressource pour trouver les demandes concurrentes
        $ressources_groupees = [];
        foreach ($demandes as $demande) {
            $cle = $demande['ressource_nom'];
            if (!isset($ressources_groupees[$cle])) {
                $ressources_groupees[$cle] = [
                    'type' => $demande['type_nom'],
                    'quantite_disponible' => $demande['quantite_disponible'] ?? 0,
                    'villes' => []
                ];
            }
            $ressources_groupees[$cle]['villes'][] = $demande;
        }

        // Créer une liste PLATE de toutes les demandes avec leurs infos
        $toutes_demandes = [];
        foreach ($ressources_groupees as $ressource_nom => $ressource) {
            foreach ($ressource['villes'] as $demande) {
                $toutes_demandes[] = [
                    'ressource_nom' => $ressource_nom,
                    'type' => $ressource['type'],
                    'ville_nom' => $demande['ville_nom'],
                    'date_premiere_demande' => $demande['date_premiere_demande'],
                    'quantite_disponible' => $ressource['quantite_disponible']
                ];
            }
        }

        // Trier TOUTES les demandes par date globalement
        usort($toutes_demandes, function($a, $b) {
            $dateA = strtotime($a['date_premiere_demande'] ?? '1970-01-01');
            $dateB = strtotime($b['date_premiere_demande'] ?? '1970-01-01');
            return $dateA - $dateB;
        });

        // Distribuer par ordre de date
        $quantites_restantes = []; // Tracker la quantité restante par ressource
        
        foreach ($toutes_demandes as $demande) {
            $ressource_nom = $demande['ressource_nom'];
            
            // Initialiser si première fois qu'on voit cette ressource
            if (!isset($quantites_restantes[$ressource_nom])) {
                $quantites_restantes[$ressource_nom] = $demande['quantite_disponible'];
            }
            
            $quantite_demandee = 1;
            $quantite_restante = $quantites_restantes[$ressource_nom];
            
            if ($quantite_restante <= 0) {
                $quantite_allouee = 0;
            } else if ($quantite_restante >= $quantite_demandee) {
                $quantite_allouee = $quantite_demandee;
            } else {
                $quantite_allouee = $quantite_restante;
            }
            
            $dispatch[] = [
                'ressource_nom' => $ressource_nom,
                'type' => $demande['type'],
                'ville_demandeuse' => $demande['ville_nom'],
                'date_demande' => $demande['date_premiere_demande'] ?? 'N/A',
                'quantite_demandee' => $quantite_demandee,
                'quantite_allouee' => $quantite_allouee,
                'quantite_disponible' => $demande['quantite_disponible'],
                'mode' => 'FIFO (Par date)'
            ];
            
            $quantites_restantes[$ressource_nom] -= $quantite_allouee;
        }

        return $dispatch;
    }

    /**
     * Mode 2: Dispatch par ordre de quantité
     * Toutes les demandes triées par ordre alphabétique de ville
     */
    public function dispatchByQuantity()
    {
        $demandes = $this->getDemandes();
        $dispatch = [];

        // Grouper par type+nom de ressource
        $ressources_groupees = [];
        foreach ($demandes as $demande) {
            $cle = $demande['ressource_nom'];
            if (!isset($ressources_groupees[$cle])) {
                $ressources_groupees[$cle] = [
                    'type' => $demande['type_nom'],
                    'quantite_disponible' => $demande['quantite_disponible'] ?? 0,
                    'villes' => []
                ];
            }
            $ressources_groupees[$cle]['villes'][] = $demande;
        }

        // Créer une liste PLATE de toutes les demandes
        $toutes_demandes = [];
        foreach ($ressources_groupees as $ressource_nom => $ressource) {
            foreach ($ressource['villes'] as $demande) {
                $toutes_demandes[] = [
                    'ressource_nom' => $ressource_nom,
                    'type' => $ressource['type'],
                    'ville_nom' => $demande['ville_nom'],
                    'date_premiere_demande' => $demande['date_premiere_demande'],
                    'quantite_disponible' => $ressource['quantite_disponible']
                ];
            }
        }

        // Trier ALLes les demandes par ordre alphabétique de ville (ordre croissant)
        usort($toutes_demandes, function($a, $b) {
            return strcmp($a['ville_nom'], $b['ville_nom']);
        });

        // Distribuer par ordre de ville
        $quantites_restantes = []; // Tracker la quantité restante par ressource
        
        foreach ($toutes_demandes as $demande) {
            $ressource_nom = $demande['ressource_nom'];
            
            // Initialiser si première fois qu'on voit cette ressource
            if (!isset($quantites_restantes[$ressource_nom])) {
                $quantites_restantes[$ressource_nom] = $demande['quantite_disponible'];
            }
            
            $quantite_demandee = 1;
            $quantite_restante = $quantites_restantes[$ressource_nom];
            
            if ($quantite_restante <= 0) {
                $quantite_allouee = 0;
            } else if ($quantite_restante >= $quantite_demandee) {
                $quantite_allouee = $quantite_demandee;
            } else {
                $quantite_allouee = $quantite_restante;
            }
            
            $dispatch[] = [
                'ressource_nom' => $ressource_nom,
                'type' => $demande['type'],
                'ville_demandeuse' => $demande['ville_nom'],
                'date_demande' => $demande['date_premiere_demande'] ?? 'N/A',
                'quantite_demandee' => $quantite_demandee,
                'quantite_allouee' => $quantite_allouee,
                'quantite_disponible' => $demande['quantite_disponible'],
                'mode' => 'Par quantité'
            ];
            
            $quantites_restantes[$ressource_nom] -= $quantite_allouee;
        }

        return $dispatch;
    }

    /**
     * Mode 3: Dispatch par proportionnalité
     * Distribution égale: (1 / nombre_villes) * quantité_disponible
     */
    public function dispatchByProportionality()
    {
        $demandes = $this->getDemandes();
        $dispatch = [];

        // Grouper par type+nom de ressource
        $ressources_groupees = [];
        foreach ($demandes as $demande) {
            $cle = $demande['ressource_nom'];
            if (!isset($ressources_groupees[$cle])) {
                $ressources_groupees[$cle] = [
                    'type' => $demande['type_nom'],
                    'quantite_disponible' => $demande['quantite_disponible'] ?? 0,
                    'villes' => []
                ];
            }
            $ressources_groupees[$cle]['villes'][] = $demande;
        }

        // Créer une liste PLATE de toutes les demandes
        $toutes_demandes = [];
        foreach ($ressources_groupees as $ressource_nom => $ressource) {
            foreach ($ressource['villes'] as $demande) {
                $toutes_demandes[] = [
                    'ressource_nom' => $ressource_nom,
                    'type' => $ressource['type'],
                    'ville_nom' => $demande['ville_nom'],
                    'date_premiere_demande' => $demande['date_premiere_demande'],
                    'quantite_disponible' => $ressource['quantite_disponible'],
                    'nb_villes' => count($ressource['villes'])
                ];
            }
        }

        // Trier par date pour affichage cohérent
        usort($toutes_demandes, function($a, $b) {
            $dateA = strtotime($a['date_premiere_demande'] ?? '1970-01-01');
            $dateB = strtotime($b['date_premiere_demande'] ?? '1970-01-01');
            return $dateA - $dateB;
        });

        // Distribuer proportionnellement
        foreach ($toutes_demandes as $demande) {
            $proportion = 1 / $demande['nb_villes'];
            $quantite_allouee = floor($demande['quantite_disponible'] * $proportion);
            
            $dispatch[] = [
                'ressource_nom' => $demande['ressource_nom'],
                'type' => $demande['type'],
                'ville_demandeuse' => $demande['ville_nom'],
                'date_demande' => $demande['date_premiere_demande'] ?? 'N/A',
                'quantite_demandee' => 1,
                'quantite_allouee' => $quantite_allouee,
                'quantite_disponible' => $demande['quantite_disponible'],
                'proportion' => round($proportion * 100, 2),
                'nb_villes' => $demande['nb_villes'],
                'mode' => 'Proportionnalité'
            ];
        }

        return $dispatch;
    }

    /**
     * Récupère les résultats du dispatch pour un mode spécifique
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
     * Récupère un résumé comparatif des 3 modes
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
