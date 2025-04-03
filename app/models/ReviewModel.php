<?php

    namespace App\models;

    use App\entities\ReviewEntity;
    use App\viewmodels\ReviewViewModel;
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

        private function mapToViewModel(ReviewEntity $review) {
            $author = $this->userRepository->getById($review->getUserId());
            return new ReviewViewModel(
                $review->getId(),
                $review->getPostId(),
                $review->getUserId(),
                $author->getFullname(),
                $author->getUsername(),
                $review->getRating(),
                $review->getComment(),
                $review->getCreatedAt(),
                $review->getUpdatedAt(),
                $review->getDeletedAt()
            );
        }

        public function getTotalReviewsByPostId($postId) {
            return $this->reviewRepository->getTotalReviewsByPostId($postId);
        }
        public function getReviewsByPostId($postId, $limit, $offset) {
            $reviewsList = $this->reviewRepository->getReviewsByPostIdPaginate($postId, $limit, $offset);
            return array_map(fn($reviewsList) => $this->mapToViewModel($reviewsList), $reviewsList);
        }

        public function createReview($postId, $rating, $comment) {
            $this->validatePost($rating, $comment);
            return $this->reviewRepository->createReview($postId, $_SESSION['user_id'], $rating, $comment);
        }

        public function getReviewsByUserId($userId) {
            return $this->reviewRepository->getReviewsByUserId($userId);
        }

        public function getReviewByUserIdAndPostId($userId, $postId) {
            return $this->reviewRepository->getReviewByUserIdAndPostId($userId, $postId);
        }
    }

?>