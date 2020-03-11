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
$title = $_POST['title'];//役職
$name = $_POST['name'];//お名前
$emailAdd = $_POST['emailAdd'];//メールアドレス
$check = $_POST['check'];// 個人情報の取扱





//ユーザーへ送信するメール
$sendgrid = new SendGrid($sendgrid_username,$sendgrid_password, array("turn_off_ssl_verification" => true));
$email    = new SendGrid\Email();
$email->addTo($emailAdd)->
       setFrom($from)->
       setFromName("IIMヒューマン・ソリューション株式会社")->
       setSubject("【IHS】ご登録ありがとうございます" )->
       setText(" $name 様\r\n\r\nこの度は、弊社メールマガジン「IHSお役立ちメール」へご登録くださり\r\n誠にありがとうございます。\r\n登録解除をご希望の際は、web@iimhs.co.jp までご連絡頂けますよう\r\nよろしくお願い申し上げます。\r\n\r\n　本メールは、IIMヒューマン・ソリューションのメールマガジンへ \r\n ご登録いただいた方へ送信しております。 \r\n お心当たりのない方は、お手数ですが、web@iimhs.co.jpまでご連絡ください。\r\n\r\n ※このメールは自動送信です。")->


       setHtml(" $name 様<br><br>この度は、弊社メールマガジン「IHSお役立ちメール」へご登録くださり<br>誠にありがとうございます。<br>登録解除をご希望の際は、web@iimhs.co.jp までご連絡頂けますよう<br>よろしくお願い申し上げます。<br><br>　本メールは、IIMヒューマン・ソリューションのメールマガジンへ <br> ご登録いただいた方へ送信しております。 <br> お心当たりのない方は、お手数ですが、web@iimhs.co.jp までご連絡ください。<br><br> ※このメールは自動送信です。 ")->
       addCategory('contact');

$response = $sendgrid->send($email);
var_dump($response);


//管理者へ送信するメール
$sendgrid = new SendGrid($sendgrid_username,$sendgrid_password, array("turn_off_ssl_verification" => true));
$email    = new SendGrid\Email();
$email->addTo($to)->
       setFrom($from)->
       setFromName("IIMヒューマン・ソリューション株式会社")->
       setSubject("【メールマガジン登録】IHSコーポレートサイト" )->
       setText("下記のお客様より、DM登録の依頼がありました。\r\nZOHO CRMへの反映をお願いいたします。\r\n\r\n 会社名: $company \r\n 部署名: $department \r\n 職位: $title \r\n　お名前: $name \r\n メールアドレス: $emailAdd \r\n ")->


       setHtml("下記のお客様より、DM登録の依頼がありました。<br />ZOHO CRMへの反映をお願いいたします。<br /><br />会社名: $company <br /> 部署名: $department <br /> 職位: $title <br /> お名前: $name <br /> メールアドレス: $emailAdd <br /> ")->
       addCategory('contact');

$response = $sendgrid->send($email);
var_dump($response);

// 正常終了時にthanks.htmlへリダイレクト
header('Location: /contact/mailmagazine/thanks.html');
exit();

