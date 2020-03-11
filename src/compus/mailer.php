<?php
require 'vendor/autoload.php';
Dotenv::load(__DIR__);

$sendgrid_password = $_ENV['SENDGRID_PASSWORD'];
$sendgrid_username = $_ENV['SENDGRID_USERNAME'];
$from              = $_ENV['FROM'];
$to                = $_ENV['TO'];

//アンケート内容
$q1 = $_POST['q1'];
$q2 = $_POST['q2'];
$q3 = $_POST['q3'];
if (isset($_POST['q4_1']) && is_array($_POST['q4_1'])) {
    $q4_1 = implode("、", $_POST["q4_1"]);
}
if (isset($_POST['q4_2']) && is_array($_POST['q4_2'])) {
    $q4_2 = implode("、", $_POST["q4_2"]);
}
if (isset($_POST['q4_3']) && is_array($_POST['q4_3'])) {
    $q4_3 = implode("、", $_POST["q4_3"]);
}
if (isset($_POST['q4_4']) && is_array($_POST['q4_4'])) {
    $q4_4 = implode("、", $_POST["q4_4"]);
}
if (isset($_POST['q4_5']) && is_array($_POST['q4_5'])) {
    $q4_5 = implode("、", $_POST["q4_5"]);
}
$q5 = $_POST['q5'];
$q6 = $_POST['q6'];

//お客様情報
$company = $_POST['company'];
$name = $_POST['name'];
$emailadd = $_POST['email'];
$location = $_POST['location'];
$tel = $_POST['tel'];
$fax = $_POST['fax'];
$despartment = $_POST['despartment'];
$position = $_POST['position'];


$sendgrid = new SendGrid($sendgrid_username,$sendgrid_password, array("turn_off_ssl_verification" => true));
$email    = new SendGrid\Email();
$email->addTo($to)->
       setFrom($from)->
       setFromName("問合せフォーム")->
       setSubject("【WinActor】お客様アンケート")->
       setText("貴社名: $company \r\n名前: $name \r\nEmailアドレス: $emailadd \r\n所在地: $location \r\nTEL: $tel \r\nFAX: $fax \r\n部署名: $despartment \r\nお役職: $position \r\nQuestion1: $q1 \r\nQuestion2: $q2 \r\nQuestion3: $q3 \r\nQuestion4_1: $q4_1 \r\nQuestion4_2: $q4_2 \r\nQuestion4_3: $q4_3 \r\nQuestion4_4: $q4_4 \r\nQuestion4_5: $q4_5 \r\nQuestion5: $q5 \r\nQuestion6: $q6 \r\n")->
       setHtml("<strong>貴社名:</strong> $company<br />　<strong>名前:</strong> $name<br /> <strong>Emailアドレス:</strong> $emailadd<br /> <strong>所在地:</strong> $location<br /> <strong>TEL:</strong> $tel<br /> <strong>FAX:</strong> $fax<br /> <strong>部署名:</strong> $despartment<br /> <strong>お役職:</strong> $position<br /> <strong>Question1:</strong> $q1<br /> <strong>Question2:</strong> $q2<br /> <strong>Question3:</strong> $q3<br /> <strong>Question4_1:</strong> $q4_1<br /> <strong>Question4_2:</strong> $q4_2<br /> <strong>Question4_3:</strong> $q4_3<br /> <strong>Question4_4:</strong> $q4_4<br /> <strong>Question4_5:</strong> $q4_5<br /> <strong>Question5:</strong> $q5<br /> <strong>Question6:</strong> $q6<br />")->
       addCategory('contact');

$response = $sendgrid->send($email);
var_dump($response);

// 正常終了時にthanks.htmlへリダイレクト
header('Location: thanks.html');
exit();