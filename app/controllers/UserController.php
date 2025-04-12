<?php

    namespace App\controllers;

    use App\models\UserModel;
    use Exception;
    use Helper\FileProcess;

    class UserController {
        private $userModel;

        public function __construct() {
            $this->userModel = new UserModel();
        }

        public function index() {
            $user = $this->userModel->getUserById($_SESSION['user_id']);
            require_once __DIR__ . '/../../views/pages/profile/index.php';
        }

        public function updateAvatar() {
            try {
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['avatar_update'])) {
                    $avatar = null;
                    if (!empty($_FILES['avatar_update']['name'])) {
                        $avatar = FileProcess::uploadImage($_FILES['avatar_update'], 'users', $_SESSION['user_id']);
                        if (!$avatar) {
                            throw new Exception("Lỗi khi tải ảnh lên!");
                        }
                    }

                    $stt = $this->userModel->updateAvatar($_SESSION['user_id'], $avatar);
                    if (!$stt) {
                        $_SESSION['notify'] = [
                            'type' => 'error',
                            'message' => 'Có lỗi trong việc cập nhật!'
                        ];
                        header("Location: /profile");
                        exit();
                    }

                    $_SESSION['notify'] = [
                        'type' => 'success',
                        'message' => 'Đã cập nhật ảnh của bạn!'
                    ];
        
                    header("Location: /profile");
                    exit();
                }
            } catch (Exception $e) {
                $_SESSION['notify'] = [
                    'type' => 'error',
                    'message' => $e->getMessage()
                ];
                header("Location: /profile");
                exit();
            }
        }

        public function updateInformation() {
            try {
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $fullname = trim($_POST['fullname'] ?? '');
                    $username = trim($_POST['username'] ?? '');
                    $email = trim($_POST['email'] ?? '');

                    $stt = $this->userModel->updateInformation($_SESSION['user_id'], $fullname, $username, $email);
                    if (!$stt) {
                        $_SESSION['notify'] = [
                            'type' => 'error',
                            'message' => 'Có lỗi trong việc cập nhật!'
                        ];
                        header("Location: /profile");
                        exit();
                    }

                    $_SESSION['notify'] = [
                        'type' => 'success',
                        'message' => 'Đã cập nhật thông tin của bạn!'
                    ];
        
                    header("Location: /profile");
                    exit();
                }
            } catch (Exception $e) {
                $_SESSION['notify'] = [
                    'type' => 'error',
                    'message' => $e->getMessage()
                ];
                header("Location: /profile");
                exit();
            }
        }

        public function changePassword() {
            require_once __DIR__ . '/../../views/pages/profile/change-password.php';
        }

        public function updatePassword() {
            try {
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $currentPassword = trim($_POST['current_password'] ?? '');
                    $password = trim($_POST['new_password'] ?? '');
                    $confirmPassword = trim($_POST['confirm_password'] ?? '');

                    $stt = $this->userModel->updatePassword($_SESSION['user_id'], $currentPassword, $password, $confirmPassword);
                    if (!$stt) {
                        $_SESSION['notify'] = [
                            'type' => 'error',
                            'message' => 'Có lỗi trong việc cập nhật!'
                        ];
                        header("Location: /profile/change-password");
                        exit();
                    }

                    $_SESSION['notify'] = [
                        'type' => 'success',
                        'message' => 'Mật khẩu của bạn đã được thay đổi!'
                    ];
        
                    header("Location: /profile");
                    exit();
                }
            } catch (Exception $e) {
                $_SESSION['notify'] = [
                    'type' => 'error',
                    'message' => $e->getMessage()
                ];
                header("Location: /profile/change-password");
                exit();
            }
        }

        public function show($id) {
            $users = $this->userModel->getUserById($id);
            require_once __DIR__ . '/../../views/pages/user/show.php';
        }
    }

?>