<?php

namespace app\controllers;

use app\models\Ressource;
use app\models\Ville;
use Flight;

class RessourceController{
    public static function getAllWithRessourcesLib(): array{
        $v = new Ville([]);
        return $v->getAllWithRessourcesLib();
    }

    public function getRessourcesByVilleId() {
        $villeId = Flight::request()->query['villeId'] ?? null;
        
        // Validation
        if ($villeId === null) {
            Flight::halt(400, 'Le paramètre villeId est requis');
            return;
        }
        
        if (!is_numeric($villeId)) {
            Flight::halt(400, 'villeId doit être un nombre');
            return;
        }
        
        $villeId = (int)$villeId;
        
        // Récupérer les ressources
        $ressource = new Ressource([]);
        $ret = $ressource->getByVille($villeId);
        
        // Vérifier si les résultats existent
        if (empty($ret)) {
            Flight::json([], 200); // Retourner un tableau vide avec le code 200
            return;
        }
        
        Flight::json($ret, 200);
    }
}