<?php
    namespace app\models;

    use Flight;
    use Entity;
    use PDO;

    final class Dons extends Entity
    {
        private $quantite;
        private $date;

        public function __construct($quantite, $date){
            $this->quantite = $quantite;
            $this->date = $date;
            $this->db = Flight::db();
        }

        public function getAll() {
            $sql = "SELECT * FROM Dons";
            $stmt = $this->db->query($sql);
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