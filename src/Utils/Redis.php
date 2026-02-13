<?php

namespace CsLogs\Utils;

use Predis\Client;

final class Redis
{
    private static ?Client $instance = null;

    private function __construct() {} // prevent instantiation

    public static function get(): Client
    {
        if (self::$instance === null) {
            self::$instance = new Client([
                'scheme' => 'tcp',
                'host'   => $_ENV['REDIS_HOST'] ?? '127.0.0.1',
                'port'   => $_ENV['REDIS_PORT'] ?? 6379,
            ]);
        }

        return self::$instance;
    }
}