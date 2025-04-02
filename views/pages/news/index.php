<?php

use Helper\DateTimeAsia;

$title = "Bài báo";
$css = '/assets/css/magazine-list.css';

$categoriesHTML = '';
foreach ($categories as $category) {
    $categoryName = $category->getName();
    $categoryIcon = $category->getIcon();
    $categoriesHTML .= '
        <div class="item">
            <a href="/news/category/' . $category->getId() . '">
                ' . $categoryIcon . $categoryName . '
            </a>
        </div>
    ';
}

$paginationHTML = '';
$postHTML = '';
if (empty($posts)) {
    $postHTML = '<p class="no-posts">Không có bài viết nào trong danh mục này.</p>';
} else {
    foreach ($posts as $post) {
        $postHTML .= '
            <div class="item">
                <a href="/news/'. $post->getId() .'">
                    <img src="/'. $post->getThumbnail() .'" alt="">
                    <br />
                    <div class="news-category">
                        <p> ' . $post->getCategoryName() . ' </p>
                    </div>
                    <div class="news-title">
                        <p> ' . $post->getTitle() . ' </p>
                    </div>
                    <div class="news-about">
                        <p class="news-date"> ' . $post->getCreatedAt()->format('d-m-Y') . ' </p>
                        <a href="#" class="news-author">
                            ' . $post->getAuthorName() . '
                        </a>
                    </div>
                </a>
            </div>
        ';
    }

    $currentPage = $currentPage ?? 1;
    $totalPage = ceil($totalPosts / $limit);
    $paginationHTML = '
        </form>
        <form class="pagination" id="pagination" method="GET">
            <label for="page">Trang</label>
            <div>
                <input type="number" name="page" id="page" min="1" max="' . $totalPage . '" value="' . $currentPage . '" step="1">
                <span>/' . $totalPage . '</span>
            </div>
            <button type="submit"><i class=\'bx bx-right-arrow-alt\'></i></button>
        </form>
    ';
}


if (isset($_SESSION['user_id'])) {
    
}



$content = '
                    <form class="search-box" action="/news/search" method="GET">
                        <input type="text" id="search-input" name="search-input" placeholder="Tìm kiếm tiêu đề bài báo">
                        <i class=\'bx bx-search icon\'></i>
                        <button type="submit">
                            <i class=\'bx bx-search\'></i>
                        </button>
                    </form>
                    
                    <section id="category">
                        <div class="category-list">
                            <div class="item">
                                <a href="/news">
                                    <i class=\'bx bx-list-ul\'></i>Tất cả
                                </a>
                            </div>
                            ' . $categoriesHTML . '
                        </div>
                    </section>
                    <br><br>
                    <section id="news">
                        <div class="magazine-posts">
                            ' . $postHTML . '
                        </div>
                        
                        ' . $paginationHTML . '

                    </section>
';

$js = '/assets/js/magazine-list.js';
include_once __DIR__ . '/../../layout.php';

?>