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
$childname1 = $_POST['childname1'];//お名前①
$childage1 = $_POST['childage1'];//年齢①
$childname2 = $_POST['childname2'];//お名前②
$childage2 = $_POST['childage2'];//年齢②
$childname3 = $_POST['childname3'];//お名前③
$childage3 = $_POST['childage3'];//年齢③
$phone1 = $_POST['phone1'];//電話番号1枠目
$phone2 = $_POST['phone2'];//電話番号2枠目
$phone3 = $_POST['phone3'];//電話番号3枠目
$emailadd = $_POST['emailadd'];//メールアドレス
$course1 = $_POST['course'];//4月27日
$remarks = $_POST['remarks'];//備考
$checkbox = $_POST['checkbox'];//同意する

//セミナー複数選択
if (isset($_POST['course']) && is_array($_POST['course'])) {
    $course = implode("<br />", $_POST["course"]);
}

//ユーザーへ送信するメール
$sendgrid = new SendGrid($sendgrid_username,$sendgrid_password, array("turn_off_ssl_verification" => true));
$email    = new SendGrid\Email();
$email->addTo($emailadd)->
       setFrom($from)->
       setFromName("IIMヒューマン・ソリューション株式会社")->
       setSubject("【IHS】お申込みありがとうございます" )->
       setText(" $name さん\r\n\r\n

              『えいごで楽しく遊ぼう！Enjoy English ワークショップ』へのお申込みを受付ました。\r\n\r\n

              お父様/お母様の氏名: $name 様 \r\n 
              フリガナ: $phonetic 様 \r\n 
              お名前①: $childname1   年齢: $childage1 歳 \r\n
              お名前②: $childname2   年齢: $childage2 歳 \r\n 
              お名前③: $childname3   年齢: $childage3 歳 \r\n  
              電話番号: $phone1 - $phone2 - $phone3 \r\n 
              メールアドレス: $emailadd \r\n 
              【4月27日（土）】：$course 10：30～\r\n
              備考: $remarks \r\n\r\n

              ※本メールは自動送信されています。\r\n
              お問い合わせがある場合は、itseminar@iimhs.co.jpまでご連絡ください。")->



       setHtml("  $name さん<br><br>

              『えいごで楽しく遊ぼう！Enjoy English ワークショップ』へのお申込みを受付ました。<br><br>

              お父様/お母様の氏名: $name 様 <br> 
              フリガナ: $phonetic 様 <br> 
              お名前①: $childname1   年齢: $childage1 歳 <br>
              お名前②: $childname2   年齢: $childage2 歳 <br> 
              お名前③: $childname3   年齢: $childage3 歳 <br>  
              電話番号: $phone1 - $phone2 - $phone3 <br> 
              メールアドレス: $emailadd <br> 
              【4月27日（土）】：$course 10：30～<br>
              備考: $remarks <br><br>

              ※本メールは自動送信されています。<br>
              お問い合わせがある場合は、itseminar@iimhs.co.jpまでご連絡ください。")->
       addCategory('contact');

$response = $sendgrid->send($email);
var_dump($response);

//管理者へ送信するメール
$sendgrid = new SendGrid($sendgrid_username,$sendgrid_password, array("turn_off_ssl_verification" => true));
$email    = new SendGrid\Email();
$email->addTo($to)->
       setFrom($from)->
       setFromName("IHS")->
       setSubject("【えいごで楽しく遊ぼう！Enjoy English ワークショップ』へのエントリーがありました】" )->
       setText(" 『えいごで楽しく遊ぼう！Enjoy English ワークショップ』へのエントリーがありました\r\n\r\n

              お父様/お母様の氏名: $name 様 \r\n 
              フリガナ: $phonetic 様 \r\n 
              お名前①: $childname1   年齢: $childage1 歳 \r\n
              お名前②: $childname2   年齢: $childage2 歳 \r\n 
              お名前③: $childname3   年齢: $childage3 歳 \r\n  
              電話番号: $phone1 - $phone2 - $phone3 \r\n 
              メールアドレス: $emailadd \r\n 
              【4月27日（土）】：$course 10：30～\r\n
              備考: $remarks \r\n\r\n

              ※本メールは自動送信されています。\r\n
              お問い合わせがある場合は、itseminar@iimhs.co.jpまでご連絡ください。")->



       setHtml("
              お父様/お母様の氏名: $name 様 <br> 
              フリガナ: $phonetic 様 <br> 
              お名前①: $childname1   年齢: $childage1 歳 <br>
              お名前②: $childname2   年齢: $childage2 歳 <br> 
              お名前③: $childname3   年齢: $childage3 歳 <br>  
              電話番号: $phone1 - $phone2 - $phone3 <br> 
              メールアドレス: $emailadd <br> 
              【4月27日（土）】：$course 10：30～<br>
              備考: $remarks <br><br>

		※本メールは自動送信されています。<br>
              お問い合わせがある場合は、itseminar@iimhs.co.jpまでご連絡ください。")->
       addCategory('contact');

$response = $sendgrid->send($email);
var_dump($response);

// 正常終了時にthanks.htmlへリダイレクト
header('Location: /recruit/contact/shain-englishseminar_entry/thanks.html');
exit();

