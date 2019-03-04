<?php
if($_SESSION['adminName']=="" or $_SESSION['adminID']=="") {
	echo  ok("请登录后再进行访问！！","../",2);
	exit();
}
if($_SERVER['HTTP_REFERER']=="") {
	echo  ok("禁止外部直接访问！！","../",2);
	exit();
}
?>