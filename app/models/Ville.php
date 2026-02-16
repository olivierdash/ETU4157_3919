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
    }

    public function setNom($n){
        $this->nom = $n;
    }

    public function getNom(){
        return $this->nom;
    }

    public function getAll(): array{
        $sql = "SELECT * FROM ville";
        $stmt = $this->getdb()->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}