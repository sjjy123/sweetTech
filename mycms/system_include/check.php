<?php 
session_start();
header("Pragma:no-cache\r\n");
header("Cache-Control:no-cache\r\n");
header("Expires:0\r\n");
header("Content-Type: text/html; charset=uft-8");
define('INIT_XMALL',true);
define('INIT_ROOT','../');
ob_start();
require_once("conn.php");

// 用户登陆验证
$adminUserName = $_POST['adminUserName'];
$adminPassWord = md5($_POST['adminPassWord']);
$adminCode     = $_POST['adminCode'];

// 验证码是否正确
if ($adminCode!=$_SESSION['mycms_code'] && $adminUserName!="admin") {echo ok("验证码有误！",-1,1);}// 当输入帐号为admin时不验证
// 用户名是否存在
if(checkrecords($tablepre."admin","adminName",$adminUserName)==false){echo ok("账号不存在！！",-1,1);}
// 验证密码
if (checkrecords($tablepre."admin","adminName",$adminUserName)==true)
{
	$str_result = $db->query("SELECT * FROM ".$tablepre."admin WHERE adminName = '$adminUserName'");
	$str_row = $db->fetch_array($str_result);
	$strpassoword = md5($adminPassWord.$str_row["adminLov"].$str_row["adminLock"]);

	$adminSql = "SELECT * FROM ".$tablepre."admin WHERE adminName = '$adminUserName' and adminPassWord='$strpassoword'";
	$result = $db->query($adminSql);

	if($db->num_rows($result)==0){
		echo ok("帐号或者密码错误，请重新输入！",-1,1);
		exit();
	}
	else
	{
		$adminrow=$db->fetch_array($result);
		$_SESSION["adminID"]   = $adminrow['ID'];
		$_SESSION["adminName"] = $adminrow['adminName'];
		$_SESSION["adminLov"]  = $adminrow['adminLov'];
		$_SESSION["adminClass"]= $adminrow['adminClass'];//分类权限
		header("location:../system_core/index.php");
		exit();
	}	
}
?>
