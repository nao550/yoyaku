<?php

function admin_menu_ul(){

print <<< EOF
<div id="menu">
  <ul id="menu_list">
    <li><a href="index.php?mode=destroy">ログオフ</a></li>
    <li><a href="checkday.php">日付設定</a></li>
  </ul>
</div>
EOF;
}

?>