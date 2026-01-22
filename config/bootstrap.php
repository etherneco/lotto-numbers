<?php

use Symfony\Component\Dotenv\Dotenv;

require dirname(__DIR__).'/vendor/autoload.php';

if (!isset($_SERVER['APP_ENV'])) {
    if (!class_exists(Dotenv::class)) {
        throw new RuntimeException('Please run "composer require symfony/dotenv" to load the ".env" files configuring the application.');
    }

    (new Dotenv())->bootEnv(dirname(__DIR__).'/.env');
}
