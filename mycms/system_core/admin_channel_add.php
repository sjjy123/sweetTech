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
	
?><html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>添加栏目</title>
<link rel="stylesheet" type="text/css" href="../system_style/css/style.css" />
<script type="text/javascript" src="../system_style/js/HxCms.js"></script>
</head>

<body>
<table class="table1" cellspacing="0" cellpadding="0" align="center" border="0">
    <tr>
        <td width="200" height="25" align="left" valign="bottom" class="tableline linetitle">栏目管理</td>
        <td width="*" align="right" valign="bottom" class="tableline"><a href="admin_channel_add.php">添加栏目</a> | <a href="admin_channel.php">栏目管理</a></td>
    </tr>
</table>
<table id="tablehovered1" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
<tr>
	<th colspan="2">添加栏目</th>
</tr>
<form name='myform' method='post' id="myform" action='?action=saveadd' onSubmit="return checkform()">
<tr>
  <td width='32%' class='tablerow3' align='right'> 栏目名称：</td>
  <td width='68%' class='tablerow3'><input type='text' name='itemname' id='itemname' value=''>
</td>
<tr><td class='tablerow2' align="right">表的名称：</td><td class='tablerow2'><input type='text' name='itemtabname' id='itemtabname' value=''></td></tr>
<tr><td class='tablerow4' align="right">新建模版：</td><td><input type="radio" name="newmoban" checked value="0">否<input type="radio" name="newmoban" value="1">是</td></tr>
<tr><td class='tablerow3'>&nbsp;</td><td class='tablerow3'><input type='submit' name='button' id='button' value='建立栏目'></td></tr>
</form>
</table>
</body>
</html>
<script language="javascript">
function checkform()
{
	if(document.getElementById("itemname").value=="")
	{
		alert("栏目名称不能为空");
		document.getElementById("itemname").focus();
		return false;
	}
	var str;
	str=document.myform.itemtabname.value;
	str=str.replace(/(^\s*)|(\s*$)/g, "");
	str=str.replace(/(^\s*)/g,"");
	str=str.replace(/(\s*$)/g,""); 
	if(str.length==0)
	{	
		alert("数值不能为空!!");
		document.myform.itemtabname.focus();
		return false;
	}
	else
	{
	    str=str.replace(/(^[a-z]{1,})_{0,1}([a-z]{1,})(\d)?/i,"");//替换掉英文
		if(str.length>0)
		{
			alert("请输入一定长度的英文字符!");
			document.myform.itemtabname.focus();
			return false;
		}
	}
}
</script>
<?php
$stract = addslashes($_REQUEST["action"]);

switch ($stract)
{
	case "saveadd":
	
		$channelname = addslashes($_REQUEST["itemname"]);
		$itemtabname = addslashes($_REQUEST["itemtabname"]);
		$newmoban 	 = addslashes($_REQUEST["newmoban"]);
		$sequenceid  = getSequence($tablepre."channel","id");//获取ID的最大值
		$datetime    = date("Y-m-d H:i:s",time()+3600*8);//当前时间
		
		// 首先要检查表是否存在
		$ceck_result=$db->query("select * from ".$tablepre."channel where tabname='$itemtabname'");
		if ($db->num_rows($ceck_result)>0)
		{
			ok("此表已经存在!!","",1);
		}
		else 
		{

//=================== HOME ==============================================

// 在 ".$tablepre."channel 建立字段
$db->query("insert into ".$tablepre."channel (`channel`,`tabname`,`show`,`sequence`,`datetime`,`newmoban`) values ('$channelname','$itemtabname','1','$sequenceid','$datetime','$newmoban')");

// 在 ".$tablepre."field 建立字段
$cms_result = $db->query("select * from ".$tablepre."channel where `tabname`='$itemtabname'");
$cms_row    = $db->fetch_array($cms_result); //查询ID
$tableid		= $cms_row["id"];

// 建字段开始
$db->query("insert into ".$tablepre."field (`SystemID`, `fieldName`, `fieldtype`, `fieldtxt`, `fieldout`, `fieldinfo`, `fieldlength`, `fieldcontent`, `iscontent`, `ismust`, `show`, `islist`, `isaddlist`, `issystem`, `fault`, `sequence`, `CmsDate`) values 
(".$cms_row["id"].",'classid', 1, '所属分类', 5, '', 220, 'Select * from ".$tablepre."class where SystemID=".$cms_row["id"]." order by sequence Asc', 2, 0, 1, 1, NULL, 1, 0, 1, '$datetime'),
(".$cms_row["id"].", 'rmd', 1, '推荐', 3, '', 220, '0||否*^*1||是', 1, 0, 1, 1, NULL, 1, 0, 25, '$datetime'),
(".$cms_row["id"].", 'datetime', 3, '发布时间', 0, '', 220, '', 1, 0, 1, 0, 1, 1, NULL,501, '$datetime'),
(".$cms_row["id"].", 'sequence', 1, '排序', 0, '', 220, '', 1, 0, 0, 0, 1, 1, NULL, 61, '0'),
(".$cms_row["id"].", 'show', 1, '是否显示', 3, '', 220, '0||否*^*1||是', 1, 0, 1, 1, 0, 1, 1, 62, '$datetime'),


(".$cms_row["id"].", 'title', 0, '标题', 0, '', 220, '', 0, 0, 1, 1, 0, 0, 0, 500, '$datetime'),
(".$cms_row["id"].", 'content', 2, '内容', 13, '', 600, '', 0, 0, 1, 0, 0, 0, 0, 550, '$datetime'),
(".$cms_row["id"].", 'pics', 0, '缩略图',12, '', 220, '', 0, 0, 1, 0, 0, 0, 0, 510, '$datetime'),
(".$cms_row["id"].", 'pic', 0, '图片', 12, '', 220, '', 0, 0, 1, 0, 0, 0, 0, 520, '$datetime'),
(".$cms_row["id"].", 'img', 2, '多图', 9, '', 220, '', 0, 0, 1, 0, 0, 0, 0, 530, '$datetime'),
(".$cms_row["id"].", 'intro', 2, '介绍', 1, '', 600, '', 0, 0, 1, 0, 0, 0, 0, 540, '$datetime'),



(".$cms_row["id"].", 'recover', 1, '回收站', 3, '', 220, '0||否*^*1||是', 1, 0, 0, 0, 0, 1, 0, 64, '$datetime')");
					
// 建立表
$db->query("CREATE TABLE IF NOT EXISTS `".$tablepre.$itemtabname."` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`rmd` int(11) DEFAULT '0',
`classid` int(11) DEFAULT '0',
`datetime` datetime DEFAULT NULL,
`sequence` int(11) DEFAULT '0',
`show` int(11) DEFAULT '0',
`recover` int(11) DEFAULT '0',
`title` varchar(255) DEFAULT '',
`content` text DEFAULT '',
`pic` varchar(255) DEFAULT '',
`pics` varchar(255) DEFAULT '',
`img` text DEFAULT '',
`intro` text DEFAULT '',



PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;");
			
// 建立文件夹
if (!is_dir("../$itemtabname")) { mkdir("../$itemtabname",0777); }
$from_dir = "project_temp";
$to_dir   = "../$itemtabname";
xCopy($from_dir,$to_dir,1);

// 对文件进行设置
$cms_file=@fopen("../$itemtabname/admin_config.php","w+");
fwrite($cms_file,'<?php $SystemID = '.$cms_row["id"].'; ?>');
fclose($cms_file);

//=================== END ==============================================

		}
		
//生成左侧----开始
$cms_file=@fopen("../$itemtabname/admin_left.php","w+");
fwrite($cms_file,'<?php include(\'../system_core/admin_left_top.php\')?>
<?php include(\'admin_config.php\')?>
<tr>
    <td valign="top" class="listbg">
		<div class="ileft">
            <div class="ilt1" id="menuTitle'.$tableid.'" onClick="showsubmenu('.$tableid.')">'.$channelname.'</div>
            <ul id="submenu'.$tableid.'">
                <li> <a target="mainFrame" href="../'.$itemtabname.'/admin_index.php">信息列表</a></li>
				<li><a target="mainFrame" href="../'.$itemtabname.'/admin_add.php">添加信息</a></li>
				<?php if (checkManag($_SESSION["adminLov"])==true){?>
                <li> <a target="mainFrame" href="../system_core/add_classtype.php?m='.$cms_row["id"].'&act=add">添加分类</a></li>
				<li><a target="mainFrame" href="../system_core/admin_class.php?m='.$cms_row["id"].'">分类管理</a></li>
				<?php }?>
                <li><?php if (checkManag($_SESSION["adminLov"])==true){?> <a target="mainFrame" href="../system_core/admin_field.php?m='.$cms_row["id"].'&act=add">添加字段</a></li><?php }?>
                <li><a target="mainFrame" href="../'.$itemtabname.'/admin_recover.php">回 收 站</a></li>
            </ul>
        </div>
	</td>
</tr>
<?php include(\'../system_core/admin_left_foot.php\')?>
');
fclose($cms_file);
//生成左侧----结束
		ok("栏目建立成功","admin_channel.php",2);
		break;

}
?>
