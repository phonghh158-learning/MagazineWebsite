<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\repositories\PostRepository;
use Helper\Caculate;
use Helper\DateTimeAsia;

$repo = new PostRepository();

$allPosts = $repo->getAll();
$limit = 9;
$offset = Caculate::paginateOffset(count($allPosts), 1, $limit);

var_dump($offset);
var_dump($limit);

$posts = $repo->getAllPaginate(9, 0);
var_dump($posts);

foreach ($posts as $p) {
    echo '<pre>';
    print_r($p);    
    echo '</pre>';
}

?>