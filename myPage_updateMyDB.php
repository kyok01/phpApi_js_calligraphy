<?php
// CORS permission
if($_SERVER["HTTP_HOST"] == 'localhost'){
    header('Access-Control-Allow-Origin: http://localhost:3000');
    header('Access-Control-Allow-Methods: GET, POST');
    header("Access-Control-Allow-Headers: X-Requested-With");
}

$art_id = $_POST["artId"];
$lid = $_POST["lid"];
$html = $_POST["html"];
$js = $_POST["js"];
$css = $_POST["css"];

include("./library/funcs.php");  //funcs.phpを読み込む（関数群）
$pdo = db_conn();      //DB接続関数

//２．データ登録SQL作成
$stmt   = $pdo->prepare("UPDATE mypage_art SET ini_html=:html,ini_js=:js, ini_css=:css WHERE art_id=:art_id AND lid=:lid"); //SQLをセット
$stmt->bindValue(':art_id',  $art_id,   PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':lid',  $lid,   PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':html',  $html,   PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':js',  $js,   PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':css',  $css,   PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute(); //SQLを実行→エラーの場合falseを$statusに代入

//３．データ表示
if($status==false) {
  //SQLエラーの場合
  sql_error($stmt);
}else{
  //SQL成功の場合
  echo "success";
}
