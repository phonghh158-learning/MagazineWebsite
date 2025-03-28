<?php
require_once __DIR__ . '/../helper/FileProcess.php';

use Helper\FileProcess;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["image"])) {
    $dir = $_POST["dir"] ?? "default";
    $name = $_POST["name"] ?? "uploaded_file";

    $result = FileProcess::uploadImage($_FILES["image"], $dir, $name);

    if (is_array($result)) {
        echo "Lỗi: " . implode(", ", $result);
    } else {
        echo "Upload thành công: " . $result;
    }
}
?>
