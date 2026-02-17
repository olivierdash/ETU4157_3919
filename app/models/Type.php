<?php
namespace app\models;

use Flight;
use PDO;

final class Type extends Entity
{
    private $nom;
    private $db;

    public function __construct($nom = null)
    {
        $this->nom = $nom;
        $this->db = Flight::db();
    }

    // ============================================================
    // MÉTHODES DE LECTURE
    // ============================================================

    public function countTypes()
    {
        $sql = "SELECT COUNT(*) FROM type";
        $stmt = $this->db->query($sql);
        return $stmt->fetchColumn();
    }

    public function getAll()
    {
        $sql = "SELECT * FROM type ORDER BY nom";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $sql = "SELECT * FROM type WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getByNom($nom)
    {
        $sql = "SELECT * FROM type WHERE nom = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$nom]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère tous les types avec le nombre de ressources associées
     */
    public function getAllWithCount()
    {
        $sql = "SELECT 
                    t.id,
                    t.nom,
                    COUNT(r.id) as nombre_ressources
                FROM type t
                LEFT JOIN ressources r ON t.id = r.type_id
                GROUP BY t.id
                ORDER BY t.nom";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère tous les types avec le nombre de besoins associés
     */
    public function getAllWithBesoins()
    {
        $sql = "SELECT 
                    t.id,
                    t.nom,
                    COUNT(DISTINCT b.id) as nombre_besoins
                FROM type t
                LEFT JOIN ressources r ON t.id = r.type_id
                LEFT JOIN besoins b ON r.id = b.id_ressource
                GROUP BY t.id
                ORDER BY t.nom";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère les types utilisés dans les distributions
     */
    public function getTypesUtilises()
    {
        $sql = "SELECT DISTINCT t.id, t.nom
                FROM type t
                JOIN ressources r ON t.id = r.type_id
                JOIN besoins b ON r.id = b.id_ressource
                ORDER BY t.nom";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ============================================================
    // MÉTHODES D'ÉCRITURE
    // ============================================================

    public function insert()
    {
        $data = Flight::request()->data->getData();
        $sql = "INSERT INTO type (nom) VALUES (?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$data['nom']]);
    }

    public function update($id)
    {
        $data = Flight::request()->data->getData();
        $sql = "UPDATE type SET nom = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$data['nom'], $id]);
    }

    public function delete($id)
    {
        $sql = "DELETE FROM type WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }

    // ============================================================
    // GETTERS
    // ============================================================

    public function getNom()
    {
        return $this->nom;
    }

    // ============================================================
    // SETTERS
    // ============================================================

    public function setNom($nom)
    {
        $this->nom = $nom;
    }
}