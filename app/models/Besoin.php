<?php
namespace app\models;
use Flight;
use PDO;

class Besoin extends Entity
{
    private $db;

    public function __construct()
    {
        $this->db = Flight::db();
    }

    // Récupère les besoins d'une ville avec le nom de la ressource
    // Dans Besoin.php
    public function getByVille($ville_id)
    {
        $sql = "SELECT 
            b.id,
            r.nom as nom_ressource, 
            r.prixUnitaire,
            b.quantite as quantite_initiale,
            -- GREATEST assure que si le calcul est négatif, on affiche 0
            GREATEST(0, (b.quantite - IFNULL((SELECT SUM(d.quantite) FROM dons d WHERE d.id_besoins = b.id), 0))) as quantite_restante
        FROM besoins b 
        JOIN ressources r ON b.id_ressource = r.id 
        WHERE b.ville_id = ?";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$ville_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}