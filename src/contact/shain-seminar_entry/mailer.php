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
$sex = $_POST['sex'];//性別
$age = $_POST['age'];//年齢
$phone1 = $_POST['phone1'];//電話番号1枠目
$phone2 = $_POST['phone2'];//電話番号2枠目
$phone3 = $_POST['phone3'];//電話番号3枠目
$emailadd = $_POST['emailadd'];//メールアドレス
$course = $_POST['course'];//参加コース
$pc = $_POST['pc'];//PC貸出希望
$remarks = $_POST['remarks'];//備考
$checkbox = $_POST['checkbox'];//同意する

//セミナー複数選択
if (isset($_POST['course']) && is_array($_POST['course'])) {
    $course = implode("、", $_POST["course"]);
}

//ユーザーへ送信するメール
$sendgrid = new SendGrid($sendgrid_username,$sendgrid_password, array("turn_off_ssl_verification" => true));
$email    = new SendGrid\Email();
$email->addTo($emailadd)->
       setFrom($from)->
       setFromName("IIMヒューマン・ソリューション株式会社")->
       setSubject("【IHS】お申込みありがとうございます" )->
       setText(" $name さん\r\n\r\n

              『IT無料セミナー』へのお申込みを受付ました。\r\n\r\n

              氏名: $name 様 \r\n 
              フリガナ: $phonetic 様 \r\n 
              性別: $sex \r\n 
              年齢: $age 歳 \r\n 
              電話番号: $phone1 - $phone2 - $phone3 \r\n 
              メールアドレス: $emailadd \r\n 
              お申込みセミナー：$course \r\n
              PCの貸出：$pc \r\n
              備考: $remarks \r\n\r\n

              ※本メールは自動送信されています。\r\n
              お問い合わせがある場合は、itseminar@iimhs.co.jpまでご連絡ください。")->



       setHtml("  $name さん<br><br>

              『IT無料セミナー』へのお申込みを受付ました。<br><br>

              氏名: $name 様 <br> 
              フリガナ: $phonetic 様 <br> 
              性別: $sex <br> 
              年齢: $age 歳 <br>
              電話番号: $phone1 - $phone2 - $phone3 <br> 
              メールアドレス: $emailadd <br> 
              お申込みセミナー：$course <br>
              PCの貸出：$pc <br> 
              備考: $remarks <br><br>

              ※本メールは自動送信されています。<br><br>
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
       setSubject("【『IT無料セミナー』へのエントリーがありました】" )->
       setText(" 『IT無料セミナー』へのエントリーがありました\r\n\r\n

              氏名: $name さん \r\n 
              フリガナ: $phonetic 様 \r\n 
              性別: $sex \r\n 
              年齢: $age 歳 \r\n 
              電話番号: $phone1 - $phone2 - $phone3 \r\n 
              メールアドレス: $emailadd \r\n 
              お申込みセミナー：$course \r\n
              PCの貸出：$pc \r\n
              備考: $remarks \r\n\r\n

              ※本メールは自動送信されています。\r\n
              お問い合わせがある場合は、itseminar@iimhs.co.jpまでご連絡ください。")->



       setHtml("
              氏名: $name さん <br>
              フリガナ: $phonetic 様<br>
              性別: $sex <br> 
              年齢: $age 歳 <br> 
              電話番号: $phone1 - $phone2 - $phone3 <br>
              メールアドレス: $emailadd <br> 
              お申込みセミナー：$course <br>
              PCの貸出：$pc <br> 
              備考: $remarks <br><br>

		※本メールは自動送信されています。<br><br>
              お問い合わせがある場合は、itseminar@iimhs.co.jpまでご連絡ください。")->
       addCategory('contact');

$response = $sendgrid->send($email);
var_dump($response);

// 正常終了時にthanks.htmlへリダイレクト
header('Location: /recruit/contact/shain-seminar_entry/thanks.html');
exit();

