<?php

$title = "Đọc báo";
$css = '/assets/css/magazine-post.css';

if ($post) {
    $postId = $post->getId();
    $postTitle = $post->getTitle();
    $postParagraphs = $post->getParagraphs();
    $thumbnail = $post->getThumbnail();
    $postStatus = $post->getStatus();
    $postCategory = $post->getCategoryName();
    $postAuthor = $post->getAuthorName();
    $postCreatedAt = $post->getCreatedAt()->format('d-m-Y');
}

$pNumber = 0;
$postContent = '';
foreach ($postParagraphs as $paragraph) {
    $pNumber++;
    $paragraphTitle = $paragraph['title'];
    $paragraphContent = $paragraph['content'];
    $postContent .= '
        <div class="paragraph" id="paragraph-' . $pNumber . '">
            <p class="paragraph-title">
                ' . $paragraphTitle . '
            </p>
            <p class="paragraph-content">
                ' . $paragraphContent . '
            </p>
        </div>
    ';
}

$actionHTML = '';

if ((isset($_SESSION['user_id']) && $post->getAuthorId() == $_SESSION['user_id'])
    || (isset($_SESSION['user_id']) && $_SESSION['user_role'] == 'admin')
    ) {
    $actionHTML = '
        <div class="function">
            <div class="function-item" id="btn-update">
                <a href="/news/update/' . $postId . '">
                    <i class=\'bx bx-edit\'></i>
                    <span>&MediumSpace;&MediumSpace;&MediumSpace;</span>
                    <p>Chỉnh sửa</p>
                </a>
            </div>
            <div class="function-item" id="btn-delete" onclick="openModal()">
                <a href="#">
                    <i class=\'bx bx-trash\'></i>
                    <span>&MediumSpace;&MediumSpace;&MediumSpace;</span>
                    <p>Xóa</p>
                </a>
            </div>
        </div>
    ';
}

$content = '
                <div class="magazine-post">
                    <img src="/' . $thumbnail . '" alt="thumbnail" class="thumbnail">
                    <div class="magazine-category">
                        <p>
                            '. $postCategory . '
                        </p>
                    </div>
                    <div class="magazine-title">
                        <p>
                            ' . $postTitle . '
                        </p>
                    </div>
                    <div class="magazine-information">
                        <p class="author">
                            Tác giả: ' . $postAuthor . '
                        </p>
                        <p class="date">
                            Ngày đăng: ' . $postCreatedAt . '
                        </p>
                    </div>
                    <div class="magazine-content">
                        ' . $postContent . '
                    </div>
                    ' . $actionHTML . '
                </div>

                <!-- Modal Panel -->
                <div id="deleteModal" class="modal">
                    <form action="/news/delete/' . $postId . '" method="POST" class="modal-content">
                        <input type="hidden" name="id" value="' . $postId . '">
                        <h2 class="modal-title">Xóa bài viết?</h2>
                        <p>Bạn có chắc chắn muốn xóa bài viết này không?<br/>Hành động này không thể hoàn tác.</p>
                        <div class="modal-buttons">
                            <button class="btn btn-cancel" onclick="closeModal()">Hủy</button>
                            <button type="submit" class="btn btn-delete" onclick="confirmDelete()">Xóa</button>
                        </div>
                    </form>
                </div>

';

$js = '/assets/js/magazine-post.js';

include_once __DIR__ . '/../../layout.php';

?>