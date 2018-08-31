
<?php
//↓uploadファイルの有り無し確認
if (is_uploaded_file($_FILES["resume"]["tmp_name"])) {
//↓有効なファイルかどうかを検証し、問題なければ名前を変更しアップロード完了
if (move_uploaded_file($_FILES["resume"]["tmp_name"], "files/" . $_FILES["resume"]["name"])) {
chmod("files/" . $_FILES["upfile"]["name"], 0644);   //パーミッション設定
echo $_FILES["resume"]["name"] . "をアップロードしました。";
} else {
echo "ファイルをアップロードできません。";
}
} else {
echo "ファイルが選択されていません。";
}
?>
