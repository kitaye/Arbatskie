<?php
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;

  require 'phpmailer/src/Exception.php';
  require 'phpmailer/src/PHPMailer.php';

  $mail = new PHPMailer(true);
  $mail->Charset = 'UTF-8';
  $mail->setLanguage('ru', 'phpmailer/language');
  $mail->IsHTML(true);

  //От кого письмо
  $mail->setFrom('n.s.sadovnikov@gmail.com', 'Фрилансер по жизни');
  //Кому отправить
  $mail->addAddress('n.s.sadovnikov@yandex.ru');
  //Тема письма
  $mail->Subject = 'PHPMailer test';

  //Опыт
  $hand = 'Правая';
  if($_POST['hand'] == 'left'){
    $hand = 'Левая';
  }

  //Тело письма      
  $body = '<h1>Анкета кандидата</h1>';

  if(trim(!empty($_POST['name']))){
    $body.='<p><strong>Имя:</strong> '.$_POST['name'].'</p>';
  }
  if(trim(!empty($_POST('email'))){
    $body.='<p><strong>E-mail:</strong> '.$_POST['email'].'</p>';
  }
  if(trim(!empty($_POST('birth'))){
    $body.='<p><strong>Дата рождения:</strong> '.$_POST['birth'].'</p>';
  }
  if(trim(!empty($_POST('phone'))){
    $body.='<p><strong>Номер телефона:</strong> '.$_POST['phone'].'</p>';
  }
  if(trim(!empty($_POST('city'))){
    $body.='<p><strong>Город проживания:</strong> '.$_POST['city'].'</p>';
  }
  if(trim(!empty($_POST('jobExp'))){
    $body.='<p><strong>Опыт работы:</strong> '.$hand.'</p>';
  }
  if(trim(!empty($_POST('schedule'))){
    $body.='<p><strong>Пожелания к расписанию:</strong> '.$hand.'</p>';
  }
  if(trim(!empty($_POST('message'))){
    $body.='<p><strong>Сообщение:</strong> '.$_POST['message'].'</p>';
  }


// Прикрепить файлы
  if (!empty($_FILES['image']['tmp_name'])) {
    // Путь загрузки файла
    $filePath = __DIR__ . "/files/" . $_FILES['images']['name'];
    // Грузим файл
    if (copy($_FILES['image']['tmp_name'], $filePath)){
      $fileAttach = $filePath;
      $body.='<p><strong>Фото в приложении</strong>';
      $mail->addAttachment($fileAttach);
    }
  }

  $mail->Body = $body;

// Отправляем
    if (!$mail->send()) {
      $message = 'Ошибка';
    } else {
      $message = 'Данные отправлены!';
    }

    $response = ['message' => $message];

    header('Content-type: application/json');
    echo json_encode($response);
?>
