<?php
// routes.php
use app\middlewares\SecurityHeadersMiddleware;
use flight\Engine;
use flight\net\Router;
use app\controllers\VilleController;
use app\controllers\RessourceController;
use app\controllers\DonsController;
use app\controllers\DispatchController;
use app\controllers\BesoinController;
use app\models\Besoin;
use flight\net\Route;
/** 
 * @var Router $router 
 * @var Engine $app
 */

// Wrap all routes with SecurityHeadersMiddleware
$router->group('', function (Router $router) use ($app) {

    $router->get('/', function () use ($app) {
        $ressource_lib = RessourceController::getAllWithRessourcesLib();
        $count_ville = VilleController::getCountVille();
        $countDons = DonsController::countDons();
        $app->render('dashboard/list', ['ressource_lib' => $ressource_lib, 'count_ville' => $count_ville, 'countDons' => $countDons], 'content');
        $app->render('modal');
    });

    // Route pour annuler un don
    $router->get('/dons/annuler/@id', [DonsController::class, 'annuler']);

    $router->group('/dashboard', function (Router $router) use ($app) {
        $router->get('', function () use ($app) {
            $app->redirect('/');
        });
    });

    $router->group('/collectes', function (Router $router) use ($app) {
        $router->get('', [DonsController::class, 'renderFormDon']);

        $router->post('/insert', [DonsController::class, 'insert']);
    });

    $router->get('/ressource/get', [RessourceController::class, 'getRessourcesByVilleId']);

<<<<<<< HEAD
    $router->group('/recap', function (Router $router) use ($app) {
        $router->get('', function () use ($app) {
            $app->render('besoins/recap', [], 'content');
            $app->render('modal');
        });
=======
    $router->group('/recap', function(Router $router) use ($app){
        $router->get('', [VilleController::class, 'renderRecap']);
    });

    $router->get('/achats', function() {
        $besoinController = new BesoinController(new Besoin(), Flight::get('database'));
        $besoinController->showAchatPage();
    });
    
    // API : Effectuer un achat
    $router->post('/acheter-ressource', function() {
        $besoinController = new BesoinController(new Besoin(), Flight::get('database'));
        $besoinController->acheterRessource();
>>>>>>> cf71f0bcd5967142e9cc3697347a21294622402b
    });

    $router->group('/dispatch', function (Router $router) use ($app) {
        $router->get('', [DispatchController::class, 'showDispatchForm']);

        $router->get('/results', [DispatchController::class, 'showDispatch']);

        $router->get('/api', [DispatchController::class, 'getDispatch']);

        $router->get('/comparative', [DispatchController::class, 'showComparative']);

        $router->get('/api/comparative', [DispatchController::class, 'getComparative']);
    });

}, [SecurityHeadersMiddleware::class]);