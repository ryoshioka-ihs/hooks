<?php
require 'vendor/autoload.php';
Dotenv::load(__DIR__);

$sendgrid_password = $_ENV['SENDGRID_PASSWORD'];
$sendgrid_username = $_ENV['SENDGRID_USERNAME'];
$from              = $_ENV['FROM'];
$to                = $_ENV['TO'];



//フォーム情報
$new = $_POST['new'];//種別
$name = $_POST['name'];//氏名
$phonetic = $_POST['phonetic'];//フリガナ
$sex = $_POST['sex'];//性別
$birth_year = $_POST['birth_year'];//誕生年
$birth_month = $_POST['birth_month'];//誕生月
$birth_day = $_POST['birth_day'];//誕生日
$residence = $_POST['residence'];//お住まい
$other_residence = $_POST['other_residence'];//お住まい（日本国外を選択された方）
$phone1 = $_POST['phone1'];//電話番号1枠目
$phone2 = $_POST['phone2'];//電話番号2枠目
$phone3 = $_POST['phone3'];//電話番号3枠目
$emailadd = $_POST['emailadd'];//メールアドレス
$line = $_POST['line'];//LINE希望
$enquete1 = $_POST['enquete1'];//何を見てご応募いただきましたか？
$enquete1_other = $_POST['enquete1_other'];//何を見てご応募いただきましたか？（その他）
$setsumeikai = $_POST['setsumeikai'];//説明会日程
$experience = $_POST['experience'];//業務体験
$status = $_POST['status'];//現在の状態
$status_other = $_POST['status_other'];//現在の状態（その他）
$last_school = $_POST['last_school'];//最終卒業学校名
$remarks = $_POST['remarks'];//備考
//$resume = $_POST['resume'];//履歴書
$checkbox = $_POST['checkbox'];//同意する

//アンケート複数選択
if (isset($_POST['enquete1']) && is_array($_POST['enquete1'])) {
    $enquete1 = implode("、", $_POST["enquete1"]);
}

//ユーザーへ送信するメール
$sendgrid = new SendGrid($sendgrid_username,$sendgrid_password, array("turn_off_ssl_verification" => true));
$email    = new SendGrid\Email();
$email->addTo($emailadd)->
       setFrom($from)->
       setFromName("IIMヒューマン・ソリューション株式会社 採用担当")->
       setSubject("【IHS】エントリーありがとうございます" )->
       setText(" 
       	$name 様\r\n\r\n

       	この度はIIMヒューマン・ソリューションの会社説明会へご応募くださり、\r\n
       	誠にありがとうございます。\r\n
       	採用担当より折り返しご連絡いたしますので、\r\n
       	今しばらくお待ちください。\r\n\r\n 

       	種別: $new \r\n 
       	氏名: $name \r\n 
       	フリガナ: $phonetic \r\n 
       	性別: $sex \r\n 
       	生年月日: $birth_year 年 $birth_month 月 $birth_day 日 \r\n 
       	お住まい: $residence \r\n 
       	お住まい（日本国外を選択された方）:$other_residence \r\n 
       	電話番号: $phone1 - $phone2 -$phone3 \r\n 
       	メールアドレス: $emailadd \r\n 
       	何を見てご応募いただきましたか？: $enquete1 \r\n 
       	何を見てご応募いただきましたか？（その他）: $enquete1_other \r\n
		会社説明会希望日時: $setsumeikai \r\n 
       	業務体験: $experience \r\n 
       	現在の状態: $status \r\n 
       	現在の状態（その他）:$status_other \r\n 
       	最終卒業学校名: $last_school \r\n
       	備考: $remarks \r\n\r\n
              $line \r\n 

       	※本メールは自動送信されています。\r\n
       	お問い合わせがある場合は、saiyou@iimhs.co.jpまでご連絡ください。")->



       setHtml(" 
       	$name 様<br /><br />

       	この度はIIMヒューマン・ソリューションの会社説明会へご応募くださり、<br />
       	誠にありがとうございます。<br />
       	採用担当より折り返しご連絡いたしますので、<br />
       	今しばらくお待ちください。<br /><br /> 

       	種別: $new <br /> 
       	氏名: $name <br /> 
       	フリガナ: $phonetic <br /> 
       	性別: $sex <br /> 
       	生年月日: $birth_year 年 $birth_month 月 $birth_day 日 <br /> 
       	お住まい: $residence <br /> 
       	お住まい（日本国外を選択された方）:$other_residence <br /> 
       	電話番号: $phone1 - $phone2 -$phone3 <br /> 
       	メールアドレス: $emailadd <br />
       	何を見てご応募いただきましたか？: $enquete1 <br /> 
       	何を見てご応募いただきましたか？（その他）: $enquete1_other <br />
       	会社説明会希望日時: $setsumeikai <br /> 
       	業務体験: $experience <br /> 
       	現在の状態: $status <br /> 
       	現在の状態（その他）:$status_other <br /> 
       	最終卒業学校名: $last_school <br />
       	備考: $remarks <br><br />
              $line <br />

       	※本メールは自動送信されています。<br />お問い合わせがある場合は、saiyou@iimhs.co.jpまでご連絡ください。")->
       addCategory('contact');

$response = $sendgrid->send($email);
var_dump($response);

//管理者へ送信するメール
$sendgrid = new SendGrid($sendgrid_username,$sendgrid_password, array("turn_off_ssl_verification" => true));
$email    = new SendGrid\Email();
$email->addTo($to)->
       setFrom($from)->
       setFromName("IHS採用担当")->
       setSubject("【IHS新卒採用サイトからエントリーがありました】" )->
       setText("

       	IHS採用サイトより、下記のエントリーがありました。\r\n
       	ご確認の上、ご対応をお願いいたします。\r\n\r\n

       	種別: $new \r\n 
       	氏名: $name \r\n 
       	フリガナ: $phonetic \r\n 
       	性別: $sex \r\n 
       	生年月日: $birth_year 年 $birth_month 月 $birth_day 日 \r\n 
       	お住まい: $residence \r\n 
       	お住まい（日本国外を選択された方）:$other_residence \r\n 
       	電話番号: $phone1 - $phone2 -$phone3 \r\n 
       	メールアドレス: $emailadd \r\n 
       	何を見てご応募いただきましたか？: $enquete1 \r\n 
       	何を見てご応募いただきましたか？（その他）: $enquete1_other \r\n
		会社説明会希望日時: $setsumeikai \r\n 
       	業務体験: $experience \r\n 
       	現在の状態: $status \r\n 
       	現在の状態（その他）:$status_other \r\n 
       	最終卒業学校名: $last_school \r\n
       	備考: $remarks \r\n\r\n
              $line \r\n 

              ")->


       setHtml("
       	下記内容にて会社説明会へのお申込みを受け付けました。<br />
       	ご担当者は確認後、受付メールを送付してください。<br /><br />

       	種別: $new <br /> 
       	氏名: $name <br /> 
       	フリガナ: $phonetic <br /> 
       	性別: $sex <br /> 
       	生年月日: $birth_year 年 $birth_month 月 $birth_day 日 <br /> 
       	お住まい: $residence <br /> 
       	お住まい（日本国外を選択された方）:$other_residence <br /> 
       	電話番号: $phone1 - $phone2 -$phone3 <br /> 
       	メールアドレス: $emailadd <br />
       	何を見てご応募いただきましたか？: $enquete1 <br /> 
       	何を見てご応募いただきましたか？（その他）: $enquete1_other <br />
       	会社説明会希望日時: $setsumeikai <br /> 
       	業務体験: $experience <br /> 
       	現在の状態: $status <br /> 
       	現在の状態（その他）:$status_other <br /> 
       	最終卒業学校名: $last_school <br />
       	備考: $remarks <br><br />

              $line <br />

              ")->
       addCategory('contact');

$response = $sendgrid->send($email);
var_dump($response);

// 正常終了時にthanks.htmlへリダイレクト
header('Location: /recruit/contact/new_entry/thanks.html');
exit();

