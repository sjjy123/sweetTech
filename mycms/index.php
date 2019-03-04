<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>企业信息管理系统_用户登录</title>
<link rel="stylesheet" type="text/css" href="system_style/css/login.css" />
<script src="system_style/js/form.js" type="text/javascript"></script>
<script src="system_style/js/login.js" type="text/javascript"></script>
<script type="text/javascript">
function check(form){
	if (document.myform.adminUserName.value ==""){
	  alert('帐号不能为空！');
	  document.myform.adminUserName.focus();
	  return false;
	}
	if (document.myform.adminPassWord.value ==""){
	  alert('密码不能为空！');
	  document.myform.adminPassWord.focus();
	  return false;
	}
	if (document.myform.adminCode.value ==""){
	  //alert('验证码不能为空！');
	  //document.myform.adminCode.focus();
	  //return false;
	}
return true;
}
</script>
</head>

<body>
<div class="login_div">
<div class="top">
<img src="system_style/images/logo.png" height="50" />&nbsp;
<img src="system_style/images/login_title.jpg" width="217" height="33" />
</div><!-- END top -->
<div class="middle">
<form action="system_include/check.php" method="post" name="myform" onsubmit="return check(this)">
<div><input name="adminUserName" type="text" class="uname" id="adminUserName" onfocus="upbg(this);if(value=='用户名')value='';" onblur="upbg(this)" value="<?php if(isset($_COOKIE["re_username"])){echo $_COOKIE["re_username"];}else{echo '用户名';}?>" maxlength="20" onkeyup="value=value.replace(/[^\w\.\/]/ig,'')" /></div>
<div><input name="adminPassWord" type="password" class="upswd" id="adminPassWord" onfocus="upbg(this);if(value=='密码')value='';type='password';" onblur="upbg(this)" value="密码" maxlength="30" onkeyup="value=value.replace(/[^\w\.\/]/ig,'')" /></div>
<div>
    <input name="adminCode" type="text" class="ucode" id="code" onfocus="upbg(this);if(value=='验证码')value='';" onblur="upbg(this)" value="验证码" maxlength="4" onkeyup="value=value.replace(/[^\w\.\/]/ig,'')" />
    <img src="system_include/code.php" width="60" height="21" border="0" onClick="this.src=this.src+'?'" style="vertical-align:inherit;margin-left:5px;cursor:pointer;"  alt="看不清？点击更换"/>
</div>
<!--<div class="name_on">
<span class="left"><input name="name_on" type="checkbox" checked="checked" id="name_on" value="1" class="styled" />记住帐号</span>
<span class="right"><a href="#">忘记密码？</a></span>
</div>-->

<div><input type="submit" name="button" id="button" class="loginan" value="" /></div>
<div id="login_msg"></div>
</form>
</div><!-- END middle -->
<div class="bottom">
COPYRIGHT(C)2013 ALL RIGHTS DESIGNED BY ***.COM
</div><!-- END bottom -->
</div>

</body>
</html>