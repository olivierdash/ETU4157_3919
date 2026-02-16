<?php

use Flight;

class Entity{
    private $id;
    private $db;

    public function getId(){
        return $this->id;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function __construct(){
        $this->db = Flight::db();
    }
    
    public function getdb() {
        return $this->db;
    }
}

?>