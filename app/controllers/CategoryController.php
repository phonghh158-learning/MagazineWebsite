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

        public function create() {
            require_once __DIR__ ."/../../views/pages/category/create.php";
        }

        public function createCategory() {
            try {
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $name = trim($_POST['name'] ?? '');
                    $description = trim($_POST['description'] ?? '');
                    $icon = trim($_POST['icon'] ?? '');

                    $category = $this->repository->createCategory($name, $description, $icon);
                    
                    if ($category) {
                        header("Location: /category");
                        exit();
                    } else {
                        return false;
                    }
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

                    $category = $this->repository->updateCategory($id, $name, $description, $icon);

                    if ($category) {
                        header("Location: /category");
                        exit();
                    } else {
                        return false;
                    }
                } 
            } catch(Exception $e) {
                error_log("Error: " . $e->getMessage());
                return false;
            }
        }

        public function deleteCategory($id) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] == 'delete') {
                $deleteStatus = $this->repository->delete($id);
                if ($deleteStatus) {
                    header("Location: /category");
                    exit();
                } else {
                    return false;
                }
            }
        }

        public function softDeleteCategory($id) {
            return $this->repository->softDelete($id);
        }

    }

?>