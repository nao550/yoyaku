<?php
include '../config.php';
include '../class.php';

session_start();

if( isset( $_GET['mode'])) {
    if( $_GET['mode'] == "destroy" ){
        // セッション変数を全て解除する
        $_SESSION = array();

        // セッションを切断するにはセッションクッキーも削除する。
        // Note: セッション情報だけでなくセッションを破壊する
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                      $params["path"], $params["domain"],
                      $params["secure"], $params["httponly"]
                      );
        }
    }
}

if( isset( $_POST['user'] ) and isset( $_POST['password'] )){
    if( ($_POST['user'] == $ADMINNM) and ($_POST['password'] == $ADMINPS)){
        $_SESSION['user'] = $_POST['user'];
        header("Location: listview.php" );
    }  
} elseif( isset( $_SESSION['user'] ) and isset( $_POST['user'] )){
    if( $_SESSION['user'] == $_POST['user'] ){ 
        header("Location: listview.php" );
    }
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>管理画面</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <link rel="stylesheet" href="../css/reset.css">
    <link rel="stylesheet" href="../css/style.css">  

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

    <!-- Custom styles for this template -->
    <link href="signin.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="../../assets/js/ie-emulation-modes-warning.js"></script>

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>

  <div class="container">
  <form action="index.php" method="POST" id="loginform" class="form-signin" role="form">
    <h2 class="form-signin-heading">管理者ログイン</h2>
    <input type="text" id="user" name="user" class="form-control" placeholder="ログインID" required autofocus />
    <input type="password" id="password" name="password" class="form-control" placeholder="パスワード" required />
    <div class="checkbox">
      <label>
	<input type="checkbox" value="remember-me"> パスワードを記憶する</label>
    </div>
    <button class="btn btn-primary btn-block" type="submit">ログイン</button>
  </form>
  </div>
</body>
</html>
