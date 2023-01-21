<?php
// ini_set('error_reporting', E_ALL);
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
header("Content-Type: application/json; charset=UTF-8");
$protocol = stripos($_SERVER['SERVER_PROTOCOL'], 'https') === true ? 'https://' : 'http://';
$request_page = $protocol . $_SERVER['SERVER_NAME'] . '/admin/';

if ($_SERVER["REQUEST_METHOD"] == "POST" && $_SERVER['HTTP_REFERER'] == $request_page) {
  // echo json_encode($_FILES);
  require_once __DIR__ . '/../../functions/can_upload_img.php';
  require_once __DIR__ . '/../../functions/make_upload.php';

  $check = false;
  $product_arr = [];

  if (
    isset($_POST['product_name']) && empty($_POST['product_name']) ||
    isset($_POST['product_price']) && empty($_POST['product_price']) ||
    (isset($_FILES['product_img']) && empty($_FILES['product_img']['size']) &&
      isset($_POST['product_file_path']) && empty($_POST['product_file_path'])
    )
  ) {
    echo json_encode('EMPTYERROR');
    die();
  }

  // проверяем, можно ли загружать изображение
  if (isset($_FILES['product_img']) && !empty($_FILES['product_img']['size'])) {
    $check = can_upload_img($_FILES['product_img']);
    if ($check !== true) {
      echo json_encode($check);
      die();
    }
  }

  if (
    isset($_POST['product_name']) && !empty($_POST['product_name']) &&
    isset($_POST['product_price']) && !empty($_POST['product_price']) &&
    (isset($_FILES['product_img']) && !empty($_FILES['product_img']['size']) ||
      isset($_POST['product_file_path']) && !empty($_POST['product_file_path'])
    )

  ) {
    require_once __DIR__ . '/../../db/DatabaseClass.php';
    require_once __DIR__ . '/../back/class/ProductClass.php';
    $database = new Database();
    $db = $database->getConnection();
    $product = new ProductClass($db);

    // загружаем изображение на сервер
    if (isset($_FILES['product_img']) && !empty($_FILES['product_img']['size'])) {
      $product_img = make_upload($_FILES['product_img']);
    } else {
      $product_img = trim(
        strip_tags(
          $_POST['product_file_path']
        )
      );
    }

    $product->product_img = $product_img;
    $product->product_id = trim(strip_tags($_POST['product_id']));
    $product->product_name = trim(strip_tags($_POST['product_name']));
    $product->product_price = trim(strip_tags($_POST['product_price']));
    $product->product_price_old = isset($_POST['product_price_old']) ? trim(strip_tags($_POST['product_price_old'])) : '';
    $product->product_vendor_code = isset($_POST['product_vendor_code']) ? trim(strip_tags($_POST['product_vendor_code'])) : '';

    if (isset($_POST['product_is_active']) && !empty($_POST['product_is_active'])) {
      $product->product_is_active = 1;
    } else {
      $product->product_is_active = 0;
    }

    if (isset($_POST['product_is_quantity']) && !empty($_POST['product_is_quantity'])) {
      $product->product_is_quantity = 1;
    } else {
      $product->product_is_quantity = 0;
    }

    if (isset($_POST['product_is_fast_by']) && !empty($_POST['product_is_fast_by'])) {
      $product->product_is_fast_by = 1;
    } else {
      $product->product_is_fast_by = 0;
    }

    $respond = $product->update_product();

    if (stristr($respond, 'UNIQUE')) {

      if (stristr($respond, 'product_img')) {
        echo json_encode('NOTUNIQUEPRODUCTIMG');
        die();
      }
    }

    $product_file_path = str_replace('/admin/img/product/', '', $_POST['product_file_path']);
    if ($respond == 'UPDATEPRODUCTSUCCESS' && isset($_FILES['product_img']) && !empty($_FILES['product_img']['size'])) {
      unlink(__DIR__ . '/../../img/product/' . $product_file_path);
    }

    echo json_encode($respond);
  }
} else {
  header("Location: /");
}
