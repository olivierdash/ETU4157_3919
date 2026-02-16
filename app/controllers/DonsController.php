<?php
    namespace app\controllers;
    use app\models\Dons;

    class DonsController {
        public static function getAll() {
            $dons = new Dons();
            return $dons->getAll();
        }

        public static function countDons() {
            $dons = new Dons();
            return $dons->countDons();
        }
    }
?>