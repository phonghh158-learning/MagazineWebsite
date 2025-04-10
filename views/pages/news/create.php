<?php

use Helper\DateTimeAsia;

$title = 'Viết báo';
$css = '/assets/css/magazine-post.css';

$categoryOptions = '';

foreach ($categories as $category) {
    $categoryId = $category->getId();
    $categoryName = $category->getName();
    $categoryOptions .= '<option value="'.$categoryId.'">'.$categoryName.'</option>';
}

$content = '
    <form class="write-post-form" action="/news/create" method="POST" enctype="multipart/form-data">
        <input class="thumbnail" type="file" id="thumbnail" name="thumbnail" accept=".jpg, .jpeg, .png, .gif" required>
        <select name="category_id" id="category" class="category" required>
            <option value="" disabled selected>Chọn danh mục</option>
            ' .$categoryOptions. '
        </select>
        <input class="title" type="text" name="title" id="title" placeholder="Tiêu đề bài báo" required>
        <div class="magazine-information">
            <p class="author">
                <input type="text" name="author_id" id="author" value="' . $_SESSION['user_id'] . '" hidden required>
                Tác giả: ' . $author->getFullname() . '
            </p>
            <p class="date">
                Ngày đăng: '. DateTimeAsia::now()->format('d-m-Y') . '
            </p>
        </div>
        <div class="content" id="content">
            <div class="paragraph" id="paragraph-1">
                <input class="paragraph-title" type="text" name="paragraph_title[]" id="paragraph-title" placeholder="Tiêu đề đoạn văn" required>
                <textarea class="paragraph-content" name="paragraph_content[]" id="paragraph-content" cols="30" rows="10" placeholder="Nội dung đoạn văn" required></textarea>
            </div>
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
