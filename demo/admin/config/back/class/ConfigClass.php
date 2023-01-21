<?php
// ini_set('error_reporting', E_ALL);
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);

require_once __DIR__ . '/../../../db/DatabaseClass.php';

class ConfigClass
{
  private $conn;
  private $table_name = "config";

  // свойства продукта
  public $config_currency;
  public $config_mail_from;
  public $config_mail_to;
  public $config_smtp_host;
  public $config_smtp_login;
  public $config_smtp_pass;
  public $config_smtp_port;
  public $config_metrika_counter;
  public $config_metrika_add_to_basket;
  public $config_metrika_submit_basket;
  public $config_mask_tel;

  public $config_is_name_active;
  public $config_is_tel_active;
  public $config_is_email_active;
  public $config_is_city_active;
  public $config_is_street_active;
  public $config_is_house_number_active;
  public $config_is_apartment_number_active;
  public $config_is_postcode_active;
  public $config_is_comment_active;

  public $config_is_name_required;
  public $config_is_tel_required;
  public $config_is_email_required;
  public $config_is_city_required;
  public $config_is_street_required;
  public $config_is_house_number_required;
  public $config_is_apartment_number_required;
  public $config_is_postcode_required;
  public $config_is_comment_required;

  // конструктор для соединения с базой данных
  public function __construct($db)
  {
    $this->conn = $db;
  }

  function update_config()
  {
    $query = "UPDATE $this->table_name SET
              config_currency                     =:config_currency,
              config_mail_from                    =:config_mail_from,
              config_mail_to                      =:config_mail_to,

              config_smtp_host                      =:config_smtp_host,
              config_smtp_login                     =:config_smtp_login,
              config_smtp_pass                      =:config_smtp_pass,
              config_smtp_port                      =:config_smtp_port,

              config_metrika_counter              =:config_metrika_counter,
              config_metrika_add_to_basket        =:config_metrika_add_to_basket,
              config_metrika_submit_basket        =:config_metrika_submit_basket,
              config_mask_tel                     =:config_mask_tel,
              config_is_name_active               =:config_is_name_active,
              config_is_tel_active                =:config_is_tel_active,
              config_is_email_active              =:config_is_email_active,
              config_is_city_active               =:config_is_city_active,
              config_is_street_active             =:config_is_street_active,
              config_is_house_number_active       =:config_is_house_number_active,
              config_is_apartment_number_active   =:config_is_apartment_number_active,
              config_is_postcode_active           =:config_is_postcode_active,
              config_is_comment_active            =:config_is_comment_active,
              config_is_name_required             =:config_is_name_required,
              config_is_tel_required              =:config_is_tel_required,
              config_is_email_required            =:config_is_email_required,
              config_is_city_required             =:config_is_city_required,
              config_is_street_required           =:config_is_street_required,
              config_is_house_number_required     =:config_is_house_number_required,
              config_is_apartment_number_required =:config_is_apartment_number_required,
              config_is_postcode_required         =:config_is_postcode_required,
              config_is_comment_required          =:config_is_comment_required
            ";

    // подготовка запроса
    $stmt = $this->conn->prepare($query);
    try {
      if ($stmt->execute([
        'config_currency'                     => $this->config_currency,
        'config_mail_from'                    => $this->config_mail_from,
        'config_mail_to'                      => $this->config_mail_to,

        'config_smtp_host'                      => $this->config_smtp_host,
        'config_smtp_login'                      => $this->config_smtp_login,
        'config_smtp_pass'                      => $this->config_smtp_pass,
        'config_smtp_port'                      => $this->config_smtp_port,

        'config_metrika_counter'              => $this->config_metrika_counter,
        'config_metrika_add_to_basket'        => $this->config_metrika_add_to_basket,
        'config_metrika_submit_basket'        => $this->config_metrika_submit_basket,
        'config_mask_tel'                     => $this->config_mask_tel,
        'config_is_name_active'               => $this->config_is_name_active,
        'config_is_tel_active'                => $this->config_is_tel_active,
        'config_is_email_active'              => $this->config_is_email_active,
        'config_is_city_active'               => $this->config_is_city_active,
        'config_is_street_active'             => $this->config_is_street_active,
        'config_is_house_number_active'       => $this->config_is_house_number_active,
        'config_is_apartment_number_active'   => $this->config_is_apartment_number_active,
        'config_is_postcode_active'           => $this->config_is_postcode_active,
        'config_is_comment_active'            => $this->config_is_comment_active,
        'config_is_name_required'             => $this->config_is_name_required,
        'config_is_tel_required'              => $this->config_is_tel_required,
        'config_is_email_required'            => $this->config_is_email_required,
        'config_is_city_required'             => $this->config_is_city_required,
        'config_is_street_required'           => $this->config_is_street_required,
        'config_is_house_number_required'     => $this->config_is_house_number_required,
        'config_is_apartment_number_required' => $this->config_is_apartment_number_required,
        'config_is_postcode_required'         => $this->config_is_postcode_required,
        'config_is_comment_required'          => $this->config_is_comment_required
      ])) {
        return 'UPDATECONFIGSUCCESS';
      }
    } catch (PDOException $e) {

      return json_encode("Error: " . $e->getMessage());
    }

    return false;
  }

  function get_all_config_list()
  {
    $query = "SELECT *  FROM $this->table_name";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt;
  }

  function get_config_frontend_list()
  {
    $query = "SELECT config_currency, config_mask_tel, config_is_name_active, config_is_tel_active, config_is_email_active, config_is_city_active, config_is_street_active, config_is_house_number_active, config_is_apartment_number_active, config_is_postcode_active, config_is_comment_active, config_is_name_required, config_is_tel_required, config_is_email_required, config_is_city_required, config_is_street_required, config_is_house_number_required, config_is_apartment_number_required, config_is_postcode_required, config_is_comment_required FROM $this->table_name";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt;
  }
}
