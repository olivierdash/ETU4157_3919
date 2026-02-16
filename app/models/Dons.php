<?php
    namespace app\models;

    use Entity;
    use PDO;

    final class Dons extends Entity
    {
        private $quantite;
        private $date;

        public function __construct($quantite, $date){
            $this->quantite = $quantite;
            $this->date = $date;
        }
        public function getAll() {
            $sql = "SELECT * FROM Dons";
            $stmt = $this->getdb()->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }
        public function getQuantite(){
            return $this->quantite;
        }
        public function getDate(){
            return $this->date;
        }
    }
    
?>