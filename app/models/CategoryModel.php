<?php

namespace App\models;

use App\repositories\CategoryRepository;
use App\repositories\UserRepository;
use App\entities\CategoryEntity;
use App\viewmodels\CategoryViewModel;
use Helper\DateTimeAsia;
use Exception;

class CategoryModel {
    private $repository;
    
    public function __construct() {
        $this->repository = new CategoryRepository();
    }

    public function getCategories() {
        $list = $this->repository->getAll();
        if (empty($list)) {
            return "Không có dữ liệu về danh mục";
        }
        return $this->repository->getAll();
    }

    public function getCategory($id) {
        $category = $this->repository->getById($id);
        if (!$category) {
            return ("Không tìm thấy dữ liệu về danh mục");
        }
        return $category;
    }

    public function createCategory($name, $description, $icon) {
        if (empty($name)) {
            throw new Exception("Tên không được để trống");
        }
        return $this->repository->createCategory($name, $description, $icon);
    }

    public function updateCategory($id, $name, $icon, $description) {
        $category = $this->repository->getById($id);
        if (!$category) {
            throw new Exception("Không tìm thấy dữ liệu về danh mục");
        }
        return $this->repository->updateCategory($id, $name, $icon, $description, $category->getCreatedAt());
    }

    public function deleteCategory($id, $password) {
        $category = $this->repository->getById($id);
        if (!$category) {
            throw new Exception("Không tìm thấy dữ liệu về danh mục");
        }
    
        // Kiểm tra mật khẩu có được nhập không
        if (empty($password)) {
            throw new Exception("Vui lòng nhập mật khẩu");
        }
    
        $userRepository = new UserRepository();
        $user = $userRepository->getById($_SESSION['user_id']);
        if (!$user) {
            throw new Exception("Người dùng không tồn tại");
        }
    
        // Verify password
        if (!password_verify($password, $user->getPassword())) {
            throw new Exception("Mật khẩu không chính xác");
        }
    
        return $this->repository->delete($id);
    }    
}
