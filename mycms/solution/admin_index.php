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
$page=$_REQUEST["page"];
	
	//获取栏目ID
	//$SystemID =addslashes($_REQUEST["m"]);
	$tabName  =tabName($SystemID);
	$isnewmoban=cms_get_newmoban($SystemID);
	if (addslashes($_REQUEST["act"])=="upd")
	{
		$Cms_field=$_REQUEST["field"];
		$Cms_num =$_REQUEST["strnum"];
		$Cms_id =$_REQUEST["cmsid"];
		Cms_update($tabName,$Cms_field,$Cms_num,$Cms_id);
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<link rel="stylesheet" type="text/css" href="../system_style/css/style.css" />
<script type="text/javascript" src="../system_style/js/HxCms.js"></script>
<script type="text/javascript" src="../system_style/js/jquery-1.4.2.js"></script>
<script type="text/javascript" src="../system_style/js/Hx_showIMG.js"></script>

</head>
<body>
<?php 
echo $htmls;
($isnewmoban==0)?include_once(INIT_ROOT."system_core/admin_list.php"):include_once("admin_list.php");

?>