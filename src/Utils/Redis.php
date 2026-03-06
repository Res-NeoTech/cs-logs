<?php

namespace CsLogs\Utils;

use Predis\Client;
use Psr\Log\LoggerInterface;

final class Redis
{
    private static ?Client $instance = null;

    private function __construct() {} // prevent instantiation

    public static function get(?LoggerInterface $logger = null): Client
    {
        try {
            if (self::$instance === null) {
                self::$instance = new Client([
                    'scheme' => 'tcp',
                    'host'   => $_ENV['REDIS_HOST'] ?? '127.0.0.1',
                    'port'   => $_ENV['REDIS_PORT'] ?? 6379,
                ]);
            }
        } catch (\Throwable $e) {
            if ($logger !== null) {
                $logger->error('Redis client initialization failed', [
                    'host' => $_ENV['REDIS_HOST'] ?? '127.0.0.1',
                    'port' => $_ENV['REDIS_PORT'] ?? 6379,
                    'message' => $e->getMessage(),
                    'exception_class' => $e::class,
                ]);
            }
            throw $e;
        }

        return self::$instance;
    }
}
