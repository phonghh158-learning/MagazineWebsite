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

$reviewHTML = '';
if (isset($_SESSION['user_id'])) {
    if ($_SESSION['user_id'] != $post->getAuthorId() && $_SESSION['user_role'] != 'admin') {
        if ($userReview == null) {
            $reviewHTML = '
            <form class="review-form" action="/news/' . $postId . '/review/create" method="POST">
                <textarea name="review" id="review" placeholder="Hãy nêu đánh giá của bạn về bài viết tại đây"></textarea>
                <div class="review-function">
                    <div class="review-rating">
                        <i class=\'bx bx-star rating-star\'></i>
                        <i class=\'bx bx-star rating-star\'></i>
                        <i class=\'bx bx-star rating-star\'></i>
                        <i class=\'bx bx-star rating-star\'></i>
                        <i class=\'bx bx-star rating-star\'></i>
                        <input class="rating" type="number" name="rating" id="rating" min="1" max="5" hidden required>
                    </div>
                    <input type="submit" id="review-submit" value="Đăng" disabled>
                </div>
            </form>
        ';
        } else {
            $reviewHTML = '
                <div class="your-review">
                    <div class="review-rating">
                        <i class=\'bx bx-star\' id="rating-1"></i>
                        <i class=\'bx bx-star\' id="rating-2"></i>
                        <i class=\'bx bx-star\' id="rating-3"></i>
                        <i class=\'bx bx-star\' id="rating-4"></i>
                        <i class=\'bx bx-star\' id="rating-5"></i>
                        <p>&ThickSpace;&ThickSpace;</p>
                        <div class="your-rating">
                            <div class="your-rating-number">
                                <p class="your-rating-value" id="your-rating-value">' . $userReview->getRating() . '</p>
                                <p class="rating-max">/5</p>
                            </div>
                            <p class="your-rating-text">Khá hay</p>
                        </div>
                    </div>
                    <p class="review-text">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                    </p>
                </div>
            ';
        }
    }
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


                <!-- Review -->
                <div class="magazine-review">
                    <p class="magazine-review-title"> Đánh giá </p>
                    ' . $reviewHTML . '
                </div>

                <!-- Modal Panel -->
                <div id="deleteModal" class="modal">
                    <form action="/news/delete/' . $postId . '" method="POST" class="modal-content">
                        <input type="hidden" name="id" value="' . $postId . '">
                        <h2 class="modal-title">Xóa bài viết?</h2>
                        <p>Bạn có chắc chắn muốn xóa bài viết này không?<br/>Hành động này không thể hoàn tác.</p>
                        <br/>
                        <label for="password" id="lbl-password">Vui lòng nhập mật khẩu</label><br/>
                        <input type="password" name="password" id="password" placeholder="Nhập mật khẩu để xóa" required>
                        <div class="modal-buttons">
                            <button class="btn btn-cancel" onclick="closeModal()">Hủy</button>
                            <button type="submit" class="btn btn-delete" onclick="closeModal()">Xóa</button>
                        </div>
                    </form>
                </div>

';

$js = '/assets/js/magazine-post.js';

include_once __DIR__ . '/../../layout.php';

?>