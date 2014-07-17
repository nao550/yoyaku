<?php
include 'config.php';

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
</head>
<body>

  <h1 id="pagetitle">受講予約</h1>

  <!-- <?php echo "sql:" . $sql; ?> -->

  <form action="additem.php" method="POST" id="yoyaku_admit">
    <label>日付：</label>
    <input type="text" name="date_p" size="15" readonly value="<?php echo date("Y年m月d日",$date) ?>" />
    <input type="hidden" name="date" size="15" readonly value="<?php echo date("Y-m-d",$date) ?>" />
    <input type="text" name="class" size="2" readonly value="<?php echo $class ?>" />
    <label>時限目</label>
    <br />
    <label>学籍番号：</label>
    <input type="text" name="studentid" />
    <br />
    <label>氏名：</label>
    <input type="text" name="studentnm" />
    <br />
    <input type="hidden" name="mode" value="add">
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
