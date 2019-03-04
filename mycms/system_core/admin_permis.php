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
	
	//获取栏目ID
	$strid =addslashes($_REQUEST["strid"]);
	$con_result=$db->query("select * from ".$tablepre."admin where ID=$strid");
	$con_row=$db->fetch_array($con_result);
	$check_value=$con_row["adminConfig"];
	$class_value=$con_row["adminclass"];
	$tabName  =$tablepre."admin";
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<link rel="stylesheet" type="text/css" href="../system_style/css/style.css" />
<script type="text/javascript" src="../system_style/js/HxCms.js"></script>
<title>无标题文档</title>
</head>
<body>
<?php 
include_once("admin_member_top.php");
?>
<table id="tablehovered1" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder" >
  <form name="myform" method="post" action="admin_permis.php?action=savemain">
  <INPUT type="hidden" name="strid" value="<?=$strid?>" id="strid">
    <tr>
      <th colspan="2">设置权限</th>
    </tr>
    <tr>
      <td class="tablerow1" align="right" width="10%">栏目名称：</td>
      <td class="tablerow1">
      <label>
      <?php 
	   $prm_sql="select * from ".$tablepre."channel where `show`=1 order by id asc";
	   $prm_result=$db->query($prm_sql);
	   while ($prm_row=$db->fetch_array($prm_result))
	   {
	   	echo "&nbsp;&nbsp;<input type='checkbox' name='perbok[]' id='perbok' value='".$prm_row["id"]."' ";
	   	$con_value=explode(",",$check_value);
	   	for ($k=0;$k<count($con_value);$k++)
	   	{
	   		if($con_value[$k]==$prm_row["id"]){echo "checked";}
	   	}
	   	echo " />&nbsp;<span style='vertical-align:middle'>".$prm_row["channel"]."</span>";
	   }
	  ?>
      </label></td>
    </tr>
<!--    <tr>
      <td class="tablerow1" align="right" width="10%">管理的活动线路：</td>
      <td class="tablerow1">
      <label>
      < ?php 
	   $mysql=$db->query("select * from hxcms_class where `show`=1 and SystemID=22 and depth=0 order by sequence asc");
	   while ($rs=$db->fetch_array($mysql))
	   {
	   	echo "&nbsp;&nbsp;<input type='checkbox' name='classper[]' id='classper' value='".$rs["ID"]."' ";
	   	$con_class=explode(",",$class_value);
	   	for ($mk=0;$mk<count($con_class);$mk++)
	   	{
	   		if($con_class[$mk]==$rs["ID"]){echo "checked";}
	   	}
	   	echo " />&nbsp;<span style='vertical-align:middle'>".$rs["ClassName"]."</span>";
	   }
	  ?>
      </label></td>
    </tr>-->
    <tr>
      <td class="tablerow1" align="right">&nbsp;</td>
      <td class="tablerow1"><input type="submit" value="保存设置" name="submit_button" id="submit_button" class="button"></td>
    </tr>
  </form>
</table>
</body>
</html>
<?php 
 if (addslashes($_REQUEST["action"])=="savemain")
 {
 	$strid=addslashes($_REQUEST["strid"]);
 	$drop_arr=$_REQUEST["perbok"];
	$class_arr=$_REQUEST["classper"];
	for ($k=0;$k<count($drop_arr);$k++)
	{
		if($k==0){$drop=$drop_arr[0];}
		if($k >0){$drop=$drop.",".$drop_arr[$k];}
	}
	$str_value=$drop;

	for ($k=0;$k<count($class_arr);$k++)
	{
		if($k==0){$class=$class_arr[0];}
		if($k >0){$class=$class.",".$class_arr[$k];}
	}
	$adminclass=$class;

	$db->query("update ".$tablepre."admin set `adminConfig`='$str_value',`adminclass`='$adminclass' where ID= $strid");
	ok("权限设置成功!",$_SERVER['HTTP_REFERER'],2);
 }
  $db->close();
?>