<?php
require 'vendor/autoload.php';
Dotenv::load(__DIR__);

$sendgrid_password = $_ENV['SENDGRID_PASSWORD'];
$sendgrid_username = $_ENV['SENDGRID_USERNAME'];
$from              = $_ENV['FROM'];
$to                = $_ENV['TO'];



//お客様情報
$company = $_POST['company'];//会社名
$lastname = $_POST['lastname'];//姓
$firstname = $_POST['firstname'];//名
//$despartment = $_POST['despartment'];//部署名
//$position = $_POST['position'];//お役職
$emailAdress = $_POST['emailAdress'];//メールアドレス
$phone = $_POST['phone'];//電話番号1
$seminar =$_POST['seminar'];//セミナー
$message = $_POST['message'];//特記事項
$check = $_POST['check'];// 個人情報の取扱




//ユーザーへ送信するメール
$sendgrid = new SendGrid($sendgrid_username,$sendgrid_password, array("turn_off_ssl_verification" => true));
$email    = new SendGrid\Email();
$email->addTo($emailAdress)->
       setFrom($from)->
       setFromName("IIMヒューマン・ソリューション株式会社")->
       setSubject("【xoBlos製品概要セミナーのキャンセルを承りました】" )->
       setText("$company \r\n$lastname $firstname 様\r\n\r\nご連絡いただきまして、ありがとうございます。\r\n下記内容でお申し込みのキャンセルを承りました。\r\n\r\n　会社名: $company \r\n ご希望の開催日: $seminar \r\n メールアドレス: $emailAdress \r\n　電話番号: $phone \r\n　特記事項: $message \r\n　個人情報の取扱: $check \r\n\r\n　別日程でのご参加をご希望の方は、\r\n https://www.iimhs.co.jp/xoblos/form/seminar_form/ よりお申し込みください。\r\n\r\n")->


       setHtml("$company <br> $lastname $firstname 様<br><br>ご連絡いただきまして、ありがとうございます。<br>下記内容でお申し込みのキャンセルを承りました。<br><br>会社名: $company <br />ご希望の開催日： $seminar <br />メールアドレス: $emailAdress <br />電話番号: $phone <br />特記事項: $message <br />個人情報の取扱: $check <br /><br>別日程でのご参加をご希望の方は<br> https://www.iimhs.co.jp/xoblos/form/seminar_form/ よりお申し込みください。<br><br>")->
       addCategory('contact');

$response = $sendgrid->send($email);
var_dump($response);

//管理者へ送信するメール
$sendgrid = new SendGrid($sendgrid_username,$sendgrid_password, array("turn_off_ssl_verification" => true));
$email    = new SendGrid\Email();
$email->addTo($to)->
       setFrom($from)->
       //setFromName("")->
       setSubject("【xoBlos製品概要セミナーのキャンセルを承りました】" )->
       setText("下記内容にてセミナーのキャンセルを承りました。\r\nご担当者はご対応のほどよろしくお願いいたします。\r\n\r\n会社名: $company \r\n ご希望の開催日: $seminar\r\n 参加者名: $lastname $firstname 様\r\n メールアドレス: $emailAdress\r\n　電話番号: $phone \r\n　特記事項: $message\r\n　個人情報の取扱: $check")->


       setHtml("下記内容にてセミナーのキャンセルを承りました。<br>ご担当者はご対応のほどよろしくお願いいたします。<br><br>会社名: $company <br /> ご希望の開催日: $seminar <br /> 参加者名: $lastname $firstname 様<br /> メールアドレス: $emailAdress <br /> 電話番号: $phone <br /> 特記事項: $message <br /> 個人情報の取扱: $check <br />")->
       addCategory('contact');

$response = $sendgrid->send($email);
var_dump($response);

 //正常終了時にthanks.htmlへリダイレクト
header('Location: /xoblos/form/cancel_seminar_form/thanks.html');
exit();

