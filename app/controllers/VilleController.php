<?php
    namespace app\controllers;

    use app\models\Ville;

    class VilleController {
        public static function getAll() {
            $ville = new Ville();
            return $ville->getAll();
        }

        public static function getCountVille() {
            $ville = new Ville();
            return $ville->getCountVille();
        }
    }
?>