<?php

function admin_menu_ul(){

print <<< EOF
<div id="admin_menu">
  <ul id="admin_menu_ul">
    <li><a href="../index.php">トップへ</a></li>
    <li><a href="listview.php">学生一覧表示</a></li>
    <li><a href="checkday.php">日付設定</a></li>
    <li><a href="index.php?mode=destroy">ログオフ</a></li>
    <li><a href="../docs/admin/_build/html/index.html">マニュアル</a></li>
  </ul>
</div>
EOF;
}

?>