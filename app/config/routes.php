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
    
    // GET home page - display all products
    $router->get('/', function() use ($app) {
        $controller = new ProductController($app);
        $products = $controller->getProducts();
        $app->render('home', ['products' => $products]);
    });

    // POST insert/update product
    $router->post('/insert', function() use ($app) {
        $controller = new ProductController($app);
        try {
            $data = Flight::request()->data;
            $result = $controller->insertProduct($data);
            Flight::redirect('/?message=Product saved successfully');
        } catch (Exception $e) {
            Flight::halt(400, 'Error inserting product: ' . $e->getMessage());
        }
    });

    $router->get('/form', function() use ($app){
        $app->render('form');
    });

    $router->get('/form/@id', function($productId) use ($app) {
        $controller = new ProductController($app);    
        $product = $productId ? $controller->getProductById($productId) : null;
        $app->render('form', ['product' => $product]);
    });

    // GET list of all products (as JSON)
    $router->get('/list', function() use ($app) {
        $controller = new ProductController($app);
        $products = $controller->getProducts();
        Flight::json($products);
    });

}, [SecurityHeadersMiddleware::class]);