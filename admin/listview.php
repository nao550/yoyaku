<?php
include '../config.php';
include '../class.php';
require_once 'PHPExcel.php';
require_once 'PHPExcel/IOFactory.php';

session_start();

if( empty( $_SESSION['user'] ) or ( $_SESSION['user'] != $ADMINNM )){
    header("Location: index.php");
}


$DayMode = "";
$StartDay = "";
$EndDay = "";

if( isset( $_GET['mode'] )){
   if( $_GET['mode'] == "daychange" ){
       $DayMode = h( $_GET['SetTime'] );
       $StartDay = h( $_GET['StartDay'] );
       $EndDay = h( $_GET['EndDay'] );
       //   } elseif( $_GET['mode'] == "dlexcel" ){
       //       DownLoadExcel();
   }
} else {
    $DayMode = 'AllTime';
}

        
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>管理画面</title>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../css/reset.css">
  <link rel="stylesheet" href="../css/style.css">  
  <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
  <link rel="stylesheet" href="../js/themes/blue/style.css">  
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
  <script type="text/javascript" src="../js/jquery.tablesorter.js"></script>
  <script type="text/javascript" src="../js/addons/pager/jquery.tablesorter.pager.js"></script>

  <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <![endif]-->
  <script type="text/javascript">
    $(document).ready(function(){
            $("#listtable")
                .tablesorter({widthFixed: true, widgets: ['zebra']})
                .tablesorterPager({container: $("#paging")});
    }); 
  </script>


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
          <li class="active"><a href="listview.php">予約一覧</a></li>
          <li><a href="studentlist.php">受講履歴</a></li>
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
      <h1 style="margin-top: 60px;">予約一覧表示</h1>
    </div>
    <div class="col-sm-1">
    </div>
  </div>


  <div class="container">
    <div class="col-sm-2">
    </div>
    <div class="col-sm-8" style="text-align: left;">
    <form action="listview.php" method="GET" name="DayRange" >
    <input type="radio" name="SetTime" value="AllTime" <?php if($DayMode == "AllTime"){ echo "checked"; } ?> />全期間<br />
      <input type="radio" name="SetTime" value="Today"  <?php if($DayMode == "Today"){ echo "checked"; } ?> />本日の予約<br />
      <input type="radio" name="SetTime" value="TimePeriod"  <?php if($DayMode == "TimePeriod"){ echo "checked"; } ?> />範囲指定
      <input type="text" name="StartDay" value="<?php 
if( $DayMode == "TimePeriod" ){
    echo $StartDay;
} else {
    echo date("Y-m-d");
}
?>" />-<input type="text" name="EndDay" value="<?php 
if( $DayMode == "TimePeriod" ){
    echo $EndDay;
} else {
    echo date("Y-m-d",mktime(0,0,0,date("m"),date("d") + 10, date("Y")));
}
?>" /><br />
      <input type="hidden" name="mode" value="daychange" />
      <input type="submit" value="変更" />
    </form>
    </div>
    <div class="col-sm-2">
    </div>
  </div>

  <div class="container">
    <div class="col-sm-1">
    </div>
    <div class="col-sm-10">

<?php
    ScanYoyaku( $DayMode, $StartDay, $EndDay );
?>
      <div id="paging" class="paging" style="float: left;">
	<form>
	  <img src="../js/addons/pager/icons/first.png" class="first"/>
	  <img src="../js/addons/pager/icons/prev.png" class="prev"/>
	  <input type="text" class="pagedisplay"/>
	  <img src="../js/addons/pager/icons/next.png" class="next"/>
	  <img src="../js/addons/pager/icons/last.png" class="last"/>
	  <select class="pagesize">
	    <option value="10">10</option>
	    <option  selected="selected" value="20">20</option>
	    <option value="30">30</option>
	    <option value="40">40</option>
	    <option value="50">50</option>
	  </select>
	</form>
      </div>

    <form action="#" method="GET">
      <input type="hidden" name="mode" value="dlexcel" />
      <input type="submit" value="DL" >
    </form>
      

    </div>
    <div class="col-sm-1" >
    </div>
  </div>

   <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
   <script src="../js/bootstrap.min.js"></script>
   
</body>
</html>



<?php

    function ScanYoyaku( $DayMode = 'AllTime', $StartDay = '', $EndDay = '' ){
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
    echo "    </tbody></table>\n";

    CreatExcel( $result );
}


function CreateExcel(){

    $book = new PHPExcel();
    $book->setActiveSheetIndex(0);
    $sheet = $book->getActiveSheet();
    $sheet->setTitle('list');

    $sheet->setCellValue('A1','hoge');
    $sheet->setCellValue('A2','hage');

    $writer = PHPExcel_IOFactory::createWriter( $book, 'Excel2007');
    $writer->save('./o.xlsx');

}

?>
