<?php
ob_start();// 防止PHP环境中output_buffering参数未开始出错
error_reporting(E_ALL & ~ E_NOTICE);
date_default_timezone_set('PRC');// 取中国的标准时区

// [CH] 以下变量请根据空间商提供的账号参数修改,如有疑问,请联系服务器提供商
	$dbhost = '127.0.0.1';			// 数据库服务器,mysql 默认端口3306
	$dbuser = 'root';			    // 数据库用户名
	$dbpw = '';				// 数据库密码Chihu!@#456xlc
	$dbname = 'sq_bofeike';			// 数据库名
	$pconnect = 0;				    // 数据库持久连接 0=关闭, 1=打开
	$tablepre = 'cms_';   		// 表名前缀, 同一数据库安装多网站
	$dbcharset = 'utf8';			// 定义数据库链接的编码
	$time = 0;
// 常用变量设置:
	$WebSite_Title = "企业信息管理系统";

// 邮件发送myemail类参数设置如下
	$smtpServer = "smtp.163.com";			// SMTP服务器，如：smtp.qq.com、smtp.163.com
	$smtpServerPort = 25;					// SMTP服务器端口，一般为25
	$smtpUserName = "yuanfa0822@163.com";		// SMTP服务器的用户帐号
	$smtpPassWord = "yuanfa0822321";   			// SMTP服务器的用户密码，这里是指你qq的密码  
	$mailtype = "HTML";						// 邮件格式（HTML/TXT）,TXT为文本邮件
	
// 邮件类调用方式说明如下：

//  $smtp = new myemail($smtpServer, $smtpServerPort, true, $smtpUserName, $smtpPassWord);//这里面的一个true是表示使用身份验证,否则不使用身份验证.
//  $smtp->debug = false;//是否显示发送的调试信息
//  $smtpemailto = "邮件要发给谁";
//  $mailsubject = "要发信息件的标题";
//  $mailbody = "要发信件的内容！";
//  if($smtp->sendmail($smtpemailto, $smtpUserName, $mailsubject, $mailbody)=="1"){
//     echo "邮件发送成功！";
//  }else{
//     echo "邮件发送失败！";
//  }

// 邮件类调用方式说明End

?>