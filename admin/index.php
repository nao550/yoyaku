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
  <meta name="viewport" content="width=device-width">
  <link rel="stylesheet" href="../css/reset.css">
  <link rel="stylesheet" href="../css/style.css">  
</head>
<body>
  <h1>管理者ログイン</h1>


  <form action="index.php" method="POST" id="loginform">
    <label>ログイン名：</label>
    <input type="text" id="user" name="user" width='20' /><br />
    <label>パスワード：</label>
    <input type="text" id="password" name="password" width='20' /><br />
    <input type="submit" value="ログイン" />
    <input type="reset" value="reset" />
  </form>
</body>
</html>
