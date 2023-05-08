<?php

require_once '../../classes/Comment.php';

// Проверяем авторизацию пользователя
$comment = new Comment();
if (!$comment->checkAuthorization()) {
    http_response_code(401);
    exit();
}

// Получаем входные данные в формате JSON
$json = file_get_contents('php://input');
$data = json_decode($json, true);

// Проверяем наличие обязательных полей в данных
if (!isset($data['id'], $data['text'])) {
    http_response_code(400);
    exit();
}

// Обновляем комментарий
if ($comment->updateComment($data['id'], $data['text'])) {
    http_response_code(200);
} else {
    http_response_code(500);
}
