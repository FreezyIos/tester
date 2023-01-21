<?php
// mb_internal_encoding('UTF-8');
// ini_set('error_reporting', E_ALL);
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);

header("Content-Type: application/json; charset=UTF-8");


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  require_once __DIR__ . '/../../db/DatabaseClass.php';
  require_once __DIR__ . '/../back/class/ContactClass.php';
  $database = new Database();
  $db = $database->getConnection();
  $contact_data = new ContactClass($db);
  $stmt_config_mail = $contact_data->get_mail_data();
  $mail_config = $stmt_config_mail->fetchAll(PDO::FETCH_ASSOC);
  $mail_config = $mail_config[0];
  if (

    empty($mail_config['sv']) &&
    isset($mail_config['config_mail_from']) && !empty($mail_config['config_mail_from']) &&
    isset($mail_config['config_mail_to']) && !empty($mail_config['config_mail_to']) &&
    isset($mail_config['config_smtp_host']) && !empty($mail_config['config_smtp_host']) &&
    isset($mail_config['config_smtp_login']) && !empty($mail_config['config_smtp_login']) &&
    isset($mail_config['config_smtp_pass']) && !empty($mail_config['config_smtp_pass']) &&
    isset($mail_config['config_smtp_port']) && !empty($mail_config['config_smtp_port'])

  ) {
    require_once __DIR__ . '/../back/class/phpmailer/PHPMailer.php';
    require_once __DIR__ . '/../back/class/phpmailer/SMTP.php';
    require_once __DIR__ . '/../back/class/phpmailer/Exception.php';
    require_once __DIR__ . '/../../functions/valid_submit_form.php';


    $stmt_required_fields = $contact_data->get_required_fields();
    $required_fields = $stmt_required_fields->fetchAll(PDO::FETCH_ASSOC);
    $required_fields = $required_fields[0];

    $is_submit_form = valid_submit_form($_POST, $required_fields);
    if ($is_submit_form !== true) {
      echo json_encode($is_submit_form);
      die();
    }

    $title = "Заказ с сайта";
    $body = "";

    $bodyHeader = '<table border="0" cellpadding="0" cellspacing="0" style="border-top: 0px; border-left:0px; border-bottom:1px; border-right:1px; border-color:#e2e2e2; border-style: solid; width:800px" width="800" align="center">';
    $body .= $bodyHeader;

    if (isset($_POST['user_name']) && !empty($_POST['user_name'])) {
      $body .= '<tr><td colspan="2" style="padding-top:15px; padding-bottom:15px; padding-right:15px; padding-left:15px; text-align:left; border-top:1px; border-left:1px; border-right:0; border-bottom:0; border-color:#e2e2e2; border-style: solid;" >';
      $body .= '<b>Имя: </b></td>';
      $body .= '<td colspan="2" style="padding-top:15px; padding-bottom:15px; padding-right:15px; padding-left:15px; text-align:left; border-top:1px; border-left:1px; border-right:0; border-bottom:0; border-color:#e2e2e2; border-style: solid;" >';
      $body .= strip_tags($_POST['user_name']);
      $body .= '</td></tr>';
    }

    if (isset($_POST['user_tel']) && !empty($_POST['user_tel'])) {
      $body .= '<tr><td colspan="2" style="padding-top:15px; padding-bottom:15px; padding-right:15px; padding-left:15px; text-align:left; border-top:1px; border-left:1px; border-right:0; border-bottom:0; border-color:#e2e2e2; border-style: solid;" >';
      $body .= '<b>Телефон: </b></td>';
      $body .= '<td colspan="2" style="padding-top:15px; padding-bottom:15px; padding-right:15px; padding-left:15px; text-align:left; border-top:1px; border-left:1px; border-right:0; border-bottom:0; border-color:#e2e2e2; border-style: solid;" >';
      $body .=  strip_tags($_POST['user_tel']);
      $body .= '</td></tr>';
    }

    if (isset($_POST['user_mail']) && !empty($_POST['user_mail'])) {
      $body .= '<tr><td colspan="2" style="padding-top:15px; padding-bottom:15px; padding-right:15px; padding-left:15px; text-align:left; border-top:1px; border-left:1px; border-right:0; border-bottom:0; border-color:#e2e2e2; border-style: solid;" >';
      $body .= '<b>E-mail: </b></td>';
      $body .= '<td colspan="2" style="padding-top:15px; padding-bottom:15px; padding-right:15px; padding-left:15px; text-align:left; border-top:1px; border-left:1px; border-right:0; border-bottom:0; border-color:#e2e2e2; border-style: solid;" >';
      $body .= strip_tags($_POST['user_mail']);
      $body .= '</td></tr>';
    }

    if (isset($_POST['user_city']) && !empty($_POST['user_city'])) {
      $body .= '<tr><td colspan="2" style="padding-top:15px; padding-bottom:15px; padding-right:15px; padding-left:15px; text-align:left; border-top:1px; border-left:1px; border-right:0; border-bottom:0; border-color:#e2e2e2; border-style: solid;" >';
      $body .= '<b>Город: </b></td>';
      $body .= '<td colspan="2" style="padding-top:15px; padding-bottom:15px; padding-right:15px; padding-left:15px; text-align:left; border-top:1px; border-left:1px; border-right:0; border-bottom:0; border-color:#e2e2e2; border-style: solid;" >';
      $body .=  strip_tags($_POST['user_city']);
      $body .= '</td></tr>';
    }

    if (isset($_POST['user_street']) && !empty($_POST['user_street'])) {
      $body .= '<tr><td colspan="2" style="padding-top:15px; padding-bottom:15px; padding-right:15px; padding-left:15px; text-align:left; border-top:1px; border-left:1px; border-right:0; border-bottom:0; border-color:#e2e2e2; border-style: solid;" >';
      $body .= '<b>Улица: </b></td>';
      $body .= '<td colspan="2" style="padding-top:15px; padding-bottom:15px; padding-right:15px; padding-left:15px; text-align:left; border-top:1px; border-left:1px; border-right:0; border-bottom:0; border-color:#e2e2e2; border-style: solid;" >';
      $body .=  strip_tags($_POST['user_street']);
      $body .= '</td></tr>';
    }

    if (isset($_POST['user_house_number']) && !empty($_POST['user_house_number'])) {
      $body .= '<tr><td colspan="2" style="padding-top:15px; padding-bottom:15px; padding-right:15px; padding-left:15px; text-align:left; border-top:1px; border-left:1px; border-right:0; border-bottom:0; border-color:#e2e2e2; border-style: solid;" >';
      $body .= '<b>Номер дома: </b></td>';
      $body .= '<td colspan="2" style="padding-top:15px; padding-bottom:15px; padding-right:15px; padding-left:15px; text-align:left; border-top:1px; border-left:1px; border-right:0; border-bottom:0; border-color:#e2e2e2; border-style: solid;" >';
      $body .=  strip_tags($_POST['user_house_number']);
      $body .= '</td></tr>';
    }

    if (isset($_POST['user_apartment_number']) && !empty($_POST['user_apartment_number'])) {
      $body .= '<tr><td colspan="2" style="padding-top:15px; padding-bottom:15px; padding-right:15px; padding-left:15px; text-align:left; border-top:1px; border-left:1px; border-right:0; border-bottom:0; border-color:#e2e2e2; border-style: solid;" >';
      $body .= '<b>Номер квартиры: </b></td>';
      $body .= '<td colspan="2" style="padding-top:15px; padding-bottom:15px; padding-right:15px; padding-left:15px; text-align:left; border-top:1px; border-left:1px; border-right:0; border-bottom:0; border-color:#e2e2e2; border-style: solid;" >';
      $body .=  strip_tags($_POST['user_apartment_number']);
      $body .= '</td></tr>';
    }

    if (isset($_POST['user_postindex']) && !empty($_POST['user_postindex'])) {
      $body .= '<tr><td colspan="2" style="padding-top:15px; padding-bottom:15px; padding-right:15px; padding-left:15px; text-align:left; border-top:1px; border-left:1px; border-right:0; border-bottom:0; border-color:#e2e2e2; border-style: solid;" >';
      $body .= '<b>Почтовый индекс: </b></td>';
      $body .= '<td colspan="2" style="padding-top:15px; padding-bottom:15px; padding-right:15px; padding-left:15px; text-align:left; border-top:1px; border-left:1px; border-right:0; border-bottom:0; border-color:#e2e2e2; border-style: solid;" >';
      $body .=  strip_tags($_POST['user_postindex']);
      $body .= '</td></tr>';
    }

    if (isset($_POST['user_comment']) && !empty($_POST['user_comment'])) {
      $body .= '<tr><td colspan="2" style="padding-top:15px; padding-bottom:15px; padding-right:15px; padding-left:15px; text-align:left; border-top:1px; border-left:1px; border-right:0; border-bottom:0; border-color:#e2e2e2; border-style: solid;" >';
      $body .= '<b>Комментарий:  </b></td>';
      $body .= '<td colspan="2" style="padding-top:15px; padding-bottom:15px; padding-right:15px; padding-left:15px; text-align:left; border-top:1px; border-left:1px; border-right:0; border-bottom:0; border-color:#e2e2e2; border-style: solid;" >';
      $body .=  strip_tags($_POST['user_comment']);
      $body .= '</td></tr>';
    }

    if (isset($_POST['total_price']) && !empty($_POST['total_price'])) {
      $body .= '<tr><td colspan="2" style="padding-top:15px; padding-bottom:15px; padding-right:15px; padding-left:15px; text-align:left; border-top:1px; border-left:1px; border-right:0; border-bottom:0; border-color:#e2e2e2; border-style: solid;" >';
      $body .= '<b>Общая стоимость: </b></td>';
      $body .= '<td colspan="2" style="padding-top:15px; padding-bottom:15px; padding-right:15px; padding-left:15px; text-align:left; border-top:1px; border-left:1px; border-right:0; border-bottom:0; border-color:#e2e2e2; border-style: solid;" >';
      $body .=  strip_tags($_POST['total_price']);
      $body .= '</td></tr>';
    }

    $body .= '<tr><td colspan="4" style="padding-top:15px; padding-bottom:15px; padding-right:15px; padding-left:15px; background:#eee; border-top:1px; border-left:1px; border-right:0; border-bottom:0; border-color:#e2e2e2; border-style: solid;"></td></tr>';


    foreach ($_POST['order'] as $k) {
      $body .= '<tr>';
      foreach ($k as $key => $value) {

        if ($key == 'img') {
          $product_img = '<img src="' . $value . '" width="100" height="100" alt="картинка товара">';
          $body .= '<td style="width: 100px; padding-top:15px; padding-bottom:15px; padding-right:15px; padding-left:15px; text-align:center; border-top:1px; border-left:1px; border-right:0; border-bottom:0; border-color:#e2e2e2; border-style: solid;" >';
          $body .= $product_img;
          $body .= '</td>';
        }

        if ($key == 'name') {
          $body .=
            '<td style="width: 300px;  padding-top:15px; padding-bottom:15px; padding-right:15px; padding-left:15px; text-align:center; border-top:1px; border-left:1px; border-right:0; border-bottom:0; border-color:#e2e2e2; border-style: solid;" >
											<div style="padding: 5px;">';

          $body .= $value;
          if (!empty($k['vendor_code'])) {
            $body .= '(артикул: ' . $k['vendor_code'] . ')';
          }

          $body .= '</div></td>';
        }

        if ($key == 'quantity') {
          $product_quantity = $value ? $value : 1;
          $body .=
            '<td style="width: 100px;  padding-top:15px; padding-bottom:15px; padding-right:15px; padding-left:15px; text-align:center; border-top:1px; border-left:1px; border-right:0; border-bottom:0; border-color:#e2e2e2; border-style: solid;" >
												<div style="padding: 5px;"> Кол-во: 
												'
            . $product_quantity .
            '</div></td>';
        }

        if ($key == 'price') {
          $body .=
            '<td style="width: 100px;  padding-top:15px; padding-bottom:15px; padding-right:15px; padding-left:15px; text-align:center; border-top:1px; border-left:1px; border-right:0; border-bottom:0; border-color:#e2e2e2; border-style: solid;" >
												<div style="padding: 5px;"> Цена: 
												'
            . $value .
            '</div></td>';
        }
      }
      $body .= '</tr>';
    }

    $bodybottom = '</table>';
    $body .= $bodybottom;



    // Настройки PHPMailer
    $mail = new PHPMailer\PHPMailer\PHPMailer();
    try {
      $mail->isSMTP();
      $mail->CharSet = "UTF-8";
      $mail->SMTPAuth   = true;
      //$mail->SMTPDebug = 2;
      $mail->Debugoutput = function ($str, $level) {
        $GLOBALS['status'][] = $str;
      };

      // Настройки вашей почты
      // $mail->Host       = 'smtp.mail.ru'; // SMTP сервера вашей почты
      // $mail->Username   = 'dima.d.v@list.ru'; // Логин на почте
      // $mail->Password   = '85cfA889S16kGS2QemJUd'; // Пароль на почте
      // $mail->SMTPSecure = 'ssl';
      // $mail->Port       = 465;      

      $mail->Host       = $mail_config['config_smtp_host']; // SMTP сервера вашей почты
      $mail->Username   = $mail_config['config_smtp_login']; // Логин на почте
      $mail->Password   = $mail_config['config_smtp_pass']; // Пароль на почте
      $mail->SMTPSecure = 'ssl';
      $mail->Port       = $mail_config['config_smtp_port'];
      $mail->setFrom($mail_config['config_smtp_login'], 'Корзина SmartBasket'); // Адрес самой почты и имя отправителя

      // Получатель письма
      $mail->addAddress($mail_config['config_mail_to']);
      // $mail->addAddress('youremail@gmail.com'); // Ещё один, если нужен

      // Прикрипление файлов к письму
      if (!empty($file['name'][0])) {
        for ($ct = 0; $ct < count($file['tmp_name']); $ct++) {
          $uploadfile = tempnam(sys_get_temp_dir(), sha1($file['name'][$ct]));
          $filename = $file['name'][$ct];
          if (move_uploaded_file($file['tmp_name'][$ct], $uploadfile)) {
            $mail->addAttachment($uploadfile, $filename);
            $rfile[] = "Файл $filename прикреплён";
          } else {
            $rfile[] = "Не удалось прикрепить файл $filename";
          }
        }
      }
      // Отправка сообщения
      $mail->isHTML(true);
      $mail->Subject = $title;
      $mail->Body = $body;

      // Проверяем отравленность сообщения
      if ($mail->send()) {
        // echo json_encode("success");
        echo json_encode("success");
      } else {
        echo json_encode("error");
      }
    } catch (Exception $e) {
      $result = "error";
      echo json_encode("Сообщение не было отправлено. Причина ошибки: {$mail->ErrorInfo}");
    }
  } else {
    echo json_encode('NOTCONFIGSENDMAIL');
  };
} else {
  header('Location: /');
}
