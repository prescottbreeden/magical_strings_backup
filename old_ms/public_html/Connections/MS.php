<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_MS = "localhost";
$database_MS = "magica6_contact";
$username_MS = "magica6_magica6";
$password_MS = "skellig";
$MS = mysql_connect($hostname_MS, $username_MS, $password_MS) or trigger_error(mysql_error(),E_USER_ERROR); 
?>