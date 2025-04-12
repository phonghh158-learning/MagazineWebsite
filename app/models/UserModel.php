<?php

namespace App\models;

use App\repositories\UserRepository;
use Ramsey\Uuid\Uuid;
use Exception;

class UserModel {
    private $repository;

    public function __construct() {
        $this->repository = new UserRepository();
    }

    //Authentication

    private function validateUserData(array $data) {
        if (empty($data['username']) || empty($data['email']) || empty($data['password']) || empty($data['confirm_password'])) {
            throw new Exception("Vui lòng nhập đầy đủ thông tin!");
        }
        
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Email không hợp lệ!");
        }
        
        if ($this->repository->getUserByEmail($data['email'])) {
            throw new Exception("Email đã được sử dụng!");
        }
        
        if ($data['password'] !== $data['confirm_password']) {
            throw new Exception("Mật khẩu nhập lại không khớp!");
        }
    }

    private function validatePasswordStrength($password) {
        if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $password)) {
            throw new Exception("Mật khẩu phải có ít nhất 8 ký tự, gồm chữ hoa, chữ thường, số và ký tự đặc biệt!");
        }
    }
    

    public function registerUser(array $data) {
        $this->validateUserData($data);
        $this->validatePasswordStrength($data['password']);
        
        $hashedPassword = password_hash($data['password'], PASSWORD_ARGON2ID);
        
        return $this->repository->createUser(
            $data['id'], $data['username'], $data['fullname'], $data['email'], $hashedPassword
        );
    }

    public function loginUser(array $credentials) {
        $user = $this->repository->getUserByEmail($credentials['email']);
        if (!$user || !password_verify($credentials['password'], $user->getPassword())) {
            throw new Exception("Email hoặc mật khẩu không chính xác!");
        }
        
        $_SESSION['user_id'] = $user->getId();
        $_SESSION['user_role'] = $user->getRole();

        if ($credentials['remember_me']) {
            $config = require_once __DIR__ . '/../../config/app.php';
            $token = bin2hex(random_bytes(32));
            $hashedToken = hash_hmac('sha256', $token, $config['secret_key_256']);
            
            while ($this->repository->isTokenExist($hashedToken)) {
                $token = bin2hex(random_bytes(32));
                $hashedToken = hash_hmac('sha256', $token, $config['secret_key_256']);
            }
            
            $this->repository->updateRememberToken($user->getId(), $hashedToken);
            setcookie('remember_token', $token, time() + (7 * 24 * 60 * 60), "/", "", true, true);
        }

        return $user;
    }

    public function logoutUser() {
        if (isset($_SESSION['user_id'])) {
            $this->repository->updateRememberToken($_SESSION['user_id'], "");
        }
        session_destroy();
        setcookie('remember_token', '', time() - 3600, "/", "", true, true);
    }

    public function autoLoginUser() {
        if (!isset($_SESSION['user_id']) && isset($_COOKIE['remember_token'])) {
            $config = require_once __DIR__ . '/../../config/app.php';
            $hashedToken = hash_hmac('sha256', $_COOKIE['remember_token'], $config['secret_key_256']);
            $user = $this->repository->getUserByRememberToken($hashedToken);

            if ($user) {
                $_SESSION['user_id'] = $user->getId();
            } else {
                setcookie('remember_token', '', time() - 3600, "/", "", true, true);
                throw new Exception("Không tìm thấy người dùng với token đã lưu.");
            }
        }
    }

    //Profile
    public function getUserById($id) {
        return $this->repository->getById($id);
    }

    public function updateAvatar($id, $avatar) {
        return $this->repository->updateAvatar($id, $avatar);
    }

    public function updateInformation($id, $fullname, $username, $email) {
        if (empty($username) || empty($email) || empty($fullname)) {
            throw new Exception("Vui lòng nhập đầy đủ thông tin!");
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Email không hợp lệ!");
        }

        return $this->repository->updateInformation($id, $fullname, $username, $email);
    }

    public function updatePassword($id, $currentPassword, $password, $confirmPassword) {
        if (empty($password) || empty($confirmPassword) || empty($currentPassword)) {
            throw new Exception("Vui lòng nhập đầy đủ mật khẩu!");
        }

        if (!password_verify($currentPassword, $this->repository->getById($id)->getPassword())) {
            throw new Exception("Mật khẩu hiện tại không chính xác");
        }

        if ($password !== $confirmPassword) {
            throw new Exception("Mật khẩu nhập lại không khớp!");
        }

        $this->validatePasswordStrength($password);
        
        $hashedPassword = password_hash($password, PASSWORD_ARGON2ID);

        return $this->repository->updatePassword($id, $hashedPassword);
    }
}
