<?php

require_once 'DB.php';

class Comment
{
    private $db;

    public function __construct()
    {
        $this->db = new DB();
    }

    public function createComment($jsonData)
    {
        $data = json_decode($jsonData, true);
        $commentText = $data['comment_text'];
        $userId = $data['user_id'];
        $parentId = $data['parent_id'] ?? null;

        // Check if user is authorized
        $this->checkAuthorization();

        // Insert comment into database
        $query = "INSERT INTO comments (comment_text, user_id, parent_id) VALUES (:comment_text, :user_id, :parent_id)";
        $params = [
            ':comment_text' => $commentText,
            ':user_id' => $userId,
            ':parent_id' => $parentId
        ];
        $result = $this->db->query($query, $params);

        return $result ? $this->db->lastInsertId() : null;
    }

    public function editComment($id, $jsonData)
    {
        $data = json_decode($jsonData, true);
        $commentText = $data['comment_text'];
        $userId = $data['user_id'];

        // Check if user is authorized
        $this->checkAuthorization();

        // Update comment in database
        $query = "UPDATE comments SET comment_text = :comment_text WHERE id = :id AND user_id = :user_id";
        $params = [
            ':comment_text' => $commentText,
            ':id' => $id,
            ':user_id' => $userId
        ];
        $result = $this->db->query($query, $params);

        return $result ? true : false;
    }

    public function getComment($id)
    {
        // Check if user is authorized
        $this->checkAuthorization();

        // Get comment from database
        $query = "SELECT * FROM comments WHERE id = :id";
        $params = [':id' => $id];
        $result = $this->db->query($query, $params);

        return $result ? $result->fetch(PDO::FETCH_ASSOC) : null;
    }

    public function deleteComment($id)
    {
        // Check if user is authorized
        $this->checkAuthorization();

        // Delete comment from database
        $query = "DELETE FROM comments WHERE id = :id";
        $params = [':id' => $id];
        $result = $this->db->query($query, $params);

        return $result ? true : false;
    }

    private function checkAuthorization()
    {
        // Проверяем, что заголовок Authorization был передан
    if(!isset($_SERVER['HTTP_AUTHORIZATION'])) {
        http_response_code(401); // Ошибка авторизации
        exit();
    }

    // Получаем токен из заголовка Authorization
    $token = $_SERVER['HTTP_AUTHORIZATION'];

    // Запрос в БД на получение пользователя с таким токеном
    $user = DB::query('SELECT * FROM users WHERE token = ?', $token)->fetch();

    // Если пользователь не найден, то генерируем ошибку авторизации
    if(!$user) {
        http_response_code(401); // Ошибка авторизации
        exit();
    }

    // Если пользователь найден, то сохраняем его ID для последующего использования
    $this->userId = $user['id'];
    }
}
