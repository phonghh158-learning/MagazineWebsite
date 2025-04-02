<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\entities\CategoryEntity;
use App\repositories\CategoryRepository;
use App\models\CategoryModel;
use Helper\Caculate;
use Helper\DateTimeAsia;

$repo = new CategoryRepository();

$categories = $repo->getAll();

foreach ($categories as $category) {
    echo $category->getName() . "<br>";
}

$model = new CategoryModel();
$res = $model->updateCategory("bdfabd14-d7e8-44cf-baea-9fc2a9103461", "Danh muc TESTEST", "<i class='bx bx-bowl-rice'></i>", "Description TESTEST");

if ($res) {
    echo "Thanh cong";
}

?>