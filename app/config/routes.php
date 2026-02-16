<?php
// routes.php
use app\middlewares\SecurityHeadersMiddleware;
use flight\Engine;
use flight\net\Router;
use app\controllers\VilleController;
/** 
 * @var Router $router 
 * @var Engine $app
 */

// Wrap all routes with SecurityHeadersMiddleware
$router->group('', function(Router $router) use ($app) {
    
    $router->get('/', function() use ($app) {
        $lstVille = VilleController::getAll();
        $app->render('dashboard/list', ['villes' => $lstVille]);
    });    

}, [SecurityHeadersMiddleware::class]);