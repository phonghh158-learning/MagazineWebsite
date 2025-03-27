<?php
$title = "Danh sách danh mục";
$css = "/assets/css/category.css";

$str = "";
if (!empty($categories)) {
    foreach ($categories as $category) {
        $id = $category->getId();
        $name = $category->getName();
        $icon = $category->getIcon();
        $str .= "<div class=\"item\">
                    <a href=\"/category/show/{$id}\">
                        {$icon}
                        <p>{$name}</p>
                    </a>
                </div> ";
    }
}

$addStr = "";
if (isset($_SESSION['user_id']) && $_SESSION['user_role'] == 'admin') {
    $addStr = '
        <div class="section-button">
            <a href="/category/create">
                <i class="bx bx-plus" style="margin: 4px 4px 0 0;"></i>
                Thêm
            </a>
        </div>';
} 

$content = '
                <section id="category">
                    <div class="title">
                        <p>
                            Danh mục tin
                        </p>
                    </div>
                    <div class="category-list">'
                        . $str .
                    '</div>
                    ' . $addStr . '
                </section>
';

include __DIR__ . '/../../layout.php';

?>