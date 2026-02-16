<?php
    namespace app\models;

    use Entity;

    final class Dons extends Entity
    {
        private $quantite;
        private $date;

        public function __construct($quantite, $date){
            $this->quantite = $quantite;
            $this->date = $date;
        }

        public function getAll() {
            
        }
        public function getQuantite(){
            return $this->quantite;
        }
        public function getDate(){
            return $this->date;
        }
    }
    
?>