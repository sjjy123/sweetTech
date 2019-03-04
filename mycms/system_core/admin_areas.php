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
	$ID       = addslashes($_REQUEST['ID']);
	
	if(addslashes($_REQUEST['act'])=='del') {
 		$db->query("delete from ".$tablepre."areas where ID=$ID");
		header("location:admin_areas.php");
  }
	
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<link rel="stylesheet" type="text/css" href="../system_style/css/style.css" />
<script type="text/javascript" src="../system_style/js/HxCms.js"></script>
<script type="text/javascript" src="../system_style/js/jquery-1.4.2.js"></script>
</head>
<body>
<script language="javascript">
function stemp(stemp,id,value)
{//alert(stemp+"aa"+id+"bb"+value);
	$.get("admin_stemp.php?t="+new Date()+")",{action:'stemp',field:stemp,id:id,tabname:'".$tablepre."class',val:value},function(responseHTML){
	$("#"+stemp+"_"+id).html(responseHTML);
	//alert("aa");
	})	
}	
 function checkform()
 {
 	if(document.myform.ClassName.value=="")
	{
		document.getElementById("ClassNameHTML").innerHTML="&nbsp;&nbsp;信息不能为空";
		document.myform.ClassName.focus();
		return false;
	}
 }
</script>
<?php include_once("areastop.php");?>
<table id="tablehovered" align="center" class="tableborder" cellspacing="1" cellpadding="2">
  <tr>
    <?php if ($_SESSION["adminLov"]>=1) { ?>
    <th noWrap width="7%">分类编号</th>
    <th width="41%">分类名称</th>
    <th width="24%">管理选项</th>
    <th width="9%">启 用</th>
    <th  width="19%">分类排序</th>
    <?php }else{ ?>
    <th noWrap width="7%">分类编号</th>
    <th >分类名称</th>
    <th width="24%">管理选项</th>
    <?php } ?>
  </tr>
  <?php
	if ($_SESSION["adminLov"]>=1) { 
		$Cmsql = "Select * from ".$tablepre."areas where 1 order by Sequence Asc";
	}else{
		$Cmsql = "Select * from ".$tablepre."areas where 1 order by Sequence Asc";
	}
	//echo $Cmsql;
	$Result= $db->query($Cmsql);
	while ($Row=$db->fetch_array($Result)) 
	{
		$Class_arr[]=array($Row["ID"],$Row["ClassName"],$Row["ClassNameEng"],$Row["Depth"],$Row["partid"],$Row["Sequence"],$Row["Num"],$Row["show"],"ParPath"=>$Row["ParPath"],"yc_paixu"=>$Row["ycpaixu"]);
	}

	if(!empty($Class_arr)){
		foreach ($Class_arr as $key => $value) {
			$ParPath[$key] = $value['partid'];
		}
		array_multisort($ParPath, $Class_arr);//数组排序
	}

	if ($_SESSION["adminLov"]>=1) { 
		ShowAreas(0,true);
	}else{
		//我当前有的分类权限adminclassKj
		ShowAreas2(0,true);
	}
	//输出分类内容  
 ?>
</table>
<?php

 /*
 修改排序编号 方便排序；act=upd
 */  
 if(addslashes($_REQUEST["act"])=="upd")
 {
 	$SystemID=addslashes($_REQUEST["m"]);
 	if(is_numeric(addslashes($_REQUEST["sequeceID"])))//判断是否为数字
 	{
 		$sequeceID=addslashes($_REQUEST["sequeceID"]);
		$sequeceID_paixu=str_pad($sequeceID,5,"0",STR_PAD_LEFT);//输入的排序数值生成5位
		$ID =addslashes($_REQUEST["ID"]);
		$sel_sql=$db->query("select * from ".$tablepre."areas where ID=".$ID);
		$sel_row=$db->fetch_array($sel_sql);
		//生成自身的排序值--开始
		$sel_row_parpath=explode(',',$sel_row['ParPath']);
		if(count($sel_row_parpath)>1){
			for($i=1;$i<count($sel_row_parpath);$i++){//循环生成父级分类集合的排序
				if($i==1){
					$yc_px=cms_get_fsequence($sel_row_parpath[$i]);
					$sequeceID_px=str_pad($yc_px,5,"0",STR_PAD_LEFT);
				}else{
					$yc_px=cms_get_fsequence($sel_row_parpath[$i]);
					$sequeceID_px.=','.str_pad($yc_px,5,"0",STR_PAD_LEFT);
				}
			}
			$sequeceID_paixu=$sequeceID_px.','.$sequeceID_paixu;
		}
		//生成自身的排序值--结束
		$UpSql="update ".$tablepre."areas set sequence=$sequeceID where ID=$ID";
 		$db->query($UpSql);
		$UpSql="update ".$tablepre."areas set ycpaixu='$sequeceID_paixu' where ID=$ID";
 		$db->query($UpSql);
		cms_get_digui_sequence($ID,$sequeceID_paixu);//子分类的排序值修改
		echo "<script language=\"JavaScript\">";
  		echo "location.replace(\"admin_areas.php\")";
  		echo "</script>";
 	}
 	else
 	{
 		ok("请不要输入非数字的值或者空置","admin_areas.php",1);
 		exit();
 	}
 }
 $db->close();
 
?>
</body>
</html>
