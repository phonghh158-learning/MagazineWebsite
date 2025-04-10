<?php

    namespace App\repositories;

    use App\entities\ReviewEntity;
    use App\repositories\BaseRepository;
    use Helper\DateTimeAsia;
    use Ramsey\Uuid\Nonstandard\Uuid;
    use Core\Mapper;
    use PDO;
    use PDOException;

    class ReviewRepository extends BaseRepository {
        public function __construct() {
            parent::__construct('reviews', ReviewEntity::class);
        }

        public function createReview($postId, $userId, $rating, $comment) {
            $entity = new ReviewEntity(Uuid::uuid4()->toString(), $postId, $userId, $rating, $comment, 
            DateTimeAsia::now(), DateTimeAsia::now(), null);

            return parent::create($entity);
        }

        public function updateReview($reviewId, $postId, $userId, $rating, $comment, $createdAt) {
            $entity = new ReviewEntity($reviewId, $postId, $userId, $rating, $comment, 
            $createdAt, DateTimeAsia::now(), null);
            return parent::update($entity);
        }

        public function getTotalReviewsByPostId($postId) {
            try {
                $query = "SELECT COUNT(*) FROM {$this->table} WHERE post_id = :post_id AND deleted_at IS NULL";
                $stmt = $this->pdo->prepare($query);
                $stmt->execute(['post_id' => $postId]);
    
                return $stmt->fetchColumn();
            } catch (PDOException $e) {
                error_log("Error: " . $e->getMessage());
                return null;
            }
        }

        public function getReviewsByPostIdPaginate($postId, $limit, $offset) {
            try {
                $query = "SELECT * FROM {$this->table} WHERE post_id = :post_id AND deleted_at IS NULL ORDER BY created_at LIMIT $limit OFFSET $offset";
                $stmt = $this->pdo->prepare($query);
                $stmt->execute(['post_id' => $postId]);
    
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return array_map(fn($item) => Mapper::DataToEntity($this->entityClass, $item), $data);
            } catch (PDOException $e) {
                error_log("Error: " . $e->getMessage());
                return null;
            }
        }

        public function getReviewsByUserId($userId) {
            try {
                $query = "SELECT * FROM {$this->table} WHERE user_id = :user_id AND deleted_at IS NULL ORDER BY created_at DESC";
                $stmt = $this->pdo->prepare($query);
                $stmt->execute(['user_id' => $userId]);
    
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return array_map(fn($item) => Mapper::DataToEntity($this->entityClass, $item), $data);
            } catch (PDOException $e) {
                error_log("Error: " . $e->getMessage());
                return null;
            }
        }

        public function getReviewByUserIdAndPostId($userId, $postId) {
            try {
                $query = "SELECT * FROM {$this->table} WHERE user_id = :user_id AND post_id = :post_id AND deleted_at IS NULL";
                $stmt = $this->pdo->prepare($query);
                $stmt->execute(['user_id' => $userId, 'post_id' => $postId]);
    
                $data = $stmt->fetch(PDO::FETCH_ASSOC);
                return $data ? Mapper::DataToEntity($this->entityClass, $data) : null;
            } catch (PDOException $e) {
                error_log("Error: " . $e->getMessage());
                return null;
            }
        }
    }

?>