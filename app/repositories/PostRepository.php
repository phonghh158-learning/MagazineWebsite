<?php

    namespace App\repositories;

    use App\repositories\BaseRepository;
    use App\models\PostModel;
    use Core\Mapper;
    use Helper\DateTimeAsia;
    use PDO;
    use PDOException;
    use Ramsey\Uuid\Nonstandard\Uuid;

    class PostRepository extends BaseRepository {
        public function __construct() {
            parent::__construct('magazine_posts', PostModel::class);
        }

        public function createPost($id, $title, $thumbnail, $content, $status, $categoryId, $authorId) {
            $entity = new PostModel(
                $id, $title, $thumbnail, $content, $status,
                 $categoryId, $authorId, DateTimeAsia::now(), DateTimeAsia::now(), null);

            return parent::create($entity);
        }

        public function updatePost($id, $title, $thumbnail, $content, $status, $categoryId, $authorId) {
            $entity = new PostModel(
                $id, $title, $thumbnail, $content, $status,
                 $categoryId, $authorId, DateTimeAsia::now(), DateTimeAsia::now(), null);

            return parent::update($entity);
        }

        public function getPostByCategory($categoryId) {
            try {
                $query = "SELECT * FROM {$this->table} WHERE category_id = :category_id AND deleted_at IS NULL";
                $stmt = $this->pdo->prepare($query);
                $stmt->execute(['category_id' => $categoryId]);
                
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return array_map(fn($item) => Mapper::DataToEntity($this->entityClass, $item), $data);
            } catch (PDOException $e) {
                error_log("Error: " . $e->getMessage());
                return [];
            }
        }

        public function getPostByAuthor($authorId) {
            try {
                $query = "SELECT * FROM {$this->table} WHERE author_id = :author_id AND deleted_at IS NULL";
                $stmt = $this->pdo->prepare($query);
                $stmt->execute(['author_id' => $authorId]);
                
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return array_map(fn($item) => Mapper::DataToEntity($this->entityClass, $item), $data);
            } catch (PDOException $e) {
                error_log("Error: " . $e->getMessage());
                return [];
            }
        }

        public function getPostByStatus($status) {
            try {
                $query = "SELECT * FROM {$this->table} WHERE status = :status AND deleted_at IS NULL";
                $stmt = $this->pdo->prepare($query);
                $stmt->execute(['status' => $status]);
                
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return array_map(fn($item) => Mapper::DataToEntity($this->entityClass, $item), $data);
            } catch (PDOException $e) {
                error_log("Error: " . $e->getMessage());
                return [];
            }
        }

        public function getThumbnailById($id) {
            try {
                $query = "SELECT thumbnail FROM {$this->table} WHERE id = :id AND deleted_at IS NULL LIMIT 1";
                $stmt = $this->pdo->prepare($query);
                $stmt->execute(['id' => $id]);
                
                $data = $stmt->fetchColumn();
                return $data;
            } catch (PDOException $e) {
                error_log("Error: " . $e->getMessage());
                return null;
            }
        }

        public function searchPost($keyword) {
            try {
                $query = "SELECT * FROM {$this->table} WHERE title LIKE :keyword AND deleted_at IS NULL";
                $stmt = $this->pdo->prepare($query);
                
                $stmt->bindValue(':keyword', "%$keyword%", PDO::PARAM_STR);
                $stmt->execute();

                
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return array_map(fn($item) => Mapper::DataToEntity($this->entityClass, $item), $data);
            } catch (PDOException $e) {
                error_log("Error: " . $e->getMessage());
                return [];
            }
        }
    }

?>