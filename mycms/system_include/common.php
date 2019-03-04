<?php
$db = new dbmysql;
$db->connect($dbhost, $dbuser, $dbpw, $dbname, $dbcharset, $pconnect, $tablepre, $time);
unset($dbhost, $dbuser, $dbpw, $dbname, $pconnect);
?>