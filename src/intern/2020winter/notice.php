<?php
require 'vendor/autoload.php';
Dotenv::load(__DIR__);

$sendgrid_password = $_ENV['SENDGRID_PASSWORD'];
$sendgrid_username = $_ENV['SENDGRID_USERNAME'];
$from              = $_ENV['FROM'];
$to                = $_ENV['TO'];



//フォーム情報
$name = $_POST['name'];//氏名
$phonetic = $_POST['phonetic'];//フリガナ
$emailadd = $_POST['emailadd'];//メールアドレス
$checkbox = $_POST['checkbox'];//同意する


//ユーザーへ送信するメール
$sendgrid = new SendGrid($sendgrid_username,$sendgrid_password, array("turn_off_ssl_verification" => true));
$email    = new SendGrid\Email();
$email->addTo($emailadd)->
       setFrom($from)->
       setFromName("IIMヒューマン・ソリューション株式会社 インターンシップ担当")->
       setSubject("【IHS】冬季インターンシップ2019の通知設定が完了しました。" )->
       setText(" $name 様\r\n\r\n

                  IIMヒューマン・ソリューションの冬季インターンシップ2019の通知設定が完了しました。\r\n
                  開催日程が決定し次第、ご入力いただきましたメールアドレスへご連絡させていただきます。\r\n

                  氏名: $name \r\n 
                  フリガナ: $phonetic \r\n 
                  メールアドレス: $emailadd \r\n\r\n 

                  ※本メールは自動送信されています。\r\n
                  お問い合わせがある場合は、saiyou@iimhs.co.jpまでご連絡ください。")->


       setHtml(" $name 様<br><br>

                  IIMヒューマン・ソリューションの冬季インターンシップ2019の通知設定が完了しました。<br>
                  開催日程が決定し次第、ご入力いただきましたメールアドレスへご連絡させていただきます。<br>

                  氏名: $name <br>
                  フリガナ: $phonetic <br>
                  メールアドレス: $emailadd <br><br>

                  ※本メールは自動送信されています。<br>
                  お問い合わせがある場合は、saiyou@iimhs.co.jpまでご連絡ください。")->
       addCategory('contact');

$response = $sendgrid->send($email);
var_dump($response);

//管理者へ送信するメール
$sendgrid = new SendGrid($sendgrid_username,$sendgrid_password, array("turn_off_ssl_verification" => true));
$email    = new SendGrid\Email();
$email->addTo($to)->
       setFrom($from)->
       setFromName("IHS採用担当")->
       setSubject("【冬季インターンシップ2019】通知設定を受信しました" )->
       setText("
                  自動受付完了メールを送付しております。\r\n\r\n

                  氏名: $name \r\n 
                  フリガナ: $phonetic \r\n 
                  メールアドレス: $emailadd \r\n\r\n 

                  ※本メールは自動送信されています。\r\n")->


       setHtml("  自動受付完了メールを送付しております。<br><br>

                  氏名: $name <br> 
                  フリガナ: $phonetic <br> 
                  メールアドレス: $emailadd <br><br> 

                  ※本メールは自動送信されています。<br>")->
       addCategory('contact');

$response = $sendgrid->send($email);
var_dump($response);

// 正常終了時にthanks.htmlへリダイレクト
header('Location: /recruit/intern/2019winter/thanks.html');
exit();

