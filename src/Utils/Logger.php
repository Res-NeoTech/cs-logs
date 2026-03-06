<?php

namespace CsLogs\Utils;

class Logger
{
    private const LOG_DIR = __DIR__ . '/../logs/errors/';
    private const LOG_FILE = self::LOG_DIR . 'errors.log';

    public static function logError(string $message): void
    {
        self::log('ERROR', $message);
    }

    public static function logWarning(string $message): void
    {
        self::log('WARNING', $message);
    }

    private static function log(string $level, string $message): void
    {
        if (!is_dir(self::LOG_DIR)) {
            mkdir(self::LOG_DIR, 0755, true);
        }

        $timestamp = date('Y-m-d H:i:s');
        $logEntry = "[$timestamp] [$level] $message" . PHP_EOL;

        file_put_contents(self::LOG_FILE, $logEntry, FILE_APPEND | LOCK_EX);
    }
}