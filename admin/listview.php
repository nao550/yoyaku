<?php
include '../config.php';
include '../class.php';

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

<?php
    ScanYoyaku();
?>

</body>
</html>

<?php

function ScanYoyaku(){
    global $DBSV, $DBUSER , $DBPASS , $DBNM;
    $n = 1;

   $mysql = new mysqli( "localhost", $DBUSER, $DBPASS, $DBNM );

   $sql = "select date, class, studentid, studentnm from yoyaku order by date;";

   if( $mysql->connect_errno ){
       printf( "Connect failed: %s\n", $mysql->connect_error );
       exit();
   }
   $result = $mysql->query( $sql );

   echo '    <table id="listtable"><tbody>';   echo "\n";
   echo '      <tr><th>日付</th><th>時限</th><th>学籍番号</th><th>氏名</th></tr>'; echo "\n";

   while ( $row = $result->fetch_assoc()){
       if( $n%2 == 0 ){
           printf("<tr><td>%s</td><td>%d</td><td>%s</td><td>%s</td></tr>\n",
                  $row['date'], $row['class'], $row['studentid'], $row['studentnm']);       
       } else {
           printf("<tr class=\"bggray\"><td>%s</td><td>%d</td><td>%s</td><td>%s</td></tr>\n",
                  $row['date'], $row['class'], $row['studentid'], $row['studentnm']);       
       }
       $n++;
   }
   echo "    </tbody></table>\n";

}

?>