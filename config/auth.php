<?php

// данные для подключения к БД
$db_host = 'localhost';
$db_name = 'mydatabase';
$db_username = 'myusername';
$db_password = 'mypassword';

// соединяемся с БД
$pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_username, $db_password);

// функция для проверки авторизации пользователя по токену
function checkAuthorization($pdo, $token) {
  $stmt = $pdo->prepare("SELECT user_id FROM tokens WHERE token = ?");
  $stmt->execute([$token]);
  $result = $stmt->fetch(PDO::FETCH_ASSOC);
  if ($result) {
    return true;
  } else {
    return false;
  }
}
