<?php

$title = "Danh mục - Tạo";
$css = "/assets/css/category.css";
$js = "/assets/js/create-category.js";

$content = '
                <section class="show-category">
                    <div class="title">
                        <p id="title">' . $title . '</p>
                    </div>
                    <form class="crud" action="/category/create" method="POST">
                        <label for="name" id="lbl-name">Tên danh mục</label>
                        <input type="text" name="name" id="name" placeholder="Tên danh mục..." required>

                        <label for="icon" id="lbl-icon">Icon</label>
                        <div class="input-group" id="group-icon">
                            
                        </div>

                        <label for="description" id="lbl-description">Mô tả:</label>
                        <textarea name="description" id="description" placeholder="Mô tả danh mục..." required></textarea>
                        
                        <div class="form-button" id="form-button">
                            <input type="reset" value="Reset">
                            <input type="submit" value="Submit">
                        </div>
                    </form>
                </section>
';

include_once __DIR__ . '/../../layout.php';

?>