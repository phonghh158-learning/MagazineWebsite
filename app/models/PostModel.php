<?php

namespace App\models;

use App\entities\PostEntity;
use App\repositories\PostRepository;
use App\repositories\UserRepository;
use App\repositories\CategoryRepository;
use App\viewmodels\PostViewModel;
use Core\Mapper;
use Helper\DateTimeAsia;
use Exception;
use Helper\Caculate;
use Ramsey\Uuid\Uuid;

class PostModel {
    private $postRepository;
    private $userRepository;
    private $categoryRepository;

    public function __construct() {
        $this->postRepository = new PostRepository();
        $this->userRepository = new UserRepository();
        $this->categoryRepository = new CategoryRepository();
    }

    private function validatePost($title, $thumbnail, $paragraphTitles, $paragraphContents) {
        if (empty($title) || empty($thumbnail) || empty($paragraphTitles) || empty($paragraphContents)) {
            return throw new Exception("Vui lòng nhập đầy đủ thông tin!");
        }
    }

    private function mapToViewModel(PostEntity $post) {
        $paragraphs = json_decode($post->getParagraphs(), true);
        return new PostViewModel(
            $post->getId(),
            $post->getTitle(),
            $post->getThumbnail(),
            $paragraphs,
            $post->getStatus(),
            $post->getCategoryId(),
            $this->categoryRepository->getById($post->getCategoryId())->getName(),
            $post->getAuthorId(),
            $this->userRepository->getById($post->getAuthorId())->getFullname(),
            $post->getCreatedAt(),
            $post->getUpdatedAt()
        );
    }

    // Get Posts List
    public function getAllPosts(): array {
        $posts = $this->postRepository->getAll();
        return array_map(fn($post) => $this->mapToViewModel($post), $posts);
    }
    public function getAllPostsPaginate($limit, $offset) {
        $posts = $this->postRepository->getAllPaginate($limit, $offset);
        return array_map(fn($post) => $this->mapToViewModel($post), $posts);
    }

    // Get Post By Status
    public function getPostsByStatus($status) {
        $posts = $this->postRepository->getPostsByStatus($status);
        return array_map(fn($post) => $this->mapToViewModel($post), $posts);
    }

    public function getPostsByStatusPaginate($status, $limit, $offset) {
        $posts = $this->postRepository->getPostsByStatusPaginate($status, $limit, $offset);
        return array_map(fn($post) => $this->mapToViewModel($post), $posts);
    }

    // Get Post By Id
    public function getPostById($id) {
        $post = $this->postRepository->getById($id);
        return $post ? $this->mapToViewModel($post) : null;
    }

    // Get Posts By Category
    public function getPostsByCategory($categoryId) {
        $posts = $this->postRepository->getPostsByCategory($categoryId);
        return array_map(fn($post) => $this->mapToViewModel($post), $posts);
    }

    public function getPostsByCategoryPaginate($categoryId, $limit, $offset) {
        $posts = $this->postRepository->getPostsByCategoryPaginate($categoryId, $limit, $offset);
        return array_map(fn($post) => $this->mapToViewModel($post), $posts);
    }

    // Create Post
    public function createPost($id, $title, $thumbnail, $paragraphTitles, $paragraphContents, $categoryId, $authorId) {
        $this->validatePost($title, $thumbnail, $paragraphTitles, $paragraphContents);
        
        if ($this->userRepository->getById($authorId)->getRole() !== 'admin') {
            $status = 'pending';
        } else {
            $status = 'public';
        }

        $paragraphs = [];
        for ($i = 0; $i < count($paragraphTitles); $i++) {
            $paragraphs[] = [
                'title' => $paragraphTitles[$i],
                'content' => $paragraphContents[$i]
            ];
        }
        $paragraphJson = json_encode($paragraphs, JSON_UNESCAPED_UNICODE);
        
        return $this->postRepository->createPost(
            $id, $title, $thumbnail, $paragraphJson,
            $status, $categoryId, $authorId
        );
    }

    public function updatePost($id, $title, $thumbnail, $paragraphTitles, $paragraphContents, $categoryId, $authorId) {
        $post = $this->postRepository->getById($id);
        
        $this->validatePost($title, $thumbnail, $paragraphTitles, $paragraphContents);

        if (!$post) {
            throw new Exception("Không tìm thấy bài viết");
        }

        if ($_SESSION['user_role'] !== 'admin') {
            $status = 'pending';
        } else {
            $status = 'public';
        }

        $paragraphs = [];
        for ($i = 0; $i < count($paragraphTitles); $i++) {
            $paragraphs[] = [
                'title' => $paragraphTitles[$i],
                'content' => $paragraphContents[$i]
            ];
        }
        $paragraphJson = json_encode($paragraphs, JSON_UNESCAPED_UNICODE);
        
        return $this->postRepository->updatePost(
            $post->getId(), $title, $thumbnail, $paragraphJson,
            $status, $categoryId, $authorId, $post->getCreatedAt()
        );
    }

    public function deletePost($id) {
        return $this->postRepository->delete($id);
    }

    public function softDeletePost($id, $password) {
        $post = $this->postRepository->getById($id);
        if (!$post) {
            throw new Exception("Không tìm thấy bài viết");
        }

        // Kiểm tra mật khẩu có được nhập không
        if (empty($password)) {
            throw new Exception("Vui lòng nhập mật khẩu");
        }

        $user = (new UserRepository())->getById($_SESSION['user_id']);
        if (!$user) {
            throw new Exception("Không tìm thấy người dùng");
        }

        // Verify password
        if (!password_verify($password, $user->getPassword())) {
            throw new Exception("Mật khẩu không chính xác");
        }

        return $this->postRepository->softDelete($id);
    }

    public function getThumbnailById($id) {
        return $this->postRepository->getThumbnailById($id);
    }

    public function searchPost($keyword, $limit, $offset) {
        $posts = $this->postRepository->searchPostPaginate($keyword, $limit, $offset);
        return array_map(fn($post) => $this->mapToViewModel($post), $posts);
    }
    public function searchTotalPost($keyword) {
        return $this->postRepository->searchTotalPost($keyword);
    }
}
