<?php

define('APP_PATH',dirname(__DIR__));

require APP_PATH.'/vendor/autoload.php';

Core\Application::register()->run();
