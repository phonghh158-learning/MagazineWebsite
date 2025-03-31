<?php

namespace App\controllers;

use App\models\UserModel;
use Ramsey\Uuid\Uuid;
use Exception;

class AuthController {
    private $model;

    public function __construct() {
        $this->model = new UserModel();
    }

    public function showRegisterForm() {
        require_once __DIR__ . '/../../views/auth/register.php';
    }

    public function showLoginForm() {
        require_once __DIR__ . '/../../views/auth/login.php';
    }

    public function register() {
        try {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $userData = [
                    'id' => Uuid::uuid4()->toString(),
                    'username' => trim($_POST['username'] ?? ''),
                    'fullname' => trim($_POST['fullname'] ?? ''),
                    'email' => trim($_POST['email'] ?? ''),
                    'password' => $_POST['password'] ?? '',
                    'confirm_password' => $_POST['confirm-password'] ?? ''
                ];

                $user = $this->model->registerUser($userData);
                if ($user) {
                    header("Location: /login");
                    exit();
                } else {
                    throw new Exception("Đăng ký thất bại!");
                }
            }
        } catch (Exception $e) {
            error_log("Error: " . $e->getMessage());
            return false;
        }
    }

    public function login() {
        try {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $credentials = [
                    'email' => trim($_POST['email'] ?? ''),
                    'password' => $_POST['password'] ?? '',
                    'remember_me' => isset($_POST['remember_me'])
                ];

                $user = $this->model->loginUser($credentials);
                if ($user) {
                    header("Location: /");
                    exit();
                } else {
                    throw new Exception("Email hoặc mật khẩu không chính xác!");
                }
            }
        } catch (Exception $e) {
            error_log("Error: " . $e->getMessage());
            return false;
        }
    }

    public function logout() {
        try {
            $this->model->logoutUser();
            header("Location: /");
            exit();
        } catch (Exception $e) {
            error_log("Error: " . $e->getMessage());
            echo $e->getMessage();
        }
    }

    public function autoLogin() {
        try {
            $this->model->autoLoginUser();
        } catch (Exception $e) {
            error_log("Error: " . $e->getMessage());
        }
    }
}
