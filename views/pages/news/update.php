<?php

use Helper\DateTimeAsia;

$title = 'Viết báo';
$css = '/assets/css/magazine-post.css';

$categoryOptions = '';

foreach ($categories as $category) {
    $categoryId = $category->getId();
    $categoryName = $category->getName();
    if ($categoryId == $post->getCategoryId()) {
        $categoryOptions .= '<option value="'.$categoryId.'" selected>'.$categoryName.'</option>';
    } else {
        $categoryOptions .= '<option value="'.$categoryId.'">'.$categoryName.'</option>';
    }
}

$paragraphs = $post->getParagraphs();
$pNumber = 0;
$paragraphHTML = '';
foreach ($paragraphs as $paragraph) {
    $pNumber++;
    $paragraphTitle = $paragraph['title'];
    $paragraphContent = $paragraph['content'];
    $paragraphHTML .= '
        <div class="paragraph" id="paragraph-' . $pNumber . '">
            <input class="paragraph-title" type="text" name="paragraph_title[]" id="paragraph-title" value="' . $paragraphTitle . '" placeholder="Tiêu đề đoạn văn" required>
            <textarea class="paragraph-content" name="paragraph_content[]" id="paragraph-content" cols="30" rows="10" placeholder="Nội dung đoạn văn" required>
                ' . trim(htmlspecialchars($paragraphContent)) . '
            </textarea>
        </div>
    ';
}

$content = '
    <form class="write-post-form" action="/news/update/' . $post->getId() . '" method="POST" enctype="multipart/form-data">
        <input type="text" name="id" value="' . $post->getId() . '" hidden>
        <select class="status" name="status" id="status" disabled>
            <option value="" disabled>Chọn trang thái</option>
            <option value="public" ' . ($post->getStatus() == 'public' ? 'selected' : '') . '>Đã đăng</option>
            <option value="pending" ' . ($post->getStatus() == 'pending' ? 'selected' : '') . '>Đang chờ duyệt</option>
            <option value="deleted" ' . ($post->getStatus() == 'deleted' ? 'selected' : '') . '>Bài viết đã xóa</option>
        </select>
        <input class="thumbnail" type="file" id="thumbnail" name="thumbnail" accept="image/*" style="background-image: url(/' . $post->getThumbnail() . '); background-size: cover;">
        <input type="text" name="current-thumbnail" value="' . $post->getThumbnail() . '" hidden>
        <select name="category_id" id="category" class="category" required>
            <option value="" disabled>Chọn danh mục</option>
            ' .$categoryOptions. '
        </select>
        <input class="title" type="text" name="title" id="title" value="' . $post->getTitle() . '" placeholder="Tiêu đề bài báo" required>
        <div class="magazine-information">
            <p class="author">
                <input type="text" name="author_id" id="author" value="' . $post->getAuthorId() . '" hidden required>
                Tác giả: ' . $post->getAuthorName() . '
            </p>
            <p class="date">
                Ngày đăng: '. $post->getCreatedAt()->format('Y-m-d') . '
            </p>
        </div>
        <div class="content" id="content">
            ' . $paragraphHTML . '
        </div>
        <div class="paragraph-function">
            <div class="paragraph-function-item" id="add-paragraph">
                <i class=\'bx bx-plus\'></i>
                <span>&MediumSpace;&MediumSpace;</span>
                <p>Thêm đoạn văn</p>
        </div>
    
            <div class="paragraph-function-item" id="delete-paragraph">
                <i class=\'bx bx-minus\'></i>
                <span>&MediumSpace;&MediumSpace;</span>
                <p>Xóa đoạn văn</p>
            </div>
        </div>
        <input class="submit" type="submit" value="Đăng bài">
    </form>
';

$js = '/assets/js/write-news.js';

include_once __DIR__ . '/../../layout.php';
