<?php

function calender( $ymd = ""){

    if ( $ymd == ""){
        $ymd = date("Y-m-01");
    } else {
        $ymd = date("Y-m", $ymd) . "-01";
    }

    //開始日のタイムスタンプ
    $s = strtotime($ymd);
    //日付リストを作る
    $data = array();
    for ($t = $s; date('m', $t) == date('m', $s); $t += 60*60*24) {
        $data[] = $t;
    }
    //先頭の日の曜日を見て前に余白を追加
    if (date('w', $data[0]) > 0) {
        $data = array_merge(array_fill(0, date('w', $data[0]), ''), $data);
    }
    //末尾の日の曜日を見て後ろに余白を追加
    if (date('w', end($data)) < 6) {
        $data = array_merge($data, array_fill(0, 6 - date('w', end($data)), ''));
    }
    //7で割る
    $data = array_chunk($data, 7);
 
    //以上でデータは出来上がった
 
    //カレンダーを表示する
    echo '<table id="yoyakucal">';
    //見出し
    echo "<tr><th>日</th><th>月</th><th>火</th><th>水</th><th>木</th><th>金</th><th>土</th></tr>\n";
    //週のループ
    foreach ($data as $week) {
        echo "<tr>\n";
        //週の中の日のループ
        foreach ($week as $date) {
            if ($date) {
                echo '<td><!--' . date('Y-m-d',$date) . '--><strong>' . date('j', $date) . '</strong><br />';
                echo '<div class="classtime">';
                echo '  <a href="additem.php?date=' . $date . '&class=1">1限</a>：' . CheckYoyaku( $date, 1 )  . '<br />';
                echo '  <a href="additem.php?date=' . $date . '&class=2">2限</a>：' . CheckYoyaku( $date, 2 )  . '<br />';
                echo '  <a href="additem.php?date=' . $date . '&class=3">3限</a>：' . CheckYoyaku( $date, 3 )  . '<br />';
                echo '  <a href="additem.php?date=' . $date . '&class=4">4限</a>：' . CheckYoyaku( $date, 4 )  . '<br />';
                echo '  <a href="additem.php?date=' . $date . '&class=5">5限</a>：' . CheckYoyaku( $date, 5 )  . '<br />';
                echo '  <a href="additem.php?date=' . $date . '&class=6">6限</a>：' . CheckYoyaku( $date, 6 ) ;
                echo "\n";
            } else {
                echo '<td>&#160;</td>';
                echo "\n";
            }
        }
        echo "</tr>\n";
    }
    echo '</table>';
}

function CheckYoyaku( $date, $class){
   global $DBSV, $DBUSER , $DBPASS , $DBNM;

   $date = date("Y-m-d", $date);
   $mysql = new mysqli( "localhost", $DBUSER, $DBPASS, $DBNM );

   $sql = "select studentid from yoyaku where date ='$date' and class ='$class'";

   if( $mysql->connect_errno ){
       printf( "Connect failed: %s\n", $mysql->connect_error );
       exit();
   }

   $result = $mysql->query( $sql );

   $num = $result->num_rows;

   return $num;
    
}

?>