<?php
require 'vendor/autoload.php';
Dotenv::load(__DIR__);

$sendgrid_password = $_ENV['SENDGRID_PASSWORD'];
$sendgrid_username = $_ENV['SENDGRID_USERNAME'];
$from              = $_ENV['FROM'];
$to                = $_ENV['TO'];



//お客様情報
$company = $_POST['company'];//貴社名
$department = $_POST['department'];//部署名
$name = $_POST['name'];//お名前
$emailAdd = $_POST['emailAdd'];//メールアドレス
$phone = $_POST['phone'];//電話番号
$category = $_POST['category'];//お問い合わせのカテゴリー
$message = $_POST['message'];//お問い合わせ内容
$enquete = $_POST['enquete'];// 何をみてお問い合わせいただきましたか？
$check = $_POST['check'];// 個人情報の取扱





//ユーザーへ送信するメール
$sendgrid = new SendGrid($sendgrid_username,$sendgrid_password, array("turn_off_ssl_verification" => true));
$email    = new SendGrid\Email();
$email->addTo($emailAdd)->
       setFrom($from)->
       setFromName("IIMヒューマン・ソリューション株式会社")->
       setSubject("【IHS】お問合わせいただきありがとうございます。" )->
       setText(" $name 様\r\n\r\nこの度は、お問合せくださり、誠にありがとうございます。\r\n下記の内容で、受付けました。\r\n内容を確認し、営業より折り返しご連絡いたしますので、\r\n今しばらくお待ちください。\r\n\r\n　貴社名: $company \r\n 部署名: $department \r\n お名前: $name \r\n メールアドレス: $emailAdd \r\n 電話番号: $phone \r\n お問い合わせのカテゴリー: $category \r\n お問合わせ内容: $message \r\n\r\n ※このメールは自動送信です。\r\n 何かございましたらweb@iimhs.co.jpまでお問い合わせください。")->


       setHtml(" $name 様<br /><br />この度は、お問合せくださり、誠にありがとうございます。<br />下記の内容で、受付けました。<br />内容を確認し、営業より折り返しご連絡いたしますので、<br />今しばらくお待ちください。<br /><br />貴社名: $company <br /> 部署名: $department <br /> お名前: $name <br /> メールアドレス: $emailAdd <br /> 電話番号: $phone <br /> お問い合わせのカテゴリー: $category <br /> お問合わせ内容: $message <br /><br /> ※このメールは自動送信です。<br /> 何かございましたらweb@iimhs.co.jpまでお問い合わせください。")->
       addCategory('contact');

$response = $sendgrid->send($email);
var_dump($response);


//管理者へ送信するメール
$sendgrid = new SendGrid($sendgrid_username,$sendgrid_password, array("turn_off_ssl_verification" => true));
$email    = new SendGrid\Email();
$email->addTo($to)->
       setFrom($from)->
       setFromName("IIMヒューマン・ソリューション株式会社")->
       setSubject("【WEB問い合わせ】IHSコーポレートサイト" )->
       setText("総合お問合わせを受信しました。\r\nご確認の上、ご対応をお願いいたします。\r\n\r\n 会社名: $company \r\n お名前: $name \r\n 部署名: $department \r\n メールアドレス: $emailAdd \r\n 電話番号: $phone \r\n 何をみてお問い合わせいただきましたか？: $message \r\n　お問い合わせのカテゴリー: $category \r\n お問合わせ内容: $message \r\n ")->


       setHtml("総合お問合わせを受信しました。<br />ご確認の上、ご対応をお願いいたします。<br /><br />会社名: $company <br /> お名前: $name <br />  部署名: $department <br /> メールアドレス: $emailAdd <br /> 電話番号: $phone <br /> 何をみてお問い合わせいただきましたか？: $enquete <br />　お問い合わせのカテゴリー: $category <br /> お問合わせ内容: $message <br />")->
       addCategory('contact');

$response = $sendgrid->send($email);
var_dump($response);

// 正常終了時にthanks.htmlへリダイレクト
header('Location: /contact/contact/thanks.html');
exit();

