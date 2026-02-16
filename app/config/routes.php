<?php
// routes.php
use app\middlewares\SecurityHeadersMiddleware;
use flight\Engine;
use flight\net\Router;
use app\controllers\VilleController;
use app\controllers\RessourceController;
use app\controllers\DonsController;
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

    $router->get('/collectes', function() use ($app){
        $app->render('collect/form');
    });

}, [SecurityHeadersMiddleware::class]);