<?php
require 'vendor/autoload.php';
Dotenv::load(__DIR__);

$sendgrid_password = $_ENV['SENDGRID_PASSWORD'];
$sendgrid_username = $_ENV['SENDGRID_USERNAME'];
$from              = $_ENV['FROM'];
$to                = $_ENV['TO'];



//お客様情報
$name = $_POST['name'];//お名前
$name2 = $_POST['name2'];//フリガナ
$emailAdd = $_POST['emailAdd'];//メールアドレス
$phone = $_POST['phone'];//電話番号
$message = $_POST['message'];//応募きっかけ
$check = $_POST['check'];// 個人情報の取扱





/*ユーザーへ送信するメール
$sendgrid = new SendGrid($sendgrid_username,$sendgrid_password, array("turn_off_ssl_verification" => true));
$email    = new SendGrid\Email();
$email->addTo($emailAdd)->
       setFrom($from)->
       setFromName("IIMヒューマン・ソリューション株式会社 採用担当")->
       setSubject("【IHS】エントリーありがとうございます" )->
       setText(" $name 様\r\n\r\nこの度はIIMヒューマン・ソリューションの会社説明会へご応募くださり、\r\n誠にありがとうございます。\r\n採用担当より折り返しご連絡いたしますので、\r\n今しばらくお待ちください。\r\n\r\n　会社説明会日程: $briefing \r\n お名前: $name （ $name2 ）\r\n メールアドレス: $emailAdd \r\n\r\n 生年月日: $birthday \r\n 性別: $sex \r\n 電話番号: $phone \r\n 応募きっかけ: $enquete \r\n 応募きっかけ/その他を選択した方: $other1 \r\n 現在の状態: $status \r\n 現在の状態/その他を選択した方: $other2 \r\n 最終学歴: $education \r\n 最終学歴/その他を選択した方: $other3 \r\n 最終卒業学校名: $school \r\n\r\n ※このメールは自動送信です。\r\n 何かございましたらwebteam@iimhs.co.jpまでお問い合わせください。")->


       setHtml(" $name 様<br /><br />この度はIIMヒューマン・ソリューションの会社説明会へご応募くださり、<br />誠にありがとうございます。<br />採用担当より折り返しご連絡いたしますので、<br />今しばらくお待ちください。<br /><br />会社説明会日程: $briefing <br /> お名前: $name （ $name2 ）<br /> メールアドレス: $emailAdd <br /><br /> 生年月日: $birthday <br /> 性別: $sex <br /> 電話番号: $phone <br /> 応募きっかけ: $enquete <br /> 応募きっかけ/その他を選択した方: $other1 <br /> 現在の状態: $status <br /> 現在の状態/その他を選択した方: $other2 <br /> 最終学歴: $education <br /> 最終学歴/その他を選択した方: $other3 <br /> 最終卒業学校名: $school <br /><br /> ※このメールは自動送信です。<br /> 何かございましたらsaiyou@iimhs.co.jpまでお問い合わせください。")->
       addCategory('contact');

$response = $sendgrid->send($email);
var_dump($response);
*/

//管理者へ送信するメール
$sendgrid = new SendGrid($sendgrid_username,$sendgrid_password, array("turn_off_ssl_verification" => true));
$email    = new SendGrid\Email();
$email->addTo($to)->
       setFrom($from)->
       setFromName("IHS採用担当")->
       setSubject("【IHS採用サイトからお問い合わせがありました】" )->
       setText("IHS採用サイトより、下記のお問い合わせがありました。\r\nご確認の上、ご対応をお願いいたします。\r\n\r\n\お名前: $name （ $name2 ）\r\n メールアドレス: $emailAdd \r\n\r\n 電話番号: $phone \r\n お問合わせ内容: $message \r\n ")->


       setHtml("IHS採用サイトより、下記のお問い合わせがありました。<br />ご確認の上、ご対応をお願いいたします。<br /><br />お名前: $name （ $name2 ）<br /> メールアドレス: $emailAdd <br /> 電話番号: $phone <br /> お問合わせ内容: $message <br />")->
       addCategory('contact');

$response = $sendgrid->send($email);
var_dump($response);

// 正常終了時にthanks.htmlへリダイレクト
header('Location: /recruit/contact/contact/thanks.html');
exit();

