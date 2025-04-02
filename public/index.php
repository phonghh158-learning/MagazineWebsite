<?php

session_start();

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../core/Router.php';
require_once __DIR__ . '/../routes/web.php';

use Core\Router;

error_reporting(E_ALL);
ini_set('display_errors', 1);


Router::dispatch();

?>