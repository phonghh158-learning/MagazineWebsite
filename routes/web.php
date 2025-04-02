<?php

namespace routes;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../app/controllers/HomeController.php';
require_once __DIR__ . '/../app/controllers/AuthController.php';
require_once __DIR__ . '/../app/controllers/CategoryController.php';
require_once __DIR__ . '/../app/controllers/PostController.php';

use App\controllers\HomeController;
use App\controllers\AuthController;
use App\controllers\CategoryController;
use App\controllers\PostController;
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

//Category
Router::get('category', [CategoryController::class,'index']);
Router::get('category/show/{id}', [CategoryController::class,'show']);

Router::get('category/create', [CategoryController::class,'create']);
Router::post('category/create', [CategoryController::class,'createCategory']);

Router::post('category/update/{id}', [CategoryController::class,'updateCategory']);
Router::post('category/delete/{id}', [CategoryController::class,'deleteCategory']);

//News
Router::get('news', [PostController::class,'index']);
Router::get('news/{id}', [PostController::class,'show']);
Router::get('news/category/{id}', [PostController::class,'getPostsByCategory']);

Router::get('news/create', [PostController::class,'create']);
Router::post('news/create', [PostController::class,'createPost']);

Router::get('news/update/{id}', [PostController::class,'update']);
Router::post('news/update/{id}', [PostController::class,'updatePost']);

Router::post('news/delete/{id}', [PostController::class,'softDeletePost']);

Router::get('news/search', [PostController::class,'searchPost']);

Router::post('news/{$id}/review/create', [PostController::class,'addReview']);


