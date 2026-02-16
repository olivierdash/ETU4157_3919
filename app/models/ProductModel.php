<?php

namespace app\models;

use Flight;
use PDO;
use Exception;

class ProductModel
{
    private $id;
    private $name;
    private $alt;
    private $price;
    private $image;

    // -----------------------------------------------
    // CONSTRUCTEUR
    // -----------------------------------------------
    public function __construct($data = []){
        $this->id    = $data['id'] ?? null;
        $this->name  = $data['name'] ?? null;
        $this->alt   = $data['alt'] ?? null;
        $this->price = $data['price'] ?? null;
        $this->image = $data['image'] ?? null;
    }

    // -----------------------------------------------
    // Récupère tous les produits (méthode statique)
    // -----------------------------------------------
    public static function getProducts(): array
    {
        try {
            $stmt = Flight::db()->runQuery("SELECT * FROM produits");
            $products = [];
            
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $products[] = new ProductModel($row);
            }
            
            return $products;
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la récupération des produits: " . $e->getMessage());
        }
    }

    // -----------------------------------------------
    // Récupérer un produit par ID
    // -----------------------------------------------
    public function getProductById($id): bool
    {
        try {
            $sql = "SELECT * FROM produits WHERE id = :id";
            $stmt = Flight::db()->runQuery($sql, [':id' => $id]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Vérifier si le produit existe
            if (!$row) {
                return false;
            }
            
            // Utiliser les setters correctement
            $this->setId($row['id']);
            $this->setName($row['name']);
            $this->setAlt($row['alt']);
            $this->setPrice($row['price']);
            $this->setImage($row['image']);
            
            return true;
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la récupération du produit: " . $e->getMessage());
        }
    }

    // -----------------------------------------------
    // Insérer un produit dans la base
    // -----------------------------------------------
    public function insertProduct(): int
    {
        if (!$this->name || !$this->price) {
            throw new Exception("Le nom et le prix sont obligatoires.");
        }

        try {
            $pdo = Flight::db();
            $pdo->beginTransaction();
            
            $sql = "INSERT INTO produits (name, alt, price, image) 
                    VALUES (:name, :alt, :price, :image)";

            $stmt = $pdo->runQuery($sql, [
                ':name'  => $this->name,
                ':alt'   => $this->alt,
                ':price' => $this->price,
                ':image' => $this->image
            ]);
            
            $lastId = $pdo->lastInsertId();
            $this->setId($lastId);
            
            $pdo->commit();
            return $lastId;
            
        } catch (Exception $e) {
            $pdo->rollBack();
            throw new Exception("Erreur lors de l'insertion du produit: " . $e->getMessage());
        }
    }

    // -----------------------------------------------
    // Modifier un produit
    // -----------------------------------------------
    public function modifyProduct(): bool
    {
        if (!$this->id) {
            throw new Exception("Impossible de modifier un produit sans ID.");
        }

        if (!$this->name || !$this->price) {
            throw new Exception("Le nom et le prix sont obligatoires.");
        }

        try {
            $pdo = Flight::db();
            $pdo->beginTransaction();
            
            $sql = "UPDATE produits 
                    SET name = :name, alt = :alt, price = :price, image = :image
                    WHERE id = :id";

            $pdo->runQuery($sql, [
                ':name'  => $this->name,
                ':alt'   => $this->alt,
                ':price' => $this->price,
                ':image' => $this->image,
                ':id'    => $this->id
            ]);
            
            $pdo->commit();
            return true;
            
        } catch (Exception $e) {
            $pdo->rollBack();
            throw new Exception("Erreur lors de la modification du produit: " . $e->getMessage());
        }
    }

    public function deleteProduct(): bool {
    if (!$this->id) {
        throw new Exception("ID requis pour supprimer.");
    }
    try {
        $sql = "DELETE FROM produits WHERE id = :id";
        Flight::db()->runQuery($sql, [':id' => $this->id]);
        return true;
    } catch (Exception $e) {
        throw new Exception("Erreur suppression: " . $e->getMessage());
    }
}

    // -----------------------------------------------
    // GETTERS
    // -----------------------------------------------
    public function getId()    { return $this->id; }
    public function getName()  { return $this->name; }
    public function getAlt()   { return $this->alt; }
    public function getPrice() { return $this->price; }
    public function getImage() { return $this->image; }

    // -----------------------------------------------
    // SETTERS
    // -----------------------------------------------
    public function setId($id)          { $this->id = $id; }
    public function setName($name)      { $this->name = $name; }
    public function setAlt($alt)        { $this->alt = $alt; }
    public function setPrice($price)    { $this->price = $price; }
    public function setImage($image)    { $this->image = $image; }
}