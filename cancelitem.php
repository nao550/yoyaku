<?php
include 'config.php';
include 'class.php';

if( isset( $_GET )){
    $date = h( $_GET['date'] );
    $class = h( $_GET['class'] );
    $studentid = h( $_GET['studentid'] );
    $studentnm = h( $_GET['studentnm'] );
} else {
    heder('Location: index.php');
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>予約キャンセル</title>
  <meta name="viewport" content="width=device-width">
  <link rel="stylesheet" href="css/reset.css">
  <link rel="stylesheet" href="css/style.css">  
</head>
<body>

<?php
    echo $date . $class . $studentid . $studentnm ;
?>

</body>
</html>