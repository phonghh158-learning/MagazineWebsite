<?php

    namespace App\repositories;

    use App\repositories\BaseRepository;
    use App\models\CategoryModel;
    use Ramsey\Uuid\Uuid;
    use Helper\DateTimeAsia;
    use Exception;

    class CategoryRepository extends BaseRepository {
        public function __construct() {
            parent::__construct('categories', CategoryModel::class);
        }

        public function createCategory($name, $description, $icon) {
            $entity = new CategoryModel(
                Uuid::uuid4()->toString(), $name, $icon, $description, DateTimeAsia::now(), DateTimeAsia::now(), null);
            return parent::create($entity);
        }

        public function updateCategory($id, $name, $description, $icon) {
            $entity = new CategoryModel($id, $name, $icon, $description, DateTimeAsia::now(), DateTimeAsia::now(), null);
            return parent::update($entity);
        }
        
    }

?>