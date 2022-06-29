<?php
// CORS permission
if($_SERVER["HTTP_HOST"] == 'localhost'){
    header('Access-Control-Allow-Origin: http://localhost:3000');
    header('Access-Control-Allow-Methods: GET, POST');
    header("Access-Control-Allow-Headers: X-Requested-With");
}

$artId = $_POST["artId"];
$lid = $_POST["lid"];
$html = $_POST["html"];
$js = $_POST["js"];
$css = $_POST["css"];


$showErrorScript = <<<EOF
window.onerror = function (e) {
    let errorEle = document.createElement("div");
    errorEle.id = "errorStr";
    errorEle.append("Error:"+e);
    document.querySelector("body").append(errorEle);
    const redirectSERP = () => {
        window.open("https://www.google.co.jp/search?site=&source=hp&q="+e , '_blank')
    }
    errorEle.addEventListener("click", redirectSERP);
    let errorStl = errorEle.style;
    errorStl.position = "fixed";
    errorStl.bottom = "0px";
    errorStl.zIndex = "9999";
    errorStl.width = "100%";
    errorStl.padding = "25px";
    errorStl.background = "red";
    errorStl.color = "white";
    errorStl.cursor = "pointer";
}


EOF;

// process about directory
$directory_path = "./user/${lid}/folder{$artId}";

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
$file = fopen("./user/${lid}/folder{$artId}/sample.html", "w" ); //ファイルOPEN
clearstatcache(); // cashe clear
fwrite( $file, $html); //書込みです
fclose( $file ); //ファイル閉じる

$file = fopen("./user/${lid}/folder{$artId}/main.js", "w" ); //ファイルOPEN
clearstatcache(); // cashe clear
fwrite( $file, $showErrorScript.$js); //書込みです
fclose( $file ); //ファイル閉じる

$file = fopen("./user/${lid}/folder{$artId}/style.css", "w" ); //ファイルOPEN
clearstatcache(); // cashe clear
fwrite( $file, $css); //書込みです
fclose( $file ); //ファイル閉じる

clearstatcache(); // cashe clear
echo $html;
?>