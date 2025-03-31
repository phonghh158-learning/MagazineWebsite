<?php

namespace App\viewmodels;

use DateTime;

class PostViewModel {
    private string $id;
    private string $title;
    private ?string $thumbnail;
    private array $paragraphs;
    private string $status;
    private string $categoryName;
    private string $authorName;
    private DateTime $createdAt;
    private DateTime $updatedAt;
    
    public function __construct($id, $title, $thumbnail, $paragraphs, $status, $categoryName, $authorName, $createdAt, $updatedAt) {
        $this->id = $id;
        $this->title = $title;
        $this->thumbnail = $thumbnail;
        $this->paragraphs = is_string($paragraphs) ? json_decode($paragraphs, true) : $paragraphs;
        $this->status = $status;
        $this->categoryName = $categoryName;
        $this->authorName = $authorName;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    // Getters
    public function getId(): string { return $this->id; }
    public function getTitle(): string { return $this->title; }
    public function getThumbnail(): ?string { return $this->thumbnail; }
    public function getParagraphs(): array { return $this->paragraphs; }
    public function getStatus(): string { return $this->status; }
    public function getCategoryName(): string { return $this->categoryName; }
    public function getAuthorName(): string { return $this->authorName; }
    public function getCreatedAt(): DateTime { return $this->createdAt; }
    public function getUpdatedAt(): DateTime { return $this->updatedAt; }
}
