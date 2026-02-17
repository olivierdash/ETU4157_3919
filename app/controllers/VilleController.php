<?php
    namespace app\controllers;
    use Flight;
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

        public function renderRecap(){
            $v = new Ville([]);
            $temp1 = $v->getMontantTotal();
            $temp2 = $v->getMontantBesoin();
            Flight::render('besoins/recap', ['besoin_total' => $temp2, 'besoin_restant' => max($temp1 - $temp2, 0)], 'content');
            Flight::render('modal');
        }
    }
?>