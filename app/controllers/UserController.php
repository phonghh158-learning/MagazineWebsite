<?php

    namespace App\controllers;

    use App\repositories\UserRepository;
    
    class UserController {
        private $repository;

        public function __construct() {
            $this->repository = new UserRepository();
        }

        public function index() {
            $users = $this->repository->getAll();
            require_once __DIR__ . '/../../views/pages/user/index.php';
        }

        public function show($id) {
            $users = $this->repository->getById($id);
            require_once __DIR__ . '/../../views/pages/user/show.php';
        }
    }

?>