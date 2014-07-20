<?php
include '../config.php';
include '../class.php';

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
  <title>管理画面</title>
  <meta name="viewport" content="width=device-width">
  <link rel="stylesheet" href="../css/reset.css">
  <link rel="stylesheet" href="../css/style.css">  
</head>
<body>
<h1>学生一覧表示</h1>

    <?php scanyoyaku(); ?>

</body>
</html>
