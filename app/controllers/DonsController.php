<?php
    namespace app\controllers;
    use app\models\Dons;

    class DonsController {
        public static function getAll() {
            $dons = new Dons();
            return $dons->getAll();
        }
    }
?>