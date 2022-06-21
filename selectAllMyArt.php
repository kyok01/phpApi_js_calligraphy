<?php
// CORS permission
if($_SERVER["HTTP_HOST"] == 'localhost'){
    header('Access-Control-Allow-Origin: http://localhost:3000');
    header('Access-Control-Allow-Methods: GET, POST');
    header("Access-Control-Allow-Headers: X-Requested-With");
}

$lid = $_POST["lid"];

include("./library/funcs.php");  //funcs.phpを読み込む（関数群）
$pdo = db_conn();      //DB接続関数


//２．データ登録SQL作成
$stmt   = $pdo->prepare("SELECT * FROM mypage_art WHERE lid=:lid"); //SQLをセット
  $stmt->bindValue(':lid',  $lid,   PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
  $status = $stmt->execute(); //SQLを実行→エラーの場合falseを$statusに代入
  if($status==false) {
    //SQLエラーの場合
    $error = $stmt->errorInfo();
    echo "SQLError:".$error[2];
  }else{
  //SQL成功の場合
    $r = $stmt->fetchAll();
  echo json_encode($r);
}