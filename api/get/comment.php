<?php

// Подключаем классы
require_once '../../classes/Comment.php';
require_once '../../classes/Db.php';

// Создаем объект базы данных
$db = new Db();

// Проверяем авторизацию
if (!$db->checkAuthorization()) {
    // Если пользователь не авторизован, возвращаем ошибку
    header('HTTP/1.1 401 Unauthorized');
    exit();
}

// Получаем комментарии из базы данных
$comments = Comment::getAll($db);

// Возвращаем комментарии в формате JSON
header('Content-Type: application/json');
echo json_encode($comments);
