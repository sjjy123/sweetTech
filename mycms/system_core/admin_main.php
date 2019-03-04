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
?><html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<link rel="stylesheet" type="text/css" href="../system_style/css/style.css" />
<script type="text/javascript" src="../system_style/js/HxCms.js"></script>
</head>
<body class="indexbody" style="background:#fbf8f6 url(../images/yc_main_top_bg.jpg) top left repeat-x">
<table class="tableborder" cellspacing="1" cellpadding="3" width="100%" align="center" border="0" style="margin-top:5px;">
	<tr>
		<th colspan="2" align="left">我的个人信息</th>
	</tr>
	<tr>
		<td class="tablerow2" width="100" height="23">用户基本信息：</td>
        <td class="tablerow2" style="line-height: 150%">您好，<font color="red"><?php echo $_SESSION['adminName'];?></font> <a href="admin_member.php" title="点击修改管理员密码">							        <?php
		if (checkManag($_SESSION["adminLov"])==true){echo " <font color=red>[超级管理员]</font>";}
		if (checkManag($_SESSION["adminLov"])==false)
		{
			if ($_SESSION["adminLov"]==1){echo " <font color=#016AA9>[超级管理员]</font>";}
			if ($_SESSION["adminLov"]==0){echo " <font color=blue>[普通管理员]</font>";}
		}
        ?></a>　<a target="_top" href="admin_logout.php" onClick="return confirm('系统提示：您确定要退出后台管理吗?')">退出</a></td>
	</tr>
	<tr>
		<td class="tablerow1" width="100" height="23">上次登陆时间：</td>
		<td class="tablerow1" style="line-height: 150%">2012-3-24 17:15:19</td>
	</tr>
	<tr>
		<td class="tablerow2" width="100" height="23">上次登陆IP：</td>
		<td class="tablerow2" style="line-height: 150%"><?php echo getip_out();?></td>
	</tr>
</table>
<table class="tableborder" cellspacing="1" cellpadding="3" align="center" border="0">
	<tr>
		<th colspan="2" align="left">网站系统信息</th>
	</tr>
	<tr>
		<td class="tablerow1" width="100" height="23">系统当前版本：</td>
		<td class="tablerow1" >CHMyCms V1.1 版本</td>
	</tr>
	<tr>
		<td class="tablerow2" width="100" height="23">操作系统：</td>
		<td class="tablerow2" ><?php echo userOS()?> <?php echo userBrowser()?></td>
	</tr>
	<tr>
		<td class="tablerow1" width="100" height="23">服务器软件：</td>
		<td class="tablerow1" ><?php echo apache_get_version();?></td>
	</tr>
	<tr>
		<td class="tablerow1" width="100" height="23">其它信息：</td>
		<td class="tablerow1" >系统栏目8个，<a href="not_safe/myphpinfo.php" target="_blank">查看配置信息</a></td>
	</tr>
</table>
<table class="tableborder" cellspacing="1" cellpadding="3" align="center" border="0">
	<tr>
		<th colspan="2" align="left">系统版权信息</th>
	</tr>
	<tr>
		<td class="tablerow1" width="100" height="23">版权所有：</td>
		<td class="tablerow1" style="line-height: 150%">杭州田密科技有限公司 [<a href="http://www.tianmi100.com/" target="_bank">田密科技</a>]</td>
	</tr>
	<tr>
		<td class="tablerow2" height="23">联系方式：</td>
		<td class="tablerow2" style="line-height: 150%">TEL：86795772 EMAIL：info@hzchihu.com QQ：2562227279</td>
	</tr>
	<tr>
		<td class="tablerow1" height="23">版权声明：</td>
		<td class="tablerow1" style="line-height: 150%">1、本系统未经书面授权，不得向任何第三方提供本软件系统;<br />
		2、用户自由选择是否使用,在使用中出现任何问题和由此造成的一切损失作者将不承担任何责任;<br />
	  3、本系统受中华人民共和国《著作权法》《计算机软件保护条例》等相关法律、法规保护，作者保留一切权利。　</td>
	</tr>
</table>
