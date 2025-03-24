<?php

namespace App\controllers;

class HomeController {
    public function index() {
        require_once __DIR__ . '/../../views/index.php';
    }

    public function about() {
        echo "Giới thiệu về Music Magazine!";
    }

    public function contact() {
        echo "Liên hệ với chúng tôi!";
    }
}
