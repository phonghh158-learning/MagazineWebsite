<?php

use Helper\DateTimeAsia;

$title = "Chi tiết danh mục";
$css = '/assets/css/category.css';
$js = '/assets/js/category.js';

if (isset($_SESSION['user_id']) && $_SESSION['user_role'] == 'admin') {
    $name = $category->getName();
    $description = trim($category->getDescription());
    $icon = $category->getIcon();
    $createdAt = DateTimeAsia::toUTC7($category->getCreatedAt());
    $updatedAt = DateTimeAsia::toUTC7($category->getUpdatedAt());
    $deletedAt = DateTimeAsia::toUTC7($category->getDeletedAt());
}

$content = '
                <section class="show-category">
                    <div class="title">
                        <p id="title">Danh mục - Xem</p>
                    </div>
                    <form class="crud" action="/category/show/' . $id . '" method="POST">
                        <input type="text" name="action" id="action" hidden>
                        <input type="text" name="id" id="id" value="' . $id . '" hidden disabled>

                        <label for="name" id="lbl-name">Name</label>
                        <input type="text" name="name" id="name" value="' . $name . '" required disabled>

                        <label for="icon" id="lbl-icon">Icon</label>
                        <div class="input-group" id="group-icon">
                            <label class="input-item" for="icon">
                                <input type="radio" name="icon" id="icon" value="' . $icon . '" required disabled>
                                ' . $icon . '
                            </label>
                        </div>

                        <label for="description" id="lbl-description">Description</label>
                        <textarea name="description" id="description" required disabled>
                            ' . $description . '
                        </textarea>

                        <label for="created_at" id="lbl-created_at">Created At</label>
                        <input type="datetime-local" name="created_at" id="created_at" value="' . $createdAt . '" disabled>

                        <label for="updated_at" id="lbl-updated_at">Updated At</label>
                        <input type="datetime-local" name="updated_at" id="updated_at" value="' . $updatedAt . '" disabled>
                        
                        <p id="message"></p>
                        <div class="form-button" id="form-button">
                            <input type="reset" value="Reset">
                            <input type="submit" value="Submit">
                        </div>
                    </form>

                    <div class="function">
                        <div class="function-item" id="fn-show">
                            <i class=\'bx bx-show\'></i>
                            <span>&MediumSpace;&MediumSpace;&MediumSpace;</span>
                            <p>Xem</p>
                        </div>
                        <div class="function-item" id="fn-update">
                            <i class=\'bx bx-edit\'></i>
                            <span>&MediumSpace;&MediumSpace;&MediumSpace;</span>
                            <p>Chỉnh sửa</p>
                        </div>
                        <div class="function-item" id="fn-delete">
                            <i class=\'bx bx-trash\'></i>
                            <span>&MediumSpace;&MediumSpace;&MediumSpace;</span>
                            <p>Xóa</p>
                        </div>
                    </div>
                </section>
';

if ($deletedAt != null) {
    $content = '
                <section class="show-category">
                    <div class="title">
                        <p id="title">Đã xóa</p>
                    </div>
                    <label for="deleted_at" id="lbl-deleted_at">Deleted At</label>
                    <input type="datetime-local" name="deleted_at" id="deleted_at" value="' . $deletedAt . '" disabled>
                    <p id="message">Danh mục đã bị xóa</p>
                </section>
    ';
}

include __DIR__ . '/../../layout.php';

?>