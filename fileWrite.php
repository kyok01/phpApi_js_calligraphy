<?php
// CORS permission
if($_SERVER["HTTP_HOST"] == 'localhost'){
    header('Access-Control-Allow-Origin: http://localhost:3000');
    header('Access-Control-Allow-Methods: GET, POST');
    header("Access-Control-Allow-Headers: X-Requested-With");
}

$artId = $_POST["artId"];
$html = $_POST["html"];
$js = $_POST["js"];
$css = $_POST["css"];

// process about directory
$directory_path = "./data/folder{$artId}";

if(file_exists($directory_path)){
    echo "directory exists";
}else{
    if(mkdir($directory_path, 0777)){
        //作成したディレクトリのパーミッションを確実に変更
        chmod($directory_path, 0777);
        echo "you make directory";
    }else{
        //作成に失敗した時の処理
        echo "error about directory";
    }
}


// process about file
$file = fopen("./data/folder{$artId}/sample.html", "w" ); //ファイルOPEN
clearstatcache(); // cashe clear
fwrite( $file, $html); //書込みです
fclose( $file ); //ファイル閉じる

$file = fopen("./data/folder{$artId}/main.js", "w" ); //ファイルOPEN
clearstatcache(); // cashe clear
fwrite( $file, $js); //書込みです
fclose( $file ); //ファイル閉じる

$file = fopen("./data/folder{$artId}/style.css", "w" ); //ファイルOPEN
clearstatcache(); // cashe clear
fwrite( $file, $css); //書込みです
fclose( $file ); //ファイル閉じる

clearstatcache(); // cashe clear
echo $html;
?>