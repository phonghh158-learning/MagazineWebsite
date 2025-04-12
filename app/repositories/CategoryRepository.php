<?php

    namespace App\repositories;

    use App\repositories\BaseRepository;
    use App\entities\CategoryEntity;
    use Ramsey\Uuid\Uuid;
    use Helper\DateTimeAsia;
    use Core\Mapper;
    use PDO;
    use PDOException;
    use Exception;

    class CategoryRepository extends BaseRepository {
        public function __construct() {
            parent::__construct('categories', CategoryEntity::class);
        }

        public function createCategory($name, $description, $icon) {
            $entity = new CategoryEntity(
                Uuid::uuid4()->toString(), $name, $icon, $description, DateTimeAsia::now(), DateTimeAsia::now(), null);
            return parent::create($entity);
        }

        public function updateCategory($id, $name, $icon, $description, $createdAt) {
            $entity = new CategoryEntity(
                $id, $name, $icon, $description, 
                $createdAt, DateTimeAsia::now(), null);
            return parent::update($entity);
        }
        
        public function getTopCategories($limit) {
            try {
                $sql = " SELECT c.*, COUNT(p.id) AS post_count
                    FROM {$this->table} c
                    LEFT JOIN magazine_posts p ON p.category_id = c.id
                    GROUP BY c.id
                    ORDER BY post_count DESC
                    LIMIT :limit
                ";

                $stmt = $this->pdo->prepare($sql);
                $stmt->execute(['limit' => $limit]);
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return array_map(fn($item) => Mapper::DataToEntity($this->entityClass, $item), $data);
            } catch (PDOException $e) {
                error_log("Lỗi lấy top danh mục: " . $e->getMessage());
                return [];
            }
        }
    }

?>