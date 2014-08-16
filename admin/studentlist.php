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

$Mode = "";
$StartDay = "";
$EndDay = "";
$StudentId = "";

if( isset( $_GET['mode'] )){
    if( $_GET['mode'] == "All" ){
        $Mode = h( $_GET['mode'] );
    } elseif( $_GET['mode'] == "Period" ){
        $Mode = h( $_GET['mode'] );
        $StartDay = h( $_GET['startday'] );
        $EndDay = h( $_GET['endday'] );
    } elseif( $_GET['mode'] == "Person" ){
        $Mode = h( $_GET['mode'] );
        $StudentId = h( $_GET['studentid'] );
    }
} else {
   $Mode = "All";
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
	<input type="radio" name="mode" value="All" <?php if( $Mode == "All" ){ echo "checked"; } ?>>全表示<br />
	<input type="radio" name="mode" value="Period" <?php if( $Mode == "Period" ){ echo "checked"; } ?>>期間指定 <input type="text" width="15" name="startday" value="<?php
if( $Mode == 'Period' ){
    echo $StartDay ;
} else {
    echo date("Y-m-d");
}
?>
">-<input type="text" width="15" name="endday" value="<?php
if( $Mode == 'Period' ){
    echo $EndDay;
} else {
    echo date("Y-m-d",mktime(0,0,0,date("m"),date("d") + 10, date("Y")));
}
?>
"><br />
	<input type="radio" name="mode" value="Person" <?php if( $Mode == "Person" ){ echo "checked"; } ?>>学籍番号指定<input type="text" width="15" name="studentid" value="<?php
if( $Mode == 'Person' ){
    echo $StudentId;
}
?>"><br />
	<input type="submit" value="変更" >
      </form>
      <?php echo '<!--'. $Mode . "-->\n"; ?>
    </div>
    <div class="col-sm-3">
    </div>
  </div>

  <div class="container">
    <div class="col-sm-2">
    </div>
    <div class="col-sm-8">
      <table id="listtable" class="tablesorter" cellspacing="1">
	<thead>
	  <tr><th>学籍場号</th><th>名前</th><th>日付</th><th>時限</th></tr>
	</thead>
	<?php Stlistv( $Mode, $StudentId, $StartDay, $EndDay ); ?>
	<tbody>
	</tbody>
      </table>

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

    </div>
    <div class="col-sm-2">
    </div>
  </div>    

      
    <script src="../js/bootstrap.min.js"></script>
</body>
</html>

<?php

function Stlistv( $Mode, $StudentId="", $StartDay="", $EndDay="" ){
    global $DBSV, $DBUSER , $DBPASS , $DBNM, $MAXROWS;

    $mysql = new mysqli( "localhost", $DBUSER, $DBPASS, $DBNM );
    if( $mysql->connect_errno ){
        printf( "Connect failed: %s\n", $mysql->connect_error );
        exit();
    }

    if( $Mode == "All" ){
        $sql = "select cd, date, class, studentid, studentnm from yoyaku order by date, class;";
    } elseif( $Mode == "Period" ){
        $sql = "select cd, date, class, studentid, studentnm from yoyaku where date >='$StartDay' and date <= '$EndDay' order by date, class;";        
    } elseif( $Mode == "Person" ){
        $sql = "select cd, date, class, studentid, studentnm from yoyaku where studentid = '$StudentId' order by date, class;";
    } 

    echo "<!-- $sql -->";
    $result = $mysql->query( $sql );

    if( $result->num_rows != NULL ){
        while ( $row = $result->fetch_assoc()){
            printf("<tr>");
            printf("<td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>\n",
                   $row['studentid'], $row['studentnm'], $row['date'], $row['class']);       
        } 
   }
   
}

?>
