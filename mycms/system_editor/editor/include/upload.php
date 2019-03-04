<?php 
  set_time_limit("600"); 
?>
<HTML>
<HEAD>
<TITLE>文件上传</TITLE>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<style type="text/css">
body, a, table, div, span, td, th, input, select{font:9pt;font-family: "宋体", Verdana, Arial, Helvetica, sans-serif;}
body {padding:0px;margin:0px}
</style>

<script language="JavaScript" src="../dialog/dialog.js"></script>
<script language="JavaScript" src="../js/globals.js"></script>
</head>
<body bgcolor=menu>

<form action="?action=save&type=img" method=post name=myform enctype="multipart/form-data">
<input type=file name=uploadfile size=1 style="width:100%" onchange="originalfile.value=this.value">
<input type=hidden name=originalfile value="">
</form>

<script language=javascript>

// 允许上传的扩展名
var sAllowExt = "";

switch (URLParams ('type'))
{
	case "image":
		sAllowExt = "gif|jpg|jpeg|png";
		break;
	case "flash":
		sAllowExt = "swf";
		break;
	case "media":
		sAllowExt = "rm|mp3|wav|mid|midi|ra|avi|mpg|mpeg|asf|asx|wma|mov";
		break;
	case "file":
		sAllowExt = "rar|zip|exe|doc|xls|chm|hlp";
		break;
	default:
		break;
}

// 检测上传表单
function CheckUploadForm()
{
	if (!IsExt(document.myform.uploadfile.value,sAllowExt))
	{
		parent.UploadError("提示：\n\n请选择一个有效的文件，\n支持的格式有（"+sAllowExt+"）！");
		return false;
	}
	return true
}

// 提交事件加入检测表单
var oForm = document.myform ;
oForm.attachEvent("onsubmit", CheckUploadForm) ;
if (! oForm.submitUpload) oForm.submitUpload = new Array() ;
oForm.submitUpload[oForm.submitUpload.length] = CheckUploadForm ;
if (! oForm.originalSubmit) {
	oForm.originalSubmit = oForm.submit ;
	oForm.submit = function() {
		if (this.submitUpload) {
			for (var i = 0 ; i < this.submitUpload.length ; i++) {
				this.submitUpload[i]() ;
			}
		}
		this.originalSubmit() ;
	}
}

// 上传表单已装入完成
try {
	parent.UploadLoaded();
}
catch(e){
}

</script>

</body>
</html>
<?php
if ($_POST['originalfile']){
	//' 取得上传数据,限制最大上传
	if($_FILES['uploadfile']['error'] > 0){
		switch ((int)$_FILES['uploadfile']['error']){
			case UPLOAD_ERR_NO_FILE:
				OutScript ("parent.UploadError('请选择有效的上传文件！')");
				break;
			case UPLOAD_ERR_FORM_SIZE: 
				OutScript ("parent.UploadError('你上传的文件总大小超出了最大限制！')");
				break;
		}
		return;
	}
	preg_match ("/\.([^\.]+)$/", $_FILES['uploadfile']['name'], $exts);
	$sNewFileName	= date ('Ymdhis') . '.'. $exts[1];
    $dir = $_SERVER["DOCUMENT_ROOT"]."/uploadfiles/adimg/";
    if(!is_dir($dir)) mkdir($dir);
	$sFileName		.= $dir. $sNewFileName;
	$path = '/uploadfiles/adimg/' . $sNewFileName;
	if (move_uploaded_file($_FILES['uploadfile']['tmp_name'], $sFileName)){
		echo "<SCRIPT LANGUAGE='JavaScript'>parent.UploadSaved('". $path ."');</SCRIPT>";
		exit;
	}else{
		echo "<SCRIPT LANGUAGE='JavaScript'>parent.parent.UploadError('上传失败！');</SCRIPT>";
		exit;
	}
}
?>