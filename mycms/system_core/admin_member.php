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
 if (addslashes($_REQUEST["act"])=="edit")
 {
 	$strid=addslashes($_REQUEST["strid"]);
 	$strsql=$db->query("select * from ".$tablepre."admin where id=$strid");
 	$strrow=$db->fetch_array($strsql);
 	$str_username=$strrow["adminName"];
 	$str_adminLov=$strrow["adminLov"];
    $stract ="saveedit";
 }
 else
 {
	 $stract ="savemain";
 }
?>
<table id="tablehovered1" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder" >
  <form name="myform" method="post" action="?action=<?=$stract?>&strid=<?=$strid?>" onSubmit="return checkform()">
  	<?php if($_SESSION["adminLov"]>0){?>
    <tr>
      <th colspan="2">添加管理员</th>
    </tr>
    <tr>
      <td class="tablerow1" align="right" width="30%"><u>
        管理员名称</u>：</td>
      <td class="tablerow1">
        <input name="UserName" type="text" id="UserName"  size="35" value="<?php echo $str_username;?>">
      <span class="Warning"><font id="ClassNameHTML"></font></span></td>
    </tr>
    <tr>
      <td class="tablerow2" align="right"><u title="MainDomain">账号密码</u>：</td>
      <td class="tablerow2"><input name="password" type="password" id="password"  size="35" maxlength="20"></td>
    </tr>
    <tr>
      <td class="tablerow1" align="right"><u title="MainDomain">确认密码</u>：</td>
      <td class="tablerow1"><input name="password1" type="password" id="password1"  size="35" maxlength="20" ></td>
    </tr>
    <tr>
      <td class="tablerow2" align="right"><u title="MainDomain">管理权限</u>：</td>
      <td class="tablerow2">
          <?php 
          echo " <label>";
          if (checkManag($_SESSION["adminLov"])==true)
          {
	          echo "<input type='radio' name='admin_lov' id='admin_lov' value='520' ";
			  if ($str_adminLov==520){echo "checked";}
			  echo "/>";
	          echo "网站制作者";
          }
          echo "<input type='radio' name='admin_lov' id='admin_lov' value='1' ";
		  if ($str_adminLov==1){echo "checked";}
		  echo "/>";
          echo "超级管理员";
          echo "<input type='radio' name='admin_lov' id='admin_lov' value='0' ";
		  if ($str_adminLov==0){echo "checked";}
		  echo "/>";
          echo "普通管理员";
          echo "</label>";
          ?>
      </td>
    </tr>
    <tr>
      <td class="tablerow1" align="right">&nbsp;</td>
      <td class="tablerow1"><input type="submit" value="保存设置" name="submit_button" id="submit_button" class="button"></td>
    </tr>
    <?php }?>
  </form>
</table>
<script language="javascript">
function checkform()
{
   var str;
	str=document.myform.UserName.value;
	str=str.replace(/(^\s*)|(\s*$)/g, "");
	str=str.replace(/(^\s*)/g,"");
	str=str.replace(/(\s*$)/g,""); 
	if(str.length==0)
	{	
		alert("用户名不能为空!!");
		document.myform.UserName.focus();
		return false;
	}
	else
	{
	    str=str.replace(/(^[a-z]{1,})([a-z]{1,})?/i,"");//替换掉英文
		if(str.length>0)
		{
			alert("请输入一定长度的英文字符!");
			document.myform.UserName.focus();
			return false;
		}
	}
	//判断密码
	pass =document.myform.password.value;
	pass1=document.myform.password1.value;
	if(pass!=pass1)
	{
		alert("两次密码不相对请重新输入!");
		return false;
	}
	if(pass=="" || pass1=="")
	{
		alert("请输入密码!!")
		return false;
	}
	
	 var actncheck=document.getElementsByName("admin_lov");
	 for   (var i=0;i<actncheck.length;i++)
	 {
          if(actncheck[i].checked==true)
		  {
			  var flag=true;
			  break;
		  }  
     }
	 if(!flag)
	   {
		 alert("请选管理权限");
		 return false;   
	   }
}
</script>
</body>
</html>
<?php 
 $stract =addslashes($_REQUEST["action"]);
  switch ($stract)
  {
  	case "savemain":
  		 $UserName   = addslashes($_REQUEST["UserName"]);
  		 if (checkstr($UserName)==true){ok("$UserName 为非法名称","",1);}
  		 $password   = md5(addslashes($_REQUEST["password"]));
  		 $admin_lov   = addslashes($_REQUEST["admin_lov"]);
  		 $adminloack = randmon(5);
  		 $cmspassword=md5($password.$admin_lov.$adminloack);//更改权限后，请重置密码
  		 $adminDate  = date("Y-m-d H:i:s",time()+3600*8);
  		 if(checkrecords($tablepre."admin","adminName",$UserName)==true)
  		 {
  		 	ok("用户名已经存在,请重新输入","",1);
  		 }
  		 else
  		 {
  		 	$db->query("insert into ".$tablepre."admin (`adminName`,`adminPassWord`,`adminLov`,`adminlock`,`adminDate`) values ('$UserName','$cmspassword','$admin_lov','$adminloack','$adminDate')");
  		 ok("管理员添加成功!请设置权限","admin_member.php",2);
  		 }  
  		break;
  	case "saveedit":
  		$strid=addslashes($_REQUEST["strid"]); 
  		 $password   = md5(addslashes($_REQUEST["password"]));
  		 $admin_lov   = addslashes($_REQUEST["admin_lov"]);
  		 $adminloack = cms_get_randmon(5);
  		 $cmspassword=md5($password.$admin_lov.$adminloack);//更改权限后，请重置密码
  		 $db->query("update ".$tablepre."admin set `adminPassWord`='$cmspassword',`adminLov`='$admin_lov',`adminlock`='$adminloack' where ID=".$strid);
  		 ok("修改成功!请设置权限","admin_member.php",2);
  		break;
	case "del":
		 $strid=addslashes($_REQUEST["strid"]);
	     $db->query("delete  from ".$tablepre."admin where ID=".$strid);
		 ok("删除成功","admin_member.php",2);
  		break;	
  }
  $db->close();
?>