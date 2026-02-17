<?php
namespace app\models;
<<<<<<< HEAD
use Flight;
use PDO;

class Besoin extends Entity
{
    private $db;

    public function __construct()
    {
        $this->db = Flight::db();
    }

    // Récupère les besoins d'une ville avec le nom de la ressource
    // Dans Besoin.php
    public function getByVille($ville_id)
    {
        $sql = "SELECT 
            b.id,
            r.nom as nom_ressource, 
            r.prixUnitaire,
            b.quantite as quantite_initiale,
            -- GREATEST assure que si le calcul est négatif, on affiche 0
            GREATEST(0, (b.quantite - IFNULL((SELECT SUM(d.quantite) FROM dons d WHERE d.id_besoins = b.id), 0))) as quantite_restante
        FROM besoins b 
        JOIN ressources r ON b.id_ressource = r.id 
        WHERE b.ville_id = ?";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$ville_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
=======

use Flight;
use PDO;

final class Besoin extends Entity
{
    private $quantite;
    private $ville_id;
    private $ressource_id;
    private $db;

    public function __construct($quantite = null, $ville_id = null, $ressource_id = null)
    {
        $this->quantite = $quantite;
        $this->ville_id = $ville_id;
        $this->ressource_id = $ressource_id;
        $this->db = Flight::db();
    }

    // ============================================================
    // MÉTHODES DE LECTURE
    // ============================================================

    public function countBesoins()
    {
        $sql = "SELECT COUNT(*) FROM besoins";
        $stmt = $this->db->query($sql);
        return $stmt->fetchColumn();
    }

    public function getAll()
    {
        $sql = "SELECT * FROM besoins";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getBesoinsAvecProgression()
    {
        $sql = "SELECT 
                    b.id,
                    v.id AS ville_id,
                    v.nom AS ville,
                    r.id AS ressource_id,
                    r.nom AS ressource,
                    t.nom AS type,
                    b.quantite AS quantite_besoin,
                    COALESCE(SUM(dd.quantite), 0) AS quantite_distribuee,
                    b.quantite - COALESCE(SUM(dd.quantite), 0) AS quantite_restante,
                    r.prixUnitaire,
                    ROUND((COALESCE(SUM(dd.quantite), 0) * 100.0 / b.quantite), 1) AS pourcentage_comble
                FROM besoins b
                JOIN ville v ON b.ville_id = v.id
                JOIN ressources r ON b.id_ressource = r.id
                JOIN type t ON r.type_id = t.id
                LEFT JOIN distribution d ON v.id = d.ville_id
                LEFT JOIN distribution_detail dd ON d.id = dd.distribution_id AND b.id_ressource = dd.ressource_id
                GROUP BY b.id
                ORDER BY v.nom, pourcentage_comble ASC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getBesoinById($besoin_id)
    {
        $sql = "SELECT b.*, r.prixUnitaire, v.id AS ville_id
                FROM besoins b
                JOIN ressources r ON b.id_ressource = r.id
                JOIN ville v ON b.ville_id = v.id
                WHERE b.id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$besoin_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getArgentDisponible()
    {
        // Argent collecté
        $sql_collecte = "SELECT SUM(d.quantite) AS total
                         FROM dons d
                         JOIN ressources r ON d.id_ressource = r.id
                         JOIN type t ON r.type_id = t.id
                         WHERE t.nom = 'argent'";
        $stmt = $this->db->query($sql_collecte);
        $argent_collecte = $stmt->fetch(PDO::FETCH_ASSOC);

        // Argent dépensé
        $sql_depense = "SELECT SUM(dd.quantite * r.prixUnitaire) AS total
                        FROM distribution_detail dd
                        JOIN ressources r ON dd.ressource_id = r.id";
        $stmt = $this->db->query($sql_depense);
        $argent_depense = $stmt->fetch(PDO::FETCH_ASSOC);

        $total_collecte = $argent_collecte['total'] ?? 0;
        $total_depense = $argent_depense['total'] ?? 0;

        return [
            'collecte' => $total_collecte,
            'depense' => $total_depense,
            'disponible' => $total_collecte - $total_depense
        ];
    }

    public function getQuantiteDistribueeForBesoin($ressource_id, $ville_id)
    {
        $sql = "SELECT COALESCE(SUM(dd.quantite), 0) AS total
                FROM distribution_detail dd
                JOIN distribution d ON dd.distribution_id = d.id
                WHERE dd.ressource_id = ? AND d.ville_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$ressource_id, $ville_id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] ?? 0;
    }

    // ============================================================
    // MÉTHODES D'ÉCRITURE
    // ============================================================

    public function insert()
    {
        $data = Flight::request()->data->getData();
        $sql = "INSERT INTO besoins (ville_id, id_ressource, quantite) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$data['ville_id'], $data['ressource_id'], $data['quantite']]);
    }

    public function getOrCreateDistributionDuJour($ville_id)
    {
        // Chercher la distribution du jour
        $sql = "SELECT id FROM distribution 
                WHERE ville_id = ? AND DATE(date_distribution) = CURDATE()
                LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$ville_id]);
        $distribution = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($distribution) {
            return $distribution['id'];
        }

        // Créer une nouvelle distribution
        $sql = "INSERT INTO distribution (ville_id, date_distribution, remarques) 
                VALUES (?, CURDATE(), 'Achat automatique')";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$ville_id]);
        return $this->db->lastInsertId();
    }

    public function addOrUpdateDistributionDetail($distribution_id, $ressource_id, $quantite)
    {
        // Vérifier si la ressource existe dans cette distribution
        $sql = "SELECT id FROM distribution_detail 
                WHERE distribution_id = ? AND ressource_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$distribution_id, $ressource_id]);
        $existing = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($existing) {
            // Mettre à jour
            $sql = "UPDATE distribution_detail 
                    SET quantite = quantite + ? 
                    WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$quantite, $existing['id']]);
        } else {
            // Insérer
            $sql = "INSERT INTO distribution_detail (distribution_id, ressource_id, quantite) 
                    VALUES (?, ?, ?)";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$distribution_id, $ressource_id, $quantite]);
        }
    }

    // ============================================================
    // GETTERS
    // ============================================================

    public function getQuantite()
    {
        return $this->quantite;
    }

    public function getVilleId()
    {
        return $this->ville_id;
    }

    public function getRessourceId()
    {
        return $this->ressource_id;
    }
>>>>>>> cf71f0bcd5967142e9cc3697347a21294622402b
}