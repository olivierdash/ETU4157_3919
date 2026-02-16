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
        $app->render('dashboard/list', ['ressource_lib' => $ressource_lib, 'dons' => $lstDons]);
    });    

}, [SecurityHeadersMiddleware::class]);