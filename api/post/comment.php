<?php

// Заголовки ответа сервера будут в формате JSON
header('Content-Type: application/json');

// Проверка токена доступа пользователя
include_once('../../classes/User.php');
$user = new User();
if (!$user->checkAuthorization()) {
    http_response_code(401); // Ошибка "Не авторизован"
    echo json_encode(array("message" => "Вы не авторизованы."));
    exit();
}

// Получение данных из тела запроса в формате JSON
$data = json_decode(file_get_contents("php://input"));

// Валидация входных данных
if (!isset($data->text) || !isset($data->author)) {
    http_response_code(400); // Ошибка "Неверный запрос"
    echo json_encode(array("message" => "Некоторые данные отсутствуют."));
    exit();
}

// Подключение к БД
include_once('../../config/db.php');
$database = new DB();
$db = $database->getConnection();

// Создание объекта комментария и установка свойств
include_once('../../classes/Comment.php');
$comment = new Comment($db);
$comment->setText($data->text);
$comment->setAuthor($data->author);

// Создание комментария в БД
if ($comment->create()) {
    http_response_code(201); // Код "Создано"
    echo json_encode(array("message" => "Комментарий создан."));
} else {
    http_response_code(503); // Ошибка "Сервис недоступен"
    echo json_encode(array("message" => "Не удалось создать комментарий."));
}
