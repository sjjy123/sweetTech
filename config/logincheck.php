<?php
	session_start();
	header("Content-Type:text/html;charset=utf-8");
	$url=$_SERVER['HTTP_REFERER'];
	if($_SESSION['userid']=="")
	{
		echo "<script>window.location.href='member-login.php?url=".$url."';</script>";
		//echo "<script>alert('您还没有登录，或你已经超时，请重新登录！');window.location.href='member-login.php';;< /script>";	
	}
?>
