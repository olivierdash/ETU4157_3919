<?php

use PDO;

class Entity{
    private $id;
    private $db;

    public function getId(){
        return $this->id;
    }

    public function setId($id){
        $this->id = $id;
    }
}

?>