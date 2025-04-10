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

$statusHTML = '';
if ($post->getStatus() == 'public') {
    $statusHTML = '
        <input class="status" type="text" name="status" value="Đã xuất bản" readonly>
    ';
} elseif ($post->getStatus() == 'pending') {
    $statusHTML = '
        <input class="status" type="text" name="status" value="Đang chờ duyệt" readonly>
    ';
} elseif ($post->getStatus() == 'deleted') {
    $statusHTML = '
        <input class="status" type="text" name="status" value="Bài viết đã xóa" readonly>
    ';
}


$pNumber = 0;
$categoriesHTML = '';
$paragraphHTML = '';

$paragraphFunction = '';
$thumbnailHTML = '';
$readonlyStatus = '';
if (isset($_SESSION['user_id'])) {
    // Set hiển thị bài viết khi chỉnh sửa
    // Nếu là tác giả thì cho thay đổi
    if ($post->getAuthorId() == $_SESSION['user_id']) {
        $categoriesHTML = '
            <select name="category_id" id="category" class="category" required>
                <option value="" disabled>Chọn danh mục</option>
                ' .$categoryOptions. '
            </select>
        ';

        $thumbnailHTML = '
            <input class="thumbnail" type="file" id="thumbnail" name="thumbnail" accept=".jpg, .jpeg, .png, .gif"
            style="background-image: url(/' . $post->getThumbnail() . ');">
        ';

        foreach ($post->getParagraphs() as $paragraph) {
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

        $paragraphFunction = '
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
        ';
    } else {
        //Nếu không phải tác giả -> nhưng là admin -> chỉ cho phép duyệt bài viết, những nội dung khác chỉ đọc
        if ($_SESSION['user_role'] == 'admin') {
            $categoriesHTML = '
                <input type="hidden" name="category_id" value="' . $post->getCategoryId() . '" readonly>
                <input class="category" type="text" name="category" value="' . $post->getCategoryName() . '" readonly>
            ';

            $thumbnailHTML = '
                <input type="file" id="thumbnail" name="thumbnail" value="' . $post->getThumbnail() . '" hidden>
                <img class="img-thumbnail" src="/' . $post->getThumbnail() . '" alt="Thumbnail">
            ';

            foreach ($post->getParagraphs() as $paragraph) {
                $pNumber++;
                $paragraphTitle = $paragraph['title'];
                $paragraphContent = $paragraph['content'];
                $paragraphHTML .= '
                    <div class="paragraph" id="paragraph-' . $pNumber . '">
                        <input class="paragraph-title" type="text" name="paragraph_title[]" id="paragraph-title" value="' . $paragraphTitle . '" placeholder="Tiêu đề đoạn văn" required readonly>
                        <textarea class="paragraph-content" name="paragraph_content[]" id="paragraph-content" cols="30" rows="10" placeholder="Nội dung đoạn văn" required readonly>
                            ' . trim(htmlspecialchars($paragraphContent)) . '
                        </textarea>
                    </div>
                ';
            }

            $paragraphFunction = '
                <div class="paragraph-function" style="display: none;">
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
            ';

            $readonlyStatus = 'readonly';
        }
    }
}


$content = '
    <form class="write-post-form" action="/news/update/' . $post->getId() . '" method="POST" enctype="multipart/form-data">
        <input type="text" name="id" value="' . $post->getId() . '" hidden>
        ' . $statusHTML . '
        ' . $thumbnailHTML . '
        <input type="text" name="current-thumbnail" value="' . $post->getThumbnail() . '" hidden>
        ' . $categoriesHTML . '
        <input class="title" type="text" name="title" id="title" value="' . $post->getTitle() . '" placeholder="Tiêu đề bài báo" required ' . $readonlyStatus . '>
        <div class="magazine-information">
            <p class="author">
                <input type="text" name="author_id" id="author" value="' . $post->getAuthorId() . '" hidden required>
                Tác giả: ' . $post->getAuthorName() . '
            </p>
            <p class="date">
                Ngày đăng: '. $post->getCreatedAt()->format('d-m-Y') . '
            </p>
        </div>
        <div class="content" id="content">
            ' . $paragraphHTML . '
        </div>
        ' . $paragraphFunction . '
        <input class="submit" type="submit" value="Đăng bài">
    </form>
';

$js = '/assets/js/write-news.js';

include_once __DIR__ . '/../../layout.php';

?>