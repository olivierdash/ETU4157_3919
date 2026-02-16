<?php

namespace app\models;
use PDO;
use Flight;

class Ressource extends Entity{
    private $nom;
    private $villeId;
    private $typeId;
    private $prixUnitaire;

    public function __construct($data = []){
        if(empty($data)) return;

        $i = $data['id'] ?? -1;
        $this->setId($i);
        $this->nom = $data['nom'] ?? "";
        $this->villeId = $data['ville_id'] ?? -1;
        $this->typeId = $data['type_id'] ?? -1;
        $this->prixUnitaire = $data['prixUnitaire'] ?? 0;
    }

    public function getAll(){
        $sql = "SELECT * FROM Ressources";
        $stmt = $this->db->query($sql);
        $ret = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $result = [];
        foreach($ret as $row){
            $result = new Ressource($row);
        }
        return $result;
    }

    public function getByVille($villeId){
        $sql = "SELECT * FROM Ressources WHERE ville_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$villeId]);
        $result = [];
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $result[] = new Ressource($row);
        }
        return $result;
    }
}