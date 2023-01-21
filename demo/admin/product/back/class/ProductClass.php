<?php
//ini_set('error_reporting', E_ALL);
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);

require_once __DIR__ . '/../../../db/DatabaseClass.php';

class ProductClass
{
  private $conn;
  private $table_name = "product";

  // свойства продукта
  public $product_id;
  public $product_name;
  public $product_price;
  public $product_quantity;
  public $product_price_old;
  public $product_vendor_code;
  public $product_img;
  public $product_is_quantity;
  public $product_is_fast_by;
  public $product_is_active;

  // конструктор для соединения с базой данных
  public function __construct($db)
  {
    $this->conn = $db;
  }

  function add_product()
  {
    $query = "INSERT INTO product (
              product_name,
              product_price,
              product_price_old,
              product_vendor_code,
              product_img,
              product_is_quantity,
              product_is_fast_by
        ) VALUES (
              :product_name,
              :product_price,
              :product_price_old,
              :product_vendor_code,
              :product_img,
              :product_is_quantity,
              :product_is_fast_by
        )";

    // подготовка запроса
    $stmt = $this->conn->prepare($query);

    try {
      if ($stmt->execute([
        'product_name' => $this->product_name,
        'product_price' => $this->product_price,
        'product_price_old' => $this->product_price_old,
        'product_vendor_code' => $this->product_vendor_code,
        'product_img' => $this->product_img,
        'product_is_quantity' => $this->product_is_quantity,
        'product_is_fast_by' => $this->product_is_fast_by
      ])) {
        return 'ADDPRODUCTSUCCESS';
      }
    } catch (PDOException $e) {

      return json_encode("Error: " . $e->getMessage());
    }

    return false;
  }

  function delete_product()
  {
    $query = "DELETE FROM product WHERE product_id=:product_id";
    $stmt = $this->conn->prepare($query);
    try {
      if ($stmt->execute([
        'product_id' => $this->product_id
      ])) {
        return 'DELETEPRODUCTSUCCESS';
      }
    } catch (PDOException $e) {
      return json_encode("Error: " . $e->getMessage());
    }

    return false;
  }

  function update_product()
  {
    $query = "UPDATE product SET
              product_name =:product_name,
              product_price =:product_price,
              product_price_old =:product_price_old,
              product_vendor_code =:product_vendor_code,
              product_img =:product_img,
              product_is_quantity =:product_is_quantity,
              product_is_fast_by =:product_is_fast_by,
              product_is_active =:product_is_active
         WHERE product_id =:product_id";

    // подготовка запроса
    $stmt = $this->conn->prepare($query);
    try {
      if ($stmt->execute([
        'product_id' => $this->product_id,
        'product_name' => $this->product_name,
        'product_price' => $this->product_price,
        'product_price_old' => $this->product_price_old,
        'product_vendor_code' => $this->product_vendor_code,
        'product_img' => $this->product_img,
        'product_is_quantity' => $this->product_is_quantity,
        'product_is_fast_by' => $this->product_is_fast_by,
        'product_is_active' => $this->product_is_active
      ])) {
        return 'UPDATEPRODUCTSUCCESS';
      }
    } catch (PDOException $e) {

      return json_encode("Error: " . $e->getMessage());
    }

    return false;
  }

  function get_product_list()
  {
    $query = 'SELECT *  FROM `product` ORDER BY product_id DESC';
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt;
  }
}
