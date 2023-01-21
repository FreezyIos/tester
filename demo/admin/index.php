<?php
session_start();

function isAuth()
{
  if (isset($_SESSION["is_auth"])) {
    return $_SESSION["is_auth"];
  } else return false;
}
?>

<!doctype html>
<html lang="ru">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Демо корзины (SmartBasket)</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@200;300;400;500;600&display=swap" rel="stylesheet">
  <link href="/admin/css/style.css" rel="stylesheet" />
  <?php if (isAuth()) : ?>
    <script defer="defer" src="/admin/js/chunk-vendors.1b8c9bbe.js"></script>
    <script defer="defer" src="/admin/js/app.dd72e36f.js"></script>
    <link href="/admin/css/app.2c317f01.css" rel="stylesheet">
  <?php endif; ?>
</head>

<body>
  <?php if (isAuth()) : ?>

    <div id="app_admin"></div>

  <?php else : ?>
    <?php require_once __DIR__ . '/auth/front/auth_form.php'; ?>
  <?php endif; ?>

</body>

</html>