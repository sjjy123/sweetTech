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
	$strid =$_REQUEST["stids"];

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
<?=$htmls?>
<form name="myform" method="post" action="admin_save.php?action=editsave" onSubmit="return checkform()">
<INPUT type="hidden" id="strid" value="<?=$strid?>" name="strid">
<table id="tablehovered1" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
<tr>
	<th colspan="2">添加信息</th>
</tr>

<?php
$cms_sql="select * from $tabName where id=$strid";
$cms_result=$db->query($cms_sql);
$cms_row=$db->fetch_array($cms_result);
$fieSql="Select * from ".$tablepre."field where SystemID=$SystemID order by sequence asc";
 	$fieResult = $db->query($fieSql);
 	$x=0;
 	while ($fieRow=$db->fetch_array($fieResult))
 	{
 		if ($fieRow['show']==1) //判断字段是否显示
 		{
 			//获取样式 Start
 			if($x%2==0) 
 			{
 				$strclassname="tablerow1";
 			}
 			else 
 			{
 				$strclassname="tablerow2";
 			}
 			// 获取样式 end
 			echo "<tr>";
 			echo "<td width='20%' align='right' class='$strclassname' >".$fieRow['fieldtxt']."：</td>";
 			echo "<td width='85%' class='$strclassname'>";
 			//Start				
			echo showfieldout($fieRow['fieldout'],$fieRow['fieldName'],$fieRow['fieldlength'],$fieRow['fieldcontent'],$fieRow['iscontent'],$fieRow['fault'],$cms_row[$fieRow['fieldName']],$SystemID);
 			
			
 			//Start
 			if($fieRow['fieldinfo']!="")
 			{
 				echo "&nbsp;&nbsp;<font style='color:#F00'>注</font>：<span style='color:#FF3C3C'>".$fieRow['fieldinfo']."</span>";
 			}
 			// end 
 			
 			echo "</td>";
 			echo "</tr>";	
 			$x++;
 		}
 	}
?>
<tr><td class="tablerow3">&nbsp;</td><td class="tablerow3"><input type="submit" class="yc_button" name="button" id="button" value="" style="width:100px; height:30px; font-size:13px" /></td></tr>
</table>
</form>
<?php 
 //调用检测表单函数；
 checkmyform($SystemID);
?>
<script type="text/javascript" src="../system_style/datejs/date.js"></script>
</body>
</html>
