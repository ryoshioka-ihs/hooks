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
$birth_year = $_POST['birth_year'];//誕生年
$birth_month = $_POST['birth_month'];//誕生月
$birth_day = $_POST['birth_day'];//誕生日
$residence = $_POST['residence'];//お住まい
$phone1 = $_POST['phone1'];//電話番号1枠目
$phone2 = $_POST['phone2'];//電話番号2枠目
$phone3 = $_POST['phone3'];//電話番号3枠目
$emailadd = $_POST['emailadd'];//メールアドレス
$enquete1 = $_POST['enquete1'];//セミナー参加目的
$enquete1_other = $_POST['enquete1_other'];//セミナー参加目的（その他）
$pc = $_POST['pc'];//PC貸出
$status = $_POST['status'];//現在の状態
$school = $_POST['school'];//学校名
$faculty = $_POST['faculty'];//学部
$department = $_POST['department'];//学科
$remarks = $_POST['remarks'];//備考
//$resume = $_POST['resume'];//履歴書
$checkbox = $_POST['checkbox'];//同意する

//セミナー複数選択
if (isset($_POST['enquete1']) && is_array($_POST['enquete1'])) {
    $enquete1 = implode("、", $_POST["enquete1"]);
}
//ユーザーへ送信するメール
$sendgrid = new SendGrid($sendgrid_username,$sendgrid_password, array("turn_off_ssl_verification" => true));
$email    = new SendGrid\Email();
$email->addTo($emailadd)->
       setFrom($from)->
       setFromName("IIMヒューマン・ソリューション株式会社 セミナー担当")->
       setSubject("【IHS】エントリーありがとうございます" )->
       setText(" $name 様\r\n\r\n

                  この度はIIMヒューマン・ソリューションのインターンシップへご応募くださり、\r\n
                  誠にありがとうございます。\r\n
                  セミナー担当より折り返しご連絡いたしますので、\r\n
                  今しばらくお待ちください。\r\n\r\n 

                  氏名: $name \r\n 
                  フリガナ: $phonetic \r\n 
                  性別: $sex \r\n 
                  生年月日: $birth_year 年 $birth_month 月 $birth_day 日 \r\n 
                  お住まい: $residence \r\n 
                  電話番号: $phone1 - $phone2 -$phone3 \r\n 
                  メールアドレス: $emailadd \r\n 
                  セミナー参加目的: $enquete1 \r\n 
                  セミナー参加目的（その他）: $enquete1_other \r\n 
                  ノートPC貸出: $pc \r\n 
                  現在の状態: $status \r\n 
                  学校名: $school \r\n 
                  学部: $faculty \r\n 
                  学科: $department \r\n 
                  備考: $remarks\r\n\r\n

                  ※本メールは自動送信されています。\r\n
                  お問い合わせがある場合は、saiyou@iimhs.co.jpまでご連絡ください。")->


       setHtml(" $name 様<br><br>

                  この度はIIMヒューマン・ソリューションのインターンシップへご応募くださり、<br>
                  誠にありがとうございます。<br>
                  セミナー担当より折り返しご連絡いたしますので、<br>
                  今しばらくお待ちください。<br><br>

                  氏名: $name <br> 
                  フリガナ: $phonetic <br> 
                  性別: $sex <br> 
                  生年月日: $birth_year 年 $birth_month 月 $birth_day 日 <br> 
                  お住まい: $residence <br> 
                  電話番号: $phone1 - $phone2 -$phone3 <br> 
                  メールアドレス: $emailadd <br> 
                  セミナー参加目的: $enquete1 <br> 
                  セミナー参加目的（その他）: $enquete1_other <br> 
                  ノートPC貸出: $pc <br> 
                  現在の状態: $status <br> 
                  学校名: $school <br> 
                  学部: $faculty <br> 
                  学科: $department <br> 
                  備考: $remarks　<br><br>

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
       setSubject("【インターンシップへエントリーがありました】" )->
       setText("
                  インターンシップへエントリーがありました\r\n
                  自動受付完了メールを送付しております。\r\n
                  ご対応をお願いいたします。\r\n\r\n 

                  氏名: $name \r\n 
                  フリガナ: $phonetic \r\n 
                  性別: $sex \r\n 
                  生年月日: $birth_year 年 $birth_month 月 $birth_day 日 \r\n 
                  お住まい: $residence \r\n 
                  電話番号: $phone1 - $phone2 -$phone3 \r\n 
                  メールアドレス: $emailadd \r\n 
                  セミナー参加目的: $enquete1 \r\n 
                  セミナー参加目的（その他）: $enquete1_other \r\n 
                  ノートPC貸出: $pc \r\n 
                  現在の状態: $status \r\n 
                  学校名: $school \r\n 
                  学部: $faculty \r\n 
                  学科: $department \r\n 
                  備考: $remarks\r\n\r\n

                  ※本メールは自動送信されています。\r\n")->


       setHtml("  インターンシップへエントリーがありました<br>
                  自動受付完了メールを送付しております。<br>
                  ご対応をお願いいたします。<br><br>

                  氏名: $name <br> 
                  フリガナ: $phonetic <br> 
                  性別: $sex <br> 
                  生年月日: $birth_year 年 $birth_month 月 $birth_day 日 <br> 
                  お住まい: $residence <br> 
                  電話番号: $phone1 - $phone2 -$phone3 <br>
                  メールアドレス: $emailadd <br> 
                  セミナー参加目的: $enquete1 <br> 
                  セミナー参加目的（その他）: $enquete1_other <br> 
                  ノートPC貸出: $pc <br> 
                  現在の状態: $status <br> 
                  学校名: $school <br> 
                  学部: $faculty <br> 
                  学科: $department <br> 
                  備考: $remarks<br><br>

                  ※本メールは自動送信されています。<br>")->
       addCategory('contact');

$response = $sendgrid->send($email);
var_dump($response);

// 正常終了時にthanks.htmlへリダイレクト
header('Location: /recruit/intern2019/thanks.html');
exit();

