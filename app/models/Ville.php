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

    public function getAll(): array
    {
        $sql = "SELECT * FROM ville";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllWithRessourcesLib(): array{
        $r = new Ressource();
        $ret = $r->getRessourceLib();
        $result = [];
        foreach($ret as $row){
            $key = $row['ville_id'];
            if(! isset($result[$key])) {
                $result[$key] = [];
            }
            $result[$key][] = $row;
        }
        return $result;
    }
}