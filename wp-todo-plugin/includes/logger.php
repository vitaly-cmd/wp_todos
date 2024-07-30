<?php

use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;

class WP_Todo_Logger {
    private static $logger;

    public static function initialize() {
        if (!class_exists('Monolog\Logger')) {
            require plugin_dir_path(__FILE__) . 'vendor/autoload.php';
        }

        $logger = new Monolog\Logger('wp_todo_logger');
        $logger->pushHandler(new Monolog\Handler\StreamHandler(WP_CONTENT_DIR . '/debug.log', Monolog\Logger::DEBUG));

        self::$logger = $logger;
    }

    public static function log($level, $message) {
        if (self::$logger instanceof LoggerInterface) {
            self::$logger->log($level, $message);
        }
    }
}
