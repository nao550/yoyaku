<?php

function h( $s ){
    return htmlspecialchars( $s, ENT_QUOTES, 'UTF-8');
}


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

                if( chkdate( date('Y-m-d', $date) ) == '1' ){
                    // 予約可能日
                    echo '<div class="classtime">' . "\n";

                    // 6クラス分ループで生成する
                    for( $n = 1; $n < 7 ; $n++ ){
                        $revNum = CheckYoyaku( $date, $n ); // 日時時限の予約数のとりだし
                        if( $revNum < ($RESVMAX + 1)){
                            echo '  <a href="additem.php?date=' . $date . '&class=' . $n . '">' . $n . '限</a>： ' . $revNum  . "<br />\n";
                        } else {
                            echo '  ' . $n . '限： ' . $revNum  . "<br />\n";
                        }
                    }
                } elseif ( chkdate( date('Y-m-d', $date )) == '0' ){

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
   $sql = sprintf("select studentid from yoyaku where date ='%s' and class ='%s'", $mysql->real_escape_string( $date ), $mysql->real_escape_string( $class ));
   if( $mysql->connect_errno ){
       printf( "Connect failed: %s\n", $mysql->connect_error );
       exit();
   }
   $result = $mysql->query( $sql );
   $num = $result->num_rows;
   return $num;
}

function chkdate( $date ){
    // 予約可能日かどうかのチェック
    // return
    // 0: 予約不可能
    // 1: 予約可能

    switch( chk_day_mode( $date )){
    case '1': 
        return( 0 );
        break;
    case '2': 
        return( 1 );
        break;
    case '3': 
        return( 1 );
        break;
    case '4': 
        return( 0 );
        break;
    }
}


function chk_day_mode( $date ){
    // $date が予約可能日かどうか、DBに登録されているかどうか
    // return
    // 1: 予約可能 yoyaku_day に日付あり
    // 2: 予約不可能 yoyaku_day に日付あり
    // 3: 予約可能 yoyaku_day に日付なし
    // 4: 予約不可能 yoyaku_day に日付なし

    global $DBSV, $DBUSER, $DBPASS, $DBNM, $CHK_DATE_MODE;

    $mysql = new mysqli( "localhost", $DBUSER, $DBPASS, $DBNM );
    if( $mysql->connect_errno ){
        printf( "Connect failed: %s\n", $mysql->connect_error );
        exit();
    }

    $sql = sprintf("select flag from yoyaku_day where date ='%s'", $mysql->real_escape_string( $date ));
    $result = $mysql->query( $sql );

    $s='';
    $chkflag = $result->fetch_assoc();

    if(( $CHK_DATE_MODE == "0" ) and ( $chkflag['flag'] == '0' )){
        // 0 default Open, 1 default close.
        // chkflag 0 close, 1 open.
        $s = '1' ;  //day false dateon;
    } elseif(( $CHK_DATE_MODE == "0" ) and ( $chkflag['flag'] == '1' )){
        $s = '2'; //day true dateoff
    } elseif(( $CHK_DATE_MODE == "0" ) and ( $chkflag['flag'] == '' )){
        $s = '3'; //day false addoff
    } elseif(( $CHK_DATE_MODE == "1" ) and ( $chkflag['flag'] == '0' )){
        $s = '1'; //day false dateon
    } elseif(( $CHK_DATE_MODE == "1" ) and ( $chkflag['flag'] == '1' )){
        $s = '2'; //day true dateoff
    } elseif(( $CHK_DATE_MODE == "1" ) and ( $chkflag['flag'] == '' )){
        $s = '4'; //day true addon
    }
    return $s;
}


class YOYAKU {

    function ischk( $date, $class, $id, $nm ){
        // 予約が有無のチェック、あれば 1 を返す、なければ 0
        global $DBSV, $DBUSER, $DBPASS, $DBNM;
        $mysql = new mysqli( "localhost", $DBUSER, $DBPASS, $DBNM );
        if( $mysql->connect_errno ){
            printf( "Connect failed: %s\n", $mysql->connect_error );
            exit();
        }

        $sql = sprintf("select * from yoyaku where date ='%s' and class='%s' and studentid='%s' and studentnm='%s';", 
                       $mysql->real_escape_string( $date ), 
                       $mysql->real_escape_string( $class ), 
                       $mysql->real_escape_string( $id ), 
                       $mysql->real_escape_string( $nm ));
        $result = $mysql->query( $sql );

        return( $result->num_rows );
    }


    function num( $date, $class){
        // 指定した日、時限の予約数を返す
        global $DBSV, $DBUSER , $DBPASS , $DBNM;
        $mysql = new mysqli( "localhost", $DBUSER, $DBPASS, $DBNM );
        $sql = sprintf("select studentid from yoyaku where date ='%s' and class ='%s'", $mysql->real_escape_string( $date ), $mysql->real_escape_string( $class ));
        if( $mysql->connect_errno ){
            printf( "Connect failed: %s\n", $mysql->connect_error );
            exit();
        }
        $result = $mysql->query( $sql );

        $num = $result->num_rows;
        return( $num );
    }

    function maxnum( ){
        // 登録されている予約数を返す
        global $DBSV, $DBUSER , $DBPASS , $DBNM;
        $mysql = new mysqli( "localhost", $DBUSER, $DBPASS, $DBNM );
        $sql = sprintf("select studentid from yoyaku;");
        if( $mysql->connect_errno ){
            printf( "Connect failed: %s\n", $mysql->connect_error );
            exit();
        }
        $result = $mysql->query( $sql );

        $num = $result->num_rows;
        return( $num );
    }


    function add( $date, $class, $id, $nm ){
        // 予約を登録する, 正常終了で1が返る
        global $DBSV, $DBUSER, $DBPASS, $DBNM;
        $mysql = new mysqli( "localhost", $DBUSER, $DBPASS, $DBNM );
        if( $mysql->connect_errno ){
            printf( "Connect failed: %s\n", $mysql->connect_error );
            exit();
        }

        $sql = sprintf("insert into yoyaku ( date, class, studentid, studentnm, regdate ) value ( '%s', '%s', '%s', '%s', '%s' )", 
                       $mysql->real_escape_string( $date ), 
                       $mysql->real_escape_string( $class ), 
                       $mysql->real_escape_string( $id ), 
                       $mysql->real_escape_string( $nm ),
                       date('Y-m-d'));
        return ($mysql->query( $sql ));
    }


    function del( $date, $class, $id, $nm ){
        // 予約を削除する、削除できれば 1 を返す
        global $DBSV, $DBUSER, $DBPASS, $DBNM;
        $mysql = new mysqli( "localhost", $DBUSER, $DBPASS, $DBNM );
        if( $mysql->connect_errno ){
            printf( "Connect failed: %s\n", $mysql->connect_error );
            exit();
        }

        $sql = sprintf("delete from yoyaku where date ='%s' and class='%s' and studentid='%s' and studentnm='%s';", 
                       $mysql->real_escape_string( $date ), 
                       $mysql->real_escape_string( $class ), 
                       $mysql->real_escape_string( $id ), 
                       $mysql->real_escape_string( $nm ));
        return( $mysql->query( $sql ));

    }

}


?>