<?php

namespace CsLogs\Utils;

use Monolog\Formatter\LineFormatter;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Level;
use Monolog\Logger;
use Psr\Log\LoggerInterface;

final class LoggerFactory
{
    public static function create(): LoggerInterface
    {
        $debug = filter_var($_ENV['APP_DEBUG'] ?? false, FILTER_VALIDATE_BOOL);
        $level = $debug ? Level::Debug : Level::Info;

        $logDir = __DIR__ . '/../logs';
        if (!is_dir($logDir)) {
            mkdir($logDir, 0777, true);
        }

        $logger = new Logger('app');
        $handler = new RotatingFileHandler($logDir . '/app.log', 7, $level);
        $handler->setFormatter(new LineFormatter(
            "[%datetime%] %level_name%: %message% %context%\n",
            'Y-m-d H:i:s',
            true,
            true
        ));

        $logger->pushHandler($handler);

        return $logger;
    }
}
