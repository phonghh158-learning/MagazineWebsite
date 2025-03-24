<?php

    namespace App\models;

    use DateTime;

    class PostModel {
        private string $id;
        private string $title;
        private ?string $thumbnail;
        private string $content;
        private string $status;
        private ?string $categoryId;
        private ?string $authorId;
        private DateTime $createdAt;
        private DateTime $updatedAt;
        private ?DateTime $deletedAt;
    
        public function __construct($id, $title, $thumbnail, $content, $status, $categoryId, $authorId, $createdAt, $updatedAt, $deletedAt) {
            $this->id = $id;
            $this->title = $title;
            $this->thumbnail = $thumbnail;
            $this->content = $content;
            $this->status = $status;
            $this->categoryId = $categoryId;
            $this->authorId = $authorId;
            $this->createdAt = $createdAt;
            $this->updatedAt = $updatedAt;
            $this->deletedAt = $deletedAt;
        }

        // Getters
        public function getId(): string { return $this->id; }
        public function getTitle(): string { return $this->title; }
        public function getThumbnail(): ?string { return $this->thumbnail; }
        public function getContent(): string { return $this->content; }
        public function getStatus(): string { return $this->status; }
        public function getCategoryId(): ?string { return $this->categoryId; }
        public function getAuthorId(): ?string { return $this->authorId; }
        public function getCreatedAt(): DateTime { return $this->createdAt; }
        public function getUpdatedAt(): DateTime { return $this->updatedAt; }
        public function getDeletedAt(): ?DateTime { return $this->deletedAt; }

        // Setters
        public function setId(string $id): void { $this->id = $id; }
        public function setTitle(string $title): void { $this->title = $title; }
        public function setThumbnail(?string $thumbnail): void { $this->thumbnail = $thumbnail; }
        public function setContent(string $content): void { $this->content = $content; }
        public function setStatus(string $status): void { $this->status = $status; }
        public function setCategoryId(?string $categoryId): void { $this->categoryId = $categoryId; }
        public function setAuthorId(?string $authorId): void { $this->authorId = $authorId; }
        public function setCreatedAt(DateTime $createdAt): void { $this->createdAt = $createdAt; }
        public function setUpdatedAt(DateTime $updatedAt): void { $this->updatedAt = $updatedAt; }
        public function setDeletedAt(?DateTime $deletedAt): void { $this->deletedAt = $deletedAt; }

    }

?>