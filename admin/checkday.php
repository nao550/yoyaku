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
  <title>予約可能日設定</title>
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
          <li><a href="listview.php">学生一覧</a></li>
	  <li class="active"><a href="checkday.php">日付設定</a></li>
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
      <h1 style="margin-top: 60px;" >予約可能日設定</h1>
    </div>
    <div class="col-sm-1">
    </div>
  </div>

  <div class="container">
    <div class="col-sm-1">
    </div>
    <div class="col-sm-3" style="text-align; left;">

<?php
       $lastmonth = mktime(0, 0, 0, date("m",$month) -1, date("d", $month), date("Y",$month));
       $last = date("Y年m月", $lastmonth);
   if( $month > time() ){ 
       echo '<a href="checkday.php?month=' . $lastmonth . '">' . $last. '</a>';
   } else {
       echo $last;
   }
?>
    </div>
    <div class="col-sm-4">

<?php
   $nowmonth = date("Y年m月", $month);
   echo $nowmonth;
?>
    </div>
    <div class="col-sm-3">

<?php
   $nextmonth = mktime(0, 0, 0, date("m",$month) +1, date("d", $month), date("Y",$month));
   $next = date("Y年m月", $nextmonth);
   echo '<a href="checkday.php?month=' . $nextmonth . '">' . $next .'</a>';
?>
    </div>
    <div class="col-sm-1">
    </div>
  </div>

  <div class="container">
    <div class="col-sm-1">
    </div>
    <div class="col-sm-10">

      <?php chk_calender( $month ); ?>

    </div>
    <div class="col-sm-1">
    </div>
  </div>
      
  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
</body>
</html>


<?php
function chk_calender( $month = ""){

    if ( $month == ""){
        $ymd = date("Y-m-01");
    } else {
        $ymd = date("Y-m", $month) . "-01";
    }

    //開始日のタイムスタンプ
    $s = strtotime($ymd);
    //日付リストを作る
    $data = array();
    for ($t = $s; date('m', $t) == date('m', $s); $t += 60*60*24) {
        $data[] = $t;
    }
    //先頭の日の曜日を見て前に余白を追加
    if (date('w', $data[0]) > 0) {
        $data = array_merge(array_fill(0, date('w', $data[0]), ''), $data);
    }
    //末尾の日の曜日を見て後ろに余白を追加
    if (date('w', end($data)) < 6) {
        $data = array_merge($data, array_fill(0, 6 - date('w', end($data)), ''));
    }
    //7で割る
    $data = array_chunk($data, 7);
 
    //以上でデータは出来上がった
 
    //カレンダーを表示する
    echo '<table id="yoyakucal">';
    //見出し
    echo '<tr><th>日</th><th>月</th><th>火</th><th>水</th><th>木</th><th>金</th><th>土</th></tr>' ;
    echo "\n";
    //週のループ
    foreach ($data as $week) {
        echo "<tr>\n";
        //週の中の日のループ
        foreach ($week as $date) {
            if ($date) {
                echo '<td><!--' . date('Y-m-d',$date) . '--><strong>' . date('j', $date) . "</strong><br />" . chk_day( date('Y-m-d',$date), $month ) . "</td>\n";
            } else {
                echo '<td>&#160;</td>';
                echo "\n";
            }
        }
        echo "</tr>\n";
    }
    echo '</table>';
}

function chk_day( $date, $month ){

    switch( chk_day_mode( $date )){
    case '1':
        $s = "<a href=\"checkday.php?mode=dateon&date=" . $date . "&month=" . $month . "\">×</a>";
        break;
    case '2':
        $s = "<a href=\"checkday.php?mode=dateoff&date=" . $date . "&month=" . $month . "\">○</a>";
        break;
    case '3':
        $s = "<a href=\"checkday.php?mode=addoff&date=" . $date . "&month=" . $month . "\">○</a>";
        break;
    case '4':
        $s = "<a href=\"checkday.php?mode=addon&date=" . $date . "&month=" . $month .  "\">×</a>";
        break;
    }
    return $s;
}

function dateon( $date ){
    global $DBSV, $DBUSER, $DBPASS, $DBNM, $CHK_DATE_MODE;

   $mysql = new mysqli( "localhost", $DBUSER, $DBPASS, $DBNM );
   $sql = sprintf("update yoyaku_day set flag='1' where date='%s'", $mysql->real_escape_string( $date ));
   if( $mysql->connect_errno ){
       printf( "Connect failed: %s\n", $mysql->connect_error );
       exit();
   }
   $mysql->query( $sql );
}

function dateoff( $date ){
    global $DBSV, $DBUSER, $DBPASS, $DBNM, $CHK_DATE_MODE;

   $mysql = new mysqli( "localhost", $DBUSER, $DBPASS, $DBNM );
   $sql = sprintf("update yoyaku_day set flag='0' where date='%s'", $mysql->real_escape_string( $date ));
   if( $mysql->connect_errno ){
       printf( "Connect failed: %s\n", $mysql->connect_error );
       exit();
   }
   $mysql->query( $sql );
}

function addon( $date ){
    global $DBSV, $DBUSER, $DBPASS, $DBNM, $CHK_DATE_MODE;

   $mysql = new mysqli( "localhost", $DBUSER, $DBPASS, $DBNM );
   $sql = sprintf("insert into yoyaku_day ( flag, date ) value ( '1', '%s' )", $mysql->real_escape_string( $date ));
   if( $mysql->connect_errno ){
       printf( "Connect failed: %s\n", $mysql->connect_error );
       exit();
   }
   $mysql->query( $sql );
}

function addoff( $date ){
    global $DBSV, $DBUSER, $DBPASS, $DBNM, $CHK_DATE_MODE;

   $mysql = new mysqli( "localhost", $DBUSER, $DBPASS, $DBNM );
   $sql = sprintf("insert into yoyaku_day ( flag, date ) value ( '0', '%s' )", $mysql->real_escape_string( $date ));

   if( $mysql->connect_errno ){
       printf( "Connect failed: %s\n", $mysql->connect_error );
       exit();
   }
   $mysql->query( $sql );
}



?>
