<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="../sys/images/style.css" />
<style type="text/css">
<!--
body {
	margin:0px;
	font-size:12px; padding:0px;
}
-->
</style>
</head>
<body>
<?php 
$fieldname = $_REQUEST["fieldname"];
?>
<form enctype="multipart/form-data" action="file.php?fieldname=<?php echo $fieldname;?>" method="POST">
<input name="uploadinput" type="file" style="margin-right:0px; width:200px;"><input type="submit" value="" style=" background:url(../system_style/images/yc_shangchuan.gif) no-repeat; width:49px; height:20px;  border:none">
</form>
</body>
</html>