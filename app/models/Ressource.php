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
        $db = Flight::db();
        $sql = "SELECT * FROM Ressources";
        $stmt = $db->query($sql);
        $ret = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $result = [];
        foreach ($ret as $row) {
            $result = new Ressource($row);
        }
        return $result;
    }

    public function getByVille($villeId)
    {
        $db = Flight::db();
        $sql = "SELECT * FROM Ressources WHERE ville_id = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$villeId]);
        $result = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = new Ressource($row);
        }
        return $result;
    }

    public function getRessourceLib(): array
    {
        $db = Flight::db();
        $sql = "SELECT * FROM v_ressources_lib";
        $stmt = $db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}