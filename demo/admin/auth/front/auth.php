<?php
// ini_set('error_reporting', E_ALL);
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
session_start();
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (
    isset($_POST['login']) && empty($_POST['login']) ||
    isset($_POST['password']) && empty($_POST['password'])
  ) {
    echo json_encode('no_data');
    die();
  }

  require_once __DIR__ . '/../../db/DatabaseClass.php';
  require_once __DIR__ . '/../back/class/AuthClass.php';
  $database = new Database();
  $db = $database->getConnection();
  $admin = new AdminClass($db);

  $stmt_admin = $admin->get_auth_data();
  $admin_arr_data = $stmt_admin->fetchAll(PDO::FETCH_ASSOC)[0];

  $admin_name = $admin_arr_data['admin_name'];
  $admin_pass = $admin_arr_data['admin_pass'];
  $user_login = htmlspecialchars(trim($_POST['login']));
  $user_password = htmlspecialchars(trim($_POST['password']));

  if (password_verify($user_password, $admin_pass) && $admin_name == $user_login) {
    $_SESSION['is_auth'] = true;
    $_SESSION["login"] = $user_login;
    header("Location: /admin/");
  } else {
    $_SESSION["is_auth"] = false;
    header("Location: /admin/");
    die();
  }

  // echo json_encode($admin_arr_data);




  // } else {
  //   header("Location: /");
  // }
  // if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["admin_name"]) && isset($_POST["admin_name"])) {

  //     require_once __DIR__ . '/class/AuthClass.php';
  //     $auth = new AuthClass();

  //         //Если логин и пароль введен не правильно
  //         if (!$auth->auth($_POST["admin_name"], $_POST["admin_name"])) {
  //             echo json_encode('AUTHERRORLP');
  //         }

  //         // Если авторизовался
  //         if ($auth->isAuth()) {
  //             echo json_encode('AUTHSUCCESS');
  //         }


} else {
  header("Location: /admin/");
}
