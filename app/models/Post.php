<?php

namespace app\models;

use PDO;

class Post {
    private $pdo;

    public function __construct() {
        $dsn = 'mysql:host=localhost;dbname=your_database_name;charset=utf8';
        $username = 'your_username';
        $password = 'your_password';
        $this->pdo = new PDO($dsn, $username, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
    }

    public function getAllPosts() {
        $stmt = $this->pdo->query("SELECT * FROM posts");
        return $stmt->fetchAll();
    }

    public function savePost($title, $description) {
        $stmt = $this->pdo->prepare("INSERT INTO posts (title, description) VALUES (?, ?)");
        $stmt->execute([$title, $description]);
        return $this->pdo->lastInsertId();
    }

    public function getPostById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM posts WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function updatePost($id, $title, $description) {
        $stmt = $this->pdo->prepare("UPDATE posts SET title = ?, description = ? WHERE id = ?");
        $stmt->execute([$title, $description, $id]);
    }

    public function deletePost($id) {
        $stmt = $this->pdo->prepare("DELETE FROM posts WHERE id = ?");
        $stmt->execute([$id]);
    }
}
