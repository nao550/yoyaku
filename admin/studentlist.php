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

$mode = "";
$stid = "";
$stday = "";
$edday = "";

if( isset( $_GET['mode'] )){
    if( $_GET['mode'] == "All" ){
        $mode = h( $_GET['mode'] );
    } elseif( $_GET['mode'] == "Period" ){
        $mode = h( $_GET['mode'] );
        $stday = h( $_GET['startday'] );
        $edday = h( $_GET['endday'] );
    } elseif( $_GET['mode'] == "Person" ){
        $mode = h( $_GET['mode'] );
        $stid = h( $_GET['studentid'] );
    }
} else {
   $mode = "All";
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
    <div class="col-sm-3">
    </div>
    <div class="col-sm-6" style="text-align: left;">

      <form action=# method="GET" name="CngMode" >
	<input type="radio" name="mode" value="All" <?php if( $mode == "All" ){ echo "checked"; } ?>>全表示<br />
	<input type="radio" name="mode" value="Period" <?php if( $mode == "Period" ){ echo "checked"; } ?>>期間指定 <input type="text" width="15" name="startday">-<input type="text" width="15" name="endday"><br />
	<input type="radio" name="mode" value="Person" <?php if( $mode == "Person" ){ echo "checked"; } ?>>受講生指定<input type="text" width="15" name="studentid" ><br />
	<input type="submit" value="変更" >
      </form>
      <?php echo $mode; ?>
    </div>
    <div class="col-sm-3">
    </div>
  </div>

  <div class="container">
    <div class="col-sm-2">
    </div>
    <div class="col-sm-8">
      <table class="table table-bordered">
	<thead>
	  <tr><th></th><th>学籍場号</th><th>名前</th><th>日付</th><th>時限</th></tr>
	</thead>
	<?php Stlistv( $mode, $stid, $stday, $edday); ?>
	<tbody>
	</tbody>
      </table>

    </div>
    <div class="col-sm-2">
    </div>
  </div>    

      
  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
</body>
</html>

<?php

function Stlistv( $mode, $stid="", $stday="", $edday="" ){
    global $DBSV, $DBUSER , $DBPASS , $DBNM, $MAXROWS;

    $mysql = new mysqli( "localhost", $DBUSER, $DBPASS, $DBNM );
    if( $mysql->connect_errno ){
        printf( "Connect failed: %s\n", $mysql->connect_error );
        exit();
    }

    if( $DayMode == "AllTime" ){
        $sql = "select cd, date, class, studentid, studentnm from yoyaku order by date, class;";
    } elseif( $DayMode == "Today" ){
        $sql = "select cd, date, class, studentid, studentnm from yoyaku where date = DATE(NOW()) order by date, class;";
    } elseif( $DayMode == "TimePeriod" ){
        $EndDay = $EndDay; // $EndDay にプラス1日する
        $sql = "select cd, date, class, studentid, studentnm from yoyaku where date >='$StartDay' and date <= '$EndDay' order by date, class;";        
    } 

    echo "<!-- $sql -->";
    $result = $mysql->query( $sql );

    echo '    <table id="listtable" class="tablesorter" cellspacing="1"><thead>';   echo "\n";
    echo '      <tr><th>日付</th><th>時限</th><th>学籍番号</th><th>氏名</th><th></th></tr>'; echo "\n</thead><tbody>";

    if( $result->num_rows != NULL ){
        while ( $row = $result->fetch_assoc()){
            printf("<tr>");
            printf("<td>%s</td><td>%d</td><td>%s</td><td>%s</td><td>\n",
                   $row['date'], $row['class'], $row['studentid'], $row['studentnm']);       
            printf('         <a href="cancelitem.php?mode=del&cd=' . $row['cd'] . '&date=' . $row['date'] . '&class=' . $row['class'] . '&id=' . $row['studentid'] . '&nm=' . $row['studentnm'] . '"><input class="btn btn-xs btn-default" type="submit" value="削除" /></a></td></tr>' . "\n");
            printf('       </form>' . "\n");
        } 
   }
   
}

?>
