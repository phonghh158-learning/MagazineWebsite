<?php

session_start();

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../core/Router.php';
require_once __DIR__ . '/../routes/web.php';

use Core\Router;

Router::dispatch();

?>