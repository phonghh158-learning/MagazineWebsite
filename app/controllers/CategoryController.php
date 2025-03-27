<?php

    namespace App\controllers;

    use App\repositories\CategoryRepository;
    use Exception;

    class CategoryController {
        private $repository;

        public function __construct() {
            $this->repository = new CategoryRepository();
        }

        public function index() {
            $categories = $this->repository->getAll();
            require_once __DIR__ . "/../../views/pages/category/index.php";
        }

        public function getCategories() {
            return $this->repository->getAll();
        }

        public function show($id) {
            $category = $this->repository->getById($id);
            require_once __DIR__ ."/../../views/pages/category/show.php";
        }

        public function getCategory($id) {
            return $this->repository->getById($id);
        }

        public function createCategory() {
            try {
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $name = trim($_POST['name'] ?? '');
                    $description = trim($_POST['description'] ?? '');
                    $icon = trim($_POST['icon'] ?? '');

                    $category = $this->repository->createCategory($name, $description, $icon);
                    
                    return $category;
                }
            } catch(Exception $e) {
                error_log("Error: " . $e->getMessage());
                return false;
            }
        }

        public function updateCategory($id) {
            try {
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $name = trim($_POST['name'] ?? '');
                    $description = trim($_POST['description'] ?? '');
                    $icon = trim($_POST['icon'] ?? '');

                    $category = $this->repository->updateCategory($id, $name, $description, $icon);
                    return $category;
                }
            } catch(Exception $e) {
                error_log("Error: " . $e->getMessage());
                return false;
            }
        }

        public function deleteCategory($id) {
            return $this->repository->delete($id);
        }

        public function softDeleteCategory($id) {
            return $this->repository->softDelete($id);
        }

    }

?>