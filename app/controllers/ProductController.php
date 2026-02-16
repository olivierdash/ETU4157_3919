<?php
namespace app\controllers;

use flight\Engine;
use app\models\ProductModel;

class ProductController {
    
    protected Engine $app;

    /**
     * Constructor - receives Flight app instance
     */
    public function __construct(Engine $app) {
        $this->app = $app;
    }

    public function getProducts(): array {
        return ProductModel::getProducts();
    }

    public function getProductById($id): ?ProductModel {
        $product = new ProductModel();
        $product->getProductById($id);
        return $product;
    }

    public function insertProduct(array $data): bool {
        try {
            $product = new ProductModel($data);
            $product->insertProduct();
            return true;
        } catch (Exception $e) {
            throw new Exception('Failed to insert product: ' . $e->getMessage());
        }
    }

    public function editProduct(array $data): bool {
        try {
            $product = new ProductModel($data);
            $product->modifyProduct();
            return true;
        } catch (Exception $e) {
            throw new Exception('Failed to edit product: ' . $e->getMessage());
        }
    }

    public function deleteProduct($id): bool {
    $product = new ProductModel(['id' => $id]);
    return $product->deleteProduct();
}
}