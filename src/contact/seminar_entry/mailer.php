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
$course = $_POST['course'];//セミナーコース
$pc = $_POST['pc'];//PC貸出希望
$status_other = $_POST['status_other'];//業種
$last_school = $_POST['last_school'];//学校名
$enquete = $_POST['enquete'];//アンケート
$remarks = $_POST['remarks'];//備考
$checkbox = $_POST['checkbox'];//同意する

//セミナー複数選択
if (isset($_POST['course']) && is_array($_POST['course'])) {
    $course = implode("<br />", $_POST["course"]);
}

//アンケート
if (isset($_POST['enquete']) && is_array($_POST['enquete'])) {
      $enquete = implode("<br />", $_POST["enquete"]);
  }

//ユーザーへ送信するメール
$sendgrid = new SendGrid($sendgrid_username,$sendgrid_password, array("turn_off_ssl_verification" => true));
$email    = new SendGrid\Email();
$email->addTo($emailadd)->
       setFrom($from)->
       setFromName("IIMヒューマン・ソリューション株式会社")->
       setSubject("【IHS】お申込みありがとうございます" )->
       setText(" $name 様\r\n\r\n

              この度はIIMヒューマン・ソリューションの『IT無料セミナー』へご応募くださり、\r\n
              誠にありがとうございます。\r\n\r\n

              担当より折り返しご連絡いたしますので、今しばらくお待ちください。\r\n\r\n

              氏名: $name 様 \r\n 
              フリガナ: $phonetic 様 \r\n 
              性別: $sex \r\n 
              年齢: $age 歳 \r\n 
              電話番号: $phone1 - $phone2 - $phone3 \r\n 
              メールアドレス: $emailadd \r\n 
              現在の状態: $status \r\n 
              ご希望のコース：\r\n $course \r\n 
              PCの貸出：$pc \r\n
              業種: $status_other \r\n 
              学校名: $last_school \r\n
              備考: $remarks \r\n\r\n

              ※本メールは自動送信されています。\r\n
              お問い合わせがある場合は、web@iimhs.co.jpまでご連絡ください。")->



       setHtml("  $name 様<br><br>

              この度はIIMヒューマン・ソリューションの『IT無料セミナー』へご応募くださり、<br>
              誠にありがとうございます。<br><br>

              担当より折り返しご連絡いたしますので、今しばらくお待ちください。<br><br>

              氏名: $name 様 <br> 
              フリガナ: $phonetic 様 <br> 
              性別: $sex <br> 
              年齢: $age 歳 <br>
              電話番号: $phone1 - $phone2 - $phone3 <br> 
              メールアドレス: $emailadd <br> 
              現在の状態: $status <br> 
              ご希望のコース：<br> $course <br>
              PCの貸出：$pc <br> 
              業種: $status_other <br> 
              学校名: $last_school <br>
              備考: $remarks <br><br>

              ※本メールは自動送信されています。<br><br>
              お問い合わせがある場合は、web@iimhs.co.jpまでご連絡ください。")->
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

              氏名: $name 様 \r\n 
              フリガナ: $phonetic 様 \r\n 
              性別: $sex \r\n 
              年齢: $age 歳 \r\n 
              電話番号: $phone1 - $phone2 - $phone3 \r\n 
              メールアドレス: $emailadd \r\n 
              現在の状態: $status \r\n 
              ご希望のコース：\r\n $course \r\n 
              PCの貸出：$pc \r\n
              業種: $status_other \r\n 
              学校名: $last_school \r\n
              何をみてご応募いただきましたか？：\r\n $enquete \r\n 
              備考: $remarks \r\n\r\n

              確認後は受付完了メールを送付ください。\r\n")->



       setHtml("
              氏名: $name 様 <br>
              フリガナ: $phonetic 様<br>
              性別: $sex <br> 
              年齢: $age 歳 <br> 
              電話番号: $phone1 - $phone2 - $phone3 <br>
              メールアドレス: $emailadd <br> 
              現在の状態: $status <br> 
              ご希望のコース：<br> $course <br>
              PCの貸出：$pc <br> 
              業種: $status_other <br> 
              学校名: $last_school <br><br>
              何をみてご応募いただきましたか？: <br> $enquete <br>
              備考: $remarks <br><br>

              確認後は受付完了メールを送付ください。<br>")->
       addCategory('contact');

$response = $sendgrid->send($email);
var_dump($response);

// 正常終了時にthanks.htmlへリダイレクト
header('Location: /recruit/contact/seminar_entry/thanks.html');
exit();

