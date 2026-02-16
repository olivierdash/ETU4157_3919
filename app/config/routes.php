<?php
// routes.php
use app\controllers\ProductController;
use app\middlewares\SecurityHeadersMiddleware;
use flight\Engine;
use flight\net\Router;

/** 
 * @var Router $router 
 * @var Engine $app
 */

// Wrap all routes with SecurityHeadersMiddleware
$router->group('', function(Router $router) use ($app) {
    
    $router->get('/', function() use ($app) {
        $app->render('dashboard/list');
    });    

}, [SecurityHeadersMiddleware::class]);