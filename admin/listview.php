<?php
include '../config.php';
include '../class.php';

session_start();

if( empty( $_SESSION['user'] )){
    header("Location: index.php");
}

if( isset( $_SESSION['user'])){
    echo "sesssion user set\n";
    if( $_SESSION['user'] != $ADMINNM ){
        header("Location: index.php");
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
<div id="menu">
    <a href="index.php?mode=destroy">logout</a>
</div>
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
   echo '      <tr><th>日付</th><th>時限</th><th>学籍番号</th><th>氏名</th><th></th></tr>'; echo "\n";

   while ( $row = $result->fetch_assoc()){
       if( $n%2 == 0 ){
           printf("<tr>");
       } else {
           printf("<tr class=\"bggray\">");
       }

// 以下のやりかたはまずい。
// javascript でどのname.valueをとるのか判断できない


       printf("<td>%s</td><td>%d</td><td>%s</td><td>%s</td><td>\n",
              $row['date'], $row['class'], $row['studentid'], $row['studentnm']);       
       printf('       <form action="listview.php" method="POST"  name="delchk" onSubmit="return delbt_click()" >' . "\n");

       printf('         <input type="hidden" name="date" value="' . $row['date'] . '" />' . "\n");
       printf('         <input type="hidden" name="class" value="' . $row['class'] . '" />' . "\n");
       printf('         <input type="hidden" name="studentid" value="' . $row['studentid'] . '" />' . "\n");
       printf('         <input type="hidden" name="studentnm" value="' . $row['studentnm'] . '" />' . "\n");
       printf('         <input type="hidden" name="mdoe" value="delmode" />' . "\n");
       printf('         <input type="submit" value="削除" /></td></tr>' . "\n");
       printf('       </form>' . "\n");



       $n++;
   }
   echo "    </tbody></table>\n";

}

?>
