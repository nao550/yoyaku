<?php

function admin_menu_ul(){

print <<< EOF
<div id="admin_menu">
  <ul id="admin_menu_ul">
    <li><a href="../index.php">トップへ</a></li>
    <li><a href="checkday.php">日付設定</a></li>
    <li><a href="index.php?mode=destroy">ログオフ</a></li>
  </ul>
</div>
EOF;
}

?>