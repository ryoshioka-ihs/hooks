<?php
require 'vendor/autoload.php';
Dotenv::load(__DIR__);

$sendgrid_password = $_ENV['SENDGRID_PASSWORD'];
$sendgrid_username = $_ENV['SENDGRID_USERNAME'];
$from              = $_ENV['FROM'];
$to                = $_ENV['TO'];



//お客様情報
$status = $_POST['status'];//
$id = $_POST['id'];//WinActorの保守契約ID
$company = $_POST['company'];//会社名
$despartment = $_POST['despartment'];//部署名
$lastname1 = $_POST['lastname1'];//姓(契約者)
$firstname1 = $_POST['firstname1'];//名(契約者)
$lastname2 = $_POST['lastname2'];//姓(担当者)
$firstname2 = $_POST['firstname2'];//名(担当者)
$phone = $_POST['phone'];//電話番号
$emailAdress = $_POST['emailAdress'];//メールアドレス
$version = $_POST['version'];//ご利用中のバージョン
$category = $_POST['category'];//お問い合わせ分類
$title =$_POST['title'];//お問い合わせ概要（タイトル）
$message = $_POST['message'];//お問い合わせ内容詳細
$check = $_POST['check'];// 個人情報の取扱



//ユーザーへ送信するメール
$sendgrid = new SendGrid($sendgrid_username,$sendgrid_password, array("turn_off_ssl_verification" => true));
$email    = new SendGrid\Email();
$email->addTo($emailAdress)->
       setFrom($from)->
       setFromName("IIMヒューマン・ソリューション株式会社")->
       setSubject("【お問い合わせを受け付けました】$title" )->
       setText(
       	"$company \r\n
       	 $lastname2 $firstname2 様\r\n\r\n

               下記お問い合わせを受け付けました。\r\n
               2営業日以内に一次回答をいたします。\r\n\r\n

               $status\r\n
               保守契約ID：$id\r\n
               会社名：$company\r\n
               ご契約者様部署名：$despartment\r\n
               ご契約者様名：$lastname1 $firstname1 様\r\n
               電話番号: $phone\r\n
               メールアドレス: $emailAdress\r\n
               ご利用中の製品バージョン: $version\r\n
               お問い合わせ分類： $category\r\n
               お問い合わせ内容詳細: $message\r\n")->


       setHtml("
               $company <br>
               $lastname2 $firstname2 様<br><br>

               下記お問い合わせを受け付けました。<br>
               2営業日以内に一次回答をいたします。<br><br>

               $status<br>
               保守契約ID：$id<br>
               会社名：$company<br>
               ご契約者様部署名：$despartment<br>
               ご契約者様名：$lastname1 $firstname1 様<br>
               電話番号: $phone<br>
               メールアドレス: $emailAdress<br>
               ご利用中の製品バージョン: $version<br>
               お問い合わせ分類： $category<br>
               お問い合わせ内容詳細: $message<br>")->
       addCategory('contact');

$response = $sendgrid->send($email);
var_dump($response);

//管理者へ送信するメール
$sendgrid = new SendGrid($sendgrid_username,$sendgrid_password, array("turn_off_ssl_verification" => true));
$email    = new SendGrid\Email();
$email->addTo($to)->
       setFrom($from)->
       //setFromName("")->
       setSubject("【お問い合わせを受け付けました】$title" )->
       setText(
              "WinActorサポートチーム担当者\r\n\r\n
              

               下記お問い合わせを受け付けました。\r\n
               2営業日以内に一次回答のご対応をお願いいたします。\r\n\r\n

               $status\r\n
               保守契約ID：$id\r\n
               会社名：$company\r\n
               ご契約者様部署名：$despartment\r\n
               ご契約者様名：$lastname1 $firstname1 様\r\n
               ご担当者様名：$lastname2 $firstname2 様\r\n
               電話番号: $phone\r\n
               メールアドレス: $emailAdress\r\n
               ご利用中の製品バージョン: $version\r\n
               お問い合わせ分類： $category\r\n
               お問い合わせ内容詳細: $message\r\n
               ")->


       setHtml("
               WinActorサポートチーム担当者<br><br>
              

               下記お問い合わせを受け付けました。<br>
               2営業日以内に一次回答のご対応をお願いいたします。<br><br>

               $status<br>
               保守契約ID：$id<br>
               会社名：$company<br>
               ご契約者様部署名：$despartment<br>
               ご契約者様名：$lastname1 $firstname1 様<br>
               ご担当者様名：$lastname2 $firstname2 様<br>
               電話番号: $phone<br>
               メールアドレス: $emailAdress<br>
               ご利用中の製品バージョン: $version<br>
               お問い合わせ分類： $category<br>
               お問い合わせ内容詳細: $message<br>
               ")->
       addCategory('contact');

$response = $sendgrid->send($email);
var_dump($response);

 //正常終了時にthanks.htmlへリダイレクト
header('Location: /winactor/form/support_form/thanks.html');
exit();


