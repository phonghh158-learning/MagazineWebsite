<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\repositories\CategoryRepository;

$repo = new CategoryRepository();

$categories = $repo->getAll();

foreach ($categories as $category) {
    echo $category->getName() . " - " . $category->getId() . "<br>";
}

?>