function upbg(gid)
{
	var cname = gid.className;
	if (cname=='uname')	{gid.className = 'uname2';}
	if (cname=='uname2'){gid.className = 'uname';}
	
	if (cname=='upswd')	{gid.className = 'upswd2';}
	if (cname=='upswd2'){gid.className = 'upswd';}
	
	if (cname=='ucode')	{gid.className = 'ucode2';}
	if (cname=='ucode2'){gid.className = 'ucode';}
}


function check(){
	var username = document.myLogin.username;
	var password = document.myLogin.password;
	var code = document.myLogin.code;
	
	if(username.value=='' || username.value=='用户名'){
		document.getElementById('login_msg').innerHTML='提示：用户名不能为空！';
		username.focus();
		
		return false;
	}
	if(password.value=="" || password.value=='密码'){;
		document.getElementById('login_msg').innerHTML='提示：密码不能为空！';
		password.focus();
		return false;
	}
	if(code.value=="" || code.value=='验证码'){;
		document.getElementById('login_msg').innerHTML='提示：验证码不能为空！';
		code.focus();
		return false;
	}
}