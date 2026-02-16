<?php

namespace app\controllers;
use app\models\Ville;

class RessourceController{
    public static function getAllWithRessourcesLib(): array{
        $v = new Ville([]);
        return $v->getAllWithRessourcesLib();
    }
}