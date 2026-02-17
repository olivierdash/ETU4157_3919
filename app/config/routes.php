<?php
// routes.php
use app\middlewares\SecurityHeadersMiddleware;
use flight\Engine;
use flight\net\Router;
use app\controllers\VilleController;
use app\controllers\RessourceController;
use app\controllers\DonsController;
use flight\net\Route;

/** 
 * @var Router $router 
 * @var Engine $app
 */

// Wrap all routes with SecurityHeadersMiddleware
$router->group('', function(Router $router) use ($app) {
    
    $router->get('/', function() use ($app) {
        $ressource_lib = RessourceController::getAllWithRessourcesLib();
        $count_ville = VilleController::getCountVille();
        $countDons = DonsController::countDons();
        $app->render('dashboard/list', ['ressource_lib' => $ressource_lib, 'count_ville' => $count_ville, 'countDons' => $countDons]);
    });    

    $router->group('/collectes', function(Router $router) use ($app){
        $router->get('', [DonsController::class, 'renderFormDon']);

        $router->post('/insert', [DonsController::class, 'insert']);
    });

    $router->get('/ressource/get', [RessourceController::class, 'getRessourcesByVilleId']);

}, [SecurityHeadersMiddleware::class]);