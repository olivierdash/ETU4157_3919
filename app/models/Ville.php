<?php

namespace app\models;
use Flight;
use PDO;

class Ville extends Entity
{
    private $nom;
    private $db;

    public function __construct($data = [])
    {
        $t = $data['id'] ?? null;
        $this->setId($t);
        $this->nom = $data['nom'] ?? null;
        $this->db = Flight::db();
    }

    public function setNom($n)
    {
        $this->nom = $n;
    }

    public function getNom()
    {
        return $this->nom;
    }

    public function getDonsByVille($ville_id) {
        $sql = "SELECT * FROM v_dons_lib WHERE ville_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$ville_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAll(): array
    {
        $sql = "SELECT * FROM ville";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCountVille(){
        return count($this->getAll());
    }

    public function getAllWithRessourcesLib(): array {
        $r = new Ressource();
        $ret = $r->getRessourceLib(); // Récupère les données de v_ressources_lib
        
        $result = [];
        
        foreach($ret as $row) {
            $key = $row['nom_ville']; // Utiliser le nom de ville comme clé
            
            // Initialiser la structure pour cette ville si elle n'existe pas
            if(!isset($result[$key])) {
                $result[$key] = [
                    'nom_ville' => $row['nom_ville'],
                    'besoins' => [],
                    'total_quantite' => 0,
                    'total_montant' => 0.00,
                    'derniere_date' => null
                ];
            }
            
            // Ajouter le besoin/ressource
            $result[$key]['besoins'][] = [
                'nom_ressource' => $row['nom_ressource'],
                'type_ressource' => $row['type_ressource'],
                'prixUnitaire' => $row['prixUnitaire'],
                'quantite_don' => $row['quantite_don'],
                'date_don' => $row['date_don'],
                'montant_total' => $row['montant_total']
            ];
            
            // Accumuler les totaux
            if($row['quantite_don'] !== null) {
                $result[$key]['total_quantite'] += $row['quantite_don'];
            }
            
            if($row['montant_total'] !== null) {
                $result[$key]['total_montant'] += $row['montant_total'];
            }
            
            // Mettre à jour la date la plus récente
            if($row['date_don'] !== null) {
                if($result[$key]['derniere_date'] === null || 
                   strtotime($row['date_don']) > strtotime($result[$key]['derniere_date'])) {
                    $result[$key]['derniere_date'] = $row['date_don'];
                }
            }
        }
        
        return $result;
    }

    public function getMontantBesoin(){
        $sql = "SELECT sum(montant_total) as montant
FROM v_ressources_lib";
    $stmt = $this->db->query($sql);
    return $stmt->fetch(PDO::FETCH_ASSOC)['montant'];
    }

    public function getMontantTotal(){
        $sql = "SELECT sum(b.quantite * r.prixUnitaire) as montant
FROM besoins b 
JOIN ressources r ON b.id_ressource = r.id";
    $stmt = $this->db->query($sql);
    return $stmt->fetch(PDO::FETCH_ASSOC)['montant'];
    }
}