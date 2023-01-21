<?php
// ini_set('error_reporting', E_ALL);
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);


header("Content-Type: application/json; charset=UTF-8");
$protocol = stripos($_SERVER['SERVER_PROTOCOL'], 'https') === true ? 'https://' : 'http://';
$request_page = $protocol . $_SERVER['SERVER_NAME'] . '/admin/';

if ($_SERVER["REQUEST_METHOD"] == "POST" && $_SERVER['HTTP_REFERER'] == $request_page) {


  require_once __DIR__ . '/../../db/DatabaseClass.php';
  require_once __DIR__ . '/../back/class/ProductClass.php';
  $database = new Database();
  $db = $database->getConnection();
  $product = new ProductClass($db);
  $product->product_id = trim(strip_tags($_POST['product_id']));
  $respond = $product->delete_product();
  echo json_encode($respond);
} else {
  header("Location: /");
}
