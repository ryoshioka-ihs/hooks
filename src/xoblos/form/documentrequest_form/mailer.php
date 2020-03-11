<?php
require 'vendor/autoload.php';
Dotenv::load(__DIR__);

$sendgrid_password = $_ENV['SENDGRID_PASSWORD'];
$sendgrid_username = $_ENV['SENDGRID_USERNAME'];
$from              = $_ENV['FROM'];
$to                = $_ENV['TO'];



//お客様情報
$company = $_POST['company'];//会社名
$despartment = $_POST['despartment'];//部署名
$position = $_POST['position'];//お役職
$name1 = $_POST['name1'];//姓
$name2 = $_POST['name2'];//名
$emailAdress = $_POST['emailAdress'];//メールアドレス
$phone1 = $_POST['phone1'];//電話番号1
$phone2 = $_POST['phone2'];//電話番号2
$phone3 = $_POST['phone3'];//電話番号3
$check = $_POST['check'];// 個人情報の取扱


//管理者へ送信メール
$sendgrid = new SendGrid($sendgrid_username,$sendgrid_password, array("turn_off_ssl_verification" => true));
$email    = new SendGrid\Email();
$email->addTo($to)->
       setFrom($from)->
       //setFromName("IHSWinActor")->
       setSubject("【WinActor資料がダウンロードされました】" )->
       setText("営業各位\r\n\r\nWinActorオファーページの資料がダウンロードされました。\r\n必要に応じてアクションをお願いいたします。\r\n\r\n会社名: $company \r\n 部署名: $despartment \r\n お役職: $position \r\nご担当者名: $name1 $name2 様\r\n 　メールアドレス: $emailAdress \r\n電話番号: $phone1-$phone2-$phone3 \r\n 個人情報の取扱: $check")->


       setHtml("営業各位<br><br>WinActorオファーページの資料がダウンロードされました。<br />必要に応じてアクションをお願いいたします。<br /><br /><strong>会社名:</strong> $company <br /> <strong>部署名:</strong> $despartment <br /> <strong>お役職:</strong> $position <br /> <strong>ご担当者名:</strong> $name1 $name2 様<br /> <strong>メールアドレス:</strong> $emailAdress <br /> <strong>電話番号:</strong> $phone1-$phone2-$phone3 <br /> <strong>個人情報の取扱:</strong> $check <br />")->
       addCategory('contact');

$response = $sendgrid->send($email);
var_dump($response);


// 正常終了時にthanks.htmlへリダイレクト
header('Location: https://www.iimhs.co.jp/winactor/form/documentrequest_form/thanks.html');
exit();