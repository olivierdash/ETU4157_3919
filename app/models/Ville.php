<?php

namespace app\models;
use Flight;
use PDO;

class Ville extends Entity{
    private $nom;
    
    public function __construct($data = []){
        if(empty($data)) return;
        $t = $data['id'] ?? null;
        $this->setId($t);
        $this->nom  = $data['nom'] ?? null;
        $this->db = Flight::db();
    }

    public function setNom($n){
        $this->nom = $n;
    }

    public function getNom(){
        return $this->nom;
    }

    public function getAll(): array{
        $sql = "SELECT * FROM Ville";
        $stmt = $this->db->query($sql);
        $ret = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $result = [];
        foreach($ret as $row){
            $result = new Ville($row);
        }
        return $result;
    }
}