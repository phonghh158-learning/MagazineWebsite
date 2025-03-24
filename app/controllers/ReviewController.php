<?php

    namespace App\controllers;

    use App\repositories\ReviewRepository;
    use Exception;

    class ReviewController {
        private $repository;

        public function __construct() {
            $this->repository = new ReviewRepository();
        }

        public function getReviews() {
            return $this->repository->getAll();
        }

        public function getReview($id) {
            return $this->repository->getById($id);
        }

        public function createReview() {
            try {
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $rating = $_POST['rating'] ?? 0;
                    $content = trim($_POST['content'] ?? '');
                    $postId = trim($_POST['post_id'] ?? '');
                    $userId = trim($_POST['user_id'] ?? '');

                    if (empty($content) || empty($postId) || empty($userId) || empty($rating)) {
                        throw new Exception("Vui lòng nhập đầy đủ thông tin!");
                    }

                    return $this->repository->createReview($postId, $userId, $rating, $content);
                }
            } catch (Exception $e) {
                error_log("Error: " . $e->getMessage());
                throw new Exception($e->getMessage());
            }
        }
    }

?>