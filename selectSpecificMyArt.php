<?php
// CORS permission
if($_SERVER["HTTP_HOST"] == 'localhost'){
    header('Access-Control-Allow-Origin: http://localhost:3000');
    header('Access-Control-Allow-Methods: GET, POST');
    header("Access-Control-Allow-Headers: X-Requested-With");
}

$lid = $_POST["lid"];
$keyword = $_POST["keyword"];

include("./library/funcs.php");  //funcs.phpを読み込む（関数群）
$pdo = db_conn();      //DB接続関数


//２．データ登録SQL作成
$stmt = $pdo->prepare("SELECT * FROM mypage_art WHERE lid=:lid AND name LIKE :keyword");
$stmt->bindValue(":lid", $lid, PDO::PARAM_STR);
$stmt->bindValue(":keyword", '%'.$keyword.'%', PDO::PARAM_STR);
$status = $stmt->execute();

//３．データ表示
if($status==false) {
  sql_error($stmt);
}else{
  $r = $stmt->fetchAll(); 
echo json_encode($r);
}