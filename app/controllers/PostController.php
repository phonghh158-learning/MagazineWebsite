<?php

    namespace App\controllers;

    use App\models\PostModel;
    use App\models\UserModel;
    use App\models\CategoryModel;
    use App\models\ReviewModel;
    use Exception;
    use Ramsey\Uuid\Uuid;
    use Helper\FileProcess;
    use Helper\Caculate;

    class PostController {
        private $model;
        private $userModel;
        private $categoryModel;
        private $reviewModel;

        public function __construct() {
            $this->model = new PostModel();
            $this->userModel = new UserModel();
            $this->categoryModel = new CategoryModel();
            $this->reviewModel = new ReviewModel();
        }

        public function index() {
            $categories = $this->categoryModel->getCategories();

            $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;

            $totalPosts = count($this->model->getAllPosts());
            $limit = 6;
            $offset = Caculate::paginateOffset($totalPosts, $currentPage, $limit);
            $posts = $this->model->getAllPostsPaginate($limit, $offset);
            require_once __DIR__ . '/../../views/pages/news/index.php';
        }

        public function show($id) {
            $post = $this->model->getPostById($id);

            $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
            $totalReviews = $this->reviewModel->getTotalReviewsByPostId($id);
            $limit = 5;
            $offset = Caculate::paginateOffset($totalReviews, $currentPage, $limit);
            $reviewsList = $this->reviewModel->getReviewsByPostId($id, $limit, $offset);

            if (isset($_SESSION['user_id'])) {
                $userReview = $this->reviewModel->getReviewByUserIdAndPostId($_SESSION['user_id'], $id);
            }
            require_once __DIR__ . '/../../views/pages/news/show.php';
        }

        public function getPostsByCategory($id): void {
            $categories = $this->categoryModel->getCategories();

            $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;

            $totalPosts = count($this->model->getPostsByCategory($id));
            $limit = 6;
            $offset = Caculate::paginateOffset($totalPosts, $currentPage, $limit);
            $posts = $this->model->getPostsByCategoryPaginate($id, $limit, $offset);
            require_once __DIR__ . '/../../views/pages/news/index.php';
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
        
                    $thumbnail = null;
                    if (!empty($_FILES['thumbnail']['name'])) {
                        $thumbnail = FileProcess::uploadImage($_FILES['thumbnail'], 'news', $id);
                        if (!$thumbnail) {
                            throw new Exception("Lỗi khi tải ảnh lên!");
                        }
                    } else {
                        throw new Exception("Vui lòng chọn hình ảnh!");
                    }
        
                    // Kiểm tra kết quả insert vào DB
                    $post = $this->model->createPost(
                        $id, $title, $thumbnail, 
                        $paragraphTitles, $paragraphContents, 
                        $categoryId, $authorId
                    );
                    
                    if (!$post) {
                        $_SESSION['notify'] = [
                            'type' => 'success',
                            'message' => 'Không thể tạo bài viết!'
                        ];
                        header("Location: /news");
                        exit();
                    }

                    $_SESSION['notify'] = [
                        'type' => 'success',
                        'message' => 'Tạo bài viết thành công! Hãy chờ duyệt!'
                    ];
        
                    header("Location: /news/{$id}");
                    exit();
                }
            } catch (Exception $e) {
                $_SESSION['notify'] = [
                    'type' => 'error',
                    'message' => $e->getMessage()
                ];
                header("Location: /news/");
                exit();
            }
        }

        public function update($id) {
            $post = $this->model->getPostById($id);
            $categories = $this->categoryModel->getCategories();
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
        
                    $thumbnail = null;
                    if (!empty($_FILES['thumbnail']['name'])) {
                        $thumbnail = FileProcess::uploadImage($_FILES['thumbnail'], 'news', $id);
                        if (!$thumbnail) {
                            throw new Exception("Lỗi khi tải ảnh lên!");
                        }
                    } else {
                        $thumbnail = trim($_POST['current-thumbnail']) ?? '';
                    }
        
                    $this->model->updatePost(
                        $id, $title, $thumbnail, 
                        $paragraphTitles, $paragraphContents, 
                        $status, $categoryId, $authorId
                    );

                    $_SESSION['notify'] = [
                        'type' => 'success',
                        'message' => 'Cập nhật bài viết thành công!'
                    ];
        
                    header("Location: /news/{$id}");
                    exit();
                }
            } catch (Exception $e) {
                $_SESSION['notify'] = [
                    'type' => 'error',
                    'message' => $e->getMessage()
                ];
                header("Location: /news/{$id}");
                exit();
            }
        }

        public function deletePost($id) {
            return $this->model->deletePost($id);
        }

        public function softDeletePost($id) {
            try {
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $password = $_POST['password'] ?? '';
                    $this->model->softDeletePost($id, $password);

                    $_SESSION['notify'] = [
                        'type' => 'success',
                        'message' => 'Xóa bài viết thành công!'
                    ];

                    header("Location: /news");
                    exit();
                }
            } catch (Exception $e) {
                $_SESSION['notify'] = [
                    'type' => 'error',
                    'message' => $e->getMessage()
                ];
                header("Location: /news/{$id}");
                exit();
            }
        }

        public function searchPost() {
            $searchInput = trim($_GET['search-input']);
            if (empty($searchInput)) {
                header('Location: /news');
                exit;
            }
            $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;

            $totalPosts = $this->model->searchTotalPost($searchInput);
            $limit = 6;
            $offset = Caculate::paginateOffset($totalPosts, $currentPage, $limit);
            $posts = $this->model->searchPost($searchInput, $limit, $offset);
            
            $categories = $this->categoryModel->getCategories();
            require_once __DIR__ . '/../../views/pages/news/index.php';
        }

        public function addReview($postId) {
            try {
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $rating = $_POST['rating'];
                    $review = trim($_POST['review']);

                    $this->reviewModel->createReview($postId, $rating, $review);

                    $_SESSION['notify'] = [
                        'type' => 'success',
                        'message' => 'Đã thêm đánh giá của bạn!'
                    ];

                    header("Location: /news/{$postId}");
                    exit();
                }
            } catch (Exception $e) {
                $_SESSION['notify'] = [
                    'type' => 'error',
                    'message' => $e->getMessage()
                ];
                header("Location: /news/{$postId}");
                exit();
            }
        }
    }

?>