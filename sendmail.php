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
  $body = '<h1>Встречайте супер-письмо</h1>';

  if(trim(!empty($_POST['name']))){
    $body.='<p><strong>Имя:</strong> '.$_POST['name'].'</p>';
  }
