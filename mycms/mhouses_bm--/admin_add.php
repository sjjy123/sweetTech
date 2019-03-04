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
<title>添加</title>
<link rel="stylesheet" type="text/css" href="../system_style/css/style.css" />
<script type="text/javascript" src="../system_style/js/HxCms.js"></script>
</head>
<body>
<?=$htmls?>
<form name="myform" method="post" action="admin_save.php?action=savemain" onSubmit="return checkform()">
<table id="tablehovered1" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
<tr>
	<th colspan="2">添加信息</th>
</tr>

<?php
fieldlist($SystemID);
?>
<tr><td class="tablerow3">&nbsp;</td><td class="tablerow3"><input type="submit" name="button" id="button" value="提交信息" style="width:100px; height:30px; font-size:13px" /></td></tr>
</table>
</form>
<?php 
 //调用检测表单函数；
 checkmyform($SystemID);
?>
<script type="text/javascript" src="../system_style/datejs/date.js"></script>
</body>
</html>
