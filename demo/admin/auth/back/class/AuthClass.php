<?php

class AdminClass
{

  private $conn;
  private $table_name = "admin";

  public $admin_name = 'admin';
  public $admin_pass;

  // конструктор для соединения с базой данных
  public function __construct($db)
  {
    $this->conn = $db;
  }

  function isAuth()
  {
    //Если сессия существует
    //Возвращаем значение переменной сессии is_auth (хранит true если авторизован, false если не авторизован)
    if (isset($_SESSION["is_auth"])) {
      return $_SESSION["is_auth"];
    } else return false;
  }

  function get_auth_data()
  {
    $query = "SELECT * FROM $this->table_name WHERE admin_name=:admin_name";
    $stmt = $this->conn->prepare($query);

    try {
      if ($stmt->execute([
        'admin_name' => $this->admin_name
      ])) {
        return $stmt;
      }
    } catch (PDOException $e) {
      return json_encode("Error: " . $e->getMessage());
    }
    return 'error';
  }
}
