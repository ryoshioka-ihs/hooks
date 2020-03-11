<?php
require 'vendor/autoload.php';
Dotenv::load(__DIR__);

$sendgrid_password = $_ENV['SENDGRID_PASSWORD'];
$sendgrid_username = $_ENV['SENDGRID_USERNAME'];
$from              = $_ENV['FROM'];
$to                = $_ENV['TO'];



//お客様情報
$company = $_POST['company'];//貴社名
$department = $_POST['department'];//部署名
$position = $_POST['position'];//職位
$name1 = $_POST['name1'];//姓
$name2 = $_POST['name2'];//名
$phone = $_POST['phone'];//電話番号
$emailAdd = $_POST['emailAdd'];//メールアドレス
$zip = $_POST['zip'];//郵便番号
$prefectures = $_POST['prefectures'];//都道府県
$address = $_POST['address'];//市区町村
$build = $_POST['build'];//ビル名
$book = $_POST['book'];//（本）RPAの威力
$seminar = $_POST['seminar'];//（セミナー）「RPA導入前！導入成功のカギを握る業務把握等の進め方セミナー」(有償版)
$tool = $_POST['tool'];//（ツール）xoBlos
$check = $_POST['check'];// 個人情報の取扱





//ユーザーへ送信するメール
$sendgrid = new SendGrid($sendgrid_username,$sendgrid_password, array("turn_off_ssl_verification" => true));
$email    = new SendGrid\Email();
$email->addTo($emailAdd)->
       setFrom($from)->
       setFromName("IIMヒューマン・ソリューション株式会社")->
       setSubject("【IHS】プレゼントのご希望承りました。" )->
       setText(" 
              $name1 $name2 様\r\n\r\n
              この度は、COMPUS2018へご参加いただきまして、誠にありがとうございました。\r\n
              また、本フォームへのご入力いただきまして、誠にありがとうございました。\r\n
              下記の内容で、受付けました。\r\n\r\n
              ＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝\r\n
              貴社名: $company \r\n 
              部署名: $department \r\n 
              お役職: $position \r\n 
              お名前: $name1 $name2 様 \r\n 
              電話番号: $phone \r\n 
              メールアドレス: $emailAdd \r\n 
              〒: $zip \r\n 
              都道府県： $prefectures \r\n 
              市区町村： $address $build \r\n 
              ご希望のプレゼント:\r\n
               $book ：［本］RPAの威力 \r\n
               $seminar ：［セミナー］「RPA導入前！導入成功のカギを握る業務把握等の進め方セミナー」(有償版) \r\n 
               $tool ：［RPA業務効率化ツール］xoBlos/xoBot セミナー&試用版 \r\n 
              ＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝\r\n
              ※このメールは自動送信です。\r\n 
              何かございましたらweb@iimhs.co.jpまでお問い合わせください。")->


       setHtml("
              $name1 $name2 様<br /><br />
              この度は、COMPUS2018へご参加いただきまして、誠にありがとうございました。<br />
              また、本フォームへのご入力いただきまして、誠にありがとうございました。<br />
              下記の内容で、受付けました。<br /><br />
              ＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝<br />
              貴社名: $company <br /> 
              部署名: $department <br /> 
              お役職: $position <br /> 
              お名前: $name1 $name2 様 <br /> 
              電話番号: $phone <br /> 
              メールアドレス: $emailAdd <br /> 
              〒: $zip <br /> 
              都道府県： $prefectures <br /> 
              市区町村： $address $build <br /> 
              ご希望のプレゼント:<br />
               $book ：［本］RPAの威力 <br />
               $seminar ：［セミナー］「RPA導入前！導入成功のカギを握る業務把握等の進め方セミナー」(有償版) <br /> 
               $tool ：［［RPA業務効率化ツール］xoBlos/xoBot セミナー&試用版 <br /> 
              ＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝<br />
              ※このメールは自動送信です。<br /> 
              何かございましたらweb@iimhs.co.jpまでお問い合わせください。")->
       addCategory('contact');

$response = $sendgrid->send($email);
var_dump($response);


//管理者へ送信するメール
$sendgrid = new SendGrid($sendgrid_username,$sendgrid_password, array("turn_off_ssl_verification" => true));
$email    = new SendGrid\Email();
$email->addTo($to)->
       setFrom($from)->
       setFromName("")->
       setSubject("【COMPUS2018】プレゼントお申込み" )->
       setText("
       		COMPUS2018のプレゼントフォームへお申込みがありました。\r\n
       	      ＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝\r\n
              貴社名: $company \r\n 
              部署名: $department \r\n 
              お役職: $position \r\n 
              お名前: $name1 $name2 様 \r\n 
              電話番号: $phone \r\n 
              メールアドレス: $emailAdd \r\n 
              〒: $zip \r\n 
              都道府県： $prefectures \r\n 
              市区町村： $address $build \r\n 
              ご希望のプレゼント:\r\n
               $book ：［本］RPAの威力 \r\n
               $seminar ：［セミナー］「RPA導入前！導入成功のカギを握る業務把握等の進め方セミナー」(有償版) \r\n 
               $tool ：［RPA業務効率化ツール］xoBlos/xoBot セミナー&試用版 \r\n 
              ＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝\r\n")->


       setHtml("
       	COMPUS2018のプレゼントフォームへお申込みがありました。<br />
       	      ＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝<br />
              貴社名: $company <br /> 
              部署名: $department <br /> 
              お役職: $position <br /> 
              お名前: $name1 $name2 様 <br /> 
              電話番号: $phone <br /> 
              メールアドレス: $emailAdd <br /> 
              〒: $zip <br /> 
              都道府県： $prefectures <br /> 
              市区町村： $address $build <br /> 
              ご希望のプレゼント:<br />
               $book ：［本］RPAの威力 <br />
               $seminar ：［セミナー］「RPA導入前！導入成功のカギを握る業務把握等の進め方セミナー」(有償版) <br /> 
               $tool ：［RPA業務効率化ツール］xoBlos/xoBot セミナー&試用版 <br /> 
              ＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝<br />")->
       addCategory('contact');

$response = $sendgrid->send($email);
var_dump($response);

// 正常終了時にthanks.htmlへリダイレクト
header('Location: /compus2018/form/thanks.html');
exit();

