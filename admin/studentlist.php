<?php
include '../config.php';
include '../class.php';

session_start();

if( empty( $_SESSION['user'] )){
    header("Location: index.php");
}

if( isset( $_SESSION['user'])){
    if( $_SESSION['user'] != $ADMINNM ){
        header("Location: index.php");
    }
}

if( isset( $_GET['month'] )){
    $month = h( $_GET['month'] );
} else {
    $month = time();
}

if( isset( $_GET['mode'] )){
    if( $_GET['mode'] == "dateon" ){
        dateon( h( $_GET['date'] ));
    } elseif( $_GET['mode'] == "dateoff" ){
        dateoff( h( $_GET['date'] ));
    } elseif( $_GET['mode'] == "addon" ){
        addon( h( $_GET['date'] ));
    } elseif( $_GET['mode'] == "addoff" ){
        addoff( h($_GET['date'] ));
    }
}


?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>受講履歴確認</title>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../css/reset.css">
  <link rel="stylesheet" href="../css/style.css">  
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
  <!-- Optional theme -->
  <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
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
          <li><a href="listview.php">予約一覧</a></li>
          <li class="active"><a href="studentlist.php">受講履歴</a></li>
	  <li><a href="checkday.php">日付設定</a></li>
	  <li><a href="index.php?mode=destroy">ログオフ</a></li>
	  <li><a href="../docs/admin/_build/html/index.html">マニュアル</a></li>
        </ul>
      </div><!--/.nav-collapse -->
    </div>
  </div>
  
  <div class="container">
    <div class="col-sm-1">
    </div>
    <div class="col-sm-10">
      <h1 style="margin-top: 60px;" >受講履歴一覧</h1>
    </div>
    <div class="col-sm-1">
    </div>
  </div>


  <div class="container">
    <div class="col-sm-1">
    </div>
    <div class="col-sm-10">


    </div>
    <div class="col-sm-1">
    </div>
  </div>
      
  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
</body>
</html>

