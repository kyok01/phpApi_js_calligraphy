<?php
// CORS permission
if($_SERVER["HTTP_HOST"] == 'localhost'){
    header('Access-Control-Allow-Origin: http://localhost:3000');
    header('Access-Control-Allow-Methods: GET, POST');
    header("Access-Control-Allow-Headers: X-Requested-With");
}

$art_id = $_POST["art_id"];
$lid = $_POST["lid"];
$ini_html = "";
$ini_js = "";
$ini_css = "";
$tags = "";
$uses = "";
$note = "";

include("./library/funcs.php");  //funcs.phpを読み込む（関数群）
$pdo = db_conn();      //DB接続関数

//２．データ登録SQL作成
$stmt   = $pdo->prepare("SELECT * FROM mypage_art WHERE art_id=:art_id AND lid=:lid"); //SQLをセット
$stmt->bindValue(':art_id',  $art_id,   PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':lid',  $lid,   PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute(); //SQLを実行→エラーの場合falseを$statusに代入

//３．データ表示
if($status==false) {
  //SQLエラーの場合
  selectOriginalArt();
}else{
  //SQL成功の場合
  $r = $stmt->fetch();
  echo json_encode($r);
}

function selectOriginalArt() {
  $stmt2   = $pdo->prepare("SELECT * FROM art_inival WHERE id=:art_id"); //SQLをセット
  $stmt2->bindValue(':art_id',  $art_id,   PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
  $status2 = $stmt2->execute(); //SQLを実行→エラーの場合falseを$statusに代入
  if($status2==false) {
    //SQLエラーの場合
    $error = $stmt2->errorInfo();
    echo "SQLError:".$error[2];
  }else{
  //SQL成功の場合
    $r = $stmt2->fetch();
  // $ini_html = $r->ini_html;
  // $ini_js = $r->ini_js;
  // $ini_css = $r->ini_css;
  // $tags = $r->tags;
  // $uses = $r->uses;
  // $note = $r->note;
  // insertMyArt();
  echo json_encode($r);
}
}

// function insertMyArt() {
//   $sql = "INSERT INTO mypage_art(lid, art_id,name, ini_html, ini_js, ini_css, tags, uses, note,indate)VALUE(:lid, :art_id, :name, :ini_html, :ini_js, :ini_css, :tags, :uses, :note, sysdate());";
//   $stmt = $pdo->prepare($sql);
//   $stmt->bindValue(':lid', $lid, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
//   $stmt->bindValue(':art_id', $art_id, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
//   $stmt->bindValue(':name', $name, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
//   $stmt->bindValue(':ini_html', $ini_html, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
//   $stmt->bindValue(':ini_js', $ini_js, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
//   $stmt->bindValue(':ini_css', $ini_css, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
//   $stmt->bindValue(':tags', $tags, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
//   $stmt->bindValue(':uses', $uses, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
//   $stmt->bindValue(':note', $note, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
//   $status = $stmt->execute();
//   if($status==false) {
//     //SQLエラーの場合
//     sql_error($stmt);
//   }
// }