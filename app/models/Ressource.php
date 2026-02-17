<?php

namespace app\models;
use PDO;
use Flight;

class Ressource extends Entity
{
    private $nom;
    private $villeId;
    private $typeId;
    private $prixUnitaire;
    private $db;

    public function __construct($data = [])
    {
        $i = $data['id'] ?? -1;
        $this->setId($i);
        $this->nom = $data['nom'] ?? "";
        $this->villeId = $data['ville_id'] ?? -1;
        $this->typeId = $data['type_id'] ?? -1;
        $this->prixUnitaire = $data['prixUnitaire'] ?? 0;
        $this->db = Flight::db();
    }

    public function getAll()
    {
        $sql = "SELECT * FROM ressources";
        $stmt = $this->db->query($sql);
        $ret = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $result = [];
        foreach ($ret as $row) {
            $result = new Ressource($row);
        }
        return $result;
    }

    public function getByVille($villeId, $typeId = null)
    {
        $sql = "SELECT * FROM ressources WHERE JOIN ville_id = ?";
        if( $typeId !== null) {
            $sql .= " AND type_id = ?";
        }
        $stmt = $this->db->prepare($sql);
        if( $typeId !== null) {
            $stmt->execute([$villeId, $typeId]);
        } else {
            $stmt->execute([$villeId]);
        }
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRessourceLib(): array
    {
        $sql = "SELECT * FROM v_ressources_lib";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}