<?php
include 'config.php';
include 'class.php';

$sql = "";

if ( isset($_POST['mode'] )){
    $date = $_POST['year'] . "-" . $_POST['month'] . "-" . $_POST['day'];
    $class = $_POST['class'];
    $studentid = $_POST['studentid'];
    $studentnm = $_POST['studentnm'];
    $regdate = date("Y-m-d H:i:s");

    $sql = "insert into yoyaku ( date, class, studentid, studentnm, regdate ) value ( '$date', '$class', '$studentid', '$studentnm', '$regdate' )";

    $link = mysqli_connect($DBSV, $DBUSER , $DBPASS , $DBNM ) or die(mysqli_connect_error()); 
    
    mysqli_query( $link, $sql) or die(mysqli_error( $link ));
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
    <?php echo $sql ; ?> <br >
  <form action="add_item.php" method="POST">
    <input type="text" name="year" value="2014"/>
    <label>年</label>
    <input type="text" name="month" value="7"/>
    <label>月</label>
    <input type="text" name="day" />
    <label>日</label>
    <input type="text" name="class" />
    <label>時限目</label>
    <br />
    <label>学籍番号</label>
    <input type="text" name="studentid" />
    <label>名前</label>
    <input type="text" name="studentnm" />
    <input type="hidden" name="mode" value="add" />
    <input type="submit" /><input type="reset" />
  </form>
</body>
</html>
