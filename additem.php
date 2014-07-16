<?php

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

  <!-- <?php   echo $_GET['date'] . " " . $date . " " . $class ; ?> -->

  <form action="additem.php" method="POST">
    <label>日付</label>
    <input type="text" name="date" value="<?php echo date("Y年m月d日",$date) ?>" />
    <input type="text" name="class" value="<?php echo $class ?>" />
    <label>時限目</label>
    <br />
    <label>学籍番号</label>
    <input type="text" name="studentid" />
    <label>氏名</label>
    <input type="text" name="studentnm" />
    <br />
    <input type="submit" value="予約">
    <input type="button" value="戻る" />
  </form>
    


    

</body>
</html>
