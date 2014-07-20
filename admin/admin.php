<?php
session_start();

include '../config.php';
include '../class.php';

?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>管理画面</title>
  <meta name="viewport" content="width=device-width">
  <link rel="stylesheet" href="../css/reset.css">
  <link rel="stylesheet" href="../css/style.css">  
</head>
<body>
<h1>学生一覧表示</h1>

    <?php 
    if ( !isset( $_SESSION['user'] )){
        $mode = 'nologin';  // 初回表示
        DispLogin( $mode );
    }

if( $_SESSION['check'] == 'ok' ){
    echo 'session ok <br >';
    ScanyoYaku(); 
} elseif( $_SESSION['check'] == 'ng' ){
    $mode = 'ng';  // ログインフェイル
    DispLogin( $mode );
}

session_write_close();;
?>

</body>
</html>

<?php

function DispLogin( $mode ){
    echo $mode;
  }

function ScanYoyaku(){
    echo "ScanYoyakku\n";
}

?>