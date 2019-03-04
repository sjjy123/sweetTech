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
include_once("admin_config.php");
	
	//获取栏目ID
	//$SystemID =addslashes($_REQUEST["m"]);
	$tabName  =tabName($SystemID);
	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<link rel="stylesheet" type="text/css" href="../system_style/css/style.css" />
<script type="text/javascript" src="../system_style/js/HxCms.js"></script>
</head>
<body>
	<?php 
	//开始保存所有信息
	switch ($_REQUEST["action"])
	{
		case "savemain":
		    cms_savemain($SystemID,$tabName);
		    ok("信息添加成功",$_SERVER["HTTP_REFERER"],2);
		   break;
		case "editsave":
			$strid=$_REQUEST["strid"];
			cms_editsave($SystemID,$tabName,$strid);
			ok("信息编辑成功",$_SERVER["HTTP_REFERER"],2);
		break;
	}
	
?>
</BODY>
</HTML>
