<?php

    namespace App\viewmodels;

    use DateTime;

    class ReviewViewModel {
        private string $id;
        private string $postId;
        private string $userId;
        private string $authorName;
        private string $authorUsername;
        private int $rating;
        private ?string $comment;
        private DateTime $createdAt;
        private DateTime $updatedAt;
        private ?DateTime $deletedAt;
    
        public function __construct($id, $postId, $userId, $authorName, $authorUsername, $rating, $comment, $createdAt, $updatedAt, $deletedAt) {
            $this->id = $id;
            $this->postId = $postId;
            $this->userId = $userId;
            $this->authorName = $authorName;
            $this->authorUsername = $authorUsername;
            $this->rating = $rating;
            $this->comment = $comment;
            $this->createdAt = $createdAt;
            $this->updatedAt = $updatedAt;
            $this->deletedAt = $deletedAt;
        }

        // Getters
        public function getId(): string { return $this->id; }
        public function getPostId(): string { return $this->postId; }
        public function getUserId(): string { return $this->userId; }
        public function getAuthorName(): string { return $this->authorName; }
        public function getAuthorUsername(): string { return $this->authorUsername; }
        public function getRating(): int { return $this->rating; }
        public function getComment(): ?string { return $this->comment; }
        public function getCreatedAt(): DateTime { return $this->createdAt; }
        public function getUpdatedAt(): DateTime { return $this->updatedAt; }
        public function getDeletedAt(): ?DateTime { return $this->deletedAt; }

    }

?>