<?php

// Читаем JSON-файл с конфигурацией
$config = json_decode(file_get_contents(__DIR__ . '/../config.json'), true);

// Параметры подключения к базе данных
$host = $config['db']['host'];
$dbname = $config['db']['name'];
$user = $config['db']['user'];
$password = $config['db']['password'];

// Подключение к базе данных
$pdo = new PDO("mysql:host={$host};dbname={$dbname}", $user, $password);

// Установка режима обработки ошибок
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Создание таблицы комментариев, если ее нет
$pdo->exec("
    CREATE TABLE IF NOT EXISTS comments (
        id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        text TEXT NOT NULL,
        parent_id INT(11) UNSIGNED,
        user_id INT(11) UNSIGNED NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )
");

// Создание таблицы пользователей, если ее нет
$pdo->exec("
    CREATE TABLE IF NOT EXISTS users (
        id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL,
        password VARCHAR(255) NOT NULL
    )
");

return $pdo;
