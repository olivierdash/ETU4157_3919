<?php

class Ville extends Entity{
    private $nom;
    
    public function _construct($data = []){
        if(empty($data)) return;
        $t    = $data['id'] ?? null;
        $this->setId($t);
        $this->name  = $data['nom'] ?? null;
    }

    public function setNom($n){
        $this->nom = $n;
    }

    public function getNom(){
        return $this->nom;
    }

    public function getAll(): array{
        
    }
}