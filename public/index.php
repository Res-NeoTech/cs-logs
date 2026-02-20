<?php

use CsLogs\Utils\LoggerFactory;
use Slim\Factory\AppFactory;
use Dotenv\Dotenv;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Throwable;

// 1. On charge l'autoloader de Composer
require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

// 2. On instancie l'application
$app = AppFactory::create();
$logger = LoggerFactory::create();

// 3. Routing
require_once __DIR__ . '/../config/web-routes.php';

$app->add(function (Request $request, RequestHandler $handler) use ($logger): Response {
    $start = microtime(true);
    $method = $request->getMethod();
    $path = $request->getUri()->getPath();

    $logger->info('HTTP request started', [
        'method' => $method,
        'path' => $path,
    ]);

    $response = $handler->handle($request);

    $logger->info('HTTP request completed', [
        'method' => $method,
        'path' => $path,
        'status' => $response->getStatusCode(),
        'duration_ms' => round((microtime(true) - $start) * 1000, 2),
    ]);

    return $response;
});

$errorMiddleware = $app->addErrorMiddleware(true, true, true);
$errorMiddleware->setDefaultErrorHandler(
    function (
        Request $request,
        Throwable $exception,
        bool $displayErrorDetails
    ) use ($app, $logger): Response {
        $statusCode = 500;
        $loggerMethod = 'error';

        if ($exception instanceof Slim\Exception\HttpException) {
            $statusCode = $exception->getCode() > 0 ? $exception->getCode() : 500;
            if ($statusCode >= 500) {
                $loggerMethod = 'critical';
            } elseif ($statusCode >= 400) {
                $loggerMethod = 'warning';
            }
        }

        $logger->{$loggerMethod}('Unhandled exception', [
            'method' => $request->getMethod(),
            'path' => $request->getUri()->getPath(),
            'exception_class' => $exception::class,
            'message' => $exception->getMessage(),
            'trace' => $exception->getTraceAsString(),
        ]);

        $response = $app->getResponseFactory()->createResponse($statusCode);
        $response->getBody()->write(
            json_encode([
                'error' => $statusCode >= 500 ? 'Internal Server Error' : $exception->getMessage(),
            ], JSON_UNESCAPED_UNICODE)
        );

        return $response->withHeader('Content-Type', 'application/json');
    }
);

// 4. On lance l'application
$app->run();
