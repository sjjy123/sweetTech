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

?><html xmlns="http://www.w3.org/1999/xhtml">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $WebSite_Title;?></title>
<meta http-equiv="cache-control" content="no-cache"/>
<meta http-equiv="pragma" content="no-cache"/>
<link rel="stylesheet" type="text/css" href="../system_style/css/style.css" />
<script type="text/javascript" src="../system_style/js/HxCms.js"></script>
<script type="text/javascript">
<!--
var status = 1;
function switchSysBar(){
     if (1 == window.status){
		  window.status = 0;
          switchPoint.innerHTML = '<img src="../system_style/images/left.gif"/>';
          document.all("left_iframe").style.display="none"
		  document.all("left_table").style.display="none"
     }
     else{
		  window.status = 1;
          switchPoint.innerHTML = '<img src="../system_style/images/right.gif"/>';
          document.all("left_iframe").style.display=""
		  document.all("left_table").style.display=""
     }
}
//-->
</script>
</head>
<body class="frame_class" style="background:#fbf8f6">
<table border="0" cellspacing="0" cellpadding="0" width="100%" height="100%">
	<tr>
		<td style="height:105px" id="head_iframe" colspan="2"><iframe src="admin_top.php" width="100%" height="100%" name="topFrame" scrolling="no" noresize="noresize" id="topFrame" frameborder="no"></iframe></td>
	</tr>
	<tr>
		<td id="left_table1"><div class="toplineimg"></div></td>
		<td class="topline1" ></td>
	</tr>
	<tr>
		<td id="left_iframe" valign="top"><iframe src="admin_left.php" style="height:100%;visibility:inherit;width:188px;" name="leftFrame" noresize="noresize" id="leftFrame" frameborder="no"></iframe>
		</td>
		<td id="main_iframe" valign="top"><iframe src="admin_main.php" style="height:100%;visibility:inherit;width:100%;z-index:1;" name="mainFrame" id="mainFrame" frameborder="no" scrolling="auto"></iframe>
		</td>
	</tr>
	<tr>
		<td height="30" id="foot_iframe" colspan="2">
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="botbg">
		  <tr height="32">
			<td style="width:38px;" align="center" onClick="switchSysBar()"><span class="navpoint" id="switchPoint" title="关闭/打开左栏"><img src="../system_style/images/right.gif" alt="" /></span></td>
			<td style="text-align:left;font-family:arial;font-size:11px;">Copyright Right &copy; 2008-<?php echo date("Y");?> HZCHIHU  Powered By CH MyCms1.0 Version</td>
			<td style="text-align:right;padding-right:20px;"><a href="admin_setting.php" target="mainFrame">后台设置</a> |<!-- <a href="sys/admin_online.asp" target="mainFrame">查看在线列表</a> |--> <a target="_top" href="admin_logout.php" onClick="return confirm('系统提示：您确定要退出后台管理吗?')">注销退出</a></td>
		  </tr>
		</table>
		</td>
	</tr>
</table>
<iframe id="hiddenFrame" name="hiddenFrame" style="display:none;" src="about:blank"></iframe>
</body>
</html>