<?php
// CORS permission
if($_SERVER["HTTP_HOST"] == 'localhost'){
    header('Access-Control-Allow-Origin: http://localhost:3000');
    header('Access-Control-Allow-Methods: GET, POST');
    header("Access-Control-Allow-Headers: X-Requested-With");
}

$msg = $_POST["html"];
$file = fopen("./data/test.html", "w" ); //ファイルOPEN
fwrite( $file, $msg); //書込みです
fclose( $file ); //ファイル閉じる
echo $msg;
?>