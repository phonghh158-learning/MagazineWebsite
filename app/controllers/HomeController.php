<?php

namespace App\controllers;
use App\models\PostModel;
use App\models\CategoryModel;

class HomeController {
    private $postModel;
    private $categoryModel;
    
    public function __construct() {
        $this->postModel = new PostModel();
        $this->categoryModel = new CategoryModel();
    }

    public function index() {
        $categories = $this->categoryModel->getTopCategories(4);
        $posts = $this->postModel->getPostsByStatus('public');

        $topPosts = array_slice($posts, 0, 3);

        // $firstPost = array_slice($posts, 0, 1)[0];
        // $secondPost = array_slice($posts, 1, 1)[0];
        // $threePost = array_slice($posts, 2, 1)[0];
        $homePostsList = array_slice($posts, 3, 6);

        require_once __DIR__ . '/../../views/index.php';
    }
}
