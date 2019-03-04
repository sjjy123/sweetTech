<?php
    /*code by borlandapple 2009.3.27 */
	Header("Content-type:image/png");
	session_start(); //启用超全局变量session
	$w = 55; //设置图片宽和高
	$h = 21;
	$str = Array(); //用来存储随机码
	$vcode = "";
	$string = "abcdefghijklmnopqrstuvwxyz0123456789";//随机挑选其中4个字符，也可以选择更多，注意循环的时候加上，宽度区分大小写"ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"适当调整
	for($i = 0;$i < 4;$i++){
	   $str[$i] = $string[rand(0,35)];
	   $vcode .= $str[$i];
	}
	$_SESSION['mycms_code'] = $vcode;
	$im = imagecreatetruecolor($w,$h);
	$white = imagecolorallocate($im,255,255,255); //第一次调用设置背景色
	$black = imagecolorallocate($im,0,0,0); //边框颜色
	imagefilledrectangle($im,0,0,$w,$h,$white); //画一矩形填充
	imagerectangle($im,0,0,$w-1,$h-1,$black); //画一矩形框
	//生成雪花背景
	for($i = 1;$i < 200;$i++){
	   $x = mt_rand(1,$w-9);
	   $y = mt_rand(1,$h-9);
	   $color = imagecolorallocate($im,mt_rand(200,255),mt_rand(200,255),mt_rand(200,255));
	   imagechar($im,1,$x,$y,"*",$color);
	}
	//加入3条干扰线;也可以不要;视情况而定，因为可能影响用户输入;如不用干扰线，注释就行了;
	$li = ImageColorAllocate($im, 100,100,100);//加入线条颜色；
	for($i=0;$i<4;$i++) 
	{ 
	imageline($im,rand(0,80),rand(0,70),rand(20,40),rand(0,50),$li);
	} 
	//将验证码写入图案
	for($i = 0;$i < count($str);$i++){
	   $x = 13 + $i * ($w - 15)/4;
	   $y = mt_rand(3,$h / 3);
	   $color = imagecolorallocate($im,mt_rand(0,225),mt_rand(0,150),mt_rand(0,225));
	   imagechar($im,5,$x,$y,$str[$i],$color);
	}
	header("Content-type:image/jpeg"); //以jpeg格式输出，注意上面不能输出任何字符，否则出错
	imagejpeg($im);
	imagedestroy($im);
?> 