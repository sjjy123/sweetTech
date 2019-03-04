<?php
header("Content-Type: text/html; charset=utf-8");

//获取访问者IP
function get_onlineip() {
    $onlineip = '';
    if(getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
        $onlineip = getenv('HTTP_CLIENT_IP');
    } elseif(getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
        $onlineip = getenv('HTTP_X_FORWARDED_FOR');
    } elseif(getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
        $onlineip = getenv('REMOTE_ADDR');
    } elseif(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
        $onlineip = $_SERVER['REMOTE_ADDR'];
    }
    return $onlineip;
}

//获取随即值
function randmon($length)
 {
        $hash = '';
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz';
        for ($i=0;$i<=$length;$i++)
        {
        	$hash=$hash.$chars[mt_rand(0,strlen($chars))];
        }
        return $hash;
  }
  //检测字符串是否可以注册或者是非法字段;
function checkstr($str)
{
	global $db,$tablepre;
	$key_result=$db->query("select regkeywords from ".$tablepre."config where ID=1");
	$key_row =$db->fetch_array($key_result);
	$str_str=$key_row["regkeywords"];
	$str_str_arr =explode(",",$str_str);
	if(in_array($str,$str_str_arr)==true) {return  true;} //非法字段不能注册
	if(in_array($str,$str_str_arr)==false){return  false;} //不存在：
}

function cms_get_digui_sequence($ID,$sequeceID_paixu){//取得排序值
	global $db,$tablepre;
	$sql_100=$db->query("select ID,Sequence from ".$tablepre."class where partid=".$ID);
	while($row_100=$db->fetch_array($sql_100)){
		$sequeceID_paixu_child=$sequeceID_paixu.','.str_pad($row_100['Sequence'],5,"0",STR_PAD_LEFT);
		$UpSql="update ".$tablepre."class set ycpaixu='$sequeceID_paixu_child' where ID=".$row_100['ID'];
		$db->query($UpSql);
		cms_get_digui_sequence($row_100['ID'],$sequeceID_paixu_child);
	}
}
function cms_get_fsequence($id){//取得排序值
	global $db,$tablepre;
	$strsql="select Sequence from ".$tablepre."class where id=".$id;
	$result=$db->query($strsql);
	$row=$db->fetch_array($result);
	return $row['Sequence'];
}
//获取随即值
function cms_get_randmon($length)
 {
        $hash = '';
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz';
        for ($i=0;$i<=$length;$i++)
        {
        	$hash=$hash.$chars[mt_rand(0,strlen($chars))];
        }
        return $hash;
  }
function cms_get_channel($systemid)
//返回栏目名称
{
	global $db,$tablepre;
	$strsql="select channel from ".$tablepre."channel where id=".$systemid;
	$result=$db->query($strsql);
	$row=$db->fetch_array($result);
	return $row['channel'];

}


function cms_get_newmoban($systemid)
//返回栏目是否需要建立新模版
{
	global $db,$tablepre;
	$strsql="select * from ".$tablepre."channel where id=".$systemid;
	$result=$db->query($strsql);
	$row=$db->fetch_array($result);
	return $row['newmoban'];

}

function listid($systemid,$classid)
//返回所有字ID
{
	global $db,$tablepre;
	//global $strid;
	$strsql="select ID from ".$tablepre."class where SystemID=$systemid and partid = $classid";
	$result=$db->query($strsql);
	$x=0;
	while ($row=$db->fetch_array($result))
	{
		if ($x==0)$point=",";
		if ($x>0 )$point=",";
		if ($strid=="")
		{
			$strid=$row["ID"];
			listid($systemid,$row["ID"]);
		}
		else 
		{
			$strid=$strid.$point.$row["ID"];
			listid($systemid,$row["ID"]);
		}
	$x++;	
	}
	if ($strid==""){return $classid;}
	if ($strid!=""){return $strid.",".$classid;}	
}

function ShowClassName($classid)
//==================================================================================================================================================
//输出分类的名称;
//==================================================================================================================================================
//输出分类的名称级别,调用方法: echo ShowClassName(当前分类的ID:$classid);
//==================================================================================================================================================
{
	global $db,$tablepre;
	$ClassPath="";
	while($classid<>"")
	{
		$Class_result=$db->query("select ID,partid,ClassName from ".$tablepre."class where ID=$classid");
		if($Class_row=$db->fetch_array($Class_result))
		{
			$ClassPath=">>".$Class_row['ClassName'].$ClassPath;
			$classid=$Class_row['partid'];
		}else
		{
			break;
		}
	}
	$ClassShow=substr($ClassPath,2,strlen($ClassPath)-1);
	return $ClassShow;
}

function isshow($systemid,$strfield)
//判断字段是否显示
{
	global $db;
	global $tablepre;
	$str_result=$db->query("select `show`,`islist` from ".$tablepre."field where SystemID=$systemid and fieldName='$strfield'");
	$str_row =$db->fetch_array($str_result);
    if($str_row["show"]==0){return $isshow=false;}
    if($str_row["show"]==1 && $str_row["islist"]==1){return $isshow=true;}
}
function ishavaclass($systemid)
//判断表中是否有分类
{
	global $db;
	global $tablepre;
	$str_result=$db->query("select `ID` from ".$tablepre."class where SystemID=$systemid and `show`='1'");
	$str_row =$db->fetch_array($str_result);
    if($str_row){return $ishavaclass=true;}else{return $ishavaclass=false;}
}

function get_classsql($id)
//生成当前分类下所有子类ID
{
if (is_numeric($id)) {
	$str_sql = "";
	global $db; 
	$sql="select * from ".$tablepre."class where partid=$id";
	$querys=$db->query($sql);
	while ($rs=$db->fetch_array($querys))
	{
	$str_sql .= ",".$rs['ID'];
	$abc = get_classsql($rs['ID']);
	if ($abc!="") {	$str_sql .= $abc; }
	}
	return $str_sql;
}
}

function Sequence($tablename,$strID)
// 获取ID的最大值 $tablename 表名
{//".$tablepre."class
	global $db;
	$MaxSql="select ID from $tablename order by $strID Asc";
	$Result= $db->query($MaxSql);
	while ($Row=$db->fetch_array($Result)){
		$Sequence= $Row["ID"]+1;
	}
	return $Sequence;
}

function confirm()
 {
 	return "onclick=\"javascript:if(confirm('删除后不可恢复,确认要删除吗')) return true; return false;\"";
 }

function checkManag($strlov)
// 检测是否是超级管理员。
{
	if($strlov==520)
	{
		return true;
	}
	else
	{
		return  false;
	}
}

function isSystem($fieldid)
//检测超级管理员结束
{
	global $db;
	global $tablepre;
	$Cms_sql ="select issystem from ".$tablepre."field where id=$fieldid";
	$Cms_resutl=$db->query($Cms_sql);
	$Cms_row =$db->fetch_array($Cms_resutl);
	if($Cms_row["issystem"]==1)
	{
		return true;
	}
	else  
	{
		return  false;
	}
	
}

function is_Fieldedit($systemid,$fieldname,$fieldid)
//判断编辑字段时候，如果重复字段名称将不能修改
{
	global $db;
	global $tablepre;
	$strSql="select * from ".$tablepre."field where SystemID=$systemid and fieldName='$fieldname' and ID<>$fieldid";
	$Resut=$db->query($strSql);
	if($db->num_rows($Resut))
	{
		return $is_fieldedit=false; //查询到记录
	}
	else
	{
		return $is_fieldedit=true; //没有查询到记录
	}
}

function is_Field($systemid,$fieldname)
//is_field() 函数主要是判断表 ".$tablepre."field这个表中可存在相同的字段名；
//$systemid:为栏目id,$fieldname:为将要添加的字段名称；
{
	global $db;
	global $tablepre;
	$strSql="select * from ".$tablepre."field where SystemID=$systemid and fieldName='$fieldname'";
	$Resut=$db->query($strSql);
	if($db->num_rows($Resut))
	{
		return $is_field=false; //查询到记录
	}
	else
	{
		return $is_field=true; //没有查询到记录
	}
}

function is_Tab($tabName,$fieldname)
//判断是否是系统字段结束
{
	global $db;	
	$StrSql="DESCRIBE $tabName '$fieldname'";
	$Result=$db->query($StrSql);
    $field = mysql_fetch_array($Result);
    if($field[0]==$fieldname)
    {
    	return $is_tab=false; //查到字段记录
    }
    elseif($field[0]==null)
    {
    	return $is_tab=true;  //没有查询到字段记录
    }
}

function showField($fieldname,$ShowNum,$filedID)
// 修改字段是否显示
//$filedID:字段ID,$ShowNum:修改值.
{
	global $db;
	global $tablepre;
	$UpSql="update ".$tablepre."field set `$fieldname`=".$ShowNum." where ID=$filedID";
	$db->query($UpSql);
	okUrl($_SERVER["HTTP_REFERER"]);
	exit();
}
function updSequence($strvalue,$filedID)
{
	global $db;
	global $tablepre;
	$UpSql="update ".$tablepre."field set `sequence`=".$strvalue." where ID=$filedID";
	$db->query($UpSql);
	okUrl($_SERVER["HTTP_REFERER"]);
	exit();
}

function tabName($systemid)
// 函数说明：tabName 是获取当 systemid的值不相同的时候，从而操作不同的表，在给表添加字段的时候，经常用到
{
	global $db;
	global $tablepre;
	$tab_sql="select tabname from ".$tablepre."channel where id=$systemid";
	$tab_result=$db->query($tab_sql);
	$tab_row   =$db->fetch_array($tab_result);
	return  $tabName=$tablepre.$tab_row["tabname"];

}


function deleteDir($dir) 
// 删除文件夹
{ 
	if (file_exists($dir)!="")
	{ 
		if ($dp = opendir($dir)) 
		{
			while (($file=readdir($dp)) != false) 
			{
				if ( $file!='.' && $file!='..') 
				{
				   if (!is_dir($file)){ unlink($dir."/".$file); }
				}
			}
			closedir($dp); 
		} 
	}
    rmdir($dir);
}


function Cms_update($tabName,$Cms_field,$Cms_num,$Cms_id)
//更新字段数据，$tabName 表名, $Cms_field 字段名, $Cms_num 字段值, $Cms_id 条件
{
	global $db;
	$db->query("Update `$tabName` set `$Cms_field`='$Cms_num' where id=$Cms_id");
	okUrl($_SERVER["HTTP_REFERER"]);	
}


function xCopy($source, $destination, $child)
/*  将文件从 source 拷贝到 destination $source 原地址，$destination 目标地址，$child 参数
	调用方式：if(xCopy($from_dir,$to_dir,1)){ echo '备份完成'; }
*/
{
    if(!is_dir($source)){
    echo("源路径不存在");
    return 0;
    }
    if(!is_dir($destination)){
    mkdir($destination,0777);
    }

    $handle=dir($source);
    while($entry=$handle->read()) {
        if(($entry!=".")&&($entry!="..")){
            if(is_dir($source."/".$entry)){
                if($child) xCopy($source."/".$entry,$destination."/".$entry,$child);
            }else{
                copy($source."/".$entry,$destination."/".$entry);
            }
        }
    }
    return true;
}


function getSequence($tablename,$strID)
// 获取ID的最大值 $tablename 表名，$strID 排序字段
{
	global $db;
	$MaxSql="SELECT ID FROM $tablename ORDER BY $strID asc";
	$Result= $db->query($MaxSql);
	while ($Row=$db->fetch_array($Result)){
		$Sequence= $Row["ID"]+1;
	}
	return $Sequence;
}

function checkrecords($tabname,$fieldname,$strvalue) {
// 判断记录是否存在 $tabname表名, $fieldname字段名, $strvalue字段值
	global $db;
	global $tablepre;
	$cms_result=$db->query("SELECT $fieldname FROM $tabname WHERE $fieldname='$strvalue'");
	if($db->num_rows($cms_result)>0) 
	{
		return true;//记录存在	
	}
	elseif($db->num_rows($cms_result)==0)
	{
		return false;//记录不存在 可以添加记录
	} 
}


function ok($text,$link,$lev) {
// 提示并跳转 $text提示信息, $link跳转地址, $lev类型
if($lev==1)
{
	echo "<script language=\"JavaScript\">";   
	echo "alert(\"$text\");";//echo " history.go(-1);";
	echo "history.back();";   
	echo "</script>";   
	exit;   
}
elseif ($lev==2) 
{
	echo "<script language=\"JavaScript\">";
	echo "alert(\"$text\");";
	echo "location.replace(\"$link\")";
	echo "</script>"; 
	exit;
}
}


function okConfirm($str) {
// 提示当前操作 是否同意思
	return "onclick=\"javascript:if(confirm('$str')) return true; return false;\"";
}

function okUrl($link) {
// 无提示跳转
	echo "<script language=\"JavaScript\">";
	echo "location=\"".$link ."\"";
	echo "</script>"; 
	exit;
}

function okUrlup($link) {
	header("location:$link"); 
	exit;
}


function __autoload($className){
	// 自动加类文件
	include_once INIT_ROOT.'system_class/'.$className.'.class.php'; 
}


function userOS(){
// 操作系统 
	$user_OSagent = $_SERVER['HTTP_USER_AGENT'];
	if(strpos($user_OSagent,"NT 5.1")) { 
	$visitor_os ="Windows XP (SP2)"; 
	} elseif(strpos($user_OSagent,"NT 5.2") && strpos($user_OSagent,"WOW64")){ 
	$visitor_os ="Windows XP 64-bit Edition"; 
	} elseif(strpos($user_OSagent,"NT 5.2")) { 
	$visitor_os ="Windows 2003"; 
	} elseif(strpos($user_OSagent,"NT 6.0")) { 
	$visitor_os ="Windows Vista"; 
	} elseif(strpos($user_OSagent,"NT 5.0")) { 
	$visitor_os ="Windows 2000"; 
	} elseif(strpos($user_OSagent,"4.9")) { 
	$visitor_os ="Windows ME"; 
	} elseif(strpos($user_OSagent,"NT 4")) { 
	$visitor_os ="Windows NT 4.0"; 
	} elseif(strpos($user_OSagent,"98")) { 
	$visitor_os ="Windows 98"; 
	} elseif(strpos($user_OSagent,"95")) { 
	$visitor_os ="Windows 95"; 
	} elseif(strpos($user_OSagent,"Mac")) { 
	$visitor_os ="Mac"; 
	} elseif(strpos($user_OSagent,"Linux")) { 
	$visitor_os ="Linux"; 
	} elseif(strpos($user_OSagent,"Unix")) { 
	$visitor_os ="Unix"; 
	} elseif(strpos($user_OSagent,"FreeBSD")) { 
	$visitor_os ="FreeBSD"; 
	} elseif(strpos($user_OSagent,"SunOS")) { 
	$visitor_os ="SunOS"; 
	} elseif(strpos($user_OSagent,"BeOS")) { 
	$visitor_os ="BeOS"; 
	} elseif(strpos($user_OSagent,"OS/2")) { 
	$visitor_os ="OS/2"; 
	} elseif(strpos($user_OSagent,"PC")) { 
	$visitor_os ="Macintosh"; 
	} elseif(strpos($user_OSagent,"AIX")) { 
	$visitor_os ="AIX"; 
	} elseif(strpos($user_OSagent,"IBM OS/2")) { 
	$visitor_os ="IBM OS/2"; 
	} elseif(strpos($user_OSagent,"BSD")) { 
	$visitor_os ="BSD"; 
	} elseif(strpos($user_OSagent,"NetBSD")) { 
	$visitor_os ="NetBSD"; 
	} else { 
	$visitor_os ="其它"; 
	} 
	return $visitor_os; 
}


function userBrowser(){ 
// 浏览器设置 
	$user_OSagent = $_SERVER['HTTP_USER_AGENT']; 
	if(strpos($user_OSagent,"Maxthon") && strpos($user_OSagent,"MSIE")) { 
	$visitor_browser ="Maxthon(Microsoft IE)"; 
	}elseif(strpos($user_OSagent,"Maxthon 2.0")) { 
	$visitor_browser ="Maxthon 2.0"; 
	}elseif(strpos($user_OSagent,"Maxthon")) { 
	$visitor_browser ="Maxthon";
	}elseif(strpos($user_OSagent,"MSIE 9.0")) { 
	$visitor_browser ="MSIE 9.0"; 
	}elseif(strpos($user_OSagent,"MSIE 8.0")) { 
	$visitor_browser ="MSIE 8.0"; 
	}elseif(strpos($user_OSagent,"MSIE 7.0")) { 
	$visitor_browser ="MSIE 7.0"; 
	}elseif(strpos($user_OSagent,"MSIE 6.0")) { 
	$visitor_browser ="MSIE 6.0"; 
	} elseif(strpos($user_OSagent,"MSIE 5.5")) { 
	$visitor_browser ="MSIE 5.5"; 
	} elseif(strpos($user_OSagent,"MSIE 5.0")) { 
	$visitor_browser ="MSIE 5.0"; 
	} elseif(strpos($user_OSagent,"MSIE 4.01")) { 
	$visitor_browser ="MSIE 4.01"; 
	} elseif(strpos($user_OSagent,"NetCaptor")) { 
	$visitor_browser ="NetCaptor"; 
	} elseif(strpos($user_OSagent,"Netscape")) { 
	$visitor_browser ="Netscape"; 
	} elseif(strpos($user_OSagent,"Lynx")) { 
	$visitor_browser ="Lynx"; 
	} elseif(strpos($user_OSagent,"Opera")) { 
	$visitor_browser ="Opera"; 
	} elseif(strpos($user_OSagent,"Konqueror")) { 
	$visitor_browser ="Konqueror"; 
	} elseif(strpos($user_OSagent,"Mozilla/5.0")) { 
	$visitor_browser ="Mozilla"; 
	} elseif(strpos($user_OSagent,"U")) { 
	$visitor_browser ="Firefox"; 
	} else { 
	$visitor_browser ="其它"; 
	} 
	return $visitor_browser; 
}


function getip_out(){ 
// 获取IP地址
	$ip=false; 
	if(!empty($_SERVER["HTTP_CLIENT_IP"])){ 
		$ip = $_SERVER["HTTP_CLIENT_IP"]; 
	} 
	if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) { 
		$ips = explode (", ", $_SERVER['HTTP_X_FORWARDED_FOR']); 
		if ($ip) { array_unshift($ips, $ip); $ip = FALSE; } 
			for ($i = 0; $i < count($ips); $i++) { 
			if (!eregi ("^(10│172.16│192.168).", $ips[$i])) { 
			$ip = $ips[$i]; 
			break; 
			} 
		} 
	} 
	return ($ip ? $ip : $_SERVER['REMOTE_ADDR']); 
}



























 function fieldlist($systemid)
//function fiedllist() 添加信息页面调用字段。 Start ....
 {
	 
 	global $db;
	global $tablepre;
 	$fieSql="Select * from ".$tablepre."field where SystemID=$systemid order by sequence asc";
 	$fieResult = $db->query($fieSql);
 	$x=0;
 	while ($fieRow=$db->fetch_array($fieResult))
 	{
 		if ($fieRow['show']==1) //判断字段是否显示
 		{
 			//获取样式 Start
 			if($x%2==0) 
 			{
 				$strclassname="tablerow1";
 			}else{
 				$strclassname="tablerow2";
 			}
 			// 获取样式 end
 			if ((int)$fieRow['ID']==962) {

			}else{
				
			echo "<tr>";
 			echo "<td width='20%' align='right' class='$strclassname' >".$fieRow['fieldtxt'] ."</td>";
 			echo "<td width='85%' class='$strclassname'>".showfieldout($fieRow['fieldout'],$fieRow['fieldName'],$fieRow['fieldlength'],$fieRow['fieldcontent'],$fieRow['iscontent'],$fieRow['fault'],"",$systemid);
 			
			if($fieRow['fieldinfo']!="")
 			{
 				echo "&nbsp;&nbsp;<font style='color:#F00'>注</font>：<span style='color:#FF3C3C'>".stripcslashes($fieRow['fieldinfo'])."</span>";
 			}
 			//end 
 			
 			echo "</td>";
 			echo "</tr>";	
			
			}
 			$x++;
 		}
 	}
 }
//End ....
 
//调用字段的显示样式
//Start 
//说明：$fieldout 字段显示类型，
function showfieldout($fieldout,$fieldname,$fieldlength,$fieldcontent,$iscontent,$fault,$strvalue,$SystemID)
{
	global $db;
	switch ($fieldout)
	{
		case 0:
			return  "<input type='text' name='$fieldname' id='$fieldname' value='".stripslashes($strvalue)."' style=width:".$fieldlength."px; />";
			break;
		case 1: //文本框
			return  "<textarea name='$fieldname' id='$fieldname' cols='60' rows='6' style=width:".$fieldlength."px;>".stripslashes($strvalue)."</textarea>";
			break;
		case 2: //密码框  修改时不显示原来密码，保留为空，以便判断改了密码才更新密码值，没改就不更新
			//return  "<input type='password' name='$fieldname' id='$fieldname' value='".stripslashes($strvalue)."' style=width:".$fieldlength."px; />";
			return  "<input type='password' name='$fieldname' id='$fieldname' style=width:".$fieldlength."px; />";
			break;
		case 3: // 是否框
			if ($iscontent==1)
			{
				$s_str= explode("*^*", $fieldcontent); 
				for ($i=0;$i<count($s_str);$i++)
				{
					$str_value=explode("||",$s_str[$i]);
					if($strvalue=="")
					{
						$str=$str." <input type='radio' name='$fieldname' id='$fieldname' value=".stripslashes($str_value[0])." ";
						if($fault==$str_value[0]){$str=$str."checked";}
					}
					elseif($strvalue!="")
					{
						$str=$str." <input type='radio' name='$fieldname' id='$fieldname' value=".stripslashes($str_value[0])." ";
						if($strvalue==$str_value[0]){$str=$str."checked";}
					}
				    $str=$str." /> ".$str_value[1];
				} 
				return  $str;
			}
			break;
		case 4: //多选 
			if ($iscontent==1){$cms_fieldcontent=$fieldcontent;}//普通数据
			if ($iscontent==2) //Sql数据
			{
				$cms_ClaSql=stripslashes($fieldcontent);
				$cms_Result=$db->query($cms_ClaSql);
			    $k=0;
				while ($cms_Row=$db->fetch_array($cms_Result)) 
			    {
			    	if($k==0){$cms_fieldcontent=$cms_Row["ClassName"]."||".$cms_Row["ClassName"]."||".$cms_Row["ClassIMG"];}
			    	if($k >0){$cms_fieldcontent=$cms_fieldcontent."*^*".$cms_Row["ClassName"]."||".$cms_Row["ClassName"]."||".$cms_Row["ClassIMG"];}
					$k++;
			    }
			}
			//分割
			$s_str= explode("*^*", $cms_fieldcontent); 
			for ($i=0;$i<count($s_str);$i++)
			{
				$str_value=explode("||",$s_str[$i]);
				
			    $str=$str."<span style='vertical-align:middle'><input type='checkbox' name='".$fieldname."[]' id='$fieldname' value='".$str_value[0]."' ";
			    if($strvalue!="")
				{
					$tem_value=explode("‖",$strvalue);
					for($m=0;$m<count($tem_value);$m++)
					{
						if($str_value[0]==$tem_value[$m]){$str=$str."checked";}
					}
				}
			    $str=$str." /></span> ";
			    if($str_value[2]!="")
			    {
			    	$imgsrc=substr($str_value[2],0,7);
			    	$str=$str."<span style='vertical-align:middle'><img src=../../uploadfile/".$imgsrc."/".$str_value[2]." height=25 width=60 title =".$str_value[1]." /></span> ";
			    }
			    else
			    {
			    	$str=$str.$str_value[1]; //文字
			    }
			} 
			return  $str;
			break;
		case 5:
			if ($iscontent==1) //普通数据
			{
				//echo $fieldcontent;
				$sql="select * from cms_tiaojian where sid=".$SystemID;
				$rel=$db->query($sql);
				$row=$db->fetch_array($rel);
				if($SystemID==81){
					$s_str=explode(',',$row['fangxing']);
				}
				$str="<select name='$fieldname' id='$fieldname' style=width:".$fieldlength."px;>";
				for ($i=0;$i<count($s_str);$i++)
				{
					$str=$str."<option value=".$s_str[$i]." ";
					if ($strvalue ==$s_str[$i]){$str=$str."selected=selected";}
					$str=$str. ">".$s_str[$i]."</option>";
				}
				$str=$str."</select>";
				
				//$s_str= explode("*^*", $fieldcontent); 
//				$str="<select name='$fieldname' id='$fieldname' style=width:".$fieldlength."px;>";
//				for ($i=0;$i<count($s_str);$i++)
//				{
//					$str_value=explode("||",$s_str[$i]);
//					$str_value=explode("||",$s_str[$i]);
//					$str=$str."<option value=".$str_value[0]." ";
//					if ($strvalue ==$str_value[0]){$str=$str."selected=selected";}
//					$str=$str. ">".$str_value[1]."</option>";
//				} 
//				$str=$str."</select>";
			}
			else if($iscontent==2) //Sql数据
			{   
				global $str,$tablepre;
				global $Class_arr,$ID;
				$ID=stripslashes($strvalue);
				
				$str="<select name='$fieldname' id='$fieldname' style=width:".$fieldlength."px;>";
					

					if($_SESSION["adminlov"]!=520 && $_SESSION["adminclassKj"]!="")//对快拍活动进行分类权限设置
					{
						$ClaSql="Select * from ".$tablepre."class where SystemID=$SystemID and ID in(".$_SESSION["adminclassKj"].") order by sequence asc";
					}else{
						$ClaSql="Select * from ".$tablepre."class where SystemID=$SystemID order by sequence asc";
					}
				//echo $ClaSql;
				//$ClaSql="Select * from ".$tablepre."class where SystemID=$SystemID order by sequence Asc";
					//只为信托产品商城使用
					if($fieldname == 'areaid'){
						 $ClaSql="Select * from ".$tablepre."areas where 1 order by sequence Asc";
					   $Result=$db->query($ClaSql);
					   while ($Row=$db->fetch_array($Result)) 
					   {
					   		$str=$str. "<option value=".$Row["ID"]." ";
					   		if($Row["ID"]==$strvalue){$str=$str. "selected='selected'";}
					   		if(empty($Row["partid"])){
					   			$str=$str. ">".$Row["ClassName"]. "</option>";
					   		} else {
					   			$str=$str. ">--".$Row["ClassName"]. "</option>";
					   		}
					   }					   
					}else{
						$Result=$db->query($ClaSql);
					   while ($Row=$db->fetch_array($Result)) 
					   {
						$Class_arr[]=array($Row["ID"],$Row["ClassName"],$Row["ClassNameEng"],$Row["Depth"],$Row["partid"],$Row["Sequence"],$Row["Num"],$Row["show"],"ParPath"=>$Row["ParPath"].",".$Row["ID"]);
					   }
					   if(!empty($Class_arr)){
							foreach ($Class_arr as $key => $value) {
								$ParPath[$key] = $value['ParPath'];
							}
							array_multisort($ParPath, $Class_arr);
						}
					   //调用无限级分类函数
					   $str=$str.SelecttoClass(0,true);
					}

					
					
			   $Class_arr="";//清空 全局变量
			   $str= $str. "</select>";
			}
			return   $str;
			break;
		case 6: //eweb编辑框
			$str="<textarea name=".$fieldname." style='display:none;'>".stripslashes($strvalue)."</textarea><iframe ID='eWebEditor1' src='../system_editor/editor/ewebeditor.htm?id=".$fieldname."&style=blue' frameborder=0 scrolling=no width='700' HEIGHT='450'></iframe>";
			return $str;
		  break;
	    case 7: //eweb简单编辑框
			$str="<textarea name=".$fieldname." style='display:none;'>".stripslashes($strvalue)."</textarea><iframe ID='eWebEditor1' src='../system_editor/ewebeditor.htm?id=".$fieldname."&style=mini500' frameborder=0 scrolling=no width='600' HEIGHT='300'></iframe>";
		  return $str;
		  break;
		  	
		case 13: //FCK编辑框
			$sBasePath ="../system_editor/fckeditor/";
			$oFCKeditor = new FCKeditor($fieldname) ;
			$oFCKeditor->BasePath	= $sBasePath ;
			$oFCKeditor->ToolbarSet = 'Default';
			$oFCKeditor->Value		= stripslashes($strvalue);
			$oFCKeditor->Width = '700'; // 编辑器宽度，类中有默认值，如果不想修改可不管此项 
	        $oFCKeditor->Height= '400'; // 同width，此处为高$oFCKeditor->ToolbarSet 
			return  $oFCKeditor->Create() ;	
		  break;
	    case 14: //FCK简单编辑框
			$sBasePath ="../system_editor/fckeditor/";
			$oFCKeditor = new FCKeditor($fieldname) ;
			$oFCKeditor->BasePath	= $sBasePath ;
			$oFCKeditor->ToolbarSet = 'Basic';
			$oFCKeditor->Value		= stripslashes($strvalue);
			$oFCKeditor->Width = $fieldlength; // 编辑器宽度，类中有默认值，如果不想修改可不管此项 
	        $oFCKeditor->Height= '200'; // 同width，此处为高$oFCKeditor->ToolbarSet 
			return  $oFCKeditor->Create() ;	
		  break;
		
		case 8: //上传图片[带缩略图]
		   if ($iscontent==1)
		   {
		   	  $str_value=explode("||",$fieldcontent);
		    $str="缩略图:<input id="."s_".$fieldname." value=";
			if($strvalue!=""){$str=$str."'s_".stripslashes($strvalue)."'";}
			if($strvalue==""){$str=$str."'".stripslashes($strvalue)."'";}
			$str=$str."name=="."s_".$fieldname." style=width:".$fieldlength."px;/>";
			if($strvalue!=""){
				$str=$str."<img src=../../uploadfile/".substr(stripslashes($strvalue),0,7)."/".stripslashes($strvalue)." height='25' style=\"border:1px #ccc solid; margin:2px;\"><br>";
			}
			$str=$str."<input id='$fieldname' value='".stripslashes($strvalue)."' name='$fieldname' style=width:".$fieldlength."px;/>";
			$str=$str."<span style='vertical-align:middle'> <iframe src='../include/upload.php?fieldname=$fieldname&strw=".$str_value[0]."&strh=".$str_value[1]."' width='310' height='25' scrolling='no' marginwidth='0' framespacing='0' marginheight='0' frameborder='0'></iframe></span>";
			return $str;
			}
			break;
		case 9://多图上传
		
	    if($strvalue!="")
		{
			$str_value=explode("‖",$strvalue);
			$str="<table id='container".$fieldname."' width='100%' border='0' cellspacing='0' cellpadding='0'>";
			for ($m=0;$m<count($str_value);$m++)
			{
				$str=$str."<tr><td>";
				$str=$str."<input id=".$fieldname.$m." value='".$str_value[$m]."' name='".$fieldname."[]' style=width:".$fieldlength."px;/><img src=../../uploadfile/".substr($str_value[$m],0,7)."/".$str_value[$m]." height='25' style=\"border:1px #ccc solid; margin:2px;\">";
				$str=$str."<span style='vertical-align:middle'> <iframe src='../system_include/upload.php?fieldname=".$fieldname.$m."&fieldout=".$fieldout."' width='310' height='25' scrolling='no' marginwidth='0' framespacing='0' marginheight='0' frameborder='0'></iframe></span>";
				if($m==0){$str=$str."<input name='add' type='button' value='添加' onclick=addItem('".$fieldname."',".$fieldlength."); /></td>";}
				if($m> 0){$str=$str."<input name=\"del\" type=\"button\" value=\"删除\" onclick=\"delItem('".$fieldname."',$m);\">";}
				$str=$str."</tr>";
			}
			$str=$str."</table>";
		}else{
			
			$str="<table id='container".$fieldname."' width='100%' border='0' cellspacing='0' cellpadding='0'>";
			$str=$str."<tr><td>";
			$str=$str."<input id='$fieldname' value='".stripslashes($strvalue)."' name='".$fieldname."[]' style=width:".$fieldlength."px;/>";
			$str=$str."<span style='vertical-align:middle'> <iframe src='../system_include/upload.php?fieldname=$fieldname&fieldout=".$fieldout."' width='310' height='25' scrolling='no' marginwidth='0' framespacing='0' marginheight='0' frameborder='0'></iframe></span>";
			$str=$str."<input name='add' type='button' value='添加' onclick=addItem('".$fieldname."',".$fieldlength."); /></td>";
			$str=$str."</tr>";
			$str=$str."</table>";
		}
		return $str;
		break;
		case 10:
			$str="<input id='$fieldname' value='".stripslashes($strvalue)."' name='$fieldname' style=width:".$fieldlength."px;/>";
			$str=$str."<span style='vertical-align:middle'> <iframe src='../system_include/file_upload.php?fieldname=$fieldname' width='310' height='25' scrolling='no' marginwidth='0' framespacing='0' marginheight='0' frameborder='0'></iframe></span>";
			return $str;
			break;	
		case 11: //无输出框
			$str="&nbsp;".stripslashes($strvalue);
			$str=$str."<input type='hidden' name='$fieldname' id='$fieldname' value='".stripslashes($strvalue)."' style=width:".$fieldlength."px; />";
			return $str;
			break;	
		case 12: //单图上传
			$str="<input id='$fieldname' value='".stripslashes($strvalue)."' name='$fieldname' style=width:".$fieldlength."px;/>";
			if($strvalue!=""){
				$str=$str."<img src=../../uploadfile/".substr(stripslashes($strvalue),0,7)."/".stripslashes($strvalue)." height='25' style=\"border:1px #ccc solid; margin:2px;\">";
			}
			$str=$str."<span style='vertical-align:middle'> <iframe src='../system_include/upload.php?fieldname=".$fieldname.$m."&fieldout=9' width='310' height='25' scrolling='no' marginwidth='0' framespacing='0' marginheight='0' frameborder='0'></iframe></span>";
			return $str;
			break;		
	}	
}
//End ... 





















//函数调用说明：调用分类；无限级分类；
//$SystemID:为栏目ID,$SysClassID:为类别ID
//SelectClassType($SystemID,$SysClassID)
function SelectClassType($SystemID,$SysClassID)
{
 global $db;
 global $tablepre;
  $ClaSql="Select * from ".$tablepre."class where SystemID=$SystemID order by sequence asc";
  $Result=$db->query($ClaSql);
  while ($Row=$db->fetch_array($Result)) 
  {
  	$Class_arr[]=array($Row["ID"],$Row["ClassName"],$Row["ClassNameEng"],$Row["Depth"],$Row["partid"],$Row["Sequence"]);
  }
}

function SelectClass($ClssID,$Zh)
{
  global $Class_arr;
  global $ID;
  for($i=0;$i<count($Class_arr);$i++)
  {
  	  echo "<option value=".$Class_arr[$i][0]." ";
  	  if($Class_arr[$i][0]==$ID){echo "selected='selected'";}
  	  echo ">";	
	  if($Class_arr[$i][3]==0){echo "├ ";}
	  if($Class_arr[$i][3]>0)
	  	{
	  	  for ($x=1;$x<=$Class_arr[$i][3];$x++)
	   	 	{
	   	 		echo "│";
	   	 	}
	   	 	echo"├ ";
	  	}
	  	if ($Zh==true){echo $Class_arr[$i][1];}
	  	else {echo $Class_arr[$i][2];}
	  	echo "</option>";
 }
}
//
function SelecttoClass($ClssID,$Zh)
{
  global $Class_arr;
  global $ID;
  global $str;
if($Class_arr!=""){
 // ok($Class_arr,",",1);
  for($i=0;$i<count($Class_arr);$i++)
  {
  	  $str=$str. "<option value=".$Class_arr[$i][0]." ";
  	  if($Class_arr[$i][0]==$ID){$str=$str. "selected='selected'";}
  	  $str=$str. ">";	
	  if($Class_arr[$i][3]==0){$str=$str. "├ ";}
	  if($Class_arr[$i][3]>0)
	  	{
	  	  for ($x=1;$x<=$Class_arr[$i][3];$x++)
	   	 	{
	   	 		$str=$str. "│";
	   	 	}
	   	 	$str=$str."├ ";
	  	}
	  	if ($Zh==true){$str=$str. $Class_arr[$i][1];}
	  	else 
	  	{
	  		$str=$str. $Class_arr[$i][2];
	  	}
	  	$str=$str. "</option>";
  }
}else{
	$str=$str."<option value=''>没有信息</option>";
}
}
//// Select无限级分类结束 end；

/*
============================================================
编辑分类 需要调用无限级分类函数 Start
============================================================
*/
function EditSelectClass($ClssID,$Zh)
{
  global $Class_arr;
  global $parID;
  for($i=0;$i<count($Class_arr);$i++)
  {
  	if($Class_arr[$i][4]==$ClssID)
  	{
  		//输出下拉框
  	  echo "<option value=".$Class_arr[$i][0]." ";
  	  if($Class_arr[$i][0]==$parID){echo "selected='selected'";}
  	  echo ">";	
	  if($Class_arr[$i][3]==0){echo "├ ";}
	  if($Class_arr[$i][3]>0)
	  	{
	  	  for ($x=1;$x<=$Class_arr[$i][3];$x++)
	   	 	{
	   	 		echo "│";
	   	 	}
	   	 	echo"├ ";
	  	}
	  	if ($Zh==true){echo $Class_arr[$i][1];}
	  	else {echo $Class_arr[$i][2];}
	  	echo "</option>";
	 // 	echo $Class_arr[$i][1]."<br>";
	  	EditSelectClass($Class_arr[$i][0],$Zh);
  }
 }
}
/*
============================================================
编辑分类 需要调用无限级分类函数 End
============================================================
*/

//在分类栏目中显示分类列表Start ////////////////////////////////////////////////////////////////////
function ShowClass($ClasID, $Zh, $SystemID)
{
	global $Class_arr;
    for ($i=0;$i<count($Class_arr);$i++)
    {
		
			if($Class_arr[$i][6]>0) { $ClassName="tablerow1"; } else { $ClassName="tablerow2"; }//输出样式 Start
			echo "<tr>";	
			echo "<td class=$ClassName>";
			if ($i+1 <10){echo "0".($i+1);}
			if ($i+1>=10){echo ($i+1);}
			echo "</td>";
			echo "<td class=$ClassName>";
			if($Class_arr[$i][3]==0){echo "├ ";}
			if($Class_arr[$i][3]>0)
			{
			for ($x=1;$x<=$Class_arr[$i][3];$x++)
			{
				echo " │"; //输出分类前的缩进
			}
			echo" ├ ";
			}
			if($Class_arr[$i][6]>0){echo "<b>";} //实现根类加粗操作
			$j=$j+1;
			echo $Class_arr[$i][1];
			if($Class_arr[$i][6]>0){echo "(".$Class_arr[$i][6].")";}//输出子类个数；
			if($Class_arr[$i][3]==0){echo "</b>";} //实现根类加粗操作
			echo "</td>";
			echo "<td class=$ClassName><a href=add_classtype.php?m=".$SystemID."&act=add&ID=".$Class_arr[$i][0].">添加分类</a> | <a href=add_classtype.php?m=".$SystemID."&act=edit&ID=".$Class_arr[$i][0].">编辑分类</a> | <a ".confirm()." href=admin_class.php?m=".$SystemID."&act=del&ID=".$Class_arr[$i][0].">删除分类</a>  </td>";
			echo "<td class=$ClassName><span id='show_".$Class_arr[$i][0]."'>";
			switch ($Class_arr[$i][7])//取出是否启用的值（$Class_arr[$i][7]即show的值）并进行：
			{
			case 0:
				echo "<b style='color:#ff0000;cursor:pointer' onclick=\"stemp('show','".$Class_arr[$i][0]."',0)\">×</b>";
				break;
			case 1:
				echo "<b style='color:#386BC8;cursor:pointer' onclick=\"stemp('show','".$Class_arr[$i][0]."',1)\">√</b>";
				break;	
			}		
			echo("</span></td>");
			echo "<td class=$ClassName>";
			echo "<form id=form1".$Class_arr[$i][0]." name=form1".$Class_arr[$i][0]." method=post action=admin_class.php?act=upd&m=".$SystemID."&ID=".$Class_arr[$i][0].">";
			echo "<input value=".$Class_arr[$i][5]." name='sequeceID' style='font-size:12px; width:40px;'>";
			echo "&nbsp;<input type='submit' value='修改'>";
			echo "</form>";
			echo "</td>";
			echo "</tr>";

    }//END for
}  


//在分类栏目中显示分类列表Start ////////////////////////////////////////////////////////////////////
function ShowAreas($ClasID, $Zh)
{
	global $Class_arr;
    for ($i=0;$i<count($Class_arr);$i++)
    {
		
			if($Class_arr[$i][6]>0) { $ClassName="tablerow1"; } else { $ClassName="tablerow2"; }//输出样式 Start
			echo "<tr>";	
			echo "<td class=$ClassName>";
			if ($i+1 <10){echo "0".($i+1);}
			if ($i+1>=10){echo ($i+1);}
			echo "</td>";
			echo "<td class=$ClassName>";
			if($Class_arr[$i][3]==0){echo "├ ";}
			if($Class_arr[$i][3]>0)
			{
			for ($x=1;$x<=$Class_arr[$i][3];$x++)
			{
				echo " │"; //输出分类前的缩进
			}
			echo" ├ ";
			}
			if($Class_arr[$i][6]>0){echo "<b>";} //实现根类加粗操作
			$j=$j+1;
			echo $Class_arr[$i][1];
			if($Class_arr[$i][6]>0){echo "(".$Class_arr[$i][6].")";}//输出子类个数；
			if($Class_arr[$i][3]==0){echo "</b>";} //实现根类加粗操作
			echo "</td>";
			echo "<td class=$ClassName><a href=add_areastype.php?act=add&ID=".$Class_arr[$i][0].">添加分类</a> | <a href=add_areastype.php?act=edit&ID=".$Class_arr[$i][0].">编辑分类</a> | <a ".confirm()." href=admin_areas.php?act=del&ID=".$Class_arr[$i][0].">删除分类</a>  </td>";
			echo "<td class=$ClassName><span id='show_".$Class_arr[$i][0]."'>";
			switch ($Class_arr[$i][7])//取出是否启用的值（$Class_arr[$i][7]即show的值）并进行：
			{
			case 0:
				echo "<b style='color:#ff0000;cursor:pointer' onclick=\"stemp('show','".$Class_arr[$i][0]."',0)\">×</b>";
				break;
			case 1:
				echo "<b style='color:#386BC8;cursor:pointer' onclick=\"stemp('show','".$Class_arr[$i][0]."',1)\">√</b>";
				break;	
			}		
			echo("</span></td>");
			echo "<td class=$ClassName>";
			echo "<form id=form1".$Class_arr[$i][0]." name=form1".$Class_arr[$i][0]." method=post action=admin_areas.php?act=upd&ID=".$Class_arr[$i][0].">";
			echo "<input value=".$Class_arr[$i][5]." name='sequeceID' style='font-size:12px; width:40px;'>";
			echo "&nbsp;<input type='submit' value='修改'>";
			echo "</form>";
			echo "</td>";
			echo "</tr>";

    }//END for
}

function yc_ShowClass($ClasID, $Zh, $SystemID)
{
   	global $Class_arr;
    for ($i=0;$i<count($Class_arr);$i++)
    {
		
			if($Class_arr[$i][6]>0) { $ClassName="tablerow1"; } else { $ClassName="tablerow2"; }//输出样式 Start
			echo "<tr>";	
			echo "<td class=$ClassName>";
			if ($i+1 <10){echo "0".($i+1);}
			if ($i+1>=10){echo ($i+1);}
			echo "</td>";
			echo "<td class=$ClassName>";
			if($Class_arr[$i][3]==0){echo "├ ";}
			if($Class_arr[$i][3]>0)
			{
			for ($x=1;$x<=$Class_arr[$i][3];$x++)
			{
				echo " │"; //输出分类前的缩进
			}
			echo" ├ ";
			}
			if($Class_arr[$i][6]>0){echo "<b>";} //实现根类加粗操作
			$j=$j+1;
			echo $Class_arr[$i][1];
			if($Class_arr[$i][6]>0){echo "(".$Class_arr[$i][6].")";}//输出子类个数；
			if($Class_arr[$i][3]==0){echo "</b>";} //实现根类加粗操作
			echo "</td>";
			echo "<td class=$ClassName><a href=add_classtype.php?m=".$SystemID."&act=add&ID=".$Class_arr[$i][0].">添加分类</a> | <a href=add_classtype.php?m=".$SystemID."&act=edit&ID=".$Class_arr[$i][0].">编辑分类</a> | <a ".confirm()." href=admin_class.php?m=".$SystemID."&act=del&ID=".$Class_arr[$i][0].">删除分类</a>  </td>";
			echo "<td class=$ClassName><span id='show_".$Class_arr[$i][0]."'>";
			switch ($Class_arr[$i][7])//取出是否启用的值（$Class_arr[$i][7]即show的值）并进行：
			{
			case 0:
				echo "<b style='color:#ff0000;cursor:pointer' onclick=\"stemp('show','".$Class_arr[$i][0]."',0)\">×</b>";
				break;
			case 1:
				echo "<b style='color:#386BC8;cursor:pointer' onclick=\"stemp('show','".$Class_arr[$i][0]."',1)\">√</b>";
				break;	
			}		
			echo("</span></td>");
			echo "<td class=$ClassName>";
			echo "<form id=form1".$Class_arr[$i][0]." name=form1".$Class_arr[$i][0]." method=post action=admin_class.php?act=upd&m=".$SystemID."&ID=".$Class_arr[$i][0].">";
			echo "<input value=".$Class_arr[$i][5]." name='sequeceID' style='font-size:12px; width:40px;'>";
			echo "&nbsp;<input type='submit' value='修改'>";
			echo "</form>";
			echo "</td>";
			echo "</tr>";

    }//END for
}  
// 显示分类 End;/////////////////////////////////////////////////////////


/*
============================================================
编辑分类 需要调用无限级分类函数 End 2222222222222222222
============================================================
*/

//在分类栏目中显示分类列表Start//
function ShowClass2($ClasID,$Zh,$SystemID)
   {
   	global $Class_arr;
   	//$SystemID=$SystemID;
    for ($i=0;$i<count($Class_arr);$i++)
    {
       //if($Class_arr[$i][4]==$ClasID)
       //{
       	////输出样式 Start
   		if($Class_arr[$i][6]>0)
   		{  
   			$ClassName="tablerow1";
   		}else{
   		    $ClassName="tablerow2";
   		}
		
       	////输出样式 End
       	 echo "<tr>";	
         echo "<td class=$ClassName>";
		 if ($i+1 <10){echo "0".($i+1);}
		 if ($i+1>=10){echo ($i+1);}
		 echo "</td>";
         echo "<td class=$ClassName>";
         if($Class_arr[$i][3]==0){echo "├ ";}
         if($Class_arr[$i][3]>0)
	  	 {
	  	   for ($x=1;$x<=$Class_arr[$i][3];$x++)
	   	 	{
	   	 		echo " │"; //输出分类前的缩进
	   	 	}
	   	 	echo" ├ ";
	  	 }
	  	 if($Class_arr[$i][6]>0){echo "<b>";} //实现根类加粗操作
	  	 $j=$j+1;
       	 echo "<a href=\"../news/admin_index.php?Kjid=".$Class_arr[$i][0]."\">".$Class_arr[$i][1]."</a>";
       	 if($Class_arr[$i][6]>0){echo "(".$Class_arr[$i][6].")";}//输出子类个数；
       	 if($Class_arr[$i][3]==0){echo "</b>";} //实现根类加粗操作
       	 echo "</td>";
		 
		 
		$qxclass  = "<td class=$ClassName><!--<a href=add_classtype.php?m=".$SystemID."&act=edit&ID=".$Class_arr[$i][0].">编辑分类</a> | --><a href=\"../news/admin_index.php?Kjid=".$Class_arr[$i][0]."\">查看信息</a></td>";
		
		$qxclass1 = "<td class=$ClassName><font color=#cccccc>编辑分类</font></td>";
		 
		$classkj = $_SESSION["adminclassKj"];
		$classkj_arr = explode(",",$classkj);
		
		for ($k=0; $k<count($classkj_arr); $k++) {
			if(trim($classkj_arr[$k]).""==trim($Class_arr[$i][0]).""){
				$str_qxclass = $qxclass;
				break;
			}else{
				$str_qxclass = $qxclass1;
			}
		}
		echo $str_qxclass;
		 
         echo "</tr>"; 
         //ShowClass2($Class_arr[$i][0],$Zh,$SystemID);
       }
     //}
   }  
// 显示分类 End;//

//在分类栏目中显示分类列表Start//
function ShowAreas2($ClasID,$Zh)
   {
   	global $Class_arr;
   	//$SystemID=$SystemID;
    for ($i=0;$i<count($Class_arr);$i++)
    {
       //if($Class_arr[$i][4]==$ClasID)
       //{
       	////输出样式 Start
   		if($Class_arr[$i][6]>0)
   		{  
   			$ClassName="tablerow1";
   		}else{
   		    $ClassName="tablerow2";
   		}
		
       	////输出样式 End
       	 echo "<tr>";	
         echo "<td class=$ClassName>";
		 if ($i+1 <10){echo "0".($i+1);}
		 if ($i+1>=10){echo ($i+1);}
		 echo "</td>";
         echo "<td class=$ClassName>";
         if($Class_arr[$i][3]==0){echo "├ ";}
         if($Class_arr[$i][3]>0)
	  	 {
	  	   for ($x=1;$x<=$Class_arr[$i][3];$x++)
	   	 	{
	   	 		echo " │"; //输出分类前的缩进
	   	 	}
	   	 	echo" ├ ";
	  	 }
	  	 if($Class_arr[$i][6]>0){echo "<b>";} //实现根类加粗操作
	  	 $j=$j+1;
       	 echo "<a href=\"../news/admin_index.php?Kjid=".$Class_arr[$i][0]."\">".$Class_arr[$i][1]."</a>";
       	 if($Class_arr[$i][6]>0){echo "(".$Class_arr[$i][6].")";}//输出子类个数；
       	 if($Class_arr[$i][3]==0){echo "</b>";} //实现根类加粗操作
       	 echo "</td>";
		 
		 
		$qxclass  = "<td class=$ClassName><!--<a href=add_areastype.php?act=edit&ID=".$Class_arr[$i][0].">编辑分类</a> | --><a href=\"../news/admin_index.php?Kjid=".$Class_arr[$i][0]."\">查看信息</a></td>";
		
		$qxclass1 = "<td class=$ClassName><font color=#cccccc>编辑分类</font></td>";
		 
		$classkj = $_SESSION["adminclassKj"];
		$classkj_arr = explode(",",$classkj);
		
		for ($k=0; $k<count($classkj_arr); $k++) {
			if(trim($classkj_arr[$k]).""==trim($Class_arr[$i][0]).""){
				$str_qxclass = $qxclass;
				break;
			}else{
				$str_qxclass = $qxclass1;
			}
		}
		echo $str_qxclass;
		 
         echo "</tr>"; 
         //ShowClass2($Class_arr[$i][0],$Zh,$SystemID);
       }
     //}
   }


//在分类栏目中显示分类列表Start ////////////////////////////////////////////////////////////////////
function ShowClassfiy($ClasID,$Zh,$SystemID)
   {
   	global $Class_arr;
   	//$SystemID=$SystemID;
    for ($i=0;$i<count($Class_arr);$i++)
    {
       if($Class_arr[$i][4]==$ClasID)
       {
       	////输出样式 Start
   		if($Class_arr[$i][6]>0)
   		{  
   			$ClassName="tablerow1";
   		}
   		else 
   		{
   		    $ClassName="tablerow2";
   		}
       	////输出样式 End
       	 echo "<tr>";	
         echo "<td class=$ClassName>";
		 if ($i+1 <10){echo "0".($i+1);}
		 if ($i+1>=10){echo ($i+1);}
		 echo "</td>";
         echo "<td class=$ClassName>";
         if($Class_arr[$i][3]==0){echo "├ ";}
         if($Class_arr[$i][3]>0)
	  	 {
	  	   for ($x=1;$x<=$Class_arr[$i][3];$x++)
	   	 	{
	   	 		echo " │"; //输出分类前的缩进
	   	 	}
	   	 	echo" ├ ";
	  	 }
	  	 if($Class_arr[$i][6]>0){echo "<b>";} //实现根类加粗操作
	  	 $j=$j+1;
       	 echo $Class_arr[$i][1];
       	 if($Class_arr[$i][6]>0){echo "(".$Class_arr[$i][6].")";}//输出子类个数；
       	 if($Class_arr[$i][3]==0){echo "</b>";} //实现根类加粗操作
       	 echo "</td>";
         echo "<td class=$ClassName><a href=add_classfiy.php?m=".$SystemID."&act=add&ID=".$Class_arr[$i][0].">添加地区</a> | <a href=add_classfiy.php?m=".$SystemID."&act=edit&ID=".$Class_arr[$i][0].">编辑地区</a> | <a ".confirm()." href=admin_classfiy.php?m=".$SystemID."&act=del&ID=".$Class_arr[$i][0].">删除地区</a>";
		 if($SystemID==14)echo(" | <a href=../comments/admin_index.php?typeid=140&activeid=".$Class_arr[$i][0].">评论</a>");
		 echo("</td>");
		echo "<td class=$ClassName><span id='show_".$Class_arr[$i][0]."'>";
		switch ($Class_arr[$i][7])//取出是否启用的值（$Class_arr[$i][7]即show的值）并进行：
		{
			case 0:
				echo "<b style='color:#ff0000;cursor:pointer' onclick=\"stemp('show','".$Class_arr[$i][0]."',0)\">×</b>";
				break;
			case 1:
				echo "<b style='color:#386BC8;cursor:pointer' onclick=\"stemp('show','".$Class_arr[$i][0]."',1)\">√</b>";
				break;	
		}		
		echo("</span></td>");
         echo "<td class=$ClassName>";
         echo "<form id=form1".$Class_arr[$i][0]." name=form1".$Class_arr[$i][0]." method=post action=admin_class.php?act=upd&m=".$SystemID."&ID=".$Class_arr[$i][0].">";
         echo "<input value=".$Class_arr[$i][5]." name='sequeceID' style='font-size:12px; width:40px;'>";
         echo "&nbsp;<input type='submit' value='修改'>";
         echo "</form>";
         echo "</td>";
         echo "</tr>"; 
         ShowClassfiy($Class_arr[$i][0],$Zh,$SystemID);
       }
     }
   }  
// 显示分类 End;/////////////////////////////////////////////////////////



/////////////////////////////////////////////
//////检测表单函数开始.
/////////////////////////////////////////////
//函数说明：checkmyform()检查表单提交:$SystemID:为栏目ID;
function checkmyform($SystemID)
{
  global $db;
  global $tablepre;
  $cmssql="select * from ".$tablepre."field where SystemID=$SystemID and ismust =1 order by sequence asc";
  $cmsresult=$db->query($cmssql);
  while ($cmsrow=$db->fetch_array($cmsresult))
  {
  	$cms_arr[]=array($cmsrow["fieldName"],$cmsrow["fieldtxt"],$cmsrow["fieldout"]);
  }
  global $cmsstr;
  for ($i=0;$i<count($cms_arr);$i++)
  {

  	if ($i==0){$cmsstr=$cms_arr[$i][0]."﹫".$cms_arr[$i][1]."﹫".$cms_arr[$i][2];}
  	if ($i>0){$cmsstr=$cmsstr."‖".$cms_arr[$i][0]."﹫".$cms_arr[$i][1]."﹫".$cms_arr[$i][2];} 
  }
 // echo $cmsstr;
  echo "<script language=\"javascript\">";
  echo "var Jcms_arr='$cmsstr';";
  echo "function checkform()";
  echo "{";
  echo "Jcms=Jcms_arr.split(\"‖\");";
  echo "for (var i=0;i<Jcms.length;i++)";
  echo "{";
  echo "strs=Jcms[i].split(\"﹫\");";
  echo "if(document.getElementById(strs[0]).value=='')";
  echo "{alert(\"请输入\"+strs[1]+\"信息\");document.getElementById(strs[0]).focus();return false;}";   	 	
  echo   "}"; 
  echo "}";
  echo "</script>";
}
/////////////////////////////////////////////
//////检测表单结束.
/////////////////////////////////////////////

//保存添加的信息
function cms_savemain($SystemID,$tabName)
{
	global $db,$file_all,$tablepre;
	$CmsDate      =date("Y-m-d H:i:s",time());
	$cms_Sql="Select fieldName,fieldtype,fieldout,iscontent from ".$tablepre."field where SystemID=".$SystemID." and `show`=1  order by sequence asc";
 	$cms_Result = $db->query($cms_Sql);
 	$i=0; 
 	while ($cms_row=$db->fetch_array($cms_Result))
 	{
 		//get_magic_quotes_gpc();
 		$str_value=$_REQUEST[$cms_row["fieldName"]];
//			if($SystemID==7)
//			{
//				$username  = $_POST['username'];
//				$mysql="select COUNT(*) from ".$tablepre."member where username='$username'";
//				$total_Wait = $db->result($db->query($mysql),0);
//				if($total_Wait>0)
//				{
//					echo("<script language='javascript'>alert('该用户名已经存在，请换一个用户名！');history.go(-1);< /script>");	
//					exit();
//				}
//			}
			
		    //密码框添加 记录
			if ($cms_row["fieldout"]==2) //密码框
			{   
				$str_Hash    =randmon(5);
				$str_password=md5($_REQUEST[$cms_row["fieldName"]]); //md5一次加密
				$str_value =md5($str_password.$str_Hash);// 密码 | md5 二次加密
			}
			//密码框结束
 		    //判断多选开始
			if($cms_row["fieldout"]==4)
			{
				$drop_arr=$_REQUEST[$cms_row["fieldName"]];
				for ($k=0;$k<count($drop_arr);$k++)
				{
					if($k==0){$drop=$drop_arr[0];}
					if($k >0){$drop=$drop."‖".$drop_arr[$k];}
				}
				$str_value=$drop;
			}//多选end
			 //上传图片 数组 （多图）
			if($cms_row["fieldout"]==9)
			{
				$drop_arr=$_REQUEST[$cms_row["fieldName"]];
				for ($k=0;$k<count($drop_arr);$k++)
				{
					if($k==0){$drop=$drop_arr[0];}
					if($k >0){$drop=$drop."‖".$drop_arr[$k];}
				}
				$str_value=$drop;
			}//上传图片end
 		if($i==0) //日期
 		{
 			$file_all  = "`".$cms_row["fieldName"]."`";
 			if($cms_row["fieldtype"]==3&&$str_value=="") $strvalue = "'".$CmsDate."'"; //日期
 			else
 			{
 				$value_all = "'".$str_value."'";
 			}	
 		}
 		if($i>0) 
 		{
 			$file_all=$file_all. ",`".$cms_row["fieldName"]."`";
 			if($cms_row["fieldtype"]==3&&$str_value=="")
 			{
 				$value_all =$value_all. ",'".$CmsDate."'";
 			}
 			else
 			{
 				$value_all =$value_all. ",'".$str_value."'";
 			}	
 			
 		} 
 		if($cms_row["fieldout"]==8)// 保存缩略图
		  {
		  	$file_all =$file_all.",`"."s_".$cms_row["fieldName"]."`";
		  	$value_all =$value_all. ",'"."s_".$str_value."'";
		  }
		if ($cms_row["fieldout"]==2) //密码框哈希值
		{
			$file_all  =$file_all. ",`hash`";
			$value_all =$value_all.",'".$str_Hash."'"; //哈希值
		}
 		$i++;
 	}

		if ($SystemID==1)
		{
		$db->query("insert into $tabName (".$file_all.") values (".$value_all.")");	
		}else{
		$db->query("insert into $tabName (".$file_all.") values (".$value_all.")");
		}
	//$db->query("insert into $tabName (".$file_all.",`datetime`) values (".$value_all.",'".$CmsDate."')" );
	//$db->query("insert into $tabName (".$file_all.") values (".$value_all.")" );
}
//保存编辑信息
function cms_editsave($SystemID,$tabName,$strid)
{
	global $db,$editfile_all,$tablepre;
	$CmsDate      =date("Y-m-d H:i:s",time());
	$cms_Sql="Select fieldName,fieldtype,fieldout,iscontent from ".$tablepre."field where SystemID=".$SystemID." and `show`=1  order by sequence asc";
 	$cms_Result = $db->query($cms_Sql);
 	$i=0;
 	while ($cms_row=$db->fetch_array($cms_Result))
 	{
 		get_magic_quotes_gpc();
 		$str_value=$_REQUEST[$cms_row["fieldName"]];
		//密码框添加 记录
		if ($cms_row["fieldout"]==2) //密码框
		{   
		  if($_REQUEST[$cms_row["fieldName"]]!="")//修改了密码的情况
		  {
			$str_Hash    =randmon(5);
			$str_password=md5($_REQUEST[$cms_row["fieldName"]]); //md5一次加密
			$str_value =md5($str_password.$str_Hash);// 密码 | md5 二次加密
		  }else{//未修改密码的情况：保留原密码
			  $mysql=$db->query("select * from $tabName where id=$strid");
			  $rs_pass=$db->fetch_array($mysql);
			  $str_Hash=$rs_pass['hash'];
			  $str_value=$rs_pass['password'];
		  }
		}
		//密码框结束
 		//判断多选开始
		if($cms_row["fieldout"]==4)
		{
			$drop_arr=$_REQUEST[$cms_row["fieldName"]];
			for ($k=0;$k<count($drop_arr);$k++)
			{
				if($k==0){$drop=$drop_arr[0];}
				if($k >0){$drop=$drop."‖".$drop_arr[$k];}
			}
			$str_value=$drop;
		}//多选end
	 //上传图片 数组 （多图）
		if($cms_row["fieldout"]==9)
		{
			$drop_arr=$_REQUEST[$cms_row["fieldName"]];
			for ($k=0;$k<count($drop_arr);$k++)
			{
				if($k==0){$drop=$drop_arr[0];}
				if($k >0){$drop=$drop."‖".$drop_arr[$k];}
			}
			$str_value=$drop;
		}//上传图片end
		if($i==0)
 		{
 			$editfile_all="`".$cms_row["fieldName"]."`='".$str_value."'";
 		}
 		if($i> 0)
 		{
 			$editfile_all=$editfile_all.",`".$cms_row["fieldName"]."`='".$str_value."'";
 		} 
		if($cms_row["fieldout"]==8)// 保存缩略图
		  {
			$editfile_all =$editfile_all .",`s_".$cms_row["fieldName"]."`='s_".$str_value."'";
		  }
		if ($cms_row["fieldout"]==2) //密码框哈希值
		{
			$editfile_all =$editfile_all .",`hash`='".$str_Hash."'";//哈希值
		}
 	 $i++;			
 	}
 	
	//echo "update $tabName set $editfile_all where id=".$strid;
	//exit;
	
	if ($SystemID==1)
	{
		$db->query("update $tabName set $editfile_all where id=".$strid );
	}else{
		$db->query("update $tabName set $editfile_all where id=".$strid );
	}
	
}
// 获取Detph 的最大值; 在添加分类的时候调用
function Depth($ClssID)
{
	global $db,$tablepre;
	$MaxSql="select depth from ".$tablepre."class where ID=$ClssID";
	$Result= $db->query($MaxSql);
	while ($Row=$db->fetch_array($Result)){
		$depth= $Row["depth"]+1;
	}
	return $depth;
}
/*
* 功能：PHP图片水印 (水印支持图片或文字)
* 参数：
*       $groundImage     背景图片，即需要加水印的图片，暂只支持GIF,JPG,PNG格式；
*       $waterPos        水印位置，有10种状态，0为随机位置；
*                       1为顶端居左，2为顶端居中，3为顶端居右；
*                       4为中部居左，5为中部居中，6为中部居右；
*                       7为底端居左，8为底端居中，9为底端居右；
*       $waterImage      图片水印，即作为水印的图片，暂只支持GIF,JPG,PNG格式；
*       $waterText       文字水印，即把文字作为为水印，支持ASCII码，不支持中文；
*       $fontSize        文字大小，值为1、2、3、4或5，默认为5；
*       $textColor       文字颜色，值为十六进制颜色值，默认为#CCCCCC(白灰色)；
*       $fontfile        ttf字体文件，即用来设置文字水印的字体。使用windows的用户在系统盘的目录中
*                       搜索*.ttf可以得到系统中安装的字体文件，将所要的文件拷到网站合适的目录中,
*                       默认是当前目录下arial.ttf。
*       $xOffset         水平偏移量，即在默认水印坐标值基础上加上这个值，默认为0，如果你想留给水印留
*                       出水平方向上的边距，可以设置这个值,如：2 则表示在默认的基础上向右移2个单位,-2 表示向左移两单位
*       $yOffset         垂直偏移量，即在默认水印坐标值基础上加上这个值，默认为0，如果你想留给水印留
*                       出垂直方向上的边距，可以设置这个值,如：2 则表示在默认的基础上向下移2个单位,-2 表示向上移两单位
* 返回值：
*        0   水印成功
*        1   水印图片格式目前不支持
*        2   要水印的背景图片不存在
*        3   需要加水印的图片的长度或宽度比水印图片或文字区域还小，无法生成水印
*        4   字体文件不存在
*        5   水印文字颜色格式不正确
*        6   水印背景图片格式目前不支持
* 修改记录：
*         
* 注意：Support GD 2.0，Support FreeType、GIF Read、GIF Create、JPG 、PNG
*       $waterImage 和 $waterText 最好不要同时使用，选其中之一即可，优先使用 $waterImage。
*       当$waterImage有效时，参数$waterString、$stringFont、$stringColor均不生效。
*       加水印后的图片的文件名和 $groundImage 一样。
* 作者：高西林
* 日期：2007-4-28
* 说明：本程序根据longware的程序改写而成。
*/
function imageWaterMark($groundImage,$waterPos=0,$waterImage="",$waterText="盛博会务",$fontSize=72,$textColor="#eee", $fontfile,$xOffset=0,$yOffset=0)
{
   $isWaterImage = FALSE;
     //读取水印文件
     if(!empty($waterImage) && file_exists($waterImage)) {
         $isWaterImage = TRUE;
         $water_info = getimagesize($waterImage);
         $water_w     = $water_info[0];//取得水印图片的宽
         $water_h     = $water_info[1];//取得水印图片的高

         switch($water_info[2])   {    //取得水印图片的格式  
             case 1:$water_im = imagecreatefromgif($waterImage);break;
             case 2:$water_im = imagecreatefromjpeg($waterImage);break;
             case 3:$water_im = imagecreatefrompng($waterImage);break;
             default:return 1;
         }
     }

     //读取背景图片
     if(!empty($groundImage) && file_exists($groundImage)) {
         $ground_info = getimagesize($groundImage);
         $ground_w     = $ground_info[0];//取得背景图片的宽
         $ground_h     = $ground_info[1];//取得背景图片的高

         switch($ground_info[2]) {    //取得背景图片的格式  
             case 1:$ground_im = imagecreatefromgif($groundImage);break;
             case 2:$ground_im = imagecreatefromjpeg($groundImage);break;
             case 3:$ground_im = imagecreatefrompng($groundImage);break;
             default:return 1;
         }
     } else {
         return 2;
     }

     //水印位置
     if($isWaterImage) { //图片水印  
         $w = $water_w;
         $h = $water_h;
         $label = "图片的";
         } else {  
     //文字水印
        if(!file_exists($fontfile))return 4;
         $temp = imagettfbbox($fontSize,0,$fontfile,$waterText);//取得使用 TrueType 字体的文本的范围
         $w = $temp[2] - $temp[6];
         $h = $temp[3] - $temp[7];
         unset($temp);
     }
     if( ($ground_w < $w) || ($ground_h < $h) ) {
         return 3;
     }
     switch($waterPos) {
         case 0://随机
             $posX = rand(0,($ground_w - $w));
             $posY = rand(0,($ground_h - $h));
             break;
         case 1://1为顶端居左
             $posX = 0;
             $posY = 0;
             break;
         case 2://2为顶端居中
             $posX = ($ground_w - $w) / 2;
             $posY = 0;
             break;
         case 3://3为顶端居右
             $posX = $ground_w - $w;
             $posY = 0;
             break;
         case 4://4为中部居左
             $posX = 0;
             $posY = ($ground_h - $h) / 2;
             break;
         case 5://5为中部居中
             $posX = ($ground_w - $w) / 2;
             $posY = ($ground_h - $h) / 2;
             break;
         case 6://6为中部居右
             $posX = $ground_w - $w;
             $posY = ($ground_h - $h) / 2;
             break;
         case 7://7为底端居左
             $posX = 0;
             $posY = $ground_h - $h - '10';
             break;
         case 8://8为底端居中
             $posX = ($ground_w - $w) / 2;
             $posY = $ground_h - $h - '10';
             break;
         case 9://9为底端居右
             $posX = $ground_w - $w;
             $posY = $ground_h - $h - '10';
             break;
         default://随机
             $posX = rand(0,($ground_w - $w));
             $posY = rand(0,($ground_h - $h));
             break;     
     }

     //设定图像的混色模式
     imagealphablending($ground_im, true);

     if($isWaterImage) { //图片水印
         imagecopy($ground_im, $water_im, $posX + $xOffset, $posY + $yOffset, 0, 0, $water_w,$water_h);//拷贝水印到目标文件         
     } else {//文字水印
         if( !empty($textColor) && (strlen($textColor)==7) ) {
             $R = hexdec(substr($textColor,1,2));
             $G = hexdec(substr($textColor,3,2));
             $B = hexdec(substr($textColor,5));
         } else {
           return 5;
         }
         imagettftext ( $ground_im, $fontSize, 0, $posX + $xOffset, $posY + $h + $yOffset, imagecolorallocate($ground_im, $R, $G, $B), $fontfile, $waterText);
     }

     //生成水印后的图片
     @unlink($groundImage);
     switch($ground_info[2]) {//取得背景图片的格式
         case 1:imagegif($ground_im,$groundImage);break;
         case 2:imagejpeg($ground_im,$groundImage);break;
         case 3:imagepng($ground_im,$groundImage);break;
         default: return 6;
     }

     //释放内存
     if(isset($water_info)) unset($water_info);
     if(isset($water_im)) imagedestroy($water_im);
     unset($ground_info);
     imagedestroy($ground_im);
     //
     return 0;
}
?>