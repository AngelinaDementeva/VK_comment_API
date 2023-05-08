<?php

require __DIR__ . '/vendor/autoload.php';

// Инициализация объекта приложения Slim
$app = new Slim\App();

// Инициализация объекта базы данных
$db = new DB('localhost', 'user', 'password', 'name');

// Регистрация маршрутов API
require __DIR__ . '/api/post/comment.php';
require __DIR__ . '/api/get/comment.php';
require __DIR__ . '/api/put/comment.php';
require __DIR__ . '/api/delete/comment.php';

// Запуск приложения
$app->run();
