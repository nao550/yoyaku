<?php

function calender( $ymd = ""){
    global $RESVMAX;

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
    echo '<tr><th class="jigen">時限</th><th>日</th><th>月</th><th>火</th><th>水</th><th>木</th><th>金</th><th>土</th></tr>' ;
    echo "\n";
    //週のループ
    foreach ($data as $week) {
        echo "<tr>\n";
        // 時限の挿入
        echo '<td><br /><div class="classtime_t">';
        echo '1限,10:50-11:40<br />';
        echo '2限,11:50-12:40<br />';
        echo '3限,13:30-14:20<br />';
        echo '4限,14:30-15:20<br />';
        echo '5限,15:30-16:20<br />';
        echo '6限,16:30-17:20<br /></td>';
        //週の中の日のループ
        foreach ($week as $date) {
            if ($date) {
                echo '<td><!--' . date('Y-m-d',$date) . '--><strong>' . date('j', $date) . "</strong><br />\n";
                echo '<div class="classtime">' . "\n";

                // 6クラス分ループで生成する
                for( $n = 1; $n < 7 ; $n++ ){
                    $revNum = CheckYoyaku( $date, $n ); // 日時時限の予約数のとりだし
                    if( $revNum < $RESVMAX ){
                        echo '  <a href="additem.php?date=' . $date . '&class=' . $n . '">' . $n . '限</a>： ' . $revNum  . "<br />\n";
                    } else {
                        echo '  ' . $n . '限： ' . $revNum  . "<br />\n";
                    }
                }

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
    // 指定した日、時限の予約数を返す

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