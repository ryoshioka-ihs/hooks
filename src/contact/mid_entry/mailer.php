<?php
require 'vendor/autoload.php';
Dotenv::load(__DIR__);

$sendgrid_password = $_ENV['SENDGRID_PASSWORD'];
$sendgrid_username = $_ENV['SENDGRID_USERNAME'];
$from              = $_ENV['FROM'];
$to                = $_ENV['TO'];



//フォーム情報
$status = $_POST['status'];//現在のステータス
$working_year = $_POST['working_year'];//勤続年数
$job_category = $_POST['job_category'];//現在の職種
$current_annual_income = $_POST['current_annual_income'];//現在の年収
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
$start_work = $_POST['start_work'];//就業可能時期
$desired_job_category = $_POST['desired_job_category'];//希望の職種
$desired_annual_income = $_POST['desired_annual_income'];//希望の年収
$mensetsu = $_POST['mensetsu'];//面接日程
$interview1_year = $_POST['interview1_year'];//第一面接希望年
$interview1_month = $_POST['interview1_month'];//第一面接希望月
$interview1_day = $_POST['interview1_day'];//第一面接希望日
$interview2_year = $_POST['interview2_year'];//第二面接希望年
$interview2_month = $_POST['interview2_month'];//第二面接希望月
$interview2_day = $_POST['interview2_day'];//第二面接希望日
$interview3_year = $_POST['interview3_year'];//第三面接希望年
$interview3_month = $_POST['interview3_month'];//第三面接希望月
$interview3_day = $_POST['interview3_day'];//第三面接希望日
$remarks = $_POST['remarks'];//備考
//$resume = $_POST['resume'];//履歴書
$checkbox = $_POST['checkbox'];//同意する


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

       	現在のステータス: $status \r\n 
       	勤続年数: $working_year \r\n 
       	現在の職種: $job_category \r\n 
       	氏名: $name \r\n 
       	フリガナ: $phonetic \r\n 
       	性別: $sex \r\n 
       	生年月日: $birth_year 年 $birth_month 月 $birth_day 日 \r\n 
       	お住まい: $residence \r\n 
       	お住まい（日本国外を選択された方）: $other_residence \r\n 
       	電話番号（携帯番号）: $phone1 - $phone2 - $phone3 \r\n 
       	メールアドレス: $emailadd \r\n 
       	就業可能時期: $start_work \r\n 
       	希望の職種: $desired_job_category \r\n 
       	希望の年収: $desired_annual_income 万円 \r\n 
       	会社説明会希望日時: $mensetsu \r\n 
       	第一面接希望日: $interview1_year 年 $interview1_month 月 $interview1_day 日 \r\n 
       	第二面接希望日: $interview2_year 年 $interview2_month 月 $interview2_day 日 \r\n 
       	第三面接希望日: $interview3_year 年 $interview3_month 月 $interview3_day 日 \r\n 
       	備考: $remarks \r\n\r\n 

              $line \r\n 

       	※このメールは自動送信です。\r\n 
       	何かございましたらsaiyou@iimhs.co.jpまでお問い合わせください。")->



       setHtml(" 
       	$name 様<br /><br />

       	この度はIIMヒューマン・ソリューションの会社説明会へご応募くださり、<br />
       	誠にありがとうございます。<br />
       	採用担当より折り返しご連絡いたしますので、<br />
       	今しばらくお待ちください。<br /><br /> 

       	現在のステータス: $status <br /> 
       	勤続年数: $working_year <br /> 
       	現在の職種: $job_category <br /> 
       	氏名: $name <br /> 
       	フリガナ: $phonetic <br /> 
       	性別: $sex <br /> 
       	生年月日: $birth_year 年 $birth_month 月 $birth_day 日 <br />
       	お住まい: $residence <br /> 
       	お住まい（日本国外を選択された方）: $other_residence <br /> 
       	電話番号（携帯番号）: $phone1 - $phone2 - $phone3 <br /> 
       	メールアドレス: $emailadd <br /> 
       	就業可能時期: $start_work <br /> 
       	希望の職種: $desired_job_category <br /> 
       	希望の年収: $desired_annual_income 万円<br /> 
       	会社説明会希望日時: $mensetsu <br>
       	第一面接希望日: $interview1_year 年 $interview1_month 月 $interview1_day 日 <br /> 
       	第二面接希望日: $interview2_year 年 $interview2_month 月 $interview2_day 日 <br /> 
       	第三面接希望日: $interview3_year 年 $interview3_month 月 $interview3_day 日 <br /> 備考: $remarks <br /><br /> 

              $line <br /> 

       	※このメールは自動送信です。<br /> 
       	何かございましたらsaiyou@iimhs.co.jpまでお問い合わせください。")->
       addCategory('contact');

$response = $sendgrid->send($email);
var_dump($response);

//管理者へ送信するメール
$sendgrid = new SendGrid($sendgrid_username,$sendgrid_password, array("turn_off_ssl_verification" => true));
$email    = new SendGrid\Email();
$email->addTo($to)->
       setFrom($from)->
       setFromName("IHS採用担当")->
       setSubject("【IHS中途採用サイトからエントリーがありました】" )->
       setText("
       	IHS採用サイトより、下記のエントリーがありました。\r\n
       	ご確認の上、ご対応をお願いいたします。\r\n\r\n

       	現在のステータス: $status \r\n 
       	勤続年数: $working_year \r\n 
       	現在の職種: $job_category \r\n 
       	氏名: $name \r\n 
       	フリガナ: $phonetic \r\n 
       	性別: $sex \r\n 
       	生年月日: $birth_year 年 $birth_month 月 $birth_day 日 \r\n 
       	お住まい: $residence \r\n 
       	お住まい（日本国外を選択された方）: $other_residence \r\n 
       	電話番号（携帯番号）: $phone1 - $phone2 - $phone3 \r\n 
       	メールアドレス: $emailadd \r\n 
       	就業可能時期: $start_work \r\n 
       	希望の職種: $desired_job_category \r\n 
       	希望の年収: $desired_annual_income 万円 \r\n 
       	会社説明会希望日時: $mensetsu \r\n 
       	第一面接希望日: $interview1_year 年 $interview1_month 月 $interview1_day 日 \r\n 
       	第二面接希望日: $interview2_year 年 $interview2_month 月 $interview2_day 日 \r\n 
       	第三面接希望日: $interview3_year 年 $interview3_month 月 $interview3_day 日 \r\n 
       	備考: $remarks \r\n\r\n

              $line \r\n 
              
              ")->


       setHtml("
       	下記内容にて会社説明会へのお申込みを受け付けました。<br />
       	ご担当者は確認後、受付メールを送付してください。<br /><br />

       	現在のステータス: $status <br /> 
       	勤続年数: $working_year <br /> 
       	現在の職種: $job_category <br /> 
       	氏名: $name <br /> 
       	フリガナ: $phonetic <br /> 
       	性別: $sex <br /> 
       	生年月日: $birth_year 年 $birth_month 月 $birth_day 日 <br /> 
       	お住まい: $residence <br /> 
       	お住まい（日本国外を選択された方）: $other_residence <br /> 
       	電話番号（携帯番号）: $phone1 - $phone2 - $phone3 <br /> 
       	メールアドレス: $emailadd <br /> 
       	就業可能時期: $start_work <br /> 
       	希望の職種: $desired_job_category <br /> 
       	希望の年収: $desired_annual_income 万円<br /> 
       	会社説明会希望日時: $mensetsu <br>
       	第一面接希望日: $interview1_year 年 $interview1_month 月 $interview1_day 日 <br /> 
       	第二面接希望日: $interview2_year 年 $interview2_month 月 $interview2_day 日 <br /> 
       	第三面接希望日: $interview3_year 年 $interview3_month 月 $interview3_day 日 <br /> 
       	備考: $remarks <br /><br />

              $line <br /> 
              
              ")->
       addCategory('contact');

$response = $sendgrid->send($email);
var_dump($response);

// 正常終了時にthanks.htmlへリダイレクト
header('Location: /recruit/contact/mid_entry/thanks.html');
exit();

