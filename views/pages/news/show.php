<?php

$title = "Đọc báo";
$css = '/assets/css/magazine-post.css';

// Kiểm tra bài viết tồn tại -> gán viewmodal
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

// Hiện bài viết theo đoạn
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

// Hiển thị chức năng nếu bạn là admin hoặc người tạo bài viết
$actionHTML = '';
if ((isset($_SESSION['user_id']) && $post->getAuthorId() == $_SESSION['user_id'] && $postStatus == 'pending')
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
            <div class="function-item" id="btn-delete" onclick="openDeleteModal(\'' . $id . '\', \'news\')">
                <a href="#">
                    <i class=\'bx bx-trash\'></i>
                    <span>&MediumSpace;&MediumSpace;&MediumSpace;</span>
                    <p>Xóa</p>
                </a>
            </div>
        </div>
    ';
}

// Hiển thị đánh giá
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

// Hiển thị form đánh giá - Phải đăng nhập mới hiển thị form đánh giá
$reviewHTML = '';
if (isset($_SESSION['user_id'])) {
    $reviewHTML .= '<p class="magazine-review-title"> Đánh giá </p>';
    // User không phải là admin hoặc người tạo bài viết mới được đánh giá
    if ($_SESSION['user_id'] != $post->getAuthorId() && $_SESSION['user_role'] != 'admin') {
        // Nếu chưa đánh giá -> hiện form đánh giá
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
                        <input class="rating" type="number" name="rating" id="rating" min="1" max="5" value="" hidden required>
                    </div>
                    <input type="submit" id="review-submit" value="Đăng" disabled>
                </div>
            </form>
        ';
        } else {
            //Nếu đã đánh giá -> hiện đánh giá, có nút chỉnh sửa
            $reviewHTML .= '
                <div class="your-review">
                    <div class="fn-review" id="fn-review-delete" 
                    onclick="openDeleteReviewModal(
                        \'' . $postId . '\',
                        \'' . $userReview->getId() . '\'
                    )">
                        <i class=\'bx bx-trash-alt\'></i>
                        <p>Xóa</p>
                    </div>
                    <div class="fn-review" id="fn-review-update" style="right: "
                    onclick="openEditReviewModal(
                        \'' . $postId . '\',
                        \'' . $userReview->getId() . '\',
                        \'' . htmlspecialchars($userReview->getComment()) . '\',
                        \'' . $userReview->getRating() . '\'
                    )">
                        <i class=\'bx bx-edit\'></i>
                        <p>Chỉnh sửa</p>
                    </div>
                    <p class="review-author"> ' . $userReview->getAuthorName() . ' - ' . $userReview->getAuthorUsername() . ' </p>
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
        // Nếu là nguoi tạo bài viết hoặc admin -> hiện danh sách đánh giá
        if (!$reviewsList) {
            $reviewHTML .= '
                <p class="no-review">Bài viết hiện tại chưa có đánh giá</p>
            ';
        } else {
            //Nếu là admin -> có nút ẩn đánh giá
            if ($_SESSION['user_role'] == 'admin') {
                foreach ($reviewsList as $review) {
                    $reviewHTML .= '
                        <div class="your-review">
                            <div class="fn-review" id="fn-review-delete" 
                            onclick="openDeleteReviewModal(
                                \'' . $postId . '\',
                                \'' . $review->getId() . '\'
                            )">
                                <i class=\'bx bx-trash-alt\'></i>
                                <p>Xóa</p>
                            </div>
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
            } else {
                // Nếu là người tạo bài viết -> chỉ hiện danh sách đánh giá
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
}

// Hiển thị nội dung trang
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

                <!-- Modal xác nhận xóa Post -->
                <div class="modal-overlay" id="modal-overlay">
                    <form class="modal-box" method="POST" id="delete-form">
                        <span class="close-modal" onclick="closeDeleteModal()"><i class="bx bx-x"></i></span>
                        <h2>Xác nhận xóa</h2>
                        <p>Bạn có chắc chắn muốn xóa mục này? Nhập mật khẩu để xác nhận.</p>
                        <input type="password" name="password" placeholder="Nhập mật khẩu..." required>
                        <div class="modal-actions">
                        <button type="button" class="btn btn-cancel" onclick="closeDeleteModal()">Hủy</button>
                        <button type="submit" class="btn btn-delete">Xóa</button>
                        </div>
                    </form>
                </div>

                <!-- Modal chỉnh sửa review -->
                <div class="modal-overlay" id="edit-review-overlay">
                    <form class="modal-box review-form" id="edit-review-form" method="POST">
                        <span class="close-modal" onclick="closeEditReviewModal()"><i class="bx bx-x"></i></span>
                        <h2>Chỉnh sửa đánh giá</h2>
                        <br/>
                        <textarea name="review" id="edit-review-text" placeholder="Chỉnh sửa đánh giá của bạn"></textarea>
                        <div class="review-function">
                            <div class="review-rating" id="edit-review-stars">
                                <i class=\'bx bx-star rating-star\' id="edit-rating-1"></i>
                                <i class=\'bx bx-star rating-star\' id="edit-rating-2"></i>
                                <i class=\'bx bx-star rating-star\' id="edit-rating-3"></i>
                                <i class=\'bx bx-star rating-star\' id="edit-rating-4"></i>
                                <i class=\'bx bx-star rating-star\' id="edit-rating-5"></i>
                                <input class="rating" type="number" name="rating" id="edit-rating" min="1" max="5" value="" hidden required>
                            </div>
                            <input type="submit" id="edit-review-submit" value="Cập nhật" disabled>
                        </div>
                    </form>
                </div>

                <!-- Modal xác nhận xóa Review -->
                <div class="modal-overlay" id="delete-review-overlay">
                    <form class="modal-box" method="POST" id="delete-review-form">
                        <span class="close-modal" onclick="closeDeleteReviewModal()"><i class="bx bx-x"></i></span>
                        <h2>Xác nhận xóa đánh giá</h2>
                        <p>Bạn có chắc chắn muốn xóa đánh giá này? Nhập mật khẩu để xác nhận.</p>
                        <input type="password" name="password-review-delete" placeholder="Nhập mật khẩu..." required>
                        <div class="modal-actions">
                            <button type="button" class="btn btn-cancel" onclick="closeDeleteReviewModal()">Hủy</button>
                            <button type="submit" class="btn btn-delete">Xóa</button>
                        </div>
                    </form>
                </div>

';

$js = '/assets/js/magazine-post.js';

include_once __DIR__ . '/../../layout.php';

?>