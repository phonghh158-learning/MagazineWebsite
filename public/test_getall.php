<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\repositories\CategoryRepository;
use Helper\DateTimeAsia;

$repo = new CategoryRepository();

$categories = $repo->getAll();

foreach ($categories as $category) {
    echo $category->getName() . " - " . $category->getId() . " - " . $category->getDescription() . "<br>";
}

?>