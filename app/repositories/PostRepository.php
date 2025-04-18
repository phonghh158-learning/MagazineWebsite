<?php

    namespace App\repositories;

    use App\entities\PostEntity;
    use App\repositories\BaseRepository;
    use Core\Mapper;
    use Helper\DateTimeAsia;
    use PDO;
    use PDOException;

    class PostRepository extends BaseRepository {
        public function __construct() {
            parent::__construct('magazine_posts', PostEntity::class);
        }

        public function createPost($id, $title, $thumbnail, $paragraphs, $status, $categoryId, $authorId) {
            $entity = new PostEntity(
                $id, $title, $thumbnail, $paragraphs, 
                $status, $categoryId, $authorId, 
                DateTimeAsia::now(), DateTimeAsia::now(), null);

            return parent::create($entity);
        }

        public function updatePost($id, $title, $thumbnail, $paragraphs, $status, $categoryId, $authorId, $createdAt) {
            $entity = new PostEntity(
                $id, $title, $thumbnail, $paragraphs,
                $status, $categoryId, $authorId, 
                $createdAt, DateTimeAsia::now(), null);

            return parent::update($entity);
        }

        public function getPostsByCategory($categoryId) {
            try {
                $query = "SELECT * FROM {$this->table} WHERE category_id = :category_id AND status = 'public' AND deleted_at IS NULL ORDER BY created_at DESC";
                $stmt = $this->pdo->prepare($query);
                $stmt->execute(['category_id' => $categoryId]);
                
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return array_map(fn($item) => Mapper::DataToEntity($this->entityClass, $item), $data);
            } catch (PDOException $e) {
                error_log("Error: " . $e->getMessage());
                return [];
            }
        }

        public function getPostsByCategoryPaginate($categoryId, $limit, $offset) {
            try {
                $query = "SELECT * FROM {$this->table} WHERE category_id = :category_id AND status = 'public' AND deleted_at IS NULL ORDER BY created_at DESC LIMIT :limit OFFSET :offset";
                $stmt = $this->pdo->prepare($query);
                $stmt->execute(['category_id' => $categoryId, 'limit' => $limit, 'offset' => $offset]);
                
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return array_map(fn($item) => Mapper::DataToEntity($this->entityClass, $item), $data);
            } catch (PDOException $e) {
                error_log("Error: " . $e->getMessage());
                return [];
            }
        }

        public function getPostsByAuthor($authorId) {
            try {
                $query = "SELECT * FROM {$this->table} WHERE author_id = :author_id AND deleted_at IS NULL ORDER BY created_at DESC";
                $stmt = $this->pdo->prepare($query);
                $stmt->execute(['author_id' => $authorId]);
                
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return array_map(fn($item) => Mapper::DataToEntity($this->entityClass, $item), $data);
            } catch (PDOException $e) {
                error_log("Error: " . $e->getMessage());
                return [];
            }
        }

        public function getPostsByAuthorPaginate($authorId, $limit, $offset) {
            try {
                $query = "SELECT * FROM {$this->table} WHERE author_id = :author_id AND deleted_at IS NULL ORDER BY created_at DESC LIMIT :limit OFFSET :offset";
                $stmt = $this->pdo->prepare($query);
                $stmt->execute(['author_id' => $authorId, 'limit' => $limit, 'offset' => $offset]);
                
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return array_map(fn($item) => Mapper::DataToEntity($this->entityClass, $item), $data);
            } catch (PDOException $e) {
                error_log("Error: " . $e->getMessage());
                return [];
            }
        }

        public function getPostsByStatusAndAuthor($status, $authorId) {
            try {
                $query = "SELECT * FROM {$this->table} WHERE status = :status AND author_id = :author_id AND deleted_at IS NULL ORDER BY created_at";
                $stmt = $this->pdo->prepare($query);
                $stmt->execute(['status' => $status, 'author_id' => $authorId]);
                
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return array_map(fn($item) => Mapper::DataToEntity($this->entityClass, $item), $data);
            } catch (PDOException $e) {
                error_log("Error: " . $e->getMessage());
                return [];
            }
        }

        public function getPostsByStatusAndAuthorPaginate($status, $authorId, $limit, $offset) {
            try {
                $query = "SELECT * FROM {$this->table} WHERE status = :status AND author_id = :author_id AND deleted_at IS NULL ORDER BY created_at DESC LIMIT :limit OFFSET :offset";
                $stmt = $this->pdo->prepare($query);
                $stmt->execute(['status' => $status, 'author_id' => $authorId, 'limit' => $limit, 'offset' => $offset]);
                
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return array_map(fn($item) => Mapper::DataToEntity($this->entityClass, $item), $data);
            } catch (PDOException $e) {
                error_log("Error: " . $e->getMessage());
                return [];
            }
        }

        public function getPostsByStatus($status) {
            try {
                $query = "SELECT * FROM {$this->table} WHERE status = :status AND deleted_at IS NULL ORDER BY created_at DESC";
                $stmt = $this->pdo->prepare($query);
                $stmt->execute(['status' => $status]);
                
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return array_map(fn($item) => Mapper::DataToEntity($this->entityClass, $item), $data);
            } catch (PDOException $e) {
                error_log("Error: " . $e->getMessage());
                return [];
            }
        }

        public function getPostsByStatusPaginate($status, $limit, $offset) {
            try {
                $query = "SELECT * FROM {$this->table} WHERE status = :status AND deleted_at IS NULL ORDER BY created_at DESC LIMIT :limit OFFSET :offset";
                $stmt = $this->pdo->prepare($query);
                $stmt->execute(['status' => $status, 'limit' => $limit, 'offset' => $offset]);
                
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

        public function softDelete($id) {
            try {
                $query = "UPDATE {$this->table} SET deleted_at = :deleted_at, status = :status WHERE id = :id";
                $stmt = $this->pdo->prepare($query);
                
                $now = DateTimeAsia::now()->format('Y-m-d H:i:s');
                
                return $stmt->execute(["id" => $id, "deleted_at" => $now, "status" => 'deleted']);
            } catch (PDOException $e) {
                error_log("Error: " . $e->getMessage());
                return false;
            }
        }

        public function searchTotalPost($keyword) {
            try {
                $query = "SELECT COUNT(*) FROM {$this->table} WHERE title LIKE :keyword AND deleted_at IS NULL";
                $stmt = $this->pdo->prepare($query);
                
                $stmt->bindValue(':keyword', "%$keyword%", PDO::PARAM_STR);
                $stmt->execute();
                
                return $stmt->fetchColumn();
            } catch (PDOException $e) {
                error_log("Error: " . $e->getMessage());
                return [];
            }
        }

        public function searchPostPaginate($keyword, $limit, $offset) {
            try {
                $query = "SELECT * FROM {$this->table} WHERE title LIKE :keyword AND deleted_at IS NULL ORDER BY created_at DESC LIMIT :limit OFFSET :offset";
                $stmt = $this->pdo->prepare($query);
                
                $stmt->bindValue(':keyword', "%$keyword%", PDO::PARAM_STR);
                $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
                $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
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