<?php

class Database
{
  private $host = "localhost";
  public $conn;

  // получаем соединение с БД
  public function getConnection()
  {

    $this->conn = null;

    try {
      $this->conn = new PDO("sqlite:".__DIR__."/smartbasket.db");

    } catch (PDOException $exception) {
      echo "Connection error: " . $exception->getMessage();
    }

    return $this->conn;
  }

  public function closeConnection()
  {
    $this->conn = null;
    return $this->conn;
  }
}
