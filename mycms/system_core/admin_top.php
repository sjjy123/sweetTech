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

$con_result = $db->query("select * from ".$tablepre."admin where ID=".$_SESSION["adminID"]."");
$con_row = $db->fetch_array($con_result);
$check_value = $con_row["adminConfig"];

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link rel="stylesheet" type="text/css" href="../system_style/css/top.css" />
<link rel="stylesheet" type="text/css" href="../system_style/css/left.css" />
<script type="text/javascript" src="../system_style/js/HxCms.js"></script>
</head>

<body>
<div class="itop">
    <div class="itop_left">
    <img src="../system_style/images/logo.png" height="50" />&nbsp;
    <img src="../system_style/images/login_title.jpg" width="217" height="33" />
    </div>
    <div class="itop_right">
    <ul>
    <?php
    	$url=get_onlineip();
	?>
    <li>欢迎您 "<?php echo $_SESSION["adminName"];?>" 登陆系统（IP <?php echo $url;?>）</li>
    <li><a target="_blank" href="../../">前台首页</a></li>
    <li><a target="mainFrame" href="admin_setting.php">系统设置</a></li>
    <li><a href="#">帮助中心</a></li>
    <li><a target="_parent" href="admin_logout.php" onClick="return confirm('系统提示：您确定要退出后台管理吗?')">退出</a></li>
    </ul>
    </div>
</div><!-- END itop -->
<div class="headTable">
<div id="system_logo"><img src="../system_style/images/admin_logo.gif"></div>
<div id="sysAnnounce"><span id="NewAspAnnounce"></span></div>
<div class="topmenu" id="topmenu">
	您好，<font><?php echo $_SESSION['adminName'];?></font>&nbsp;　&nbsp;
    <a href="javascript:history.back();" target="_top">后退</a>&nbsp;|&nbsp;
    <a href="index.php" target="_top">后台首页</a>&nbsp;|&nbsp;
    <a href="../../" target="_blank">网站首页</a>&nbsp;|&nbsp;
    <a href="admin_help.html" target="_blank">帮助</a>&nbsp;|&nbsp;
    <a target="_parent" href="admin_logout.php" onClick="return confirm('系统提示：您确定要退出后台管理吗?')">退出</a>&nbsp;&nbsp;
</div>
<div style="clear:both;"></div>
<div id="menuTabs" class="yc_ban">
<ul>
    <li onClick="return fullmenu('admin_left.php?action=menu&m=0');"><a href="admin_main.php" target="mainFrame"><span style='font-size:14px'><b>系统首页</b></span></a></li>
    <?php 
	$cms_sql = "SELECT * FROM ".$tablepre."channel WHERE `show`=1 and `items`=1 ORDER BY sequence asc";	 
	$cms_result = $db->query($cms_sql);
	while($cms_row=$db->fetch_array($cms_result))
	{
		$con_value = explode(",",$check_value);
		for ($k=0;$k<count($con_value);$k++)
		{
			if($con_value[$k]==$cms_row["id"]||checkManag($_SESSION["adminLov"])==true) {			 
			echo "<li onClick=\"return fullmenu('../".$cms_row["tabname"]."/admin_left.php');\">
			<a href=../".$cms_row["tabname"]."/admin_index.php target=mainFrame><span style='font-size:14px'><b>".$cms_row["channel"]."</b></span></a></li>";
			}
		}
	}//END while
    ?>
</ul>
</div>
<div style="clear:both;"></div>
</div>
</body>
<script language="JavaScript">
<!--
function fullmenu(url){
	if (url==null) {url = "admin_left.php";}
	parent.leftFrame.location = url;
}
//-->
</script>
</html>
