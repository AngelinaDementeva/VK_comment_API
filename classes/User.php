<?php
require_once("DB.php");

class User {
  private $db;

  public function __construct() {
    $this->db = new DB();
  }

  public function login($username, $password) {
    // Проверяем наличие пользователя в базе данных
    $result = $this->db->query("SELECT * FROM users WHERE username=:username AND password=:password", array(':username'=>$username, ':password'=>md5($password)));

    if(count($result) > 0) {
      // Создаем токен доступа для пользователя
      $token = bin2hex(random_bytes(64));

      // Сохраняем токен в базе данных
      $this->db->query("UPDATE users SET access_token=:token WHERE username=:username", array(':token'=>$token, ':username'=>$username));

      // Возвращаем токен доступа
      return array('status'=>'success', 'access_token'=>$token);
    } else {
      // Пользователь не найден
      return array('status'=>'error', 'message'=>'Invalid username or password');
    }
  }

  public function logout($access_token) {
    // Удаляем токен доступа из базы данных
    $this->db->query("UPDATE users SET access_token=NULL WHERE access_token=:access_token", array(':access_token'=>$access_token));
  }

  public function checkAuthorization($access_token) {
    // Проверяем наличие токена доступа в базе данных
    $result = $this->db->query("SELECT * FROM users WHERE access_token=:access_token", array(':access_token'=>$access_token));

    if(count($result) > 0) {
      // Токен доступа найден, возвращаем информацию о пользователе
      return $result[0];
    } else {
      // Токен доступа не найден
      return false;
    }
  }
}
