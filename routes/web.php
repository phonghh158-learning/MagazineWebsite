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
use App\controllers\UserController;
use Core\Router;

//TEST
Router::get('', [new HomeController, 'index']);

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
Router::get('news/status/{status}', [PostController::class,'getPostsByStatus']);

Router::get('news/create', [PostController::class,'create']);
Router::post('news/create', [PostController::class,'createPost']);

Router::get('news/update/{id}', [PostController::class,'update']);
Router::post('news/update/{id}', [PostController::class,'updatePost']);

Router::post('news/delete/{id}', [PostController::class,'softDeletePost']);

Router::get('news/search', [PostController::class,'searchPost']);

Router::post('news/{id}/review/create', [PostController::class,'addReview']);
Router::post('news/{id}/review/{reviewId}/update', [PostController::class,'updateReview']);
Router::post('news/{id}/review/{reviewId}/delete', [PostController::class,'deleteReview']);

Router::get('your-posts', [PostController::class,'getYourPosts']);
Router::get('your-posts/{status}', [PostController::class,'getYourPostsWithStatus']);

//Profile
Router::get('profile', [UserController::class,'index']);
Router::post('profile/update/avatar', [UserController::class,'updateAvatar']);
Router::post('profile/update/information', [UserController::class,'updateInformation']);

Router::get('profile/change-password', [UserController::class,'changePassword']);
Router::post('profile/update/password', [UserController::class,'updatePassword']);
