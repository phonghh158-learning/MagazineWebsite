<?php

namespace App\controllers;

use App\models\CategoryModel;
use Exception;

class CategoryController {
    private $model;

    public function __construct() {
        $this->model = new CategoryModel();
    }

    public function index() {
        $categories = $this->model->getCategories();
        require_once __DIR__ . "/../../views/pages/category/index.php";
    }

    public function show($id) {
        $category = $this->model->getCategory($id);
        require_once __DIR__ . "/../../views/pages/category/show.php";
    }

    public function create() {
        require_once __DIR__ . "/../../views/pages/category/create.php";
    }

    public function createCategory() {
        try {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $name = trim($_POST['name'] ?? '');
                $description = trim($_POST['description'] ?? '');
                $icon = trim($_POST['icon'] ?? '');

                $this->model->createCategory($name, $description, $icon);

                $_SESSION['notify'] = [
                    'type' => 'success',
                    'message' => 'Tạo danh mục thành công!'
                ];
                header("Location: /category");
                exit();
            }
        } catch(Exception $e) {
            $_SESSION['notify'] = [
                'type' => 'error',
                'message' => $e->getMessage()
            ];
            header("Location: /category");
            exit();
        }
    }

    public function updateCategory($id) {
        try {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $name = trim($_POST['name'] ?? '');
                $description = trim($_POST['description'] ?? '');
                $icon = trim($_POST['icon'] ?? '');

                $this->model->updateCategory($id, $name, $icon, $description);

                $_SESSION['notify'] = [
                    'type' => 'success',
                    'message' => 'Cập nhật danh mục thành công!'
                ];
                header("Location: /category/show/{$id}");
                exit();
            }
        } catch(Exception $e) {
            $_SESSION['notify'] = [
                'type' => 'error',
                'message' => $e->getMessage()
            ];
            header("Location: /category/show/{$id}");
            exit();
        }
    }

    public function deleteCategory($id) {
        try {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $password = $_POST['password'] ?? '';
                $this->model->deleteCategory($id, $password);

                $_SESSION['notify'] = [
                    'type' => 'success',
                    'message' => 'Xóa danh mục thành công!'
                ];

                header("Location: /category");
                exit();
            }
        } catch(Exception $e) {
            $_SESSION['notify'] = [
                'type' => 'error',
                'message' => $e->getMessage()
            ];
            header("Location: /category/show/{$id}");
            exit();
        }
    }
}
