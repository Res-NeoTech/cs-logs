<?php

namespace CsLogs\Config;

use CsLogs\Controllers\MainController;

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$app->get('/', [MainController::class, 'home']);
$app->get('/item/{id}', [MainController::class, 'itemDetails']);

$app->get('/api', [MainController::class, 'api']);
