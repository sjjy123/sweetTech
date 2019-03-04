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
	$SystemID =addslashes($_REQUEST["m"]);
	$tabName  =tabName($SystemID);
	$filedID  =addslashes($_REQUEST["fieldID"]);
	$ShowNum  =addslashes($_REQUEST["ShowNum"]);
	$strvalue =addslashes($_REQUEST["sequence"]);
	$stract =$_REQUEST["act"];
	switch ($stract)
	{
		case "show":
		    showField("show",$ShowNum,$filedID);//调用修改 show 字段的函数
		    break;
		case "islist":
		    showField("islist",$ShowNum,$filedID);//调用修改 show 字段的函数
		    break;	
		case "isaddlist":
		    showField("isaddlist",$ShowNum,$filedID);//调用修改 show 字段的函数
		    break;		
		case "updsequ": 
		     updSequence($strvalue,$filedID);
		   break;
	    case "edit": 
		     $strEditSql="Select * from ".$tablepre."field where id=$filedID";
		     $strEditResult=$db->query($strEditSql);
		     $strEditRow =$db->fetch_array($strEditResult);
		     $action="eidtsave";
		   break;
	    case "add":
	    	$action="savemain";
	    	break;	    	  
		case "alldel":
		$fieldName = addslashes($_REQUEST["fieldName"]);//字段名称
		echo $fieldName;
		$db->query("delete  from ".$tablepre."field where ID=$filedID");
		mysqli_query("alter table `$tabName` drop column `$fieldName`"); 
        okUrl("admin_field.php?m=$SystemID&act=add");
	}
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script language="javascript">
 function checkform()
 {
	var str;
	str=document.myform.fieldName.value;
	str=str.replace(/(^\s*)|(\s*$)/g, "");
	str=str.replace(/(^\s*)/g,"");
	str=str.replace(/(\s*$)/g,""); 
	if(str.length==0)
	{	
		alert("数值不能为空!!");
		document.myform.fieldName.focus();
		return false;
	}
	else
	{
	    str=str.replace(/(^[a-z]{1,})_{0,1}([a-z]{1,})(\d)?/i,"");//替换掉英文
		if(str.length>0)
		{
			alert("请输入一定长度的英文字符!");
			document.myform.fieldName.focus();
			return false;
		}
	}
	//判断字段描写输入框
	if(document.myform.fieldtxt.value=="")
	{
		alert("请输入字段描述");
		document.myform.fieldtxt.focus();
		return false;
	}
 }
</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<link rel="stylesheet" type="text/css" href="../system_style/css/style.css" />
<script type="text/javascript" src="../system_style/js/HxCms.js"></script>
</head>
<body>
<table id="tablehovered1" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
<tr>
	<th colspan="6">字段管理</th>
</tr>
<?php  
   $StrSql="Select * from ".$tablepre."field where SystemID=$SystemID order by sequence asc";
   $Result=$db->query($StrSql);
   $j=0;
   echo "<tr>";
   echo "<td align='center' class=tablerow3><b>字段名称</b></td>";
   echo "<td align='center' class=tablerow3><b>字段类型</b></td>";
   echo "<td class=tablerow3 align='center'><b>字段说明</b></td>";
   echo "<td class=tablerow3 align='center'><b>启用 | 文章列表 </b></td>";
   echo "<td class=tablerow3 align='center'><b>排序操作</b></td>";
   echo "<td class=tablerow3 align='center'><b>管理操作</b></td>"; 
   echo "</tr>";  
   while ($Row=$db->fetch_array($Result))
   {
   	$j++;
   	if ($j %2 ==0){$ClassName="tablerow1";}
   	else {$ClassName="tablerow2";}
   	//echo $Row['fieldtype'];
   	switch ($Row['fieldtype']) //显示数据类型
	{
		case 0: //文本
			 $strtype="varchar(255)" ; 
			break;
		case 1:  //数字
			$strtype="int(11)";
			break;
		case 2: //备注
			$strtype="text(255)";
			break;	
		case 3://日期
			$strtype="datetime(0)";
			break;
		case 4://是否
			$strtype="int(11)";
			break;
		case 5: //货币
			$strtype=" float(20)";
			break;			
	}
	// 是否启用
	switch ($Row['show'])
	{
		case 0:// 没有启用
		   $strshow="false(<a href=admin_field.php?act=show&m=$SystemID&ShowNum=1&fieldID=".$Row['ID']."><font style='color:#F00; font-weight:bold;'>×</font></a>)";
		   break;
		case 1:// 已经启用
		   $strshow="true(<a href=admin_field.php?act=show&m=$SystemID&ShowNum=0&fieldID=".$Row['ID']."><font style='color:#2f91b3; font-weight:bold;'>√</font></a>)";
		   break;
	}
	switch ($Row['islist'])
	{
		case 0:// 没有启用
		   $strlist="false(<a href=admin_field.php?act=islist&m=$SystemID&ShowNum=1&fieldID=".$Row['ID']."><font style='color:#F00; font-weight:bold;'>×</font></a>)";
		   break;
		case 1:// 已经启用
		   $strlist="true(<a href=admin_field.php?act=islist&m=$SystemID&ShowNum=0&fieldID=".$Row['ID']."><font style='color:#2f91b3; font-weight:bold;'>√</font></a>)";
		   break;
	}
	switch ($Row['isaddlist'])
	{
		case 0:// 没有启用
		   $strisaddlist="false(<a href=admin_field.php?act=isaddlist&m=$SystemID&ShowNum=1&fieldID=".$Row['ID']."><font style='color:#F00; font-weight:bold;'>×</font></a>)";
		   break;
		case 1:// 已经启用
		   $strisaddlist="true(<a href=admin_field.php?act=isaddlist&m=$SystemID&ShowNum=0&fieldID=".$Row['ID']."><font style='color:#2f91b3; font-weight:bold;'>√</font></a>)";
		   break;
	}
   	echo "<tr>";
    echo "<td align='center' class='$ClassName'>".$Row['fieldName']."";
	if ($Row["issystem"]==1) echo "&nbsp;&nbsp;<span style='color:#F00; font-size:11px'>[系统]</span>";
	echo "</td>";
    echo "<td class='$ClassName' align='center'>".$strtype."</td>";
    echo "<td class='$ClassName' align='center'>".$Row['fieldtxt']."</td>";
    echo "<td class='$ClassName' align='center'>".$strshow." | ".$strlist." </td>";
	echo "<td class='$ClassName' align='center'>";
	echo "<form name=upform method='post' action=admin_field.php?act=updsequ&fieldID=".$Row['ID']."&m=$SystemID>";
	echo "<input name='sequence' id='sequence' type='text' style='width:40px;' value=".$Row['sequence']." />";
	echo "&nbsp;&nbsp;<input type='submit' name='button' id='button' value='修改' />";
	echo "</form>";
	echo "</td>";
    echo "<td class='$ClassName' align='center'><a href=admin_field.php?act=edit&fieldID=".$Row['ID']."&m=$SystemID>编辑</a>";
	if($Row['issystem']==0)
	{
		echo "&nbsp;<a ".confirm()." href=admin_field.php?act=alldel&fieldID=".$Row['ID']."&m=$SystemID&fieldName=".$Row['fieldName'].">删除</a></td>";
	}
	else
	{
		echo "&nbsp;<font style='color: #ccc;'>删除</font>";
	}
    echo "</tr>"; 
   }
?>

</table>
<!--<input name="sequence" id="sequence" type="text"  value="" style="width:80px;"/>-->
<form name="myform" method="post" action="?action=<?php echo $action;?>" onSubmit="return checkform()">
<table id="tablehovered1" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
<tr>
	<th colspan="4">添加分类</th>
</tr>
<tr>
	<td align="right" class="tablerow2"><u title="MainDomain">字段名称</u>：</td>
	<td class="tablerow2"><label>
    <?php 
	 echo "<input name='fieldName' type='text' id='fieldName' value=".$strEditRow["fieldName"]."";
	      if ($strEditRow['issystem']==1&&checkManag($_SESSION["adminLov"])==false) echo " disabled='disabled' ";
	 echo " >";
	?>
      <input name="oldfieldName" type="hidden" id="oldfieldName"  value="<?php echo $strEditRow["fieldName"];?>" />
      <input name="m" id="m"  type="hidden" value="<?php echo $SystemID;?>">
      <INPUT type="hidden" name="fieldID" id="fieldID" value="<?php echo $filedID;?>" />
	</label>&nbsp;是否必填
	<label>
	  <input name="ismust" type="checkbox" id="ismust" value="1" <?php if($strEditRow["ismust"]==1){echo "checked";}?>/>
	</label>
	<?php if (checkManag($_SESSION["adminLov"])==true)
	{
		echo "&nbsp;<font style='color:#F00'>系统字段</font>";
		echo "<label>";
		echo " <input name='issystem' type='checkbox' id='issystem' value='1'";
		if($strEditRow["issystem"]==1){echo "checked";}
		echo "/></label>";
	}?>
    
    
	 
    </td>
	<td align="right" class="tablerow2"><u title="MainDomain">字段类型</u>：</td>
	<td class="tablerow2"><label>
	  <select name="fieldtype" id="fieldtype" <?php if ($strEditRow['issystem']==1&&checkManag($_SESSION["adminLov"])==false) echo " disabled='disabled' ";?> >
	    <option value="0" <?php if($strEditRow["fieldtype"]==0){echo "selected";}?> >文本型</option>
        <option value="1" <?php if($strEditRow["fieldtype"]==1){echo "selected";}?> >数字型</option>
	    <option value="2" <?php if($strEditRow["fieldtype"]==2){echo "selected";}?> >备注型</option>
	    <option value="3" <?php if($strEditRow["fieldtype"]==3){echo "selected";}?> >日期型</option>
        <option value="4" <?php if($strEditRow["fieldtype"]==4){echo "selected";}?> >是否型</option>
        <option value="5" <?php if($strEditRow["fieldtype"]==5){echo "selected";}?> >货币型</option>
	    </select>
    </label></td>
</tr>
<tr>
	<td align="right" class="tablerow1"><u title="MainDomain">字段描述</u>：</td>
	<td class="tablerow1"><label>
	  <input type="text" name="fieldtxt" id="fieldtxt" value="<?php echo $strEditRow["fieldtxt"];?>" />
    </label></td>
	<td align="right" class="tablerow1">输 出 框：</td>
	<td class="tablerow1"><label>
	  <select name="fieldout" id="fieldout" <?php if ($strEditRow['issystem']==1&&checkManag($_SESSION["adminLov"])==false) echo " disabled='disabled' ";?>>
	    <option value="0" <?php if($strEditRow["fieldout"]==0){echo "selected";}?> >单行文本框</option>
        <option value="1" <?php if($strEditRow["fieldout"]==1){echo "selected";}?> >多行文本框</option>
	    <option value="2" <?php if($strEditRow["fieldout"]==2){echo "selected";}?> >密码框</option>
	    <option value="3" <?php if($strEditRow["fieldout"]==3){echo "selected";}?> >单选框</option>
        <option value="4" <?php if($strEditRow["fieldout"]==4){echo "selected";}?> >多选框</option>
        <option value="5" <?php if($strEditRow["fieldout"]==5){echo "selected";}?> >下拉框</option>
        <option value="6" <?php if($strEditRow["fieldout"]==6){echo "selected";}?> >EWEB编辑框</option>
        <option value="7" <?php if($strEditRow["fieldout"]==7){echo "selected";}?> >EWEB简单编辑</option>
        <option value="13" <?php if($strEditRow["fieldout"]==13){echo "selected";}?>>FCK编辑框</option>
        <option value="14" <?php if($strEditRow["fieldout"]==14){echo "selected";}?>>FCK简单编辑</option> 
        <option value="8" <?php if($strEditRow["fieldout"]==8){echo "selected";}?> >上传图片[缩]</option>
        <option value="9" <?php if($strEditRow["fieldout"]==9){echo "selected";}?> >上传图片[多]</option>
        <option value="10" <?php if($strEditRow["fieldout"]==10){echo "selected";}?> >上传文件</option>
        <option value="11" <?php if($strEditRow["fieldout"]==11){echo "selected";}?> >无输入框</option>
        <option value="12" <?php if($strEditRow["fieldout"]==12){echo "selected";}?> >上传图片[单]</option>
	    </select>
    </label>&nbsp;&nbsp;输出框长度:
    <label>
      <input name="fieldlength" type="text" id="fieldlength"  style="width:50px;" value="<?php if($strEditRow["fieldlength"]==""){echo "220";}else{echo $strEditRow["fieldlength"];}?>"/>
    </label>&nbsp;单位<strong style="color:#F00">PX</strong>;</td>
</tr>
<tr> 
  <td align="right" class="tableline1"><u title="MainDomain">输入提示</u>：</td>
  <td class="tableline1"><label>
    <input type="text" name="fieldinfo" id="fieldinfo"  style="width:250px;" value="<?php echo stripcslashes($strEditRow["fieldinfo"]);?>"/>
  </label></td>
  <td align="right" class="tableline1">状　　态：</td>
  <td class="tableline1"><label>
    <input name="isshow" type="checkbox" id="isshow" value="1"  checked <?php //if($strEditRow["show"]==1 ){echo "checked";}?> />
  </label>
    <label>启用
      <input name="islist" type="checkbox" id="islist" value="1" <?php if($strEditRow["islist"]==1){echo "checked";}?> />
      文章列表
    </label>
  <!--   <label>
      <input name="isfield_list" type="checkbox" id="isfield_list" value="1" < ?php if($strEditRow["isfield_list"]==1){echo "checked";}?> />
      字段列表
    </label> -->   
    <br /></td>
</tr>
<tr>
  <td align="right" class="tableline2"><u title="MainDomain">字 段 值</u>：</td>
  <td align="left" class="tableline2" colspan="3"><label>
    <input type="text" name="fieldcontent" id="fieldcontent"  style="width:300px;" value="<?php echo $strEditRow["fieldcontent"];?>" <?php if ($strEditRow['issystem']==1&&checkManag($_SESSION["adminLov"])==false) echo " disabled='disabled' ";?>/>
    <input name="iscontent" type="radio" id="radio3" value="0"  <?php if($strEditRow["iscontent"]==0){echo "checked";}?> />
    两者都不是
    <input type="radio" name="iscontent" id="radio" value="1" <?php if($strEditRow["iscontent"]==1){echo "checked";}?> />
    启用普通
    <input type="radio" name="iscontent" id="radio2" value="2" <?php if($strEditRow["iscontent"]==2){echo "checked";}?> />
  启用Sql语句
  </label>
  &nbsp;&nbsp;默认值：<input type="text" name="fault" id="fault"  style="width:50px; font-size:12px;" value="<?php echo $strEditRow["fault"];?>"/>
 </td>
</tr>
<tr> 
  <td align="right" class="tableline1">&nbsp;</td>
  <td colspan="3" class="tableline1"><label>
    <input type="submit" name="button" id="button" class="yc_button" value="" />
  </label></td>
  </tr>
</table>
</form>
<table class="table1" cellspacing="1" cellpadding="3" align="center" border="0">
	<tr>
		<td class="tableline linetitle" width="200" align="left">&nbsp;</td>
		<td class="tableline" width="*" align="left"><!-- | <a href="add_classtype.php?m=< ?php echo $SystemID;?>&act=add">一级分类排序</a>-->
	    <strong>注：</strong>
        <br />1、任何表中都必须拥有：id,datetime 这些字段
        <br />2、添加密码框的时候。请添加一个 hash (小写) 字段.
        <Br />3、字段值的输入格式,若启用普通格式：值||显示文字*^*值||显示文字。
	    <br />4、若要启用Sql语句 一般为分类的时候用：“Select * from ".$tablepre."class where SystemID=1 order by sequence Asc”只修改SystemID的值即可
        <br />5、单选、多选的格式如下：0||多选1*^*1||多选2。
        <Br />6、简单编辑器的宽度可以改动，高度不能改变，一般编辑器的宽度和高度均不可改变，分别为：W:700*H:400,若要改动，请改源码.
        <br />7、是否必填字段，目前不支持编辑;
        <br />8、图片上传时:需设置上传图片的高度.宽度;格式：W||H;并启用普通模式;缩略图是等比缩放的。<font color="#003300">[缩]</font>：说明带有缩略图，<font color="#FF0000">[No]</font>：说明没有缩略图,<font color="#003300">[带缩略图的时候：请建立一个以"S_"开头与上传字段一样的名称。<font color="#FF0000">eg:上传字段的名称为:UploadIMG、那么应建立一个：s_UploadIMG的字段；可以不用显示。</font>,s:为小写]</font>
        <br />9、<font color="#FF0000">多选框</font>：启用Sql语句的时候，请用 ".$tablepre."classfiy 这个表。Select * from ".$tablepre."classfiy where SystemID=1 order by sequence Asc,颜色为：1、尺码为：2；
       
	    </td>
	</tr>
</table>
</body>
</html>
<?php
$action=addslashes($_REQUEST["action"]);
if($action=="savemain")
{
	$fieldName = addslashes($_POST["fieldName"]);//字段名称
	$fieldtype = addslashes($_POST["fieldtype"]);//字段类型
	$fieldtxt  = addslashes($_POST["fieldtxt"]); //字段描述
	$fieldout  = addslashes($_POST["fieldout"]); //输出框
	$SystemID  = addslashes($_REQUEST["m"]);     //获取项目ID
	$Sequence     = Sequence("".$tablepre."field","ID"); //获取ID的最大值
	$islist     =addslashes($_REQUEST["islist"]);
	$fieldlength =addslashes($_REQUEST["fieldlength"]); //获取输出字段的输出框长度
	$fieldinfo  =addslashes($_REQUEST["fieldinfo"]);// 字段提示说明;
	$show       =addslashes($_REQUEST["isshow"]); // 是否启用
	$fieldcontent = addslashes($_REQUEST["fieldcontent"]);//或者字段值的内容
	$iscontent  = addslashes($_REQUEST["iscontent"]); //获取启动状态，是启动普通文本值，还是Sql语句
	$CmsDate  = date("Y-m-d H:i:s",time()+3600*8);
	$ismust     =addslashes($_REQUEST["ismust"]); //是否必须填写
	$issystem     =addslashes($_REQUEST["issystem"]); //是否系统字段
	$fault    =addslashes($_REQUEST["fault"]); //默认值
	if((is_Tab($tabName,$fieldName)==false)||(is_Field($SystemID,$fieldName)==false))
	//if(is_field($SystemID,$fieldName)==false)
	{
		ok("该字段已经存在!","",1);
	}
	elseif ((is_Tab($tabName,$fieldName)==true)&&(is_Field($SystemID,$fieldName)==true))
	//elseif (is_field($SystemID,$fieldName)==true)
	{
	    $fieSql = "insert into ".$tablepre."field (`SystemID`,`fieldName`,`fieldtype`,`fieldtxt`,`fieldout`,`CmsDate`,`show`,`islist`,`fieldlength`,`fieldinfo`,`sequence`,`fieldcontent`,`iscontent`,`ismust`,`issystem`,`fault`) values ('$SystemID','$fieldName','$fieldtype','$fieldtxt','$fieldout','$CmsDate','$show','$islist','$fieldlength','$fieldinfo','$Sequence','$fieldcontent','$iscontent','$ismust','$issystem','$fault')";
	$db->query($fieSql);
	// 添加到表".$tablepre."fi
	switch ($fieldtype)
	{
		case 0: //文本
			 $type="varchar(255) default null" ; 
			break;
		case 1:  //数字
			$type="int(11) default 0";
			break;
		case 2: //备注
			$type="text(255) default null";
			break;	
		case 3://日期
			$type="datetime default null";
			break;
		case 4://是否
			$type="int(11) default 0";
			break;
		case 5: //货币
			$type=" float(20) default 0.00";
			break;			
	}

	$alSql="alter table `$tabName` add `$fieldName` $type ";
	$db->query($alSql);
	ok("字段添加成功!","admin_field.php?m=$SystemID&act=add",2);
	} 
}
else if($action=="eidtsave")
{
	$fieldid   = addslashes($_POST["fieldID"]);
	$oldfieldName =addslashes($_POST["oldfieldName"]);//原字段名
	$fieldName = addslashes($_POST["fieldName"]);//字段名称
	$fieldtype = addslashes($_POST["fieldtype"]);//字段类型
	$fieldtxt  = addslashes($_POST["fieldtxt"]); //字段描述
	$fieldout  = addslashes($_POST["fieldout"]); //输出框
	$SystemID  = addslashes($_REQUEST["m"]);     //获取项目ID
	$Sequence     = Sequence("".$tablepre."field","ID"); //获取ID的最大值
	$islist     =addslashes($_REQUEST["islist"]);
	$fieldlength =addslashes($_REQUEST["fieldlength"]); //获取输出字段的输出框长度
	$fieldinfo  =addslashes($_REQUEST["fieldinfo"]);// 字段提示说明;
	$show=addslashes($_POST["isshow"]); // 是否启用
	$fieldcontent = addslashes($_REQUEST["fieldcontent"]);//或者字段值的内容
	$iscontent  = addslashes($_REQUEST["iscontent"]); //获取启动状态，是启动普通文本值，还是Sql语句
	$CmsDate  = date("Y-m-d H:i:s",time()+3600*8);
	$ismust     =addslashes($_REQUEST["ismust"]); //是否必须填写
	$issystem     =addslashes($_REQUEST["issystem"]); //是否系统字段
	$fault    =addslashes($_REQUEST["fault"]); //默认值
	echo 111;
	if(is_Fieldedit($SystemID,$fieldName,$fieldid)==false)
	{
		ok("该字段已经存在!","",1);
	}
	elseif (is_Fieldedit($SystemID,$fieldName,$fieldid)==true)
	{
		 $fieSql = "update ".$tablepre."field set ";	
		 //    (系统字段)&&(超管理)||(非系统字段) 
		 if((isSystem($fieldid)==true&&checkManag($_SESSION["adminLov"])==true)||isSystem($fieldid)==false) // 是系统字段
		 {
		 	$fieSql=$fieSql. "`fieldName`='$fieldName',`fieldtype`='$fieldtype',`fieldout`='$fieldout',`fieldinfo`='$fieldinfo',`issystem`='$issystem',";
		 }
		 $fieSql =$fieSql."`fieldtxt`='$fieldtxt',`islist`='$islist',`fieldlength`='$fieldlength',`show`='$show',`iscontent`='$iscontent',`fieldcontent`='$fieldcontent',`ismust`='$ismust',`fault`='$fault' where ID=$fieldid";
		// if (issystem($fieldid)==true&&checkManag($_SESSION["adminLov"])==true);		 
		 $db->query($fieSql);
		 switch ($fieldtype)
		{
			case 0: //文本
				 $type="varchar(255) default null" ; 
				break;
			case 1:  //数字
				$type="int(11) default 0";
				break;
			case 2: //备注
				$type="text(255) default null";
				break;	
			case 3://日期
				$type="datetime default null";
				break;
			case 4://是否
				$type="int(11) default 0";
				break;
			case 5: //货币
				$type=" float(20) default 0.00";
				break;			
		}
		//    (系统字段)&&(超管理)||(非系统字段) 
		 if((isSystem($fieldid)==true&&checkManag($_SESSION["adminLov"])==true)||isSystem($fieldid)==false) // 是系统字段
		 {
		 		$alSql="alter table `$tabName` change `$oldfieldName` `$fieldName` $type ";
		 		$db->query($alSql);
		 }
		 ok("修改成功!","admin_field.php?m=$SystemID&act=add",2);
		 //okUrl("admin_field.php?m=$SystemID&act=add");
	}

}
$db->close();
?>