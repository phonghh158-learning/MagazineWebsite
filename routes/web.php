<?php

namespace routes;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../app/controllers/HomeController.php';
require_once __DIR__ . '/../app/controllers/AuthController.php';
// require_once __DIR__ . '/../app/controllers/MagazinePostController.php';

use App\controllers\HomeController;
use App\controllers\AuthController;
use App\controllers\MagazinePostController;
use Core\Router;

//TEST
Router::get('', [new HomeController, 'index']);
Router::get('about', [new HomeController, 'about']);
Router::get('contact', [new HomeController, 'contact']);

//Authentication
Router::get('register', [AuthController::class, 'showRegisterForm']);
Router::post('register', [AuthController::class, 'register']);

Router::get('login', [AuthController::class, 'showLoginForm']);
Router::post('login', [AuthController::class, 'login']);

Router::get('logout', [AuthController::class, 'logout']);

//Magazine-Post
// Router::get('magazine-post', [MagazinePostController::class, 'index']);
// Router::get('magazine-post/show/{id}', [MagazinePostController::class, 'show']);

// Router::get('magazine-post/create', [MagazinePostController::class, 'create']);
// Router::post('magazine-post/create', [MagazinePostController::class, 'create']);

// Router::get('magazine-post/update/{id}', [MagazinePostController::class, 'update']);
// Router::post('magazine-post/update/{id}', [MagazinePostController::class, 'update']);

// Router::get('magazine-post/delete/{id}', [MagazinePostController::class, 'delete']);