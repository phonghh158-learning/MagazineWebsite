<?php

    namespace App\entities;

    use DateTime;

    class CategoryEntity {
        private string $id;
        private string $name;
        private ?string $icon;
        private ?string $description;
        private DateTime $createdAt;
        private DateTime $updatedAt;
        private ?DateTime $deletedAt;
    
        public function __construct($id, $name, $icon, $description, $created_at, $updated_at, $deleted_at) {
            $this->id = $id;
            $this->name = $name;
            $this->icon = $icon;
            $this->description = $description;
            $this->createdAt = $created_at;
            $this->updatedAt = $updated_at;
            $this->deletedAt = $deleted_at;            
        }

        // Getters
        public function getId(): string { return $this->id; }
        public function getName(): string { return $this->name; }
        public function getIcon(): ?string { return $this->icon; }
        public function getDescription(): ?string { return $this->description; }
        public function getCreatedAt(): DateTime { return $this->createdAt; }
        public function getUpdatedAt(): DateTime { return $this->updatedAt; }
        public function getDeletedAt(): ?DateTime { return $this->deletedAt; }
    
        // Setters
        public function setId(string $id): void { $this->id = $id; }
        public function setName(string $name): void { $this->name = $name; }
        public function setIcon(?string $icon): void { $this->icon = $icon; }
        public function setDescription(?string $description): void { $this->description = $description; }
        public function setCreatedAt(DateTime $createdAt): void { $this->createdAt = $createdAt; }
        public function setUpdatedAt(DateTime $updatedAt): void { $this->updatedAt = $updatedAt; }
        public function setDeletedAt(?DateTime $deletedAt): void { $this->deletedAt = $deletedAt; }

    }

?>