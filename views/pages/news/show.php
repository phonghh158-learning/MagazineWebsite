<?php

$title = "Đọc báo";
$css = '/assets/css/magazine-post.css';

if ($post) {
    $postId = $post->getId();
    $postTitle = $post->getTitle();
    $postContent = $post->getContent();
    $thumbnail = $post->getThumbnail();
    $postStatus = $post->getStatus();
}

$content = '
                <div class="magazine-post">
                    <img src="' . $thumbnail . '" alt="thumbnail" class="thumbnail">
                    <div class="magazine-category">
                        <p>
                            '. $category->getName() . '
                        </p>
                    </div>
                    <div class="magazine-title">
                        <p>
                            ' . $postTitle . '
                        </p>
                    </div>
                    <div class="magazine-information">
                        <p class="author">
                            Tác giả: ' . $author->getName() . '
                        </p>
                        <p class="date">
                            Ngày đăng: ' . $post->getCreateAt() . '
                        </p>
                    </div>
                    <div class="magazine-content">
                        ' . $postContent . '
                    </div>
                </div>
';

$js = '/assets/js/magazine-post.js';

include_once __DIR__ . '/../../layout.php';

?>