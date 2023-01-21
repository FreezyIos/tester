<?php
// ini_set('error_reporting', E_ALL);
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  require_once __DIR__ . '/../../db/DatabaseClass.php';
  require_once __DIR__ . '/../back/class/ProductClass.php';
  $database = new Database();
  $db = $database->getConnection();
  $products = new ProductClass($db);
  $stmt_products = $products->get_product_list();
  $products_arr = $stmt_products->fetchAll(PDO::FETCH_ASSOC);
  echo json_encode($products_arr);
} else {
  header("Location: /");
}
