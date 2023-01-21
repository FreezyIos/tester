<?php
// ini_set('error_reporting', E_ALL);
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
header("Content-Type: application/json; charset=UTF-8");
$protocol = stripos($_SERVER['SERVER_PROTOCOL'], 'https') === true ? 'https://' : 'http://';
$request_page = $protocol . $_SERVER['SERVER_NAME'] . '/admin/';

if ($_SERVER["REQUEST_METHOD"] == "POST" && $_SERVER['HTTP_REFERER'] == $request_page) {
  require_once __DIR__ . '/../../db/DatabaseClass.php';
  require_once __DIR__ . '/../back/class/ConfigClass.php';
  $database = new Database();
  $db = $database->getConnection();
  $config = new ConfigClass($db);
  $stmt_config = $config->get_all_config_list();
  $config_arr = $stmt_config->fetchAll(PDO::FETCH_ASSOC);
  echo json_encode($config_arr);
} else {
  header("Location: /");
}
