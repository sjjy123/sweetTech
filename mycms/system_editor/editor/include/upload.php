<?php 
  set_time_limit("600"); 
?>
<HTML>
<HEAD>
<TITLE>�ļ��ϴ�</TITLE>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<style type="text/css">
body, a, table, div, span, td, th, input, select{font:9pt;font-family: "����", Verdana, Arial, Helvetica, sans-serif;}
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

// �����ϴ�����չ��
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

// ����ϴ���
function CheckUploadForm()
{
	if (!IsExt(document.myform.uploadfile.value,sAllowExt))
	{
		parent.UploadError("��ʾ��\n\n��ѡ��һ����Ч���ļ���\n֧�ֵĸ�ʽ�У�"+sAllowExt+"����");
		return false;
	}
	return true
}

// �ύ�¼��������
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

// �ϴ�����װ�����
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
	//' ȡ���ϴ�����,��������ϴ�
	if($_FILES['uploadfile']['error'] > 0){
		switch ((int)$_FILES['uploadfile']['error']){
			case UPLOAD_ERR_NO_FILE:
				OutScript ("parent.UploadError('��ѡ����Ч���ϴ��ļ���')");
				break;
			case UPLOAD_ERR_FORM_SIZE: 
				OutScript ("parent.UploadError('���ϴ����ļ��ܴ�С������������ƣ�')");
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
		echo "<SCRIPT LANGUAGE='JavaScript'>parent.parent.UploadError('�ϴ�ʧ�ܣ�');</SCRIPT>";
		exit;
	}
}
?>