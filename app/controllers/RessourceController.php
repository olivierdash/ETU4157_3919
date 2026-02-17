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
        $data = Flight::request()->query->getData();
        $villeId = $data['villeId'] ?? -1;
        $r = new Ressource([]);
        $ret = $r->getByVille($villeId);
        Flight::json($ret);
    }
}