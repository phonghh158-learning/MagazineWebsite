<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\entities\CategoryEntity;
use App\repositories\CategoryRepository;
use App\models\CategoryModel;
use Helper\Caculate;
use Helper\DateTimeAsia;

$model = new CategoryModel();
$res = $model->getTopCategories(4);

foreach ($res as $category) {
    echo $category->getName() . "<br>";
}

$postModel = new \App\models\PostModel();
$posts = $postModel->getPostsByStatus('public');

$firstPost = array_slice($posts, 0, 1);
var_dump($firstPost[0]->getParagraphs());
?>