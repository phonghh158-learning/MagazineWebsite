<?php

    namespace App\models;

    use App\repositories\ReviewRepository;
    use App\repositories\PostRepository;
    use App\repositories\UserRepository;
    use Exception;

    class ReviewModel {
        private $reviewRepository;
        private $postRepository;
        private $userRepository;

        public function __construct() {
            $this->reviewRepository = new ReviewRepository();
            $this->postRepository = new PostRepository();
            $this->userRepository = new UserRepository();
        }

        private function validatePost($rating, $comment) {
            if (empty($rating) || empty($comment)) {
                return throw new Exception("Vui lòng nhập đầy đủ thông tin!");
            }
        }

        public function getReviewByPostId($postId, $limit, $offset) {
            return $this->reviewRepository->getReviewByPostIdPaginate($postId, $limit, $offset);
        }

        public function createReview($postId, $rating, $comment) {
            $this->validatePost($rating, $comment);
            return $this->reviewRepository->createReview($postId, $_SESSION['user_id'], $rating, $comment);
        }

        public function getReviewByUserId($userId) {
            return $this->reviewRepository->getReviewByUserId($userId);
        }

        public function getReviewByUserIdAndPostId($userId, $postId) {
            return $this->reviewRepository->getReviewByUserIdAndPostId($userId, $postId);
        }
    }

?>