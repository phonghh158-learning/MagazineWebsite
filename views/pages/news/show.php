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

function showReviewRatingStar($rating) {
    $ratingStarHTML = '';
    for ($i = 1; $i <= $rating; $i++) {
        $ratingStarHTML .= '
            <i class=\'bx bxs-star\' id="rating-' . $i . '"></i>
        ';
    }
    for ($i = $rating + 1; $i <= 5; $i++) {
        $ratingStarHTML .= '
            <i class=\'bx bx-star\' id="rating-' . $i . '"></i>
        ';
    }

    return $ratingStarHTML;
}
function showRatingText($rating) {
    $ratingText = '';
    switch ($rating) {
        case '1':
            $ratingText = 'Dở';
            break;
        case '2':
            $ratingText = 'Khá tệ';
            break;
        case '3':
            $ratingText = 'Tạm được';
            break;
        case '4':
            $ratingText = 'Hay';
            break;
        case '5':
            $ratingText = 'Xuất sắc';
            break;
        default:
            $ratingText = 'Khó đoán';
            break;
    }

    return $ratingText;
}

$reviewHTML = '';
if (isset($_SESSION['user_id'])) {
    $reviewHTML .= '<p class="magazine-review-title"> Đánh giá </p>';
    
    if ($_SESSION['user_id'] != $post->getAuthorId() && $_SESSION['user_role'] != 'admin') {
        if ($userReview == null) {
            $reviewHTML .= '
            <form class="review-form" action="/news/' . $postId . '/review/create" method="POST">
                <textarea name="review" id="review" placeholder="Hãy nêu đánh giá của bạn về bài viết tại đây"></textarea>
                <div class="review-function">
                    <div class="review-rating">
                        <i class=\'bx bx-star rating-star\'></i>
                        <i class=\'bx bx-star rating-star\'></i>
                        <i class=\'bx bx-star rating-star\'></i>
                        <i class=\'bx bx-star rating-star\'></i>
                        <i class=\'bx bx-star rating-star\'></i>
                        <input class="rating" type="number" name="rating" id="rating" min="1" max="5" value="" required>
                    </div>
                    <input type="submit" id="review-submit" value="Đăng" disabled>
                </div>
            </form>
        ';
        } else {
            $reviewHTML .= '
                <div class="your-review">
                    <div class="review-rating">
                        ' . showReviewRatingStar($userReview->getRating()) .'
                        <p>&ThickSpace;&ThickSpace;</p>
                        <div class="your-rating">
                            <div class="your-rating-number">
                                <p class="your-rating-value" id="your-rating-value">' . $userReview->getRating() . '</p>
                                <p class="rating-max">/5</p>
                            </div>
                            <p class="your-rating-text" id="your-rating-text">' . showRatingText($userReview->getRating()) . '</p>
                        </div>
                    </div>
                    <p class="review-text">
                        ' . $userReview->getComment() . '
                    </p>
                </div>
            ';
        }
    } else {
        if (!$reviewsList) {
            $reviewHTML .= '
                <p class="no-review">Bài viết hiện tại chưa có đánh giá</p>
            ';
        } else {
            foreach ($reviewsList as $review) {
                $reviewHTML .= '
                    <div class="your-review">
                        <p class="review-author"> ' . $review->getAuthorName() . ' - ' . $review->getAuthorUsername() . ' </p>
                        <div class="review-rating">
                            ' . showReviewRatingStar($review->getRating()) .'
                            <p>&ThickSpace;&ThickSpace;</p>
                            <div class="your-rating">
                                <div class="your-rating-number">
                                    <p class="your-rating-value" id="your-rating-value">' . $review->getRating() . '</p>
                                    <p class="rating-max">/5</p>
                                </div>
                                <p class="your-rating-text" id="your-rating-text">' . showRatingText($review->getRating()) . '</p>
                            </div>
                        </div>
                        <p class="review-text">
                            ' . $review->getComment() . '
                        </p>
                    </div>
                ';
            }
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