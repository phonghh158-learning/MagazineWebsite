<?php

    namespace App\repositories;

    use Core\Database;
    use Core\Mapper;
    use PDO;
    use PDOException;
    use DateTime;
    use DateTimeZone;

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
                $query = "SELECT * FROM {$this->table} WHERE deleted_at IS NULL";
                $stmt = $this->pdo->prepare($query);
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
                
                $keys = array_keys($data);
                $setString = implode(', ', array_map(fn($key) => "{$key} = :{$key}", $keys));
                $query = "UPDATE {$this->table} SET $setString WHERE id = :id";

                echo $query . "<br>";
                var_dump($data);
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
                
                $now = new DateTime('now', new DateTimeZone('Asia/Ho_Chi_Minh'));
                $now = $now->format('Y-m-d H:i:s');
                
                return $stmt->execute(["id" => $id, "deleted_at" => $now]);
            } catch (PDOException $e) {
                error_log("Error: " . $e->getMessage());
                return false;
            }
        }
    }

?>