<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
</head>

<body>

<FORM method="post" name="myform" action="s.php">
<TABLE border="0" cellpadding="2" cellspacing="1">
<TR>
	<TD>编辑内容：</TD>
	<TD>
		<?php
		// 赋值，如从数据库取值
		// $html = rs("field")
		$html = "<P align=center><FONT color=#ff0000><FONT face='Arial Black' size=7><STRONG>eWeb<FONT color=#0000ff>Editor</FONT><FONT color=#000000><SUP>TM</SUP></FONT></STRONG></FONT></FONT></P><P align=right><FONT style='BACKGROUND-COLOR: #ffff00' color=#ff0000><STRONG>eWebEditor V5.5 for PHP 简体中文商业版</STRONG></FONT></P><P>本样式为系统默认样式（coolblue），最佳调用宽度550px，高度350px！</P><P>还有一些高级调用功能的例子，你可以通过导航进入示例首页查看。</P><P><B><TABLE borderColor=#ff9900 cellSpacing=2 cellPadding=3 align=center bgColor=#ffffff border=1><TBODY><TR><TD bgColor=#00ff00><STRONG>看到这些内容，且没有错误提示，说明安装已经正确完成！</STRONG></TD></TR></TBODY></TABLE></B></P>";
		// 字符转换，主要针对单双引号等特殊字符
		// 只有在给编辑器赋值时才有必要使用此字符转换函数，入库及出库显示都不需要使用此函数
		$html = htmlspecialchars($html); //功能是把html标签转化为字符串html
		?>

		<INPUT type="hidden" name="content1" value="<?php echo $html ?>">
		<IFRAME ID="eWebEditor1" src="edit/editor.htm?id=content1&style=coolblue" frameborder="0" scrolling="no" width="550" height="350"></IFRAME>
	</TD>
</TR>
</TABLE>
</FORM>
</body>
</html>