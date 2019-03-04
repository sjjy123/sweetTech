<?php
session_start();
header("Pragma:no-cache\r\n");
header("Cache-Control:no-cache\r\n");
header("Expires:0\r\n");
header("Content-Type: text/html; charset=uft-8");
define('INIT_XMALL',true);
define('INIT_ROOT','../');
	include_once(INIT_ROOT."system_include/conn.php");
	include_once(INIT_ROOT."system_include/check_purview.php");
	$action      =$_REQUEST["action"];
	$tabname     =$_REQUEST["tabname"];
	$id          =$_REQUEST["id"];
	$field       =$_REQUEST["field"];
	$val         =$_REQUEST["val"];
	switch ($action)
	{
		case "stemp":
		    if($val==0)
			{
				$sql="update hxcms_class set `$field` =1 where id=$id";
	            $db->query($sql);
				//echo $sql;
				echo "<b style='color:#386BC8;cursor:pointer' onclick=\"stemp('$field',".$id.",1)\" >√<b>";
			}
			elseif($val==1)
			{
				$sql="update hxcms_class set `$field` =0 where id=$id";
	            $db->query($sql);
				//echo $sql;
				echo "<b style='color:#ff0000;cursor:pointer' onclick=\"stemp('$field',".$id.",0)\" >×</b>";
			}
			break;
			
	}
	
?>
