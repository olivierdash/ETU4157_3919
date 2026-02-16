<?php
// routes.php
use app\middlewares\SecurityHeadersMiddleware;
use flight\Engine;
use flight\net\Router;
use app\controllers\VilleController;
use app\controllers\DonsController;
/** 
 * @var Router $router 
 * @var Engine $app
 */

// Wrap all routes with SecurityHeadersMiddleware
$router->group('', function(Router $router) use ($app) {
    
    $router->get('/', function() use ($app) {
        $lstVille = VilleController::getAll();
        $lstDons = DonsController::getAll();
        $app->render('dashboard/list', ['villes' => $lstVille, 'dons' => $lstDons]);
    });    

}, [SecurityHeadersMiddleware::class]);