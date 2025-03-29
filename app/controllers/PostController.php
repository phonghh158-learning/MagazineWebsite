<?php

    namespace App\controllers;

    use App\repositories\PostRepository;
    use App\repositories\CategoryRepository;
    use App\repositories\UserRepository;
    use Exception;
    use Ramsey\Uuid\Uuid;
    use Helper\FileProcess;

    class PostController {
        private $repository;
        private $categoryRepository;
        private $userRepository;

        public function __construct() {
            $this->repository = new PostRepository();
            $this->categoryRepository = new CategoryRepository();
            $this->userRepository = new UserRepository();
        }

        public function index() {
            $posts = $this->repository->getAll();
            $categories = $this->categoryRepository->getAll();
            require_once __DIR__ . '/../../views/pages/news/index.php';
        }

        public function getPosts() {
            return $this->repository->getPostByStatus('public');
        }

        public function show($id) {
            $post = $this->repository->getById($id);
            $category = $this->categoryRepository->getById($post->getCategoryId());
            $author = $this->userRepository->getById($post->getAuthorId());
            require_once __DIR__ . '/../../views/pages/news/show.php';
        }

        public function getPost($id) {
            return $this->repository->getById($id);
        }

        public function create() {
            $categories = $this->categoryRepository->getAll();
            $author = $this->userRepository->getById($_SESSION['user_id']);
            require_once __DIR__ . '/../../views/pages/news/create.php';
        }

        public function createPost() {
            try {
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['thumbnail'])) {
                    $id = Uuid::uuid4()->toString();
                    $title = trim($_POST['title']) ?? '';
                    $paragraphTitles = $_POST['paragraph_title'] ?? '';
                    $paragraphContents = $_POST['paragraph_content'] ?? '';
                    $status = 'pending';
                    $categoryId = trim($_POST['category_id']) ?? '';
                    $authorId = trim($_POST['author_id']) ?? '';
        
                    $errorText = [];
        
                    $content = '';
        
                    for ($i = 0; $i < count($paragraphTitles); $i++) {
                        $content .= '
                            <div class="paragraph" id="paragraph-' . ($i + 1) . '">
                                <p class="paragraph-title">
                                    ' . htmlspecialchars($paragraphTitles[$i]) . '
                                </p>
                                <p class="paragraph-content">
                                    ' . htmlspecialchars($paragraphContents[$i]) . '
                                </p>
                            </div>
                        ';
                    }
        
                    if (empty($title) || empty($content) || empty($categoryId) || empty($authorId)) {
                        $errorText[] = "Vui lòng nhập đầy đủ thông tin!";
                    }
        
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
                    $post = $this->repository->createPost($id, $title, $thumbnail, $content, $status, $categoryId, $authorId);
                    if (!$post) {
                        throw new Exception("Không thể tạo bài viết! Kiểm tra repository.");
                    }
        
                    header("Location: /news");
                }
            } catch (Exception $e) {
                echo "Lỗi hệ thống, vui lòng thử lại sau.";
                error_log("Lỗi createPost: " . $e->getMessage());
            }
        }

        public function updatePost($id) {
            try {
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $title = trim($_POST['title'] ?? '');
                    $content = trim($_POST['content'] ?? '');
                    $status = 'pending';
                    $categoryId = trim($_POST['category_id'] ?? '');
                    $authorId = trim($_POST['author_id'] ?? '');

                    $errorText = [];

                    if (empty($title) || empty($content) || empty($categoryId) || empty($authorId)) {
                        $errorText[] = ("Vui nhập đày đủ thông tin!");
                    }

                    $currentThumbnail = $this->repository->getThumbnailById($id);
                    $imageFile = $_FILES['thumbnail'] ?? null;
                    if (isset($imageFile)) {
                        $deleteImageStatus = FileProcess::deleteImage($currentThumbnail);
                        $thumbnail = FileProcess::uploadImage($imageFile, 'magazine-posts', $id);
                    } else {
                        $thumbnail = $currentThumbnail;
                    }

                    if (!isset($thumbnail)) {
                        $thumbnail = null;
                    }

                    if (!empty($errorText)) {
                        return $errorText;
                    }

                    $post = $this->repository->updatePost($id, $title, $content, $status, $thumbnail, $categoryId, $authorId);

                    return $post;
                }
            } catch (Exception $e) {
                error_log($e->getMessage());
                throw new Exception($e->getMessage());
            }
        }

        public function deletePost($id) {
            $deleteImageStatus = FileProcess::deleteImage($this->repository->getThumbnailById($id));
            return $this->repository->delete($id);
        }

        public function softDeletePost($id) {
            return $this->repository->softDelete($id);
        }

        public function searchPost($keyword) {
            return $this->repository->searchPost($keyword);
        }
    }

?>