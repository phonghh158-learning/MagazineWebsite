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

    public function getAllPosts() {
        $posts = $this->postRepository->getAll();
        return array_map(fn($post) => $this->mapToViewModel($post), $posts);
    }

    public function getPostById($id) {
        $post = $this->postRepository->getById($id);
        return $post ? $this->mapToViewModel($post) : null;
    }

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

    public function updatePost($id, $title, $thumbnail, $paragraphTitles, $paragraphContents, $status, $categoryId, $authorId) {
        $this->validatePost($title, $thumbnail, $paragraphTitles, $paragraphContents);

        $paragraphs = [];
        for ($i = 0; $i < count($paragraphTitles); $i++) {
            $paragraphs[] = [
                'title' => $paragraphTitles[$i],
                'content' => $paragraphContents[$i]
            ];
        }
        $paragraphJson = json_encode($paragraphs, JSON_UNESCAPED_UNICODE);
        
        return $this->postRepository->updatePost(
            $id, $title, $thumbnail, $paragraphJson,
            $status, $categoryId, $authorId
        );
    }

    public function deletePost($id) {
        return $this->postRepository->delete($id);
    }

    public function softDeletePost($id) {
        return $this->postRepository->softDelete($id);
    }

    public function searchPost($keyword) {
        $posts = $this->postRepository->searchPost($keyword);
        return array_map(fn($post) => $this->mapToViewModel($post), $posts);
    }

    public function getThumbnailById($id) {
        return $this->postRepository->getThumbnailById($id);
    }
}
