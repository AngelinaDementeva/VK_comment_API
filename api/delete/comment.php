<?php
require_once '../../classes/Comment.php';
require_once '../../config/db.php';

// Проверка авторизации пользователя и получение токена
$user = new User();
$token = $user->checkAuthorization();

// Проверка наличия параметра id
if (!isset($_GET['id'])) {
    $response = array('error' => 'No comment ID provided');
    http_response_code(400); // Ошибка "Bad Request"
    echo json_encode($response);
    exit;
}

// Создание объекта Comment и удаление комментария
$comment = new Comment($pdo);
$commentId = $_GET['id'];
if ($comment->deleteComment($commentId, $token)) {
    $response = array('message' => 'Comment deleted successfully');
    echo json_encode($response);
} else {
    $response = array('error' => 'Failed to delete comment');
    http_response_code(500); // Ошибка "Internal Server Error"
    echo json_encode($response);
}
