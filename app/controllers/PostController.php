<?php

    namespace App\controllers;

    use App\repositories\PostRepository;
    use Exception;
    use Ramsey\Uuid\Uuid;
    use Helper\FileProcess;

    class PostController {
        private $repository;

        public function __construct() {
            $this->repository = new PostRepository();
        }

        public function getPosts() {
            return $this->repository->getAll();
        }

        public function getPost($id) {
            return $this->repository->getById($id);
        }

        public function createPost() {
            try {
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['thumbnail'])) {
                    $id = Uuid::uuid4()->toString();
                    $title = trim($_POST['title'] ?? '');
                    $content = trim($_POST['content'] ?? '');
                    $status = 'pending';
                    $categoryId = trim($_POST['category_id'] ?? '');
                    $authorId = trim($_POST['author_id'] ?? '');

                    $errorText = [];

                    if (empty($title) || empty($content) || empty($categoryId) || empty($authorId)) {
                        $errorText[] = ("Vui lòng nhập đầy đủ thông tin!");
                    }

                    $imageFile = $_FILES['thumbnail'] ?? null;
                    if (isset($imageFile)) {
                        $thumbnail = FileProcess::uploadImage($imageFile, 'magazine-posts', $id);
                    } else {
                        $errorText[] = ("Vui lòng chọn hình ánh!");
                        $thumbnail = null;
                    }

                    if (!isset($thumbnail)) {
                        $thumbnail = null;
                    }

                    if (!empty($errorText)) {
                        return $errorText;
                    }

                    $post = $this->repository->createPost($id, $title, $content, $status, $thumbnail, $categoryId, $authorId);

                    return $post;
                }
            } catch (Exception $e) {
                error_log($e->getMessage());
                throw new Exception($e->getMessage());
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