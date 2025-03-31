<?php

    namespace App\repositories;

    use App\entities\UserEntity;
    use App\repositories\BaseRepository;
    use Core\Mapper;
    use Helper\DateTimeAsia;
    use PDO;
    use PDOException;

    class UserRepository extends BaseRepository {
        public function __construct() {
            parent::__construct('users', UserEntity::class);
        }

        public function createUser($id, $username, $fullname, $email, $password) {
            $entity = new UserEntity($id, $username, $fullname, $email, null, $password, 'user', null, null, 'active', null, DateTimeAsia::now(), DateTimeAsia::now(), null);
            return parent::create($entity);
        }

        public function createAdmin($id, $username, $fullname, $email, $password) {
            $entity = new UserEntity($id, $username, $fullname, $email, null, $password, 'admin', null, null, 'active', null, DateTimeAsia::now(), DateTimeAsia::now(), null);
            return parent::create($entity);
        }

        public function getUserByEmail(string $email) {
            try {
                $query = "SELECT * FROM {$this->table} WHERE email = :email AND deleted_at IS NULL LIMIT 1";
                $stmt = $this->pdo->prepare($query);
                $stmt->execute(['email' => $email]);

                $data = $stmt->fetch(PDO::FETCH_ASSOC);

                return $data ? Mapper::DataToEntity(UserEntity::class, $data) : null;
            } catch (PDOException $e) {
                error_log("Error: " . $e->getMessage());
                throw $e;
            }
        }

        public function isTokenExist(string $token) {
            try {
                $query = "SELECT EXISTS(SELECT 1 FROM {$this->table} WHERE remember_token = :token)";
                $stmt = $this->pdo->prepare($query);
                $stmt->execute(['token' => $token]);

                return $stmt->fetchColumn();
            } catch (PDOException $e) {
                error_log("Error: " . $e->getMessage());
                throw $e;
            }
        }

        public function getUserByRememberToken(string $token) {
            try {
                $query = "SELECT * FROM {$this->table} WHERE remember_token = :token";
                $stmt = $this->pdo->prepare($query);
                $stmt->execute(['token' => $token]);

                $data = $stmt->fetch(PDO::FETCH_ASSOC); 

                return $data ? Mapper::DataToEntity(UserEntity::class, $data) : null;
            } catch (PDOException $e) {
                error_log("Error: " . $e->getMessage());
                throw $e;
            }
        }

        public function updateRememberToken(string $userId, string $token) {
            try {
                $query = "UPDATE {$this->table} SET remember_token = :token WHERE id = :id";
                $stmt = $this->pdo->prepare($query);
                $stmt->execute(['token' => $token, 'id' => $userId]);
            } catch (PDOException $e) {
                error_log("Error: " . $e->getMessage());
                throw $e;
            }
        }

        public function updatePassword(string $userId, string $password) {
            try {
                $query = "UPDATE {$this->table} SET password = :password WHERE id = :id";
                $stmt = $this->pdo->prepare($query);
                $stmt->execute(['password' => $password, 'id' => $userId]);
            } catch (PDOException $e) {
                error_log("Error: " . $e->getMessage());
                throw $e;
            }
        }
    }

?>