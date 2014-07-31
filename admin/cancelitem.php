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
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../css/reset.css">
  <link rel="stylesheet" href="../css/style.css">  
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
  <!-- Optional theme -->
  <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
  <!-- Latest compiled and minified JavaScript -->
  <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
  <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <![endif]-->
</head>
<body>

  <div class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="#">受講予約</a>
      </div>
      <div class="collapse navbar-collapse">
        <ul class="nav navbar-nav">
          <li><a href="../index.php">Home</a></li>
          <li class="active"><a href="listview.php">学生一覧</a></li>
	  <li><a href="checkday.php">日付設定</a></li>
	  <li><a href="index.php?mode=destroy">ログオフ</a></li>
	  <li><a href="../docs/admin/_build/html/index.html">マニュアル</a></li>
        </ul>
      </div><!--/.nav-collapse -->
    </div>
  </div>

  <div class="container">
    <div class="col-sm-2">
    </div>
    <div class="col-sm-8">
    <h1 style="margin-top: 60px;">削除確認</h1>

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
    echo '<input type="button" value="一覧へ戻る" onclick="location.href='listview.php'" >';
    echo '</form>';
}        


?>
</div>
    <div class="col-sm-2">
    </div>
      </div>
   <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

</body>
</html>
