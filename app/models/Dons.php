<?php
    namespace app\models;

    use Flight;
    use PDO;
    final class Dons extends Entity
    {
        private $quantite;
        private $date;
        private $db;

        public function __construct($quantite = null, $date = null){
            $this->quantite = $quantite;
            $this->date = $date;
            $this->db = Flight::db();
        }
        public function getAll() {
            $sql = "SELECT * FROM dons";
            $stmt = $this->db->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }

        public function getQuantite(){
            return $this->quantite;
        }
        public function getDate(){
            return $this->date;
        }

        public function insert(){
            $data = Flight::request()->data->getData();
            $sql = "INSERT INTO dons (quantite, date, id_ressource) VALUES (:quantite, :date, :ressource_id)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':quantite', $data['quantite'], PDO::PARAM_INT);
            $stmt->bindParam(':date', $data['date']);
            $stmt->bindParam(':ressource_id', $data['ressource_id'], PDO::PARAM_INT);
            $stmt->execute();
            Flight::render('collect/form', ['success' => true]);
        }
    }
    
?>