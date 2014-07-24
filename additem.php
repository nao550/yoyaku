<?php
include 'config.php';
include 'class.php';

if( isset( $_POST['mode'] )){
   add_yoyaku( $_POST );
}

if(! isset( $_GET['date'] )){
    header( 'Location: index.php' );
} else {
    $date = $_GET['date'];
    $class = $_GET['class'];
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>講座予約</title>
  <link rel="stylesheet" href="default.css" name="display">
  <meta name="viewport" content="width=device-width">
  <link rel="stylesheet" href="css/reset.css">
  <link rel="stylesheet" href="css/style.css">  
  <script type="text/javascript">
    <!--
	function submit_click(){
	    var DATE = document.forms.yoyaku_admit.date_p.value;
	    var CLASS = document.forms.yoyaku_admit.classtime.value;
        var YOYAKUNUM = document.forms.yoyaku_admit.yoyakunum.value;
        var YOYAKUMAX = document.forms.yoyaku_admit.yoyakumax.value;

        if( YOYAKUNUM > YOYAKUMAX ){
            window.alert('これ以上予約できません。');
            return false;
        }

	    if(window.confirm( DATE + CLASS + "限目で予約します。\n送信してよろしいですか？")){ 
		window.alert('予約しました。');
		return true; // 「OK」時は送信を実行
	    }else{ 
		return false; // 送信を中止
	    }
	}
      -->
  </script>

</head>
<body>

    <?php user_menu(); ?>

  <h1 id="pagetitle">受講予約</h1>

  <form action="additem.php" method="POST" id="yoyaku_admit" onSubmit="return submit_click()">
    <label>日付：</label>
    <input type="text" id="date_p" name="date_p" size="15" readonly value="<?php echo date("Y年m月d日",$date) ?>" />
    <input type="hidden" id="date" name="date" size="15" readonly value="<?php echo date("Y-m-d",$date) ?>" />
    <input type="text" id="classtime" name="class" size="2" readonly value="<?php echo $class ?>" />
    <label>時限目</label>
    <br />
    <label>学籍番号：</label>
    <input type="text" id="studentid" name="studentid" />
    <br />
    <label>氏名：</label>
    <input type="text" id="studentnm" name="studentnm" />
    <br />
    <input type="hidden" name="mode" value="add">
    <input type="hidden" name="yoyakunum" value="<?php echo CheckYoyaku( $date, $class ); ?>">
    <input type="hidden" name="yoyakumax" value="<?php echo $RESVMAX; ?>">
    <input type="submit" value="予約">
    <a href="index.php"><input type="button" value="戻る" /></a>
  </form>

</body>
</html>

<?php

function add_yoyaku( $POST ){

   global $DBSV, $DBUSER , $DBPASS , $DBNM;

   $date = $POST['date'];
   $class = $POST['class'];
   $studentid = $POST['studentid'];
   $studentnm = $POST['studentnm'];
   $regdate = date("Y-m-d H:i:s");

   $sql = "insert into yoyaku ( date, class, studentid, studentnm, regdate ) value ( '$date', '$class', '$studentid', '$studentnm', '$regdate' )";

   $link = mysqli_connect( $DBSV, $DBUSER , $DBPASS , $DBNM ) or die(mysqli_connect_error()); 
    
   mysqli_query( $link, $sql) or die(mysqli_error( $link ));

}

?>
