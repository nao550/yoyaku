<?php
include '../config.php';
include '../class.php';

session_start();

if( empty( $_SESSION['user'] ) or ( $_SESSION['user'] != $ADMINNM )){
    header("Location: index.php");
}

if( isset( $_GET['mode'] )){
    $mode = h( $_GET['mode'] );
    $date = h( $_GET['date'] );
    $class = h( $_GET['class'] );
    $id = h( $_GET['id'] );
    $nm = h( $_GET['nm'] );
    if( $_GET['mode'] == 'delitem' ){
        $yoyaku = new YOYAKU();
        $yoyaku->del( $date, $class, $id, $nm );
    }
} else {
    //    heder('Location: listview.php');
    echo 'not get mode set';
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

<h1>削除確認</h1>

<form action="cancelitem.php" method="GET" >
  <input type="text" name="date" size="15" value="<?php echo $date ?>" readonly /><br />
  <input type="text" name="class" size="2" value="<?php echo $class ?>" readonly />時限<br />
  学籍番号：<input type="text" name="id" value="<?php echo $id ?>" readonly /><br />
   氏名：<input type="text" name="nm" value="<?php echo $nm ?>" readonly /><br />
    <input type="hidden" name="mode" value="delitem" >
<?php


if( isset( $mode ) && $mode == "del" ){
    $yoyaku = new YOYAKU();
    if( $yoyaku->ischk( $date, $class, $id, $nm ) === 0 ){
        echo "指定された予約はありません。<br />";
        echo '<a href="listview.php"><input type="button" value="一覧へ戻る" ></a>';
    } else {
        echo "表示されている予約を削除しますか？<br />";
        echo '<input type="submit" value="予約削除"><a href="listview.php"><input type="button" value="戻る"></a>';
    }
} elseif( $mode == "delitem" ){
    echo "削除されました。<br />";
    echo '<a href="listview.php"><input type="button" value="一覧へ戻る" ></a>';
    echo '</form>';
}        


?>

</body>
</html>
