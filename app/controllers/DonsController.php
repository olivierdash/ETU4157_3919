<?php
namespace app\controllers;
use app\models\Dons;
use app\models\Ville;
use app\controllers\RessourceController;
use Exception;
use Flight;

class DonsController
{

    // Dans DonsController.php
    public function annuler($id)
    {
        $donModel = new Dons();

        // On appelle la méthode delete que vous avez déjà créée dans Dons.php
        // Elle gère déjà la transaction et la table mouvement
        if ($donModel->delete($id)) {
            // Redirection vers l'accueil avec un message de succès (optionnel)
            Flight::redirect('/');
<<<<<<< HEAD
        } else {
            Flight::halt(500, "Erreur lors de l'annulation du don.");
=======
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
>>>>>>> cf71f0bcd5967142e9cc3697347a21294622402b
        }
    }

    public static function getAll()
    {
        $dons = new Dons();
        return $dons->getAll();
    }

    public function insert()
    {
        $don = new Dons();
        $don->insert();
        Flight::redirect('/');
    }
    public static function countDons()
    {
        $dons = new Dons();
        return $dons->countDons();
    }
    public function renderFormDon()
    {
        $v = new Ville();
        $vs = $v->getAll();
        Flight::render('collect/form', ['ville' => $vs], 'content');
        Flight::render('modal');
    }
}
?>