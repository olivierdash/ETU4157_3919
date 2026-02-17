<?php
namespace app\models;

use Flight;
use PDO;
use Exception;
final class Dons extends Entity
{
    private $quantite;
    private $date;
    private $db;

    public function __construct($quantite = null, $date = null)
    {
        $this->quantite = $quantite;
        $this->date = $date;
        $this->db = Flight::db();
    }

    public function countDons()
    {
        $sql = "SELECT COUNT(*) FROM dons";
        $stmt = $this->db->query($sql);
        return $stmt->fetchColumn();
    }
    public function getAll()
    {
        $sql = "SELECT * FROM dons";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    public function getQuantite()
    {
        return $this->quantite;
    }
    public function getDate()
    {
        return $this->date;
    }

    public function insert()
    {
        $data = Flight::request()->data->getData();

        try {
            $this->db->beginTransaction();

            // 1. Insertion dans la table dons
            $sqlDon = "INSERT INTO dons (quantite, id_ressource, id_besoins) VALUES (?, ?, ?)";
            $stmtDon = $this->db->prepare($sqlDon);
            $stmtDon->execute([
                $data['quantite'],
                $data['ressource_id'],
                $data['besoin_id'] // Ajouté car nécessaire pour vos vues SQL
            ]);

            // Récupérer l'ID du don qui vient d'être créé
            $idDon = $this->db->lastInsertId();

            // 2. Insertion du mouvement historique 'AJOUT'
            $sqlMvt = "INSERT INTO mouvement (id_don, type_action, quantite_mouvement) VALUES (?, 'AJOUT', ?)";
            $stmtMvt = $this->db->prepare($sqlMvt);
            $stmtMvt->execute([$idDon, $data['quantite']]);

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    /**
     * SUPPRESSION (Annulation) : Enregistre l'annulation puis supprime le don
     * Note: Dans un système d'audit, on préfère souvent garder le don avec 
     * une quantité à 0, mais voici la méthode pour une suppression physique.
     */
    public function delete($idDon) {
        try {
            $this->db->beginTransaction();

            // 1. Récupérer les infos du don avant de le supprimer pour l'historique
            $sqlSelect = "SELECT quantite FROM dons WHERE id = ?";
            $stmtSelect = $this->db->prepare($sqlSelect);
            $stmtSelect->execute([$idDon]);
            $don = $stmtSelect->fetch(PDO::FETCH_ASSOC);

            if ($don) {
                // 2. Créer le mouvement d'ANNULATION (quantité négative)
                $sqlMvt = "INSERT INTO mouvement (id_don, type_action, quantite_mouvement) VALUES (?, 'ANNULATION', ?)";
                $stmtMvt = $this->db->prepare($sqlMvt);
                $stmtMvt->execute([$idDon, -$don['quantite']]);

                // 3. Supprimer ou Archiver le don
                // ATTENTION: Si vous avez une clé étrangère ON DELETE RESTRICT, 
                // il faudra peut-être modifier le don au lieu de le supprimer.
                $sqlDelete = "DELETE FROM dons WHERE id = ?";
                $stmtDelete = $this->db->prepare($sqlDelete);
                $stmtDelete->execute([$idDon]);
            }

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }
}

?>