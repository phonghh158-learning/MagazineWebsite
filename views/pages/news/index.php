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
    if ($category->getId() == $post->getCategoryId()) {
        $postCategory = $category->getName();
    }
}

$newsListHTML = '';
foreach ($posts as $post) {
    $newsListHTML .= '
        <div class="item">
            <a href="#">
                <img src="/'. $post->getThumbnail() .'" alt="">
                <br />
                <div class="news-category">
                    <p> ' . $postCategory . ' </p>
                </div>
                <div class="news-title">
                    <p> ' . $post->getTitle() . ' </p>
                </div>
                <div class="news-about">
                    <p class="news-date"> ' . DateTimeAsia::toUTC7($post->getCreatedAt()) . ' </p>
                    <a href="#" class="news-author">
                        Xem thêm
                        <i class=\'bx bx-right-arrow-alt\'></i>
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
                            <div class="item">
                                <a href="#">
                                    <img src="images/home/5b63853da93f72554033ef2c52748378.jpg" alt="">
                                    <br />
                                    <div class="news-category">
                                        <p>
                                            Review
                                        </p>
                                    </div>
                                    <div class="news-title">
                                        <p>
                                            Tên bản tin
                                        </p>
                                    </div>
                                    <div class="news-about">
                                        <p class="news-date">
                                            12/03/2025
                                        </p>
                                        <p class="news-author">
                                            Farre Virtuoso
                                        </p>
                                    </div>
                                </a>
                            </div>
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