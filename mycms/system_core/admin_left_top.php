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

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="../system_style/css/left.css" />
<script type="text/javascript" src="../system_style/js/HxCms.js"></script>
<script language="JavaScript">
function showsubmenu(sid) {
	var whichEl = document.getElementById("submenu" + sid);
	var menuTitle = document.getElementById("menuTitle" + sid);
	if (whichEl!=null) {
		if (whichEl.style.display == "none"){
			whichEl.style.display='';
			if (menuTitle!=null)
			menuTitle.className='ilt1';
		}else{
			whichEl.style.display='none';
			if (menuTitle!=null)
			menuTitle.className='ilt2';
		}
	}
}
</script>
</head>
<body>
<?php /*?><table class="listflow" cellspacing="0" cellpadding="0" height="100%">
  <tr>
    <td height="107" class="topNavbar"><ul class="navbar">
        <li><img src="../system_style/images/ico001.gif" border="0" align="absMiddle"/> <a href="../system_core/admin_setting.php" target="mainFrame">基本设置</a></li>
        <?php if (checkManag($_SESSION["adminLov"])==true)
		  {?>
        <li><img src="../system_style/images/ico002.gif" border="0" align="absMiddle"/> <a href="../system_core/admin_channel.php" target="mainFrame">栏目管理</a></li>
        <?php }?>
        <!--<li><img src="../system_style/images/ico003.gif" border="0" align="absMiddle"/> <a href="../system_core/admin_template.php" target="mainFrame">模板管理</a></li>-->
      </ul></td>
  </tr><?php */?>