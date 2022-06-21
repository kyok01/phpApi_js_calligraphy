<?php
// CORS permission
if($_SERVER["HTTP_HOST"] == 'localhost'){
    header('Access-Control-Allow-Origin: http://localhost:3000');
    header('Access-Control-Allow-Methods: GET, POST');
    header("Access-Control-Allow-Headers: X-Requested-With");
}

$art_id = $_POST["id"];
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
$stmt   = $pdo->prepare("SELECT * FROM art_inival WHERE id=:art_id"); //SQLをセット
  $stmt->bindValue(':art_id',  $art_id,   PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
  $status = $stmt->execute(); //SQLを実行→エラーの場合falseを$statusに代入
  if($status==false) {
    //SQLエラーの場合
    $error = $stmt->errorInfo();
    echo "SQLError:".$error[2];
  }else{
  //SQL成功の場合
    $r = $stmt->fetch(PDO::FETCH_ASSOC);
  $name = $r["name"];
  $ini_html = $r["ini_html"];
  $ini_js = $r["ini_js"];
  $ini_css = $r["ini_css"];
  $tags = $r["tags"];
  $uses = $r["uses"];
  $note = $r["note"];
  echo json_encode($r);
}

// Insert my art into mypage_art table
  $sql = "INSERT INTO mypage_art(lid, art_id,name, ini_html, ini_js, ini_css, tags, uses, note,indate)VALUE(:lid, :art_id, :name, :ini_html, :ini_js, :ini_css, :tags, :uses, :note, sysdate());";
  $stmt = $pdo->prepare($sql);
  $stmt->bindValue(':lid', $lid, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
  $stmt->bindValue(':art_id', $art_id, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
  $stmt->bindValue(':name', $name, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
  $stmt->bindValue(':ini_html', $ini_html, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
  $stmt->bindValue(':ini_js', $ini_js, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
  $stmt->bindValue(':ini_css', $ini_css, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
  $stmt->bindValue(':tags', $tags, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
  $stmt->bindValue(':uses', $uses, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
  $stmt->bindValue(':note', $note, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
  $status = $stmt->execute();
  if($status==false) {
    //SQLエラーの場合
    sql_error($stmt);
  }

  // make files
  // process about directory
$directory_path = "./user/${lid}/folder{$art_id}";

if(file_exists($directory_path)){
    // echo "directory exists";
}else{
    if(mkdir($directory_path, 0777)){
        //作成したディレクトリのパーミッションを確実に変更
        chmod($directory_path, 0777);
        // echo "you make directory";
    }else{
        //作成に失敗した時の処理
        // echo "error about directory";
    }
}


// process about file
$file = fopen("./user/${lid}/folder{$art_id}/sample.html", "w" ); //ファイルOPEN
clearstatcache(); // cashe clear
fwrite( $file, $ini_html); //書込みです
fclose( $file ); //ファイル閉じる

$file = fopen("./user/${lid}/folder{$art_id}/main.js", "w" ); //ファイルOPEN
clearstatcache(); // cashe clear
fwrite( $file, $ini_js); //書込みです
fclose( $file ); //ファイル閉じる

$file = fopen("./user/${lid}/folder{$art_id}/style.css", "w" ); //ファイルOPEN
clearstatcache(); // cashe clear
fwrite( $file, $ini_css); //書込みです
fclose( $file ); //ファイル閉じる

clearstatcache(); // cashe clear
// echo $html;
?>