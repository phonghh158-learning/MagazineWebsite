<?php

require_once __DIR__ . '/../core/Database.php';

use core\Database;

$db = Database::getInstance()->getConnection();

if ($db) {
    echo "Kết nối thành công!";
} else {
    echo "Kết nối thất bại!";
}

?>