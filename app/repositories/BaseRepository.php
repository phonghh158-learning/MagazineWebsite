<?php

    namespace App\repositories;

    use Core\Database;
    use Core\Mapper;
    use PDO;
    use PDOException;
    use Helper\DateTimeAsia;

    abstract class BaseRepository {
        protected $pdo;
        protected $table;
        protected $entityClass;

        public function __construct($table, $entityClass) {
            $this->pdo = Database::getInstance()->getConnection();
            $this->table = $table;
            $this->entityClass = $entityClass;
        }

        // GET ALL ITEM
        public function getAll() {
            try {
                $query = "SELECT * FROM {$this->table} WHERE deleted_at IS NULL ORDER BY created_at DESC";
                $stmt = $this->pdo->prepare($query);
                $stmt->execute();
                
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return array_map(fn($item) => Mapper::DataToEntity($this->entityClass, $item), $data);
            } catch (PDOException $e) {
                error_log("Error: " . $e->getMessage());
                return [];
            }
        }

        public function getAllPaginate($limit, $offset) {
            try {
                $query = "SELECT * FROM {$this->table} WHERE deleted_at IS NULL ORDER BY created_at DESC LIMIT :limit OFFSET :offset";
                $stmt = $this->pdo->prepare($query);
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

        // GET ITEM BY ID
        public function getById($id) {
            try {
                $query = "SELECT * FROM {$this->table} WHERE id = :id AND deleted_at IS NULL LIMIT 1";
                $stmt = $this->pdo->prepare($query);
                $stmt->execute(['id' => $id]);
                
                $data = $stmt->fetch(PDO::FETCH_ASSOC);
                return $data ? Mapper::DataToEntity($this->entityClass, $data) : null;
            } catch (PDOException $e) {
                error_log("Error: " . $e->getMessage());
                return null;
            }
        }

        // CREATE
        public function create($entity) {
            try {
                $data = Mapper::EntityToData($entity);
                $columns = array_keys($data);
                $values = array_values($data);
                
                $valuesString = implode(", ", array_fill(0, sizeof($values), "?")); // Tạo mảng với giá trị là values, sau đó thì nối mảng này thành chữ và insert
                $query = "INSERT INTO {$this->table} (" . implode(", ", $columns) . ") VALUES ($valuesString)";
                $stmt = $this->pdo->prepare($query);
                echo $query;
                return $stmt->execute($values);
            } catch (PDOException $e) {
                error_log("Error: " . $e->getMessage());
                return false;
            }
        }

        // UPDATE
        public function update($entity) {
            try {
                $data = Mapper::EntityToData($entity);
                
                if (!isset($data['id'])) {
                    error_log("Error: Missing ID in update data");
                    return false;
                }

                $data['updated_at'] = DateTimeAsia::now()->format('Y-m-d H:i:s');
                
                $keys = array_keys(array_filter($data, fn($key) => $key !== 'id', ARRAY_FILTER_USE_KEY));
                $setString = implode(', ', array_map(fn($key) => "{$key} = :{$key}", $keys));
                $query = "UPDATE {$this->table} SET $setString WHERE id = :id";
                $stmt = $this->pdo->prepare($query);

                return $stmt->execute($data);
            } catch (PDOException $e) {
                error_log("Error: " . $e->getMessage());
                return false;
            }
        }

        // DELETE
        public function delete($id) {
            try {
                $query = "DELETE FROM {$this->table} WHERE id = :id";
                $stmt = $this->pdo->prepare($query);
                return $stmt->execute(['id' => $id]);
            } catch (PDOException $e) {
                error_log("Error: " . $e->getMessage());
                return false;
            }
        }

        // SOFT DELETE
        public function softDelete($id) {
            try {
                $query = "UPDATE {$this->table} SET deleted_at = :deleted_at WHERE id = :id";
                $stmt = $this->pdo->prepare($query);
                
                $now = DateTimeAsia::now()->format('Y-m-d H:i:s');
                
                return $stmt->execute(["id" => $id, "deleted_at" => $now]);
            } catch (PDOException $e) {
                error_log("Error: " . $e->getMessage());
                return false;
            }
        }
    }

?>