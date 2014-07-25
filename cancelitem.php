<?php
include 'config.php';
include 'class.php';

if( isset( $_GET )){
    $date = h( $_GET['date'] );
    $class = h( $_GET['class'] );
    $id = h( $_GET['studentid'] );
    $nm = h( $_GET['studentnm'] );
} else {
    heder('Location: index.php');
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>予約キャンセル</title>
  <meta name="viewport" content="width=device-width">
  <link rel="stylesheet" href="css/reset.css">
  <link rel="stylesheet" href="css/style.css">  
</head>
<body>

<?php

$yoyaku = new YOYAKU();
if( $yoyaku->ischk( $date, $class, $id, $nm ) === 0 ){
    echo $date . "<br />" . $class ."時限<br />学籍番号：" . $id . "<br />名前：" . $nm . "<br />の予約はありません。<br />";
    echo "<a href=\"index.php\">トップへ</a>";
} else {
    $yoyaku->del( $date, $class, $id, $nm );
    echo $date . "<br />" . $class ."時限<br />学籍番号：" . $id . "<br />名前：" . $nm . "<br />の予約を削除しました。<br />";
    echo "<a href=\"index.php\">トップへ</a>";
}
                                        


?>



</body>
</html>