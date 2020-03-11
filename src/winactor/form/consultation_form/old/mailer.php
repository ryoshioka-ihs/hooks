<?php
require 'vendor/autoload.php';
Dotenv::load(__DIR__);

$sendgrid_password = $_ENV['SENDGRID_PASSWORD'];
$sendgrid_username = $_ENV['SENDGRID_USERNAME'];
$from              = $_ENV['FROM'];
$to                = $_ENV['TO'];



//お客様情報
$company = $_POST['company'];//会社名
$department = $_POST['department'];//部署名
$position = $_POST['position'];//お役職
$name1 = $_POST['name1'];//姓
$name2 = $_POST['name2'];//名
$emailAdress = $_POST['emailAdress'];//メールアドレス
$phone1 = $_POST['phone1'];//電話番号1
$phone2 = $_POST['phone2'];//電話番号2
$phone3 = $_POST['phone3'];//電話番号3
$enquete = $_POST['enquete'];//お問い合わせのきっかけ
$category =$_POST['category'];//ご相談カテゴリー
$message = $_POST['message'];//詳しく聞きたいこと
$check = $_POST['check'];// 個人情報の取扱





//ユーザーへ送信するメール
$sendgrid = new SendGrid($sendgrid_username,$sendgrid_password, array("turn_off_ssl_verification" => true));
$email    = new SendGrid\Email();
$email->addTo($emailAdress)->
       setFrom($from)->
       setFromName("IIMヒューマン・ソリューション株式会社")->
       setSubject("【WinActor総合お問合わせ】お問合わせを受け付けました" )->
       setText("$company \r\n$name1 $name2 様\r\n\r\nこの度はWinActorに関するお問合わせをいただきまして、誠にありがとうございます。\r\n下記内容にてお問合わせを受け付けました。\r\n内容を確認し次第、担当より折り返しご連絡させていただきます。\r\n\r\n　会社名: $company \r\n 部署名: $department \r\n お役職: $position \r\n ご担当者名: $name1 $name2 様 \r\n　メールアドレス: $emailAdress \r\n電話番号: $phone1-$phone2-$phone3 \r\n ご相談カテゴリー: $category \r\n　詳しく聞きたいこと: $message\r\n 個人情報の取扱: $check")->


       setHtml("$company <br>$name1 $name2 様<br><br>この度はWinActorに関するお問合わせをいただきまして、誠にありがとうございます。<br>下記内容にてお問合わせを受け付けました。<br>内容を確認し次第、担当より折り返しご連絡させていただきます。<br><br><strong>会社名:</strong> $company<br /> <strong>部署名:</strong> $department<br /> <strong>お役職:</strong> $position<br /> <strong>ご担当者名:</strong> $name1 $name2 様<br /> <strong>メールアドレス:</strong> $emailAdress<br /> <strong>電話番号:</strong> $phone1-$phone2-$phone3<br /> <strong>ご相談カテゴリー:</strong> $category <br /> <strong>詳しく聞きたいこと:</strong> $message<br /> <strong>個人情報の取扱:</strong> $check<br />")->
       addCategory('contact');

$response = $sendgrid->send($email);
var_dump($response);

//管理者へ送信するメール
$sendgrid = new SendGrid($sendgrid_username,$sendgrid_password, array("turn_off_ssl_verification" => true));
$email    = new SendGrid\Email();
$email->addTo($to)->
       setFrom($from)->
       //setFromName("WinActor資料DL")->
       setSubject("【WinActor総合お問合わせ】お問合わせを受け付けました。" )->
       setText("下記の通りお問合わせを受け付けました。\r\n担当者は対応のほどよろしくお願いいたします。\r\n\r\n会社名: $company \r\n 部署名: $department \r\n お役職: $position \r\n ご担当者名: $name1 $name2 様 \r\n　メールアドレス: $emailAdress \r\n電話番号: $phone1-$phone2-$phone3 \r\n ご相談カテゴリー: $category \r\n　詳しく聞きたいこと: $message\r\n お問い合わせのきっかけ: $enquete \r\n個人情報の取扱: $check")->


       setHtml("WinActor総合お問合わせフォームより下記のお問合わせを受け付けました<br>ご担当者は対応のほどよろしくお願いいたします。<br><br>会社名:</strong> $company<br /> <strong>部署名:</strong> $department<br /> <strong>お役職:</strong> $position<br /> <strong>ご担当者名:</strong> $name1 $name2 様<br /> <strong>メールアドレス:</strong> $emailAdress<br /> <strong>電話番号:</strong> $phone1-$phone2-$phone3<br /> <strong>ご相談カテゴリー:</strong> $category <br /> <strong>詳しく聞きたいこと:</strong> $message<br /> <strong>お問い合わせのきっかけ:</strong> $enquete<br /><strong>個人情報の取扱:</strong> $check<br />")->
       addCategory('contact');

$response = $sendgrid->send($email);
var_dump($response);

// 正常終了時にthanks.htmlへリダイレクト
header('Location: https://www.iimhs.co.jp/winactor/form/consultation_form/thanks.html');
exit();