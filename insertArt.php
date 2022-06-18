<?php
// CORS permission
if($_SERVER["HTTP_HOST"] == 'localhost'){
    header('Access-Control-Allow-Origin: http://localhost:3000');
    header('Access-Control-Allow-Methods: GET, POST');
    header("Access-Control-Allow-Headers: X-Requested-With");
}

$name = $_POST["artName"];
$ini_html = $_POST["iniHtml"];
$ini_js = $_POST["iniJs"];
$ini_css = $_POST["iniCss"];
$tags = $_POST["tags"];
$uses = $_POST["uses"];
$note = $_POST["note"];


//*** 外部ファイルを読み込む ***
include("./library/funcs.php");
$pdo = db_conn();

//３．データ登録SQL作成
$stmt = $pdo->prepare("INSERT INTO art_iniVal(name, ini_html, ini_js, ini_css, tags, uses, note, indate)VALUES(:name, :ini_html, :ini_js, :ini_css, :tags, :uses, :note, sysdate())");
$stmt->bindValue(':name',  $name,   PDO::PARAM_STR);
$stmt->bindValue(':ini_html', $ini_html,  PDO::PARAM_STR);  
$stmt->bindValue(':ini_js', $ini_js,  PDO::PARAM_STR);  
$stmt->bindValue(':ini_css', $ini_css,  PDO::PARAM_STR);  
$stmt->bindValue(':tags', $tags,  PDO::PARAM_STR);  
$stmt->bindValue(':uses', $uses,  PDO::PARAM_STR);  
$stmt->bindValue(':note', $note,  PDO::PARAM_STR);  
$status = $stmt->execute(); //実行

//４．データ登録処理後
if($status==false){
    //*** function化を使う！*****************
    sql_error($stmt);
}else{
    //*** function化を使う！*****************
    $res = $pdo->lastInsertId();
    echo $res;
}