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
$status = $_POST['status'];//現在の状態
$status_other = $_POST['status_other'];//業種
$last_school = $_POST['last_school'];//学校名
$remarks = $_POST['remarks'];//備考
$checkbox = $_POST['checkbox'];//同意する


//ユーザーへ送信するメール
$sendgrid = new SendGrid($sendgrid_username,$sendgrid_password, array("turn_off_ssl_verification" => true));
$email    = new SendGrid\Email();
$email->addTo($emailadd)->
       setFrom($from)->
       setFromName("IIMヒューマン・ソリューション株式会社")->
       setSubject("【IHS】エントリーありがとうございます" )->
       setText(" $name 様\r\n\r\nこの度はIIMヒューマン・ソリューションの『情報処理技術の基本&業務プロセスセミナー』へご応募くださり、\r\n誠にありがとうございます。\r\n採用担当より折り返しご連絡いたしますので、今しばらくお待ちください。\r\n\r\n 氏名: $name \r\n フリガナ: $phonetic \r\n 性別: $sex \r\n 年齢: $age 歳 \r\n 電話番号: $phone1 - $phone2 -$phone3 \r\n メールアドレス: $emailadd \r\n 現在の状態: $status \r\n 業種: $status_other \r\n 学校名: $last_school \r\n 備考: $remarks \r\n\r\n※本メールは自動送信されています。\r\nお問い合わせがある場合は、saiyou@iimhs.co.jpまでご連絡ください。")->



       setHtml(" $name 様<br /><br />この度はIIMヒューマン・ソリューションの『情報処理技術の基本&業務プロセスセミナー』へご応募くださり、<br />誠にありがとうございます。<br />採用担当より折り返しご連絡いたしますので、今しばらくお待ちください。<br /><br /> 氏名: $name <br /> フリガナ: $phonetic <br /> 性別: $sex <br /> 年齢: $age 歳 <br /> 電話番号: $phone1 - $phone2 -$phone3 <br /> メールアドレス: $emailadd <br /> 現在の状態: $status <br /> 業種: $status_other <br /> 学校名: $last_school <br /> 備考: $remarks <br /><br />※本メールは自動送信されています。<br />お問い合わせがある場合は、saiyou@iimhs.co.jpまでご連絡ください。")->
       addCategory('contact');

$response = $sendgrid->send($email);
var_dump($response);

//管理者へ送信するメール
$sendgrid = new SendGrid($sendgrid_username,$sendgrid_password, array("turn_off_ssl_verification" => true));
$email    = new SendGrid\Email();
$email->addTo($to)->
       setFrom($from)->
       setFromName("IHS")->
       setSubject("【『情報処理技術の基本&業務プロセスセミナー』へのエントリーがありました】" )->
       setText("下記内容にて『情報処理技術の基本&業務プロセスセミナー』へのお申込みを受け付けました。\r\nご担当者は確認後、受付メールを送付してください。\r\n\r\n氏名: $name \r\n フリガナ: $phonetic \r\n 性別: $sex \r\n 年齢: $age 歳 \r\n 電話番号: $phone1 - $phone2 -$phone3 \r\n メールアドレス: $emailadd \r\n 現在の状態: $status \r\n 業種: $status_other \r\n 学校名: $last_school \r\n 備考: $remarks")->


       setHtml("下記内容にて『情報処理技術の基本&業務プロセスセミナー』へのお申込みを受け付けました。<br />ご担当者は確認後、受付メールを送付してください。<br /><br />氏名: $name <br /> フリガナ: $phonetic <br /> 性別: $sex <br /> 年齢: $age 歳 <br /> 電話番号: $phone1 - $phone2 -$phone3 <br /> メールアドレス: $emailadd <br /> 現在の状態: $status <br /> 業種: $status_other <br /> 学校名: $last_school<br /> 備考: $remarks <br /><br />")->
       addCategory('contact');

$response = $sendgrid->send($email);
var_dump($response);

// 正常終了時にthanks.htmlへリダイレクト
header('Location: /recruit/contact/seminar_entry/thanks.html');
exit();

