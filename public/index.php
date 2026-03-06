<?php

use Slim\Factory\AppFactory;
use Dotenv\Dotenv;

// 1. On charge l'autoloader de Composer
require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

// 2. On instancie l'application
$app = AppFactory::create();

$container = $app->getContainer();
$container['notFoundHandler'] = function ($c) {
    return function ($request, $response) use ($c) {
        $view = new \Slim\Views\PhpRenderer("../view");
        return $view->render($response->withStatus(404), '404.php');
    };
};

// 3. Routing
require_once '../config/web-routes.php';

$app->addErrorMiddleware(true, true, true);

// 4. On lance l'application
$app->run();