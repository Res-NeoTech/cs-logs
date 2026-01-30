<?php
namespace LogsRoyale\Config;
use LogsRoyale\Controllers\MainController;

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$app->get('/', [ MainController::class, 'home' ]);
$app->get('/api', [ MainController::class, 'api' ]);
