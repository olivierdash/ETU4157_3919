<?php
namespace app\controllers;

use app\models\Type;
use Flight;

class TypeController
{
    private $typeModel;

    public function __construct()
    {
        $this->typeModel = new Type();
    }

    /**
     * Affiche la liste de tous les types
     */
    public function index()
    {
        $types = $this->typeModel->getAllWithCount();
        Flight::render('type_list', compact('types'));
    }

    /**
     * Affiche le formulaire de création
     */
    public function create()
    {
        Flight::render('type_form');
    }

    /**
     * Enregistre un nouveau type
     */
    public function store()
    {
        try {
            $data = Flight::request()->data->getData();

            if (empty($data['nom'])) {
                Flight::halt(400, 'Le nom est requis');
            }

            // Vérifier que le nom n'existe pas déjà
            $existing = $this->typeModel->getByNom($data['nom']);
            if ($existing) {
                Flight::halt(400, 'Ce type existe déjà');
            }

            $this->typeModel->insert();
            Flight::redirect('/types');

        } catch (\Exception $e) {
            Flight::halt(500, 'Erreur lors de la création: ' . $e->getMessage());
        }
    }

    /**
     * Affiche le formulaire d'édition
     */
    public function edit($id)
    {
        $type = $this->typeModel->getById($id);
        
        if (!$type) {
            Flight::halt(404, 'Type non trouvé');
        }

        Flight::render('type_form', compact('type'));
    }

    /**
     * Met à jour un type
     */
    public function update($id)
    {
        try {
            $type = $this->typeModel->getById($id);
            
            if (!$type) {
                Flight::halt(404, 'Type non trouvé');
            }

            $data = Flight::request()->data->getData();

            if (empty($data['nom'])) {
                Flight::halt(400, 'Le nom est requis');
            }

            // Vérifier que le nom n'existe pas déjà (sauf pour le type actuel)
            $existing = $this->typeModel->getByNom($data['nom']);
            if ($existing && $existing['id'] != $id) {
                Flight::halt(400, 'Ce type existe déjà');
            }

            $this->typeModel->update($id);
            Flight::redirect('/types');

        } catch (\Exception $e) {
            Flight::halt(500, 'Erreur lors de la mise à jour: ' . $e->getMessage());
        }
    }

    /**
     * API : Récupère tous les types (JSON)
     */
    public function getAll()
    {
        return $this->typeModel->getAll();
    }

    /**
     * API : Récupère un type spécifique (JSON)
     */
    public function getById($id)
    {
        header('Content-Type: application/json');

        try {
            $type = $this->typeModel->getById($id);

            if (!$type) {
                http_response_code(404);
                echo json_encode([
                    'success' => false,
                    'message' => 'Type non trouvé'
                ]);
                return;
            }

            echo json_encode([
                'success' => true,
                'data' => $type
            ]);

        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * API : Récupère tous les types utilisés (JSON)
     */
    public function getTypesUtilises()
    {
        header('Content-Type: application/json');

        try {
            $types = $this->typeModel->getTypesUtilises();

            echo json_encode([
                'success' => true,
                'data' => $types
            ]);

        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * API : Récupère les types avec le nombre de ressources
     */
    public function getAllWithCount()
    {
        header('Content-Type: application/json');

        try {
            $types = $this->typeModel->getAllWithCount();

            echo json_encode([
                'success' => true,
                'data' => $types
            ]);

        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * API : Récupère les types avec le nombre de besoins
     */
    public function getAllWithBesoins()
    {
        header('Content-Type: application/json');

        try {
            $types = $this->typeModel->getAllWithBesoins();

            echo json_encode([
                'success' => true,
                'data' => $types
            ]);

        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}