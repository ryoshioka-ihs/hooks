<?php
require 'vendor/autoload.php';
Dotenv::load(__DIR__);

$sendgrid_password = $_ENV['SENDGRID_PASSWORD'];
$sendgrid_username = $_ENV['SENDGRID_USERNAME'];
$from              = $_ENV['FROM'];
$to                = $_ENV['TO'];



//お客様情報
$name = $_POST['name'];//お名前
$phonetic = $_POST['phonetic'];//フリガナ
$emailadd = $_POST['emailadd'];//メールアドレス
$phone1 = $_POST['phone1'];//電話番号(1枠目)
$phone2 = $_POST['phone2'];//電話番号(2枠目)
$phone3 = $_POST['phone3'];//電話番号(3枠目)
$message = $_POST['message'];//お問い合わせ内容
$check = $_POST['check'];// 個人情報の取扱





/*ユーザーへ送信するメール*/
$sendgrid = new SendGrid($sendgrid_username,$sendgrid_password, array("turn_off_ssl_verification" => true));
$email    = new SendGrid\Email();
$email->addTo($emailadd)->
       setFrom($from)->
       setFromName("IIMヒューマン・ソリューション株式会社 採用担当")->
       setSubject("【IHS】お問い合わせを受け付けました" )->
       setText(" 
              $name 様\r\n\r\n

              下記お問い合わせを受け付けました。\r\n
              採用担当より折り返しご連絡いたしますので、今しばらくお待ちください。\r\n\r\n　

              お名前: $name （ $phonetic ）\r\n 
              メールアドレス: $emailadd \r\n
              電話番号: $phone1 - $phone2 - $phone3 \r\n 
              お問い合わせ内容: $message \r\n\r\n 

              ※このメールは自動送信です。\r\n 
              何かございましたらsaiyou@iimhs.co.jpまでお問い合わせください。")->


       setHtml(" 
              $name 様<br><br>

              下記お問い合わせを受け付けました。<br>
              採用担当より折り返しご連絡いたしますので、今しばらくお待ちください。<br><br>

              お名前: $name （ $phonetic ）<br>
              メールアドレス: $emailadd <br>
              電話番号: $phone1 - $phone2 - $phone3 <br> 
              お問い合わせ内容: $message <br><br> 

              ※このメールは自動送信です。<br> 
              何かございましたらsaiyou@iimhs.co.jpまでお問い合わせください。")->
       addCategory('contact');

$response = $sendgrid->send($email);
var_dump($response);


//管理者へ送信するメール
$sendgrid = new SendGrid($sendgrid_username,$sendgrid_password, array("turn_off_ssl_verification" => true));
$email    = new SendGrid\Email();
$email->addTo($to)->
       setFrom($from)->
       setFromName("IHS採用サイト")->
       setSubject("【IHS採用サイトからお問い合わせがありました】" )->
       setText("
              IHS採用サイトより、下記のお問い合わせがありました。\r\n\r\n

              ご確認の上、ご対応をお願いいたします。\r\n\r\n\

              お名前: $name （ $phonetic ）\r\n 
              メールアドレス: $emailadd \r\n
              電話番号: $phone1 - $phone2 - $phone3 \r\n 
              お問い合わせ内容: $message \r\n\r\n 
              ")->


       setHtml("
              IHS採用サイトより、下記のお問い合わせがありました。<br><br>

              ご確認の上、ご対応をお願いいたします。<br><br>

              お名前: $name （ $phonetic ）<br> 
              メールアドレス: $emailadd <br>
              電話番号: $phone1 - $phone2 - $phone3 <br> 
              お問い合わせ内容: $message <br><br> ")
       		  ->
       addCategory('contact');

$response = $sendgrid->send($email);
var_dump($response);

// 正常終了時にthanks.htmlへリダイレクト
header('Location: /recruit/contact/contact/thanks.html');
exit();

