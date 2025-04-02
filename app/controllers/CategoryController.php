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
                header("Location: /category");
                exit();
            }
        } catch(Exception $e) {
            error_log("Error: " . $e->getMessage());
            return false;
        }
    }

    public function updateCategory($id) {
        try {
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] == 'update') {
                $name = trim($_POST['name'] ?? '');
                $description = trim($_POST['description'] ?? '');
                $icon = trim($_POST['icon'] ?? '');

                $this->model->updateCategory($id, $name, $icon, $description);
                header("Location: /category");
                exit();
            }
        } catch(Exception $e) {
            error_log("Error: " . $e->getMessage());
            return false;
        }
    }

    public function deleteCategory($id) {
        try {
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] == 'delete') {
                $this->model->deleteCategory($id);
                header("Location: /category");
                exit();
            }
        } catch(Exception $e) {
            error_log("Error: " . $e->getMessage());
            return false;
        }
    }
}
