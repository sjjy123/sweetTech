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
	//include('../editor/fckeditor.php');
/////////////////////////////////////////////////////////////////////////////
/////////////////////读出网站基本数据////////////////////
/////////////////////////////////////////////////////////////////////////////
   $CmsSql="Select * from ".$tablepre."config where ID=1";
   $Result = $db->query($CmsSql);
   $Row = $db->fetch_array($Result);
   //print_r($Row);
   //Split 的一种用法
   list($hxcms_url,$hxcms_title,$hxcms_Emal,$hxcms_Number)=explode("/",$Row[$tablepre.'Config']);
   $hxcms_Copyright=$Row['hxcms_Copyright'];
   $hxcms_open =$Row['hxcms_open'];
   $hxcms_Content = $Row['hxcms_webContent'];
   $regkeywords   = $Row['regkeywords'];
   $Keywords      = $Row['Keywords'];
   $User_Config   = $Row['User_Config'];
   list($User_Name,$User_tel,$User_phone,$User_fax,$User_email,$User_address) =explode("‖",$User_Config);
   

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="../system_style/css/style.css" />
<script type="text/javascript" src="../system_style/js/HxCms.js"></script>
</head>
<body>
<?php
  // 保存页面信息 操作 Start()
 $action=$_REQUEST['action'];
 if ($action!="")
 {
 	switch ($action)
 	{
 		case "savemain";
	 		 echo savemain();
	 		break;
        case "saveconta";
	 		echo saveconta();
	 		break;
 	}
 } 
 // 保存页面信息 操作 end()
?>
<form name="myform" method="post" action="?action=savemain">
<table id="tablehovered1" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
<tr>
	<th colspan="2">网站基本信息 <span class="clicksubmit" onClick="document.myform.submit();">[保存设置]</span></th>
</tr>
<tr>
	<td class="tablerow1" width="25%" align="right"><u title="InstallDir">系统安装目录</u>：</td>
	<td class="tablerow1" width="75%"><?php echo $_SERVER['DOCUMENT_ROOT']; ?>&nbsp;</td>
</tr>
<tr>
	<td width="35%" align="right" class="tablerow2"><u title="MainDomain">网站域名</u>：</td><?php echo $Row['hxcms_url'];?>
	<td width="65%" class="tablerow2"><input name="hxcms_weburl" type="text" id="hxcms_weburl" value="<?php echo stripcslashes($Row['hxcms_weburl']);?>" size="35"> </td>
</tr>
<tr>
	<td class="tablerow1" align="right"><u title="MainSet1">网站名称</u>：</td>
	<td class="tablerow1"><input name="hxcms_webtitle" type="text" id="hxcms_webtitle" value="<?php echo stripcslashes($Row['hxcms_webtitle']);?>" size="35"></td>
</tr>
<tr>
	<td class="tablerow1" align="right"><u title="MainSet2">管理员Email</u>：</td>
	<td class="tablerow1"><input name="hxcms_webEmal" type="text" id="hxcms_webEmal" value="<?php echo stripcslashes($Row['hxcms_webEmal']);?>" size="35"></td>
</tr>
<tr>
	<td class="tablerow2" align="right"><u title="MainSet3">网站备案号：</u></td>
	<td class="tablerow2"><input name="hxcms_webNumber" type="text" id="hxcms_webNumber" value="<?php echo stripcslashes($Row['hxcms_webNumber']);?>" size="35"></td>
</tr>
<tr>
	<td class="tablerow1" align="right"><u title="MainSet4">网站版权信息</u>：</td>
	<td class="tablerow1"><textarea name="hxcms_webCopyright" cols="60" rows="5" id="hxcms_webCopyright"><?php echo stripcslashes($Row['hxcms_webCopyright']);?></textarea></td>
</tr>
<tr>
	<td class="tablerow2" align="right"><u title="MainSet5">网站访问状态</u>：</td>
	<td class="tablerow2">
		<input name="hxcms_webopen" type="radio" value="0" <?php if($Row['hxcms_webopen']==0){echo "checked";}?>  /> 打开
		<input name="hxcms_webopen" type="radio" value="1" <?php if($Row['hxcms_webopen']==1){echo "checked";}?>/> 关闭
	</td>
</tr>
<tr>
	<td class="tablerow1" align="right"><u title="MainSet6">网站访问状态说明(支持HTML语法)</u>：</td>
	<td class="tablerow1">123    </td>
</tr>
<tr>
	<td class="tablerow2" align="right"><u title="MainSetting(35)">禁止的用户名中包含的字符</u>：<br/>每个字符请使用,(英文逗号)分隔</td>
	<td class="tablerow2"><input name="regkeywords" type="text" id="regkeywords" style="width:400px;" value="<?php echo $Row['regkeywords'];?>">
	<font color="red">* 用户名中所包含的此字符将被禁止使用</font></td>
</tr>
<tr>
	<td class="tablerow1" align="right"><u title="MainSetting(4)">站点关键字</u>：<br/>搜索引擎用来搜索您网站的关键内容</td>
	<td class="tablerow1"><textarea name="Keywords" cols="80" rows="4" id="Keywords"><?php echo $Row['Keywords'];?></textarea></td>
</tr>
<tr>
	<td class="tablerow2" align="right">&nbsp;</td>
	<td class="tablerow2"><input type="submit" value="保存设置" name="submit_button" id="submit_button" class="button"> </td>
</tr>
</table>
</form>
<form name="myconta" method="post" action="?action=saveconta">
<table id="tablehovered1" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
<tr>
	<th colspan="2">联系方式</th>
</tr>
<tr>
	<td class="tablerow1" width="25%" align="right"><u title="InstallDir">系统安装目录</u>：</td>
	<td class="tablerow1" width="75%"><?php echo $_SERVER['DOCUMENT_ROOT']; ?>&nbsp;</td>
</tr>
<tr>
	<td class="tablerow1" align="right"><u title="MainSet1">联 系 人</u>：</td>
	<td class="tablerow1"><input name="User_Name" type="text" id="User_Name" value="<?php echo stripcslashes($User_Name);?>" size="35"></td>
</tr>
<tr>
	<td width="35%" align="right" class="tablerow2"><u title="MainDomain">固定电话</u>：</td>
	<td width="65%" class="tablerow2"><input name="User_tel" type="text" id="User_tel" value="<?php echo stripcslashes($User_tel);?>" size="35"> </td>
</tr>
<tr>
	<td class="tablerow1" align="right"><u title="MainSet1">联系手机</u>：</td>
	<td class="tablerow1"><input name="User_phone" type="text" id="User_phone" value="<?php echo stripcslashes($User_phone);?>" size="35"></td>
</tr>
<tr>
	<td width="35%" align="right" class="tablerow2"><u>传　　真</u>：</td>
	<td width="65%" class="tablerow2"><input name="User_fax" type="text" id="User_fax" value="<?php echo stripcslashes($User_fax);?>" size="35"> </td>
</tr>
<tr>
	<td class="tablerow1" align="right"><u title="MainSet1">联系邮箱</u>：</td>
	<td class="tablerow1"><input name="User_email" type="text" id="User_email" value="<?php echo stripcslashes($User_email);?>" size="35"></td>
</tr>
<tr>
	<td width="35%" align="right" class="tablerow2"><u>联系地址</u>：</td>
	<td width="65%" class="tablerow2"><input name="User_address" type="text" id="User_address" value="<?php echo stripcslashes($User_address);?>" size="35"> </td>
</tr>
<tr>
	<td class="tablerow1" align="right">&nbsp;</td>
	<td class="tablerow1"><input type="submit" value="保存设置" name="submit_button" id="submit_button" class="button"> </td>
</tr>
</table>
</form>
<?php

  function savemain()  //保存网站基本信息
  { 
  		global $tablepre;
  	 $hxcms_weburl       = addslashes($_POST["hxcms_weburl"]);   //域名
	 $hxcms_webtitle     = addslashes($_POST['hxcms_webtitle']); //网站名称
  	 $hxcms_webEmal      = addslashes($_POST['hxcms_webEmal']);  //邮件
	 $hxcms_webNumber    = addslashes($_POST['hxcms_webNumber']);//备案号
	 $hxcms_webCopyright = addslashes($_POST['hxcms_webCopyright']);//网站版权信息
	 $hxcms_webopen      = addslashes($_POST['hxcms_webopen']);        // 网站打开状态
	 $regkeywords        = addslashes($_POST['regkeywords']); 
	 $Keywords           = addslashes($_POST['Keywords']);
	 //合并信息
	 $hxcms_webConfig =$hxcms_weburl."/".$hxcms_webtitle."/".$hxcms_webEmal."/".$hxcms_webNumber;
    //  $hxcms_date =date("Y-m-d H:i:s",time()+3600*8);
     date_default_timezone_set('PRC');//定义时区
     $hxcms_date =date("Y-m-d H:i:s");
     //Sql语句
     $CmsSql = "Update ".$tablepre."Config set ";
     $CmsSql = $CmsSql . "hxcms_weburl      ='$hxcms_weburl' ";   
     $CmsSql = $CmsSql . ",hxcms_webtitle    ='$hxcms_webtitle' "; 
     $CmsSql = $CmsSql . ",hxcms_webopen     ='$hxcms_webopen' "; 
     $CmsSql = $CmsSql . ",hxcms_webEmal      ='$hxcms_weburl' ";   
     $CmsSql = $CmsSql . ",hxcms_webNumber    ='$hxcms_webNumber' "; 
	 $CmsSql = $CmsSql . ",hxcms_webCopyright='$hxcms_webCopyright' ";
	 $CmsSql = $CmsSql . ",regkeywords      ='$regkeywords' ";
	 $CmsSql = $CmsSql . ",Keywords         ='$Keywords' ";
     $CmsSql = $CmsSql . ",hxcms_date       ='$hxcms_date' ";
     // $CmsSql = $CmsSql ." where ID=" 
      global $db; 
     if(!$db->query($CmsSql)){die("数据库错误<br>");}
	  echo ok("信息更新成功","admin_setting.php",2);
  }
  
  function saveconta()//保存网站图片上传信息配置;
  {
	  global $tablepre;
  	$User_Name    = addslashes($_REQUEST["User_Name"]); //联系人
	$User_tel     = addslashes($_REQUEST["User_tel"]);   //联系电话
	$User_phone   = addslashes($_REQUEST["User_phone"]);//联系手机
	$User_fax     = addslashes($_REQUEST["User_fax"]);    //传真
	$User_email   = addslashes($_REQUEST["User_email"]); //邮箱
	$User_address = addslashes($_REQUEST["User_address"]);//联系地址
	$User_Config  = $User_Name."‖".$User_tel."‖".$User_phone."‖".$User_fax."‖".$User_email."‖".$User_address;
	global $db; 
    if(!$db->query("update ".$tablepre."config set `User_Config`='$User_Config' where ID=1")){die("数据库错误<br>");}
	 echo ok("信息更新成功","admin_setting.php",2);
  }
  $db->Close();
 ?>
</body>
</html>