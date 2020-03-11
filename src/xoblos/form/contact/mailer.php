<?php
require 'vendor/autoload.php';
Dotenv::load(__DIR__);

$sendgrid_password = $_ENV['SENDGRID_PASSWORD'];
$sendgrid_username = $_ENV['SENDGRID_USERNAME'];
$from              = $_ENV['FROM'];
$to                = $_ENV['TO'];



//お客様情報
$company = $_POST['company'];//会社名
$name = $_POST['name'];//ご担当者名
$emailAdress = $_POST['emailAdress'];//メールアドレス
$phone = $_POST['phone'];//電話番号
$message = $_POST['message'];//詳しく聞きたいこと
$check = $_POST['check'];// 個人情報の取扱



$sendgrid = new SendGrid($sendgrid_username,$sendgrid_password, array("turn_off_ssl_verification" => true));
$email    = new SendGrid\Email();
$email->addTo($to)->
       setFrom($from)->
       setFromName("WinActor資料DL")->
       setSubject("【WinActor資料DL】" )->
       setText("会社名: $company \r\n ご担当者名: $name \r\n　メールアドレス: $emailAdress  \r\n電話番号: $phone　\r\n　詳しく聞きたいこと: $message\r\n 個人情報の取扱: $check")->


       setHtml("<strong>会社名:</strong> $company<br /> <strong>ご担当者名:</strong> $name<br /> <strong>メールアドレス:</strong> $emailAdress<br /> <strong>電話番号:</strong> $phone<br /> <strong>詳しく聞きたいこと:</strong> $message<br /> <strong>個人情報の取扱:</strong> $check<br />")->
       addCategory('contact');

$response = $sendgrid->send($email);
var_dump($response);

// 正常終了時にthanks.htmlへリダイレクト
header('Location: thanks.html');
exit();