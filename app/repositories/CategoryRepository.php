<?php

    namespace App\repositories;

    use App\repositories\BaseRepository;
    use App\entities\CategoryEntity;
    use Ramsey\Uuid\Uuid;
    use Helper\DateTimeAsia;
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
        
    }

?>