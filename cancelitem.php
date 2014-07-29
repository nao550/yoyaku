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
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/reset.css">
  <link rel="stylesheet" href="css/style.css">  
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
          <li class="active"><a href="index.php">Home</a></li>
          <li><a href="./docs/user/_build/html/user_manual.html" target="_blank">マニュアル</a></li>
        </ul>
      </div><!--/.nav-collapse -->
    </div>
  </div>

  <div class="container">
    <div class="col-sm-2">
    </div>
    <div class="col-sm-8">
      <div class="starter-template">
	<h1 style="margin-top: 60px;">
    予約キャンセル</h1>

<?php

$yoyaku = new YOYAKU();
if( $yoyaku->ischk( $date, $class, $id, $nm ) === 0 ){
    echo $date . "<br />" . $class ."時限<br />学籍番号：" . $id . "<br />名前：" . $nm . "<br />の予約はありません。<br />";
    echo '<a href="index.php"><button type="button" class="btn btn-default">トップ</button></a>';
} else {
    $yoyaku->del( $date, $class, $id, $nm );
    echo $date . "<br />" . $class ."時限<br />学籍番号：" . $id . "<br />名前：" . $nm . "<br />の予約を削除しました。<br />";
    echo '<a href="index.php"><button type="button" class="btn btn-default">トップ</button></a>';
}
                                        


?>

    <div class="col-sm-2">
    </div>
  </div>
   <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

</body>
</html>