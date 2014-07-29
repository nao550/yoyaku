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
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/reset.css">
  <link rel="stylesheet" href="css/style.css">  
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
  <!-- Optional theme -->
  <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
  <!-- Latest compiled and minified JavaScript -->
  <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
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
          <li class="active"><a href="#">Home</a></li>
          <li><a href="./admin/index.php">管理画面</a></li>
          <li><a href="./docs/user/_build/html/user_manual.html" target="_blank">マニュアル</a></li>
        </ul>
      </div><!--/.nav-collapse -->
    </div>
  </div>

  <div class="container">
    <div class="col-sm-2">
    </div>
    <div class="col-sm-8">
      <div class="starter-template">
	<h1 style="margin-top: 60px;">
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

      <?php calender($month); ?>
      </div>
    </div>
    
    <div class="col-sm-2">
    </div>
  </div>
   <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
</body>
</html>
