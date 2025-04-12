<?php
$title = 'Nhật báo';
$css = '/assets/css/homepage.css';

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

$firstNewsHTML = '';
$secondNewsHTML = '';
$thirdNewsHTML = '';

$topPostsHTML = [];

if (empty($topPosts)) {
    $topPostsHTML[] = '';
} else {
    foreach ($topPosts as $post) {
        $paragraphs = $post->getParagraphs();
        $firstContent = isset($paragraphs[0]['content']) ? $paragraphs[0]['content'] : '';

        $topPostsHTML[] = '
            <img class="news-image" src="/'. $post->getThumbnail() .'" alt="News Image">
            <div class="news-title">
                ' . $post->getTitle() . '
            </div>
            <p class="news-content">
                ' . $firstContent . '
            </p>
            <div class="news-read-btn">
                <a href="/news/'. $post->getId() .'">Đọc<i class=\'bx bx-right-arrow-alt\'></i></a>
            </div>
        ';
    }
}

// if (!isset($firstPost)) {
//     $firstNewsHTML = '';
// } else {
//     $firstNewsHTML = '
//         <img class="news-image" src="/'. $firstPost->getThumbnail() .'" alt="First News Image">
//         <div class="news-title">
//             ' . $firstPost->getTitle() . '
//         </div>
//         <p class="news-content">
//             ' . $firstPost->getParagraphs()[0]['content'] . '
//         </p>
//         <div class="news-read-btn">
//             <a href="#">Đọc<i class=\'bx bx-right-arrow-alt\'></i></a>
//         </div>
//     ';
// }

$postHTML = '';
if (empty($posts)) {
    $postHTML = '<p class="no-posts">Không có bài viết nào trong danh mục này.</p>';
} else {
    foreach ($homePostsList as $post) {
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
}

$content = '
                    <section id="homepage">
                        <div class="first-news">
                            ' . $topPostsHTML[0] . '
                        </div>
                        <div class="second-third-news">
                            <div class="second-news">
                                ' . $topPostsHTML[1] . '
                            </div>
                            <div class="third-news">
                                ' . $topPostsHTML[2] . '
                            </div>
                        </div>
                    </section>

                    <section id="news">
                        <div class="title"><p>Báo mới</p></div>
                        <div class="magazine-posts">
                            ' . $postHTML . '
                        </div>
                        <div class="section-button">
                            <a href="/news">
                                Xem Thêm
                            </a>
                        </div>
                    </section>

                    <section id="category">
                        <div class="title"><p>Top Danh mục</p></div>
                        <div class="category-list">
                            ' . $categoriesHTML . '
                        </div>
                    </section>
';

include_once __DIR__ . '/layout.php';

?>