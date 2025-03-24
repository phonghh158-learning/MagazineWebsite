<?php

namespace core;

use PDO;
use PDOException;

class Database {
    private static $instance = null;
    private $pdo;

    private function __construct() {
        $config = require __DIR__ . "/../config/app.php";

        try {
            $dsn = "mysql:host={$config['host']};dbname={$config['database']};charset={$config['charset']}";
            $this->pdo = new PDO($dsn, $config['username'], $config['password'], $config['options']);
        } catch (PDOException $e) {
            die("Database Connection Failed: " . $e->getMessage());
        }
    }

    public static function getInstance() {
        if (static::$instance === null) {
            static::$instance = new static();
        }
        return static::$instance;
    }

    public function getConnection() {
        return $this->pdo;
    }

    public function disconnect() {
        $this->pdo = null;
    }
}
