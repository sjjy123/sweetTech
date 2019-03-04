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
	
	//获取栏目ID
	$ID=addslashes($_REQUEST['ID']);
	

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<link rel="stylesheet" type="text/css" href="../system_style/css/style.css" />
<script type="text/javascript" src="../system_style/js/HxCms.js"></script>
</head>
<body style="background:#fbf8f6">
<script language="javascript">
 function checkform()
 {
 	if(document.myform.ClassName.value=="")
	{
		document.getElementById("ClassNameHTML").innerHTML="&nbsp;&nbsp;信息不能为空";
		document.myform.ClassName.focus();
		return false;
	}
 }
 // 检测 编辑提交表单
 function checkeditform(ID)
 {
	if(document.myform.ClassName.value=="")
	{
		document.getElementById("ClassNameHTML").innerHTML="&nbsp;&nbsp;信息不能为空";
		document.myform.ClassName.focus();
		return false;
	}
	if(document.getElementById('ClassID').value==ID)
	{
		document.getElementById("ClassNameHTML").innerHTML="&nbsp;&nbsp;不能选定自己为上级类";
		return false;
	}
 }
</script>
<script language="javascript">
function ToCheckClass(ID)
{
	if(document.getElementById('ClassID').value==ID)
	{
		document.getElementById("ClassNameHTML").innerHTML="&nbsp;&nbsp;不能选定自己为上级类";
		return false;
	}
	else
	{
		document.getElementById("ClassNameHTML").innerHTML="";
		return false;
	}
}
</script>
<?php
 include_once("areastop.php"); 
 if(addslashes($_REQUEST['act'])=='add')
 {	
?>
    <form name="myform" method="post" action="?action=savemain" onSubmit="return checkform()" enctype="multipart/form-data">
    <table id="tablehovered1" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
    <tr>
    <th colspan="2">添加分类</th>
    </tr>
    <tr>
    <td width="22%" align="right" class="tablerow2"><u title="MainDomain">所属类别</u>：</td>
    <td width="78%" class="tablerow2">
    
    <?php
    echo "<select name='ClassID' id='ClassID'>" ;
    echo "<option value='0'>作为一级类</option>";
    $ClaSql="Select * from ".$tablepre."areas where 1 order by sequence Asc";
	
    $Result=$db->query($ClaSql);
    while ($Row=$db->fetch_array($Result)) 
    {
		//通过分拆、组合 获得一个新的数组排序的值------开始
		$yc_parpath=explode(',',$Row["ParPath"]);
		for($i=0;$i<count($yc_parpath);$i++){
			$yc_par[$i]=str_pad($yc_parpath[$i],5,"0",STR_PAD_LEFT);
		}
		$yc_parpa=implode(',',$yc_par);
		$paixu=str_pad($Row["ID"],5,"0",STR_PAD_LEFT);
		$yc_paixu=$yc_parpa.','.$paixu;
		//通过分拆、组合 获得一个新的数组排序的值------结束
		
		$Class_arr[]=array($Row["ID"],$Row["ClassName"],$Row["ClassNameEng"],$Row["Depth"],$Row["partid"],$Row["Sequence"],$Row["Num"],$Row["show"],"ParPath"=>$Row["ParPath"],"yc_paixu"=>$yc_paixu);
    //$Class_arr[]=array($Row["ID"],$Row["ClassName"],$Row["ClassNameEng"],$Row["Depth"],$Row["partid"],$Row["Sequence"]);
    }
    if(!empty($Class_arr)){
		foreach ($Class_arr as $key => $value) {
			$ParPath[$key] = $value['yc_paixu'];
		}
		array_multisort($ParPath, $Class_arr);
		//print_r($Class_arr);
	}
    //调用无限级分类函数
    SelectClass(0,true);
    echo "</select>";
    ?>
    </td></tr>
    <tr>
    <td class="tablerow1" align="right"><u>分类名称</u>：</td>
    <td class="tablerow1">
    <input name="ClassName" type="text" id="ClassName" value="" size="35"><span class="Warning"><font id="ClassNameHTML"></font></span></td>
    </tr>
    <tr>
    <td class="tablerow2" align="right"><u title="MainDomain">英文名称</u>：</td>
    <td class="tablerow2"><input name="ClassNameEng" type="text" id="ClassNameEng" value="" size="35"> </td>
    </tr>
    <tr style="display:none;">
      <td class="tablerow2" align="right"><u>启 用</u>：</td>
      <td class="tablerow2">
      <input type="radio" value="0" name="show"> 不启用 
      <input type="radio" value="1" name="show" checked="checked"> 启用
      </td>
    </tr>
    <tr>
    <td class="tablerow2" align="right"><u>分类图片</u>：</td>
    <td class="tablerow2"><input type="file"  size="60" name="sortpic" id="sortpic" /></td></tr>
    <tr>
    <td class="tablerow2" align="right"><u>分类介绍</u>：</td>
    <td class="tablerow2"><textarea name="ClassInfo" cols="60" rows="5" id="ClassInfo"></textarea> </td>
    </tr><tr>
    <td class="tablerow1" align="right">&nbsp;</td>
    <td class="tablerow1"><input type="submit" value="保存设置" name="submit_button" id="submit_button" class="button"> </td>
    </tr>
    </table>
</form>
    <?php
     }
     elseif(addslashes($_REQUEST['act'])=='edit')
     {
        /*
         获取当前ID的ParID的值; Start
        */
        $Result=$db->query("select partid,ClassName,ClassNameEng,ClassInfo,sortpic,`show` from ".$tablepre."areas where ID=$ID");
        $Row=$db->fetch_array($Result);
        $parID        = $Row['partid'];
        $ClassName    = addslashes($Row['ClassName']);
        $ClassNameEng = addslashes($Row['ClassNameEng']);
        $ClassInfo    = addslashes($Row['ClassInfo']);
        $sortpics	  = $Row['sortpic'];
				$show		  = $Row['show'];
        /* End */
    ?>
    <form name="myform" method="post" action="?action=saveedit" onSubmit="return checkeditform(<?php echo $ID;?>)" enctype="multipart/form-data">
    <table id="tablehovered1" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
    <tr>
    <th colspan="2">编辑分类</th>
    </tr>
    
    <tr>
    <td width="22%" align="right" class="tablerow2"><u title="MainDomain">所属类别</u>：</td>
    <td width="78%" class="tablerow2">
    <?php
    echo "<select name='ClassID' id='ClassID' onChange='ToCheckClass($ID)'>" ;
    echo "<option value='0'>作为一级类</option>";
    $ClaSql="Select * from ".$tablepre."areas where 1  order by sequence desc";
    $Result=$db->query($ClaSql);
    while ($Row=$db->fetch_array($Result)) 
    {
    //通过分拆、组合 获得一个新的数组排序的值------开始
		$yc_parpath=explode(',',$Row["ParPath"]);
		for($i=0;$i<count($yc_parpath);$i++){
			$yc_par[$i]=str_pad($yc_parpath[$i],5,"0",STR_PAD_LEFT);
		}
		$yc_parpa=implode(',',$yc_par);
		$paixu=str_pad($Row["ID"],5,"0",STR_PAD_LEFT);
		$yc_paixu=$yc_parpa.','.$paixu;
		//通过分拆、组合 获得一个新的数组排序的值------结束
		
		$Class_arr[]=array($Row["ID"],$Row["ClassName"],$Row["ClassNameEng"],$Row["Depth"],$Row["partid"],$Row["Sequence"],$Row["Num"],$Row["show"],"ParPath"=>$Row["ParPath"],"yc_paixu"=>$yc_paixu);
    //$Class_arr[]=array($Row["ID"],$Row["ClassName"],$Row["ClassNameEng"],$Row["Depth"],$Row["partid"],$Row["Sequence"]);
    }
    if(!empty($Class_arr)){
		foreach ($Class_arr as $key => $value) {
			$ParPath[$key] = $value['yc_paixu'];
		}
		array_multisort($ParPath, $Class_arr);
		//print_r($Class_arr);
	}
    //调用无限级分类函数
    EditSelectClass(0,true);
    echo "</select>";
    ?>
    
      </td>
    </tr>
    <tr>
    <td class="tablerow1" align="right"><u>分类名称</u>：</td>
    <td class="tablerow1">
    <INPUT name="ID" value="<?php echo $ID;?>" type="hidden">
    <input name="ClassName" type="text" id="ClassName" value="<?php echo $ClassName;?>" size="35"><span class="Warning"><font id="ClassNameHTML"></font></span></td>
    </tr>
    <tr>
    <td class="tablerow2" align="right"><u title="MainDomain">英文名称</u>：</td>
    <td class="tablerow2"><input name="ClassNameEng" type="text" id="ClassNameEng" value="<?php echo $ClassNameEng;?>" size="35"></td>
    </tr>
    <tr style="display:none;">
      <td class="tablerow2" align="right"><u>启 用</u>：</td>
      <td class="tablerow2">
      <input type="radio" value="0" name="show" <?php if($show==0){echo("checked");}?>> 不启用 
      <input type="radio" value="1" name="show" <?php if($show==1){echo("checked");}?>> 启用
      </td>
    </tr>
    <tr>
    <td class="tablerow2" align="right"><u>分类图</u>：</td>
    <td class="tablerow2"><input type="file"  size="60" name="sortpic" id="sortpic" />
    <?php 
	if($sortpics!="")
    {
		echo("<br><img src=../../uploadfile/classpic/".$sortpics." height=25>");
		echo("<input type='radio' value='0' name='emt_pic' checked> 不清空图");
		echo("<input type='radio' value='1' name='emt_pic'> 清空图");
	}
    ?>
    </td>
    </tr>
    <tr>
    <td class="tablerow2" align="right"><u>备 注</u>：</td>
    <td class="tablerow2"><textarea name="ClassInfo" cols="60" rows="5" id="ClassInfo"><?php echo $ClassInfo;?></textarea> </td>
    </tr>
    <tr>
    <td class="tablerow1" align="right">&nbsp;</td>
    <td class="tablerow1"><input type="submit" value="保存设置" name="submit_button" id="submit_button" class="button"> </td>
    </tr>
    </table>
</form>
    <?php
    }
    ?>
    
    </body>
    </html>
    <?php
    //=====================================上传文件的函数========================================
    function uploadfiles($uptodir,$inputname)
    {
        $dir =$uptodir;															//"../data/comp/";				
        $sub =$uptodir.date("Y-m");												// "../data/comp/".date("Y-m");	
        $types_allow=".jpg;.gif;.doc;.rar;.zip;.bmp;.rmvb;.mov;.avi;.png;";			//允许上传文件的扩展名
                
        if($_FILES[$inputname]['name']!="")		   						    //有上传文件的情况
        {
            $filetypes= strrchr($_FILES[$inputname]['name'],".");			    //上传文件的扩展名
            if(strstr($types_allow,$filetypes)=="")								//$types_allow为函数库中定义的允许上传文件的扩展名,$filetypes：当前上传的文件的扩展名
            {
                echo("<script language='javascript'>alert('不允许上传的文件类型！');window.location.href='".$_SERVER['HTTP_REFERER']."';</script>");
                return;
            }
            if(!file_exists($sub)) 
            {
                mkdir($sub,0777);
            }
           $$inputname=date("Y-m")."/".date("Y-m-d").mt_rand(1000,9999).$filetypes;//上传文件的文件名
		   //$randnum=mt_rand(10,99);
           //$$inputname = date("Y-m")."/N".time().$randnum.$filetypes;					//上传文件的文件名
            move_uploaded_file($_FILES[$inputname]['tmp_name'], $dir.$$inputname);
            chmod($sub,0777);
            return $$inputname;
            exit;
            return;
        }
    }
    //===========================================================================================
    
    
    $action=addslashes($_REQUEST['action']);
    switch ($action)
    {
    case savemain:
         savemain();
         break;
    case saveedit:
         saveedit();
         break; 	 
    }
    //保存添加的分类信息；
    function savemain()
    {
	global $db,$tablepre;
    $ClassName    = addslashes($_POST['ClassName']);
    $ClassNameEng = addslashes($_POST['ClassNameEng']);
    $ClassInfo    = addslashes($_POST['ClassInfo']);
    $ClssID       = addslashes($_POST['ClassID']);
	$show     	  = addslashes($_POST['show']);
    $Sequence     = Sequence("".$tablepre."class","ID");//获取排序值
	if($ClssID=="0")
	{
		$ParPath  = $ClssID;
		$yc_paixu = str_pad($Sequence,5,"0",STR_PAD_LEFT);
	}
	else
	{
		$rs=$db->fetch_array($db->query("select * from ".$tablepre."areas where ID=$ClssID"));
		
		$ParPath  = $rs['ParPath'].",".$ClssID;
		$yc_paixu=$rs['ycpaixu'].",".str_pad($Sequence,5,"0",STR_PAD_LEFT);
	}
	
    $Depth        = addslashes(Depth($ClssID));//获取深度值
    $SystemID     = addslashes($_POST['m']);//获取栏目值
    //date_default_timezone_set("PRC");
    $CmsDate      =date("Y-m-d h:i:s",time()+3600*8);
    
    if($_FILES['sortpic']['name']!="") //有上传文件的情况=====================================================
    {
        $sortpic=uploadfiles("../../uploadfile/classpic/","sortpic");//上传文件
    }
    
    $CmsSql="insert into ".$tablepre."areas (`ClassName`,`ClassNameEng`,`ClassInfo`,`Depth`,`ParPath`,`partid`,`Sequence`,`CmsDate`,`sortpic`,`show`,`ycpaixu`) VALUES ('$ClassName','$ClassNameEng','$ClassInfo','$Depth','$ParPath','$ClssID','$Sequence','$CmsDate','$sortpic','$show','$yc_paixu')";
    $Result=$db->query($CmsSql);
    if ($ClssID!=0)
    {
        $db->query("update ".$tablepre."areas set Num=Num+1 where ID=$ClssID");
    }
    ok("信息添加成功","add_areastype.php?act=add",2);
    }
    
    /*
    更新分类信息 Start
    */
    function saveedit()
    {
    global $db,$tablepre;
    $ClassName    = addslashes($_POST['ClassName']);
    $ClassNameEng = addslashes($_POST['ClassNameEng']);
    $ClassInfo    = addslashes($_POST['ClassInfo']);
    $ClssID       = addslashes($_POST['ClassID']);
	$show     	  = addslashes($_POST['show']);
	if($ClssID=="0")
	{
		$ParPath  = $ClssID;
	}
	else
	{
		$rs=$db->fetch_array($db->query("select * from ".$tablepre."areas where ID=$ClssID"));
		
		$ParPath  = $rs['ParPath'].",".$ClssID;
	}

    $Depth        = addslashes(Depth($ClssID));//获取深度值
    $SystemID     = addslashes($_POST['m']);
    $ID           = addslashes($_REQUEST['ID']);
    if($_FILES['sortpic']['name']!="") //有上传文件的情况=====================================================
    {
        $sortpic=uploadfiles("../../uploadfile/classpic/","sortpic");//上传文件
    }else{
	  $mysql=$db->query("select * from ".$tablepre."areas where ID=$ID");
	  if($rs_pic=$db->fetch_array($mysql))
	  {
		  if($rs_pic['sortpic']!="")
		  {
			  if($_REQUEST['emt_pic']==0)
			  {
				  $sortpic=$rs_pic['sortpic'];
			  }else{
				  //删除图片文件以节省空间：
				  //del("../../uploadfile/classpic/".$rs_pic['sortpic']);
				  $sortpic="";
			  }
		  }
	  }
	}
    $CmsSql="update ".$tablepre."areas set ClassName ='$ClassName',ClassNameEng='$ClassNameEng',sortpic='$sortpic',`show`='$show',ClassInfo='$ClassInfo',Depth='$Depth',ParPath='$ParPath',partid='$ClssID' where ID=$ID";
    $db->query($CmsSql);
    ok("信息编辑成功","admin_areas.php",2);
    }
    /*
    更新分类信息 End
    */	

    ?>