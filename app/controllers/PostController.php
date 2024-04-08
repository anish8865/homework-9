<?php

namespace app\controllers;

use app\models\Post;

class PostController
{
    public function validatePost($inputData) {
        $errors = [];
        $title = isset($inputData['title']) ? trim($inputData['title']) : '';
        $description = isset($inputData['description']) ? trim($inputData['description']) : '';

        if (empty($title)) {
            $errors['titleRequired'] = 'Title is required';
        } elseif (strlen($title) < 2) {
            $errors['titleShort'] = 'Title is too short';
        }

        if (empty($description)) {
            $errors['descriptionRequired'] = 'Description is required';
        } elseif (strlen($description) < 2) {
            $errors['descriptionShort'] = 'Description is too short';
        }

        if (!empty($errors)) {
            http_response_code(400);
            echo json_encode(['errors' => $errors]);
            exit();
        }

        return [
            'title' => htmlspecialchars($title, ENT_QUOTES, 'UTF-8'),
            'description' => htmlspecialchars($description, ENT_QUOTES, 'UTF-8'),
        ];
    }

    public function getPosts($id = null) {
        header("Content-Type: application/json");
        $postModel = new Post();
        if ($id) {
            $post = $postModel->getPostById($id);
            echo json_encode($post ?: []);
        } else {
            $posts = $postModel->getAllPosts();
            echo json_encode($posts);
        }
        exit();
    }

    public function savePost() {
        $inputData = [
            'title' => $_POST['title'] ?? '',
            'description' => $_POST['description'] ?? '',
        ];
        $validatedData = $this->validatePost($inputData);

        $postModel = new Post();
        $postModel->savePost($validatedData['title'], $validatedData['description']);

        http_response_code(201); 
        echo json_encode(['message' => 'Post created successfully']);
        exit();
    }

    public function updatePost($id) {
        if (!$id) {
            http_response_code(404);
            echo json_encode(['message' => 'Post not found']);
            exit();
        }

        parse_str(file_get_contents('php://input'), $_PUT);

        $inputData = [
            'title' => $_PUT['title'] ?? '',
            'description' => $_PUT['description'] ?? '',
        ];
        $validatedData = $this->validatePost($inputData);

        $postModel = new Post();
        $postModel->updatePost($id, $validatedData['title'], $validatedData['description']);

        http_response_code(200);
        echo json_encode(['message' => 'Post updated successfully']);
        exit();
    }

    public function deletePost($id) {
        if (!$id) {
            http_response_code(404);
            echo json_encode(['message' => 'Post not found']);
            exit();
        }

        $postModel = new Post();
        $postModel->deletePost($id);

        http_response_code(200);
        echo json_encode(['message' => 'Post deleted successfully']);
        exit();
    }

   
    public function postsView() {
        include '../public/assets/views/post/posts-view.html';
        exit();
    }

    public function postsAddView() {
        include '../public/assets/views/post/posts-add.html';
        exit();
    }

    public function postsDeleteView() {
        include '../public/assets/views/post/posts-delete.html';
        exit();
    }

    public function postsUpdateView() {
        include '../public/assets/views/post/posts-update.html';
        exit();
    }
}
