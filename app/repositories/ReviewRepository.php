<?php

    namespace App\repositories;

    use App\repositories\BaseRepository;
    use App\models\ReviewModel;
    use Helper\DateTimeAsia;
    use Ramsey\Uuid\Nonstandard\Uuid;
    use Core\Mapper;
    use PDO;
    use PDOException;

    class ReviewRepository extends BaseRepository {
        public function __construct() {
            parent::__construct('reviews', ReviewModel::class);
        }

        public function createReview($postId, $userId, $rating, $comment) {
            $entity = new ReviewModel(Uuid::uuid4()->toString(), $postId, $userId, $rating, $comment, 
            DateTimeAsia::now(), DateTimeAsia::now(), null);

            return parent::create($entity);
        }

        public function getReviewByPostId($postId) {
            try {
                $query = "SELECT * FROM $this->table WHERE post_id = :post_id AND deleted_at IS NULL";
                $stmt = $this->pdo->prepare($query);
                $stmt->execute(['post_id' => $postId]);
    
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return array_map(fn($item) => Mapper::DataToEntity($this->entityClass, $item), $data);
            } catch (PDOException $e) {
                error_log("Error: " . $e->getMessage());
                return null;
            }
        }

        public function getReviewByUserId($userId) {
            try {
                $query = "SELECT * FROM $this->table WHERE user_id = :user_id AND deleted_at IS NULL";
                $stmt = $this->pdo->prepare($query);
                $stmt->execute(['user_id' => $userId]);
    
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return array_map(fn($item) => Mapper::DataToEntity($this->entityClass, $item), $data);
            } catch (PDOException $e) {
                error_log("Error: " . $e->getMessage());
                return null;
            }
        }
    }

?>