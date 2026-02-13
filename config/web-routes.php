<?php

namespace CsLogs\Config;

use CsLogs\Controllers\MainController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$app->get('/', function (Request $req, Response $resp, array $args) use ($logger): Response {
    $controller = new MainController($logger);
    return $controller->home($req, $resp, $args);
});

$app->get('/item/{id}', function (Request $req, Response $resp, array $args) use ($logger): Response {
    $controller = new MainController($logger);
    return $controller->itemDetails($req, $resp, $args);
});

$app->get('/api', function (Request $req, Response $resp, array $args) use ($logger): Response {
    $controller = new MainController($logger);
    return $controller->api($req, $resp, $args);
});
