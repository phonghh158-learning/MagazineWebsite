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
            <a href="#">
                ' . $categoryIcon . $categoryName . '
            </a>
        </div>
    ';
}

$postHTML = '';
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
                    <p class="news-date"> ' . DateTimeAsia::toUTC7($post->getCreatedAt()) . ' </p>
                    <a href="#" class="news-author">
                        ' . $post->getAuthorName() . '
                    </a>
                </div>
            </a>
        </div>
    ';
}

$content = '
                    <form class="search-box" accept="/search" method="GET">
                        <input type="text" placeholder="Nhập từ khóa...">
                        <i class=\'bx bx-search icon\'></i>
                        <button type="submit">
                            <i class=\'bx bx-search\'></i>
                        </button>
                    </form>
                    
                    <section id="category">
                        <div class="category-list">
                            ' . $categoriesHTML . '
                        </div>
                    </section>
                    <br><br>
                    <section id="news">
                        <div class="magazine-posts">
                            ' . $postHTML . '
                        </div>

                        <div class="section-button">
                            <a href="#">
                                Xem thêm
                            </a>
                        </div>
                    </section>
';

include_once __DIR__ . '/../../layout.php';

?>