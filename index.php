<?php
include 'config.php';
include 'class.php';

if( isset( $_GET['month'] )){
    $month = $_GET['month'];
} else {
    $month = time();
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>講座予約</title>
  <meta name="viewport" content="width=device-width">
  <link rel="stylesheet" href="css/reset.css">
  <link rel="stylesheet" href="css/style.css">  
</head>
<body>

    <h1>
<?php
    echo $SITETITLE; 
?>
    </h1>

    <div id="caltitle">
      <div id="caltitle_l">
<?php
       $lastmonth = mktime(0, 0, 0, date("m",$month) -1, date("d", $month), date("Y",$month));
       $last = date("Y年m月", $lastmonth);
   if( $month > time() ){ 
       echo '<a href="index.php?month=' . $lastmonth . '">' . $last. '</a>';
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
   echo '<a href="index.php?month=' . $nextmonth . '">' . $next .'</a>';
?>
      </div>
    </div>

<?php
calender($month);
?>

</body>
</html>
