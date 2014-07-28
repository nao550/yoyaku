<?php
include '../config.php';
include '../class.php';
include 'admin_func.php';

session_start();

if( empty( $_SESSION['user'] ) or ( $_SESSION['user'] != $ADMINNM )){
    header("Location: index.php");
}

if( isset( $_GET['page'] )){
    $page = h( $_GET['page'] );
} else {
    $page = 1;
}

$page = PageLimit( $page );
        
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

<?php 
    admin_menu_ul(); 
?>


<h1>学生一覧表示</h1>


<?php
$pagemove = Paging( $page );

echo $pagemove;
ScanYoyaku( $page );
echo $pagemove;
?>

</body>
</html>



<?php

function ScanYoyaku( $page ){
    global $DBSV, $DBUSER , $DBPASS , $DBNM, $MAXROWS;
    $n = 1;
    $startrow = ( $page - 1)  * $MAXROWS;

    $mysql = new mysqli( "localhost", $DBUSER, $DBPASS, $DBNM );
    $sql = "select cd, date, class, studentid, studentnm from yoyaku order by date, class limit  $startrow, $MAXROWS;";
    
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

       printf("<td>%s</td><td>%d</td><td>%s</td><td>%s</td><td>\n",
              $row['date'], $row['class'], $row['studentid'], $row['studentnm']);       
       printf('         <a href="cancelitem.php?mode=del&cd=' . $row['cd'] . '&date=' . $row['date'] . '&class=' . $row['class'] . '&id=' . $row['studentid'] . '&nm=' . $row['studentnm'] . '"><input type="submit" value="削除" /></a></td></tr>' . "\n");
       printf('       </form>' . "\n");



       $n++;
   }
   echo "    </tbody></table>\n";

}

function PageLimit( $page ){
    // ページの上限下限のチェック
    global $MAXROWS;
    $p = max( $page, 1); // マイナスページが指定された場合1を返す
    $yoyaku = new YOYAKU();
    $p = min( $page, ceil($yoyaku->maxnum() / $MAXROWS )); // 
    return $p;
}

function Paging( $page ){
    global $MAXROWS;

    if( $page > 1 ){
        $prevp = $page - 1;
        $prev = '<a href="listview.php?page=' . $prevp . '">前のページ</a>';
    } else {
        $prev = '前のページ';
    }

    $yoyaku = new YOYAKU();
    $maxpage = ceil($yoyaku->maxnum() / $MAXROWS );

    if( $page < $maxpage ){
        $nextp = $page + 1;
        $next = '<a href="listview.php?page=' . $nextp . '">次のページ</a>';
    } else {
        $next = '次のページ';
    }

    $s = sprintf("<div class=\"listpage\">\n  <div class=\"listpage_prev\">\n     %s\n  </div>\n  <div class=\"listpage_next\">\n     %s\n  </div>\n</div>\n\n",$prev, $next );

    return $s;
}
?>
