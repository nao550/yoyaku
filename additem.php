<?php
include 'config.php';
include 'class.php';

if( isset( $_POST['mode'] )){
    if( $_POST['mode'] == 'add' ){
        $date = h( $_POST['date'] );
        $class = h( $_POST['class'] );
        $id = h( $_POST['studentid'] );
        $nm = h( $_POST['studentnm'] );

        $yoyaku = new YOYAKU();
        $yoyaku->add( $date, $class, $id, $nm );
        header("Location: index.php ");
    }
}

if(! isset( $_GET['date'] )){
    header( 'Location: index.php' );
} else {
    $date = h( $_GET['date'] );
    $class = h( $_GET['class'] );
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

  <script type="text/javascript">
    <!--
	function submit_click(){
	    var DATE = document.forms.yoyaku_admit.date_p.value;
	    var CLASS = document.forms.yoyaku_admit.classtime.value;
        var YOYAKUNUM = document.forms.yoyaku_admit.yoyakunum.value;
        var YOYAKUMAX = document.forms.yoyaku_admit.yoyakumax.value;
	    var STUDENTNM = document.forms.yoyaku_admit.studentnm.value;
	    var STUDENTID = document.forms.yoyaku_admit.studentid.value;

        if( STUDENTID == "" ){
            window.alert('学籍番号を入力してください。');
            return false;
        }            

        if( STUDENTNM == "" ){
            window.alert('氏名を入力してください。');
            return false;
        }            

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

	function CancelClick(){
	    var DATE = document.forms.yoyaku_admit.date.value;
	    var CLASS = document.forms.yoyaku_admit.classtime.value;
	    var STUDENTNM = document.forms.yoyaku_admit.studentnm.value;
	    var STUDENTID = document.forms.yoyaku_admit.studentid.value;

        if( STUDENTID == "" ){
            window.alert('学籍番号を入力してください。');
            return false;
        }            

        if( STUDENTNM == "" ){
            window.alert('氏名を入力してください。');
            return false;
        }            

	    if( window.confirm( DATE + "\n" +  CLASS + "時限\n" + "学籍番号：" + STUDENTID + "\n氏名：" + STUDENTNM + "\nの申込をキャンセルしますか？")){
		// キャンセル実行
		location.href="./cancelitem.php?date=" + DATE + "&class=" + CLASS + "&studentid=" + STUDENTID + "&studentnm=" + STUDENTNM;
	    }
	    else {
		return false; //　キャンセル中止
	    }
	}
      -->
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
          <li class="active"><a href="index.php">Home</a></li>
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
        <h1 id="pagetitle" style="margin-top: 60px;">受講予約</h1>

  <form action="additem.php" method="POST" id="yoyaku_admit" onSubmit="return submit_click()" >
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
    <input type="hidden" name="yoyakunum" value="<?php $yoyaku = new YOYAKU(); echo $yoyaku->num( date("Y-m-d",$date), $class ); ?>">
    <input type="hidden" name="yoyakumax" value="<?php echo $RESVMAX; ?>">
    <input type="submit" value="受講予約">
    <a href="index.php"><input type="button" value="戻る" /></a>
    <input type="button" value="予約キャンセル" onclick="CancelClick()" />
  </form>
        
        </div>
        <div class="col-sm-2">
        </div>
        </div>
   <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

</body>
</html>


