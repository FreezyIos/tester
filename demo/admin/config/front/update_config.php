<?php
// ini_set('error_reporting', E_ALL);
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);

header("Content-Type: application/json; charset=UTF-8");
$protocol = stripos($_SERVER['SERVER_PROTOCOL'],'https') === true ? 'https://' : 'http://';
$request_page = $protocol . $_SERVER['SERVER_NAME'] . '/admin/settings';


if ($_SERVER["REQUEST_METHOD"] == "POST" && $_SERVER['HTTP_REFERER'] == $request_page) {

  require_once __DIR__ . '/../../db/DatabaseClass.php';
  require_once __DIR__ . '/../back/class/ConfigClass.php';
  $database = new Database();
  $db = $database->getConnection();
  $config = new ConfigClass($db);

  if (isset($_POST['config_currency']) && empty($_POST['config_currency'])) {
    // при включенном отладчике
    echo json_encode('EMPTYCURRENCY');
    die();
  } else {
    $config->config_currency = trim(strip_tags($_POST['config_currency']));
  }

  if (isset($_POST['config_mail_from']) && !empty($_POST['config_mail_from']) && isset($_POST['config_mail_to']) && !empty($_POST['config_mail_to']) && $_POST['config_mail_from'] == $_POST['config_mail_to']) {
    // при включенном отладчике
    echo json_encode('DOUBLEEMAIL');
    die();
  }

  if (
    isset($_POST['config_mail_from']) && !empty($_POST['config_mail_from']) &&
    isset($_POST['config_mail_to']) && empty($_POST['config_mail_to']) ||
    isset($_POST['config_mail_from']) && empty($_POST['config_mail_from']) &&
    isset($_POST['config_mail_to']) && !empty($_POST['config_mail_to'])
  ) {
    // при включенном отладчике
    echo json_encode('EMPTYONEOFMAIL');
    die();
  }

  if (isset($_POST['config_mail_from']) && !empty($_POST['config_mail_from'])) {
    $config->config_mail_from = trim(strip_tags($_POST['config_mail_from']));
  } else {
    $config->config_mail_from = "";
  }

  if (isset($_POST['config_mail_to']) && !empty($_POST['config_mail_to'])) {
    $config->config_mail_to = trim(strip_tags($_POST['config_mail_to']));
  } else {
    $config->config_mail_to = "";
  }

  if (isset($_POST['config_smtp_host']) && !empty($_POST['config_smtp_host'])) {
    $config->config_smtp_host = trim(strip_tags($_POST['config_smtp_host']));
  } else {
    $config->config_smtp_host = "";
  }

  if (isset($_POST['config_smtp_login']) && !empty($_POST['config_smtp_login'])) {
    $config->config_smtp_login = trim(strip_tags($_POST['config_smtp_login']));
  } else {
    $config->config_smtp_login = "";
  }

  if (isset($_POST['config_smtp_pass']) && !empty($_POST['config_smtp_pass'])) {
    $config->config_smtp_pass = trim(strip_tags($_POST['config_smtp_pass']));
  } else {
    $config->config_smtp_pass = "";
  }

  if (isset($_POST['config_smtp_port']) && !empty($_POST['config_smtp_port'])) {
    $config->config_smtp_port = trim(strip_tags($_POST['config_smtp_port']));
  } else {
    $config->config_smtp_port = "";
  }

  if (isset($_POST['config_metrika_counter']) && !empty($_POST['config_metrika_counter'])) {
    $config->config_metrika_counter = trim(strip_tags($_POST['config_metrika_counter']));
  } else {
    $config->config_metrika_counter = "";
  }

  if (isset($_POST['config_metrika_add_to_basket']) && !empty($_POST['config_metrika_add_to_basket'])) {
    $config->config_metrika_add_to_basket = trim(strip_tags($_POST['config_metrika_add_to_basket']));
  } else {
    $config->config_metrika_add_to_basket = "ADDTOBASKET";
  }

  if (isset($_POST['config_metrika_submit_basket']) && !empty($_POST['config_metrika_submit_basket'])) {
    $config->config_metrika_submit_basket = trim(strip_tags($_POST['config_metrika_submit_basket']));
  } else {
    $config->config_metrika_submit_basket = "SUBMITBASKET";
  }

  if (isset($_POST['config_mask_tel']) && !empty($_POST['config_mask_tel'])) {
    $config->config_mask_tel = trim(strip_tags($_POST['config_mask_tel']));
  } else {
    $config->config_mask_tel = "";
  }

  if (isset($_POST['config_is_name_active']) && !empty($_POST['config_is_name_active'])) {
    $config->config_is_name_active = 1;
  } else {
    $config->config_is_name_active = 0;
  }

  if (isset($_POST['config_is_name_required']) && !empty($_POST['config_is_name_required'])) {
    $config->config_is_name_required = 1;
  } else {
    $config->config_is_name_required = 0;
  }

  if (isset($_POST['config_is_tel_active']) && !empty($_POST['config_is_tel_active'])) {
    $config->config_is_tel_active = 1;
  } else {
    $config->config_is_tel_active = 0;
  }

  if (isset($_POST['config_is_tel_required']) && !empty($_POST['config_is_tel_required'])) {
    $config->config_is_tel_required = 1;
  } else {
    $config->config_is_tel_required = 0;
  }

  if (isset($_POST['config_is_email_active']) && !empty($_POST['config_is_email_active'])) {
    $config->config_is_email_active = 1;
  } else {
    $config->config_is_email_active = 0;
  }

  if (isset($_POST['config_is_email_required']) && !empty($_POST['config_is_email_required'])) {
    $config->config_is_email_required = 1;
  } else {
    $config->config_is_email_required = 0;
  }

  if (isset($_POST['config_is_city_active']) && !empty($_POST['config_is_city_active'])) {
    $config->config_is_city_active = 1;
  } else {
    $config->config_is_city_active = 0;
  }

  if (isset($_POST['config_is_city_required']) && !empty($_POST['config_is_city_required'])) {
    $config->config_is_city_required = 1;
  } else {
    $config->config_is_city_required = 0;
  }

  if (isset($_POST['config_is_street_active']) && !empty($_POST['config_is_street_active'])) {
    $config->config_is_street_active = 1;
  } else {
    $config->config_is_street_active = 0;
  }

  if (isset($_POST['config_is_street_required']) && !empty($_POST['config_is_street_required'])) {
    $config->config_is_street_required = 1;
  } else {
    $config->config_is_street_required = 0;
  }

  if (isset($_POST['config_is_house_number_active']) && !empty($_POST['config_is_house_number_active'])) {
    $config->config_is_house_number_active = 1;
  } else {
    $config->config_is_house_number_active = 0;
  }

  if (isset($_POST['config_is_house_number_required']) && !empty($_POST['config_is_house_number_required'])) {
    $config->config_is_house_number_required = 1;
  } else {
    $config->config_is_house_number_required = 0;
  }

  if (isset($_POST['config_is_apartment_number_active']) && !empty($_POST['config_is_apartment_number_active'])) {
    $config->config_is_apartment_number_active = 1;
  } else {
    $config->config_is_apartment_number_active = 0;
  }

  if (isset($_POST['config_is_apartment_number_required']) && !empty($_POST['config_is_apartment_number_required'])) {
    $config->config_is_apartment_number_required = 1;
  } else {
    $config->config_is_apartment_number_required = 0;
  }

  if (isset($_POST['config_is_postcode_active']) && !empty($_POST['config_is_postcode_active'])) {
    $config->config_is_postcode_active = 1;
  } else {
    $config->config_is_postcode_active = 0;
  }

  if (isset($_POST['config_is_postcode_required']) && !empty($_POST['config_is_postcode_required'])) {
    $config->config_is_postcode_required = 1;
  } else {
    $config->config_is_postcode_required = 0;
  }

  if (isset($_POST['config_is_comment_active']) && !empty($_POST['config_is_comment_active'])) {
    $config->config_is_comment_active = 1;
  } else {
    $config->config_is_comment_active = 0;
  }

  if (isset($_POST['config_is_comment_required']) && !empty($_POST['config_is_comment_required'])) {
    $config->config_is_comment_required = 1;
  } else {
    $config->config_is_comment_required = 0;
  }



  $respond = $config->update_config();

  echo json_encode($respond);
} else {
  header("Location: /");
}
