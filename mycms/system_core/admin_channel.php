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


switch (addslashes($_REQUEST["act"]))
{
	case "upd":
	$Cms_field= $_REQUEST["field"];
	$Cms_num  = $_REQUEST["strnum"];
	$Cms_id   = $_REQUEST["cmsid"];
	Cms_update("".$tablepre."channel",$Cms_field,$Cms_num,$Cms_id);
	break;
	
	case "supd":
	if(is_numeric(addslashes($_REQUEST["sequence"])))//判断是否为数字
	{
		$sequeceID=addslashes($_REQUEST["sequence"]);
		$id =addslashes($_REQUEST["ID"]);
		echo $id;
		$UpSql="update ".$tablepre."channel set sequence='$sequeceID' where id=$id";
		$db->query($UpSql);
		okUrl($_SERVER["HTTP_REFERER"]);
	}
	else
	{
		ok("请不要输入非数字的值或者空置","admin_class.php?m=$SystemID",1);
		exit();
	}
	break;
}
	
	
?><html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>栏目管理</title>
<link rel="stylesheet" type="text/css" href="../system_style/css/style.css" />
<script type="text/javascript" src="../system_style/js/HxCms.js"></script>
</head>
<body>
<table class="table1" cellspacing="0" cellpadding="0" align="center" border="0">
    <tr>
        <td width="200" height="25" align="left" valign="bottom" class="tableline linetitle">栏目管理</td>
        <td width="*" align="right" valign="bottom" class="tableline"><a href="admin_channel_add.php">添加栏目</a> | <a href="admin_channel.php">栏目管理</a></td>
    </tr>
</table>
<table id="tablehovered1" border="0" align="center" cellpadding="3" width="100%" cellspacing="1" class="tableborder">
  <tr>
    <th width="45%" colspan="8">分类排序&nbsp;&nbsp;<font style="font-weight: normal;font-size:12px;">[注：数字越大的靠后]</font></th>
  </tr>
  <tr>
    <td class="tablerow3" align="center">栏目名称</td> 
    <?php 
    if (checkManag($_SESSION["adminLov"])==true) {
    ?>
    <td class="tablerow3" align="center">表　名</td>
    <td class="tablerow3" align="center">是否启用</td>
    <td class="tablerow3" align="center">栏　目</td>
    <td class="tablerow3" align="center">字段管理</td>
    <td class="tablerow3" align="center">左侧管理</td>
    <?php } ?>
    <td class="tablerow3" align="center">排　序</td>
    <td class="tablerow3" align="center">操　作</td>
  </tr>
  <?php 
  $i=0;
  if (checkManag($_SESSION["adminLov"])==true) {
	  $cms_sql = "SELECT * FROM ".$tablepre."channel ORDER BY sequence asc";//管理员
  }else{
	  $cms_sql = "SELECT * FROM ".$tablepre."channel WHERE `show`=1 ORDER BY sequence asc";//普能用户
  }
  $cms_result = $db->query($cms_sql);
  while($cms_row=$db->fetch_array($cms_result))
  {
		if ($i%2==0) { $classname="tablerow2"; }else{ $classname="tablerow1"; }
		echo "<tr>";
		echo "<td class='$classname' align='center'>".$cms_row["channel"]."</td>";
		//判断是否显示，表名，启用，栏目，字段管理4例
		if (checkManag($_SESSION["adminLov"])==true)
		{
			echo "<td class='$classname' align='center'>".$tablepre."".$cms_row["tabname"]."</td>";
			echo "<td class='$classname' align='center'>";  
			switch ($cms_row['show'])
			{
				case 0:
					echo "<a href=?act=upd&field=show&strnum=1&cmsid=".$cms_row["id"]."><b style='color:#ff0000'>×</b></a>";
					break;
				case 1:
					echo "<a href=?act=upd&field=show&strnum=0&cmsid=".$cms_row["id"]."><b style='color:#386BC8'>√</b></a>";
					break;	
			}
			echo "</td>";
			echo "<td class='$classname' align='center'>";
			switch ($cms_row['items']) 
			{
				case 0:
					echo "<a href=?act=upd&field=items&strnum=1&cmsid=".$cms_row["id"]."><b style='color:#ff0000'>×</b></a>";
					break;
				case 1:
					echo "<a href=?act=upd&field=items&strnum=0&cmsid=".$cms_row["id"]."><b style='color:#386BC8'>√</b></a>";
					break;	
			}
			echo "</td>";
			echo "<td class='$classname' align='center'><a href=admin_field.php?m=".$cms_row["id"]."&act=add>字段管理</a></td>";
			echo "<td class='$classname' align='center'><a href=admin_left.php?do=1&m=".$cms_row["id"].">左侧导航</a></td>";
		}//END if
		
		echo "<td class='$classname' align='center'>";
		echo "<form id='form1".$cms_row["id"]."' name='form1".$cms_row["id"]."' method=post action=admin_channel.php?act=supd&ID=".$cms_row["id"].">";
		echo "<input name='sequence' id='sequence' type='text' style='width:40px;' value=".$cms_row["sequence"].">";
		echo "&nbsp;<input type='submit' value='修改'>";
		echo "</form>";
		echo "</td>";
		echo "<td class='$classname' align='center'><a href=admin_channel.php?act=edit&tabid=".$cms_row["id"].">编辑</a> | ";
		if(checkManag($_SESSION["adminLov"])==true){echo "<a ".okConfirm("删除后不可恢复,确认要删除吗")." href=admin_channel.php?act=del&tabid=".$cms_row["id"].">删除</a>";}
		if(checkManag($_SESSION["adminLov"])==false){echo "<font style='color:#ccc;'>删除</font>";}
		echo "</td></tr>";
		$i=$i+1;  
		
  }//END while
?>
</table>
<?php

$stract = addslashes($_REQUEST["act"]);

switch ($stract)
{
case "edit":
	tabedit();
	break;
case "editsave":
	$channelname =addslashes($_REQUEST["itemname"]);
	$strid   =addslashes($_REQUEST["strid"]);
	$newmoban 	 = addslashes($_REQUEST["newmoban"]);
	$db->query("update ".$tablepre."channel set `channel`='$channelname',`newmoban`='$newmoban' where id=$strid");
	okUrl($_SERVER["HTTP_REFERER"]);
	break;
case "del":
	$tabid =$_REQUEST["tabid"];
	$tabName  =tabName($tabid);
	$db->query("delete  from ".$tablepre."channel where id=$tabid");//删除栏目表中的记录
	$db->query("delete  from ".$tablepre."field where SystemID=$tabid");//删除字段表中有关栏目的所有字段
	$db->query("DROP TABLE IF EXISTS $tabName");//删除表
	$deltabname=str_replace("".$tablepre."","","$tabName");
	deleteDir("../$deltabname");//删除文件夹
	ok("删除成功!",$_SERVER["HTTP_REFERER"],2);
	break;		
}
 
 
function tabedit()
{
	global $db;
	global $tablepre;
	$tabid =addslashes($_REQUEST["tabid"]);
	$itm_result=$db->query("select * from ".$tablepre."channel where id=$tabid");
	$itm_row=$db->fetch_array($itm_result);
	echo "<table id='tablehovered1' border='0' align='center' cellpadding='3' width='100%' cellspacing='1' class='tableborder'>";
	echo "<form name='form1' method='post' action=''>";
	echo "<input name='act' id='act' type='hidden' value='editsave' />";
	echo "<input name='strid' id='strid' type='hidden' value='".$tabid."' />";
	echo "<tr>";
	echo "<td width='32%' class='tablerow3' align='right'> 栏目名称</td>";
	echo "<td width='68%' class='tablerow3'><label>";
	echo "<input type='text' name='itemname' id='itemname' value='".$itm_row["channel"]."'>";
	echo "</label></td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td width='32%' class='tablerow3' align='right'> 新建模版</td>";
	echo "<td width='68%' class='tablerow3'><label>";
	if($itm_row['newmoban']){$yes='checked';$no='';}else{$yes='';$no='checked';}
	echo "<input type='radio' name='newmoban' ".$no." value='0'>否<input type='radio' name='newmoban' ".$yes." value='1'>是";
	echo "</label></td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td width='32%' class='tablerow3'>&nbsp;</td>";
	echo "<td width='68%' class='tablerow3'><label>";
	echo "<input type='submit' name='button' id='button' value='确认修改'>";
	echo "</label></td>";
	echo "</tr>";
	echo "</form>";
	echo "</table>";
}
$db->close();
?>

