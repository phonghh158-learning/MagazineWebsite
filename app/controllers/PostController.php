<?php

    namespace App\controllers;

    use App\models\PostModel;
    use App\models\UserModel;
    use App\models\CategoryModel;
    use Exception;
    use Ramsey\Uuid\Uuid;
    use Helper\FileProcess;

    class PostController {
        private $model;
        private $userModel;
        private $categoryModel;

        public function __construct() {
            $this->model = new PostModel();
            $this->userModel = new UserModel();
            $this->categoryModel = new CategoryModel();
        }

        public function index() {
            $posts = $this->model->getAllPosts();
            require_once __DIR__ . '/../../views/pages/news/index.php';
        }

        public function show($id) {
            $post = $this->model->getPostById($id);
            require_once __DIR__ . '/../../views/pages/news/show.php';
        }

        public function create() {
            $categories = $this->categoryModel->getCategories();
            $author = $this->userModel->getUserById($_SESSION['user_id']);
            require_once __DIR__ . '/../../views/pages/news/create.php';
        }

        public function createPost() {
            try {
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['thumbnail'])) {
                    $id = Uuid::uuid4()->toString();
                    $title = trim($_POST['title']) ?? '';
                    $paragraphTitles = $_POST['paragraph_title'] ?? '';
                    $paragraphContents = $_POST['paragraph_content'] ?? '';
                    $status = 'public';
                    $categoryId = trim($_POST['category_id']) ?? '';
                    $authorId = trim($_POST['author_id']) ?? '';
        
                    $errorText = [];
        
                    $thumbnail = null;
                    if (!empty($_FILES['thumbnail']['name'])) {
                        $thumbnail = FileProcess::uploadImage($_FILES['thumbnail'], 'news', $id);
                        if (!$thumbnail) {
                            $errorText[] = "Lỗi khi tải ảnh lên!";
                        }
                    } else {
                        $errorText[] = "Vui lòng chọn hình ảnh!";
                    }
        
                    if (!empty($errorText)) {
                        return $errorText;
                    }
        
                    // Kiểm tra kết quả insert vào DB
                    $post = $this->model->createPost(
                        $id, $title, $thumbnail, 
                        $paragraphTitles, $paragraphContents, 
                        $status, $categoryId, $authorId
                    );
                    
                    if (!$post) {
                        echo("Không thể tạo bài viết! Kiểm tra model.");
                    }
        
                    header("Location: /news");
                }
            } catch (Exception $e) {
                error_log("Lỗi createPost: " . $e->getMessage());
            }
        }

        public function update($id) {
            $post = $this->model->getPostById($id);
            $categories = $this->categoryModel->getCategories();
            $author = $this->userModel->getUserById($_SESSION['user_id']);
            require_once __DIR__ . '/../../views/pages/news/update.php';
        }

        public function updatePost() {
            try {
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['thumbnail'])) {
                    $id = trim($_POST['id']) ?? '';
                    $title = trim($_POST['title']) ?? '';
                    $paragraphTitles = $_POST['paragraph_title'] ?? '';
                    $paragraphContents = $_POST['paragraph_content'] ?? '';
                    $status = trim($_POST['status']) ?? '';
                    $categoryId = trim($_POST['category_id']) ?? '';
                    $authorId = trim($_POST['author_id']) ?? '';
        
                    $errorText = [];
        
                    if (empty($title) || empty($content) || empty($categoryId) || empty($authorId)) {
                        $errorText[] = "Vui，请 输入所有信息!";
                    }
        
                    $thumbnail = null;
                    if (!empty($_FILES['thumbnail']['name'])) {
                        $thumbnail = FileProcess::uploadImage($_FILES['thumbnail'], 'news', $id);
                        if (!$thumbnail) {
                            $errorText[] = "Lỗi khi tải ảnh lên!";
                        }
                    } else {
                        $errorText[] = "Vui，请 选择图片!";
                    }
        
                    if (!empty($errorText)) {
                        return $errorText;
                    }
        
                    $post = $this->model->updatePost(
                        $id, $title, $thumbnail, 
                        $paragraphTitles, $paragraphContents, 
                        $status, $categoryId, $authorId
                    );
                    
                    if (!$post) {
                        throw new Exception("Không thể tạo bài viết! Kiểm tra model.");
                    }
        
                    header("Location: /news");
                }
            } catch (Exception $e) {
                error_log("Lỗi updatePost: " . $e->getMessage());
            }
        }

        public function deletePost($id) {
            return $this->model->deletePost($id);
        }

        public function softDeletePost($id) {
            return $this->model->softDeletePost($id);
        }

        public function searchPost($keyword) {
            return $this->model->searchPost($keyword);
        }
    }

?>