<?php

require_once __DIR__ . '/../../../db/DatabaseClass.php';

class ContactClass
{
  private $conn;
  private $table_name = "config";

  // public $config_mail_from;
  // public $config_mail_to;
  // public $config_smtp_host;
  // public $config_smtp_login;
  // public $config_smtp_pass;
  // public $config_smtp_port;

  // конструктор для соединения с базой данных
  public function __construct($db)
  {
    $this->conn = $db;
  }

  function get_mail_data()
  {
    $query = "SELECT config_mail_from, config_mail_to, config_smtp_host, config_smtp_login, config_smtp_pass, config_smtp_port FROM $this->table_name";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt;
  }

  function get_required_fields()
  {
    $query = "SELECT config_is_name_required, config_is_tel_required, config_is_email_required, config_is_city_required, config_is_street_required, config_is_house_number_required, config_is_apartment_number_required, config_is_postcode_required, config_is_comment_required FROM $this->table_name";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt;
  }
}
