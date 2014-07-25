<?php
include '../config.php';
include '../class.php';
include 'admin_func.php';

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
  <meta name="viewport" content="width=device-width">
  <link rel="stylesheet" href="../css/reset.css">
  <link rel="stylesheet" href="../css/style.css">  
</head>
<body>

<?php admin_menu_ul(); ?>

<h1>予約可能日設定</h1>

    <div id="caltitle">
      <div id="caltitle_l">
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

      <div id="caltitle_c">
<?php
   $nowmonth = date("Y年m月", $month);
   echo $nowmonth;
?>
      </div>

      <div id="caltitle_r">
<?php
   $nextmonth = mktime(0, 0, 0, date("m",$month) +1, date("d", $month), date("Y",$month));
   $next = date("Y年m月", $nextmonth);
   echo '<a href="checkday.php?month=' . $nextmonth . '">' . $next .'</a>';
?>
      </div>
    </div>

<?php chk_calender( $month ); ?>
    
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
