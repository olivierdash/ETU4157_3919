<?php
    namespace app\controllers;
    use app\models\Dons;
    use app\models\Ville;
    use app\controllers\RessourceController;
    use Flight;

    class DonsController {
        public static function getAll() {
            $dons = new Dons();
            return $dons->getAll();
        }

        public function insert() {
            $don = new Dons();
            $don->insert();
            Flight::redirect('/');
        }
        public static function countDons() {
            $dons = new Dons();
            return $dons->countDons();
        }
        public function renderFormDon(){
            $v = new Ville();
            $t = new TypeController();
            $vs = $v->getAll();
            Flight::render('collect/form', ['ville' => $vs, 'types'=> $t->getAll()], 'content');
            Flight::render('modal');
        }
    }
?>