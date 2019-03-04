<?php

function start_session($expire = 0){
	//设置session有效时间
    if($expire == 0){
        $expire = ini_get('session.gc_maxlifetime'); 
    } else {
        ini_set('session.gc_maxlifetime', $expire); 
    }
    if (empty($_COOKIE['PHPSESSID'])) {
        session_set_cookie_params($expire); 
        session_start(); 
    } else {
        session_start(); 
        setcookie('PHPSESSID', session_id(), time() + $expire); 
    } 
} 

function replace_content($str){
//去掉内容中的多余HTML代码
	$search = array ("'<script[^>]*?>.*?</script>'si", // 去掉 javascript 
	"'<style[^>]*?>.*?</style>'si", // 去掉 css 
	"'<[/!]*?[^<>]*?>'si", // 去掉 HTML 标记 
	"'<!--[/!]*?[^<>]*?>'si", // 去掉 注释标记 
	"'([rn])[s]+'", // 去掉空白字符 
	"'&(quot|#34);'i", // 替换 HTML 实体 
	"'&(amp|#38);'i", 
	"'&(lt|#60);'i", 
	"'&(gt|#62);'i", 
	"'&(nbsp|#160);'i", 
	"'&(iexcl|#161);'i", 
	"'&(cent|#162);'i", 
	"'&(pound|#163);'i", 
	"'&(copy|#169);'i", 
	"'&#(d+);'e"); // 作为 PHP 代码运行 
	$replace = array ("","","","","\1","\"","&","<",">"," ",chr(161),chr(162),chr(163),chr(169),"chr(\1)"); 
	//$document为需要处理字符串，如果来源为文件可以$document = file_get_contents('http://www.sina.com.cn'); 
	$out = preg_replace($search, $replace, $str); 
	return $out;
	//echo $out; 
}
function get_Search_class($id) {
	$str_Search_class = "";
if(is_numeric($id)){
	$str_Search_class .= ",".$id; 
	global $db,$tablepre;
	$sql = "SELECT ID,partid FROM `".$tablepre."class` WHERE `show`=1 and partid=".$id." order by sequence asc";
	$mysql_query = $db->query($sql);
	while ($rs = $db->fetch_array($mysql_query)) {
		$str_Search_class .=get_Search_class($rs['ID']);
	}
	return $str_Search_class;
}
}

function get_Search_area($id) {
	$str_Search_class = "";
if(is_numeric($id)){
	$str_Search_class .= ",".$id; 
	global $db,$tablepre;
	$sql = "SELECT ID,partid FROM `".$tablepre."areas` WHERE `show`=1 and partid=".$id." order by sequence asc";
	$mysql_query = $db->query($sql);
	while ($rs = $db->fetch_array($mysql_query)) {
		$str_Search_class .=get_Search_area($rs['ID']);
	}
	return $str_Search_class;
}
}

function cms_Get_SidClass($id) {
//取得所有频道下分类
if(is_numeric($id)){
	global $db,$tablepre;
	$sql = "SELECT * FROM `".$tablepre."class` WHERE `show`=1 and SystemID=".$id." order by sequence asc";
	$mysql_query = $db->query($sql);
	$num=0;
	while ($rs = $db->fetch_array($mysql_query)) {
		$sid_class[$num]	= $rs;
		$num++;
	}
	return $sid_class;
}
}

function cms_Get_ChildClass($id) {
if(is_numeric($id)){
    $str_Search_class = "";
	$str_Search_class .= ",".$id; 
	global $db,$tablepre;
	$sql = "SELECT ID,partid FROM `".$tablepre."class` WHERE `show`=1 and partid=".$id." order by sequence asc";
	$mysql_query = $db->query($sql);
	while ($rs = $db->fetch_array($mysql_query)) {
		$str_Search_class .=get_Search_class($rs['ID']);
	}
	return $str_Search_class;
}
}

function cms_Get_Childarea($id) {
if(is_numeric($id)){
    $str_Search_class = "";
	$str_Search_class .= ",".$id; 
	global $db,$tablepre;
	$sql = "SELECT ID,partid FROM `".$tablepre."areas` WHERE `show`=1 and partid=".$id." order by sequence asc";
	$mysql_query = $db->query($sql);
	while ($rs = $db->fetch_array($mysql_query)) {
		$str_Search_class .=get_Search_class($rs['ID']);
	}
	return $str_Search_class;
}
}

function cms_Get_class($fid){
//取得分类下的所有子分类的ID CLASSNAME
if(is_numeric($fid)){
	global $db,$tablepre;
	$sql = "select ID,ClassName from `".$tablepre."class` where `show`=1 and partid=".$fid." order by sequence asc";
	$mysql_query = $db->query($sql);
	$num=0;
	while($rs = $db->fetch_array($mysql_query)){
		$str_classname[$num] = $rs;
		$num++;
	}
	return $str_classname;
}	
}



function cms_Get_areas($fid){
//取得分类下的所有子分类的ID CLASSNAME
if(is_numeric($fid)){
	global $db,$tablepre;
	$sql = "select ID,ClassName from `".$tablepre."areas` where `show`=1 and partid=".$fid." order by sequence asc";
	$mysql_query = $db->query($sql);
	$num=0;
	while($rs = $db->fetch_array($mysql_query)){
		$str_classname[$num] = $rs;
		$num++;
	}
	return $str_classname;
}	
}

function cms_GetTabname($sid){
//通过systemid取得频道名、表名
		global $db,$tablepre;
		$sql="select id,channel,tabname from `".$tablepre."channel` where `show`=1 and id=".$sid." order by sequence asc,ID desc";
		$mysql_query =$db->query($sql);
		if($yc_rs = $db->fetch_array($mysql_query)){
			return $yc_rs;
		}
}

function cms_GetConfig($id){
//通过systemid取得频道名、表名
		global $db,$tablepre;
		$sql="select * from `".$tablepre."config` where id=".$id." order by ID desc limit 1";
		$mysql_query =$db->query($sql);
		if($yc_rs = $db->fetch_array($mysql_query)){
			return $yc_rs;
		}
}
//取得所要求信息的全部字段  
//参数：
//sid:			系统ID
//fid:			分类ID
//num:			要取的条数
//pic:			是否必须有图片
//rmd:			是否必须推荐
//show:			是否必须显示
//recover:		是否必须非回收
//order:		排序方式
//id:			是否取详细信息
//son:			是否取子分类下信息
function cms_Get_message($sid,$fid=0,$num=0,$rmd=0,$pic=0,$son=0,$id=0,$order=0,$show=1,$recover=1){
	if(is_numeric($sid)){
		global $db,$tablepre;
		$tab = cms_GetTabname($sid);//取得表名数组
		$where = "";
		
		$where .= ($show==0 || $id==22)?' 1=1':' `show`=1';//是否有显示字段
		$where .= ($recover==0)?'':' and recover=0';//是否有回收站
		$where .= ($rmd==0)?'':' and rmd>0';//是否推荐
		$where .= ($pic==0)?'':" and pic<>''";//是否有图片
		$where .= ($fid!=0 && $son==0)?' and classid='.$fid.'':"";//是否有分类
		$where .= ($son==0)?'':" and classid in (0".cms_Get_ChildClass($fid).")";//是否取子分类信息
		$where .= ($id==0)?'':" and id=".$id."";//是否固定信息
		$where .= ($order=='0')?' order by datetime Asc':'  order by '.$order.' Asc,datetime Asc';//是否按要求排序
		$where .= ($num==0)?'':' limit 0,'.$num;//需要取多少条
		
		$sql = "select * from `".$tablepre."".$tab['tabname']."` where ".$where;
		$mysql_query = $db->query($sql);
		$yc_num=0;
		while($rs = $db->fetch_array($mysql_query)){
			$yc[$yc_num] = $rs;
			$yc_num++;
		}
		return $yc;
	}
}

//取得所要求信息的全部字段  -------华坤E房网
//参数：
//sid:			系统ID
//fid:			分类ID
//num:			要取的条数
//pic:			是否必须有图片
//rmd:			是否必须推荐
//show:			是否必须显示
//recover:		是否必须非回收
//order:		排序方式
//id:			是否取详细信息
//son:			是否取子分类下信息
function cms_area_message($cityid,$sid,$fid=0,$num=0,$rmd=0,$pic=0,$son=0,$id=0,$order=0,$show=1,$recover=1){
	if(is_numeric($sid)){
		global $db,$tablepre;
		$tab = cms_GetTabname($sid);//取得表名数组
		$where = "";
		
		$where .= ($show==0)?' 1=1':' `show`=1';//是否有显示字段
		$where .= ($recover==0)?'':' and recover=0';//是否有回收站
		$where .= ($rmd==0)?'':' and rmd>0';//是否推荐
		$where .= ($pic==0)?'':" and pic<>''";//是否有图片
		$where .= ($fid!=0 && $son==0)?' and classid='.$fid.'':"";//是否有分类
		$where .= ($son==0)?'':" and classid in (0".cms_Get_ChildClass($fid).")";//是否取子分类信息
		$where .= ($cityid==0)?'':" and areaid in (0".cms_Get_Childarea($cityid).")";//是否取子分类信息
		$where .= ($id==0)?'':" and id=".$id."";//是否固定信息
		$where .= ($order=='0')?' order by datetime desc':'  order by '.$order.' desc,datetime desc';//是否按要求排序
		$where .= ($num==0)?'':' limit 0,'.$num;//需要取多少条
		
		$sql = "select * from `".$tablepre."".$tab['tabname']."` where ".$where;
		$mysql_query = $db->query($sql);
		$yc_num=0;
		while($rs = $db->fetch_array($mysql_query)){
			$yc[$yc_num] = $rs;
			$yc_num++;
		}
		return $yc;
	}
}

//取得所要求信息的全部字段  
//参数：
//sid:			系统ID
//fid:			分类ID
//num:			要取的条数
//rmd:			是否必须推荐
//show:			是否必须显示
//recover:		是否必须非回收
//order:		排序方式
//id:			是否取详细信息
//son:			是否取子分类下信息
function cms_Get_TrustProduct($sid,$fid=0,$num=0,$rmd=0,$order=0,$show=1,$recover=1){
	if(is_numeric($sid)){
		global $db,$tablepre;
		$tab = cms_GetTabname($sid);//取得表名数组
		$where = "";
		
		$where .= ($show==0)?' 1=1':' `show`=1';//是否有显示字段
		$where .= ($recover==0)?'':' and recover=0';//是否有回收站
		$where .= ($rmd==0)?'':' and rmd='.$rmd.'';//是否推荐
		$where .= ($fid!=0)?' and classid='.$fid.'':"";//是否有分类
		$where .= ($order=='0')?' order by datetime desc':'  order by '.$order.' desc,datetime desc';//是否按要求排序
		$where .= ($num==0)?'':' limit 0,'.$num;//需要取多少条
		
		$sql = "select * from `".$tablepre."".$tab['tabname']."` where ".$where;
		$mysql_query = $db->query($sql);
		$yc_num=0;
		while($rs = $db->fetch_array($mysql_query)){
			$yc[$yc_num] = $rs;
			$yc_num++;
		}
		return $yc;
	}
} 
/*获取楼盘信息*/
function cms_Get_RBHouses($sid,$fid=0,$num=0,$rmd=0,$order=0,$show=1,$recover=1,$isbrand,$cityid){
	if(is_numeric($sid)){
		global $db,$tablepre;
		$tab = cms_GetTabname($sid);//取得表名数组
		$where = "";
		
		$where .= ($show==0)?' 1=1':' `show`=1';//是否有显示字段
		$where .= ($recover==0)?'':' and recover=0';//是否有回收站
		$where .= ($rmd==0)?'':' and rmd='.$rmd.'';//是否推荐
		$where .= ($isbrand==0)?'':' and isbrand='.$isbrand.'';//是否品牌
		$where .= ($fid!=0)?' and classid='.$fid.'':"";//是否有分类
		$where .= ($cityid==0)?'':" and areaid in (0".cms_Get_Childarea($cityid).")";//是否取子分类信息
		$where .= ($order=='0')?' order by datetime desc':'  order by '.$order.' desc,datetime desc';//是否按要求排序
		$where .= ($num==0)?'':' limit 0,'.$num;//需要取多少条
		
		$sql = "select * from `".$tablepre."".$tab['tabname']."` where ".$where;
		$mysql_query = $db->query($sql);
		$yc_num=0;
		while($rs = $db->fetch_array($mysql_query)){
			$yc[$yc_num] = $rs;
			$yc_num++;
		}
		return $yc;
	}
} 
/* 新闻列表 */
function get_listarr($cid, $page, $perpage, $ord_field, $keywords, $cid_SD,$Systemid=0,$id=0,$show=1,$recover=1,$city)
{
	//if (!is_numeric($cid)&&$keywords=="") exit;
	global $db,$tablepre;
	$mk=0;
	$where   = "";
	$start 	 = ($page-1)*$perpage;
	$theurl	 = "?pernums=".$perpage;
	$theurl .= ($cid==0)?"":"&cid=".$cid."";
	$theurl .= empty($keywords)?"":"&keywords=".urlencode($keywords)."";

	$where  .= ($show==0)?' 1=1':' `show`=1';//是否有显示字段
	$where  .= ($recover==0)?'':' and recover=0';//是否有回收站
	$where  .= ($cid_SD==0)?" and classid in(0".get_Search_class($cid).")":" and classid in(0".get_Search_class($cid_SD).") ";
	$where  .= ($city==0) ? '':" and areaid in (0".cms_Get_Childarea($city).")";//是否取子分类信息
	$where  .= ($id==0)?"":" and id!=".$id."";
	$where  .= ($keywords=='0')?"":" and (title like '%".$keywords."%')";
	$ord_field = ($ord_field==0)?"datetime":$ord_field;
	$channel  = cms_GetTabname($Systemid);//取得频道信息
	$table  = $tablepre.$channel['tabname'];//取得表名
//echo $where;
	//执行SQL取数据
	//$total = mysqli_num_rows($db->query("SELECT count(*) FROM `$table` WHERE ".$where));
	//echo $total;
	$mysql_total = $db->query("SELECT count(*) as total FROM `$table` WHERE ".$where);
    list($total) = mysqli_fetch_row($mysql_total);
    //echo $total;
    //var_dump($mysql_total);
	//exit;
	$sql	=	"SELECT * FROM `$table` WHERE ".$where." ORDER BY ".$ord_field." desc LIMIT ".$start.",".$perpage;
	$mysql_mem = $db->query($sql);

	//分页数据
	$selectstyle=""; $pagebar_current="pagebine"; $pagebar_pre="pre"; $pagebar_next="next"; $numshow=1; $selectshow=1; $showallpage=1;
	$pagehtml = showpages($total,$perpage,$page,$theurl,$selectstyle,$pagebar_current,$pagebar_pre,$pagebar_next,$numshow,$selectshow,$showallpage); // 翻页函数
	$pagesstr = pagesstr($total,$perpage,$page,$theurl,$maxpage=5);
	//echo $pagesstr;
	$nListArr = array("pagehtml"=>$pagesstr,);
	//循环输出
	while($rs=$db->fetch_array($mysql_mem))
	{
		//定义二维数组 
		$nListArr[$mk] = $rs;
		$mk++;
	}
	return $nListArr;
}

/* 列表--楼盘独用 */
function get_listarr_area($cityid,$cid, $opt, $page, $perpage, $ord_field, $keywords, $cid_SD,$Systemid=0,$id=0,$show=1,$recover=1)
{
	//if (!is_numeric($cid)&&$keywords=="") exit;
	global $db,$tablepre;
	$mk=0;
	$where   = "";
	$isrec		 = empty($opt['isrec']) ? 0 : $opt['isrec'];
	$isbrand		 = empty($opt['isbrand']) ? 0 : $opt['isbrand'];
	$area		 = empty($opt['area']) ? 0 : $opt['area'];
	$price		 = empty($opt['price']) ? 0 : $opt['price'];
	$huxing		 = empty($opt['huxing']) ? 0 : $opt['huxing'];
	$type		 = empty($opt['type']) ? 0 : $opt['type'];
	$zxiu		 = empty($opt['zxiu']) ? 0 : $opt['zxiu'];
	$start 	 = ($page-1)*$perpage;
	$theurl	 = "?pernums=".$perpage;
	$theurl .= ($cid==0)?"":"&cid=".$cid."";
	$theurl .= ($isrec==0) ? "&isrec=" : "&isrec=".$isrec."";
	$theurl .= ($isbrand==0) ? "&isbrand=" : "&isbrand=".$isbrand."";
	$theurl .= ($area==0) ? "&area=" : "&area=".$area."";
	$theurl .= ($price==0) ? "&price=" : "&price=".$price."";
	$theurl .= ($huxing==0) ? "&huxing=" : "&huxing=".$huxing."";
	$theurl .= ($type==0) ? "&type=" : "&type=".$type."";
	$theurl .= ($zxiu==0) ? "&zxiu=" : "&zxiu=".$zxiu."";
	$theurl .= empty($keywords)?"":"&keywords=".urlencode($keywords)."";

	$where  .= ($show==0)?' 1=1':' `show`=1';//是否有显示字段
	$where  .= ($recover==0)?'':' and recover=0';//是否有回收站
	$where  .= ($cid_SD==0)?" and classid in(0".get_Search_class($cid).")":" and classid in(0".get_Search_class($cid_SD).") ";
	$where  .= ($id==0)?"":" and id!=".$id."";
	$where .= ($isrec==0) ? "" : " and rmd>0";
	$where .= ($isbrand==0) ? "" : " and isbrand=".$isbrand;
	$where .= ($area==0) ? "" : " and areaid=".$area;
	//$where .= ($price==0) ? "" : " and price=".$price;
	switch ($price)
	{
		case 1:
			$where .= " and price>0 and price<6000";
			break;
		case 2:
			 $where .= " and price>=6000 and price<8000";
			break;
		case 3:
			 $where .= " and price>=8000 and price<10000";
			break;
		case 4:
			 $where .= " and price>=10000 and price<15000";
			break;
		case 5:
			 $where .= " and price>=15000 and price<20000";
			break;
		case 6:
			 $where .= " and price>=20000 and price<30000";
			break;
		case 7:
			 $where .= " and price>=30000";
			break;
		default:
			$where .= "";
			break;
	}
	$where .= ($huxing==0) ? "" : " and (CONCAT('‖',huxing,'‖') like '%‖".$huxing."‖%')";
	$where .= ($type==0) ? "" : " and (CONCAT('‖',type,'‖') like '%‖".$type."‖%')";
	$where .= ($zxiu==0) ? "" : " and (CONCAT('‖',zxzhuangkuang,'‖') like '%‖".$zxiu."‖%')";
	$where .= ($cityid==0) ? '':" and areaid in (0".cms_Get_Childarea($cityid).")";//是否取子分类信息
	$where  .= ($keywords=='0')?"":" and (title like '%".$keywords."%')";
	$ord_field = ($ord_field==0)?"datetime":$ord_field;
	$channel  = cms_GetTabname($Systemid);//取得频道信息
	$table  = $tablepre.$channel['tabname'];//取得表名
	//执行SQL取数据
	$total = $db->result($db->query("SELECT count(*) FROM `$table` WHERE ".$where),0);
	$sql	=	"SELECT * FROM `$table` WHERE ".$where." ORDER BY ".$ord_field." desc LIMIT ".$start.",".$perpage;
	$mysql_mem = $db->query($sql);
	//echo $sql;
	//分页数据
	$selectstyle=""; $pagebar_current="pagebine"; $pagebar_pre="pre"; $pagebar_next="next"; $numshow=1; $selectshow=1; $showallpage=1;
	$pagehtml = showpagesarea($total,$perpage,$page,$theurl,$selectstyle,$pagebar_current,$pagebar_pre,$pagebar_next,$numshow,$selectshow,$showallpage); // 翻页函数
	$pagesstr = pagesstrnew($total,$perpage,$page,$theurl,$maxpage=5);
	//echo $pagesstr;
	$nListArr = array("pagehtml"=>$pagesstr,);
	//循环输出
	while($rs=$db->fetch_array($mysql_mem))
	{
		//定义二维数组
		$nListArr[$mk] = $rs;
		$mk++;
	}
	return $nListArr;
}

/* 会员中心列表用 */
function get_listarr_center($cid, $opt, $page, $perpage, $ord_field, $keywords, $cid_SD,$Systemid=0,$id=0,$show=1,$recover=1)
{
	//if (!is_numeric($cid)&&$keywords=="") exit;
	global $db,$tablepre;
	$mk=0;
	$where   = "";
	$uname	= empty($opt['uname']) ? '' : $opt['uname'];
	$sdate	= empty($opt['sdate']) ? '' : $opt['sdate'];
	$dty	= empty($opt['dty']) ? '' : $opt['dty'];
	$dtm	= empty($opt['dtm']) ? '' : intval($opt['dtm']);
	
	$start 	 = ($page-1)*$perpage;
	$theurl	 = "?pernums=".$perpage;
	$theurl .= ($cid==0)?"":"&cid=".$cid."";
	$theurl .= empty($dty) ? "" : "&dty=".$dty;
	$theurl .= empty($dtm) ? "" : "&dtm=".$dtm;
	$theurl .= empty($keywords)?"":"&keywords=".urlencode($keywords)."";

	$where  .= ($show==0)?' 1=1':' `show`=1';//是否有显示字段
	$where  .= ($recover==0)?'':' and recover=0';//是否有回收站
	$where  .= ($cid_SD==0)?" and classid in(0".get_Search_class($cid).")":" and classid in(0".get_Search_class($cid_SD).") ";
	$where  .= ($id==0)?"":" and id!=".$id."";
	$where .= ($isrec==0) ? "" : " and rmd>0";
	$where .= ($isbrand==0) ? "" : " and isbrand=".$isbrand;
	$where .= (empty($uname)) ? "" : " and user_name='".$uname."'";
	$where .= (empty($sdate)) ? "" : " and DATE_FORMAT(DATETIME,'20%y-%m')='".$sdate."'";
	$where  .= ($keywords=='0')?"":" and (title like '%".$keywords."%')";
	$ord_field = (empty($ord_field))?"datetime desc":$ord_field." desc,lasttime asc,datetime desc";
	$channel  = cms_GetTabname($Systemid);//取得频道信息
	$table  = $tablepre.$channel['tabname'];//取得表名
	//执行SQL取数据
	$total = $db->result($db->query("SELECT count(*) FROM `$table` WHERE ".$where),0);
	$sql	=	"SELECT * FROM `$table` WHERE ".$where." ORDER BY ".$ord_field." LIMIT ".$start.",".$perpage;
	$mysql_mem = $db->query($sql);
	
	//echo $sql;
	//分页数据
	$selectstyle=""; $pagebar_current="pagebine"; $pagebar_pre="pre"; $pagebar_next="next"; $numshow=1; $selectshow=1; $showallpage=1;
	$pagehtml = showpagesarea($total,$perpage,$page,$theurl,$selectstyle,$pagebar_current,$pagebar_pre,$pagebar_next,$numshow,$selectshow,$showallpage); // 翻页函数
	$pagesstr = pagesstrnew($total,$perpage,$page,$theurl,$maxpage=5);
	//echo $pagesstr;
	$nListArr = array("pagehtml"=>$pagesstr,);
	//循环输出
	while($rs=$db->fetch_array($mysql_mem))
	{
		//定义二维数组
		$nListArr[$mk] = $rs;
		$mk++;
	}
	return $nListArr;
}

/* 会员活动 */
function get_listarrnew($cid, $page, $perpage, $ord_field, $keywords, $cid_SD,$Systemid=0,$id=0,$show=1,$recover=1,$where2)
{
	//if (!is_numeric($cid)&&$keywords=="") exit;
	global $db,$tablepre;
	$mk=0;
	$where   = "";
	$start 	 = ($page-1)*$perpage;
	$theurl	 = "?pernums=".$perpage;
	$theurl .= ($cid==0)?"":"&cid=".$cid."";
	$theurl .= empty($keywords)?"":"&keywords=".urlencode($keywords)."";
	$where  .= ($show==0)?' 1=1':' `show`=1';//是否有显示字段
	$where  .= ($recover==0)?'':' and recover=0';//是否有回收站
	$where  .= ($cid_SD==0)?" and classid in(0".get_Search_class($cid).")":" and classid in(0".get_Search_class($cid_SD).") ";
	$where  .= ($id==0)?"":" and id!=".$id."";
	$where  .= (empty($where2))?"":$where2;
	$where  .= ($keywords=='0')?"":" and (title like '%".$keywords."%')";
	$ord_field = ($ord_field==0)?"datetime":$ord_field;
	$channel  = cms_GetTabname($Systemid);//取得频道信息
	$table  = $tablepre.$channel['tabname'];//取得表名
	//执行SQL取数据
	$total = $db->result($db->query("SELECT count(*) FROM `$table` WHERE ".$where),0);
	$sql	=	"SELECT * FROM `$table` WHERE ".$where." ORDER BY ".$ord_field." desc LIMIT ".$start.",".$perpage;
	$mysql_mem = $db->query($sql);
	//echo $sql;
	//分页数据
	$selectstyle=""; $pagebar_current="pagebine"; $pagebar_pre="pre"; $pagebar_next="next"; $numshow=1; $selectshow=1; $showallpage=1;
	$pagehtml = showpages($total,$perpage,$page,$theurl,$selectstyle,$pagebar_current,$pagebar_pre,$pagebar_next,$numshow,$selectshow,$showallpage); // 翻页函数
	$pagesstr = pagesstr($total,$perpage,$page,$theurl,$maxpage=5);
	//echo $pagesstr;
	$nListArr = array("pagehtml"=>$pagesstr,);
	//循环输出
	while($rs=$db->fetch_array($mysql_mem))
	{
		//定义二维数组 
		$nListArr[$mk] = $rs;
		$mk++;
	}
	return $nListArr;
}
//==================================================================================================================================================
//数字分页函数
//==================================================================================================================================================
function pagesstrnew($total,$perpage,$page,$url,$maxpage=5) {
	//echo $total;echo $perpage;echo $page;echo $url;
	$p=$page;
	$str = "";
	$pages = ceil($total / $perpage);
	if($page-$maxpage<1)
		$min_page=1;
	else
		$min_page=$page-$maxpage;
	if($page+$maxpage>$pages)
		$max_page=$pages;
	else
		$max_page=$page+$maxpage;

	$str = "共".$pages."页";
	//$str.= "<a href=".$url."&page=1>首页</a>";
	if($page-1>0) {
		$ppage=$p-1;
		$str.= "<a href='".$url."&page=".$ppage."' class='prev'></a>";
		//$str.= "<a href=".$url."&page=".$ppage."> 上一页 </a> "<a href="#" class="prev"></a>;
	}else{
		$str.= "<a href='".$url."&page=1' class='prev'></a>";
	}

	for($p=$min_page;$p<=$max_page;$p++) {
		if($page==$p)
			$str.= "<a href=".$url."&page=".$p." class=\"on\">".$p."</a>&nbsp;";
		else
			$str.= "<a href=".$url."&page=".$p.">".$p."</a>&nbsp;";
	}
	if($page+1<=$pages) {
		$npage=$page+1;
		$str.= "<a href=".$url."&page=".$npage." class='next'></a>";
		//$str.= "<a href=".$url."&page=".$npage."> 下一页 </a> </li>";
	}else{
	//	$str.= ">>";
		$str.= "<a href=".$url."&page=".$pages." class='next'></a>";
	}
	//$str.= "<a href=".$url."&page=".$pages.">末页</a>";
	//$str.="页次：".$page."/".$pages."页　　共".$total."条记录";
	return $str;
}
//==================================================================================================================================================
//数字分页函数
//==================================================================================================================================================
function pagesstr($total,$perpage,$page,$url,$maxpage=5) {
	//echo $total;echo $perpage;echo $page;echo $url;
	$p=$page;
	$str = "";
	$pages = ceil($total / $perpage);
	if($page-$maxpage<1)
		$min_page=1;
	else
		$min_page=$page-$maxpage;
	if($page+$maxpage>$pages)
		$max_page=$pages;
	else
		$max_page=$page+$maxpage;
	
	$str.= "";
	if($page-1>0) {
		$ppage=$p-1;
		$str.= "<a href='".$url."&page=".$ppage."' class='prev'>上一页</a>&nbsp;";
		//$str.= "<a href=".$url."&page=".$ppage."> 上一页 </a> ";
	}else{
		$str.= "<a href='".$url."&page=".$page."' class='prev'>上一页</a>&nbsp;";
	}
	
	for($p=$min_page;$p<=$max_page;$p++) {
		if($page==$p)
			$str.= "<span>".$p."</span>&nbsp;";
		else
			$str.= "<a href='".$url."&page=".$p."' >".$p."</a>&nbsp;";
	}	
	//for($p=$min_page;$p<=$max_page;$p++) {
//		if($page==$p)
//			$str.= "<a href=".$url."&page=".$p." class=\"pagebar_current\">".$p."</a>&nbsp;";
//		else
//			$str.= "<a href=".$url."&page=".$p."> [".$p."] </a>&nbsp;";
//	}
	if($page+1<=$pages) {
		$npage=$page+1;
		//$str.= "<a href='".$url."&page=".$npage."' class='n1'></a>";
		$str.= "<a href=".$url."&page=".$npage." class='next'> 下一页 </a> </li>";
	}else{
		$str.= "<a href='".$url."&page=".$page."' class='next'>下一页</a>";
	}
	//$str.= "<a href=".$url."&page=".$pages.">最后一页</a>";
	//$str.="页次：".$page."/".$pages."页　　共".$total."条记录";
	return $str;
}

//国能博泰独用
function showpagesarea($total,$perpage,$page,$url,$selectstyle,$pagebar_current,$pagebar_pre,$pagebar_next,$numshow,$selectshow,$showallpage,$maxpage=1)
{
	$p=$page;
	if($selectshow==1){
		$str = "<form action=".$url." method='post' name='page'>";
	}
	$pages = ceil($total / $perpage);
	if($page-$maxpage<1)
	{
		$min_page=1;
	}else{
		$min_page=$page-$maxpage;
	}
	if($page+$maxpage>$pages)
	{
		$max_page=$pages;
	}else{
		$max_page=$page+$maxpage;
	}

	//$str.= "<a href=".$url."&page=1 class=".$pagebar_pre."></a>";
	if($page-1>0) {
		$ppage=$p-1;
		$str.= "<a href=".$url."&page=".$ppage." class=".$pagebar_pre."></a>";
	}else{
		$str.= "<a href=".$url."&page=1 class=".$pagebar_pre."></a>";
	}

	if($numshow==1)
	{	//是否显示数字页码
	  for($p=$min_page;$p<=$max_page;$p++)
	   {
		if($page==$p)
		  $str.= "<a href=".$url."&page=".$p." class=".$pagebar_current.">".$p."</a>";
		else
		  $str.= "<a href=".$url."&page=".$p." class=".$pagebar_old."> ".$p." </a>";
	   }
	}

	if($page+1<=$pages) {
		$npage=$page+1;
		$str.= "<a href=".$url."&page=".$npage." class=".$pagebar_next."></a>";
	}else{
		$str.= "<a href=".$url."&page=".$pages." class=".$pagebar_next."></a>";
	}
	//$str.= "<a href=".$url."&page=".$pages." class=".$pagebar_next."></a>";

	//if($showallpage==1)
	// {
		//$str.="&nbsp;&nbsp;共".$total."条 第".$page."/".$pages."页 ";
	// }

	 if($showallpage==1)
	 {
		//$str.=" 每页". $perpage ."条 ";
	 }
	$str .= "</form>";
	return $str;
}
//==================================================================================================================================================
//分页函数带下拉转
//$pagehtml=showpages($total,$perpage,$page,$url,$style,$pagebar_current,$pagebar_old,$numshow,$selectshow,$showallpage,$maxpage=5)
// 总记录数，每页记录数，当前页码，链接加传参，下拉框样式，当前页码样式，非当前页码样式，是否显示数字页码，是否显示下拉页码，是否显示总页数
//共 124 条, 第1/9 页 首页 上一页 下一页 尾 页 每页 条
//==================================================================================================================================================
function showpages($total,$perpage,$page,$url,$selectstyle,$pagebar_current,$pagebar_pre,$pagebar_next,$numshow,$selectshow,$showallpage,$maxpage=1) 
{
	$p=$page;
	if($selectshow==1){
		$str = "<form action=".$url." method='post' name='page'>";
	}
	$pages = ceil($total / $perpage);
	if($page-$maxpage<1)
	{
		$min_page=1;
	}else{
		$min_page=$page-$maxpage;
	}
	if($page+$maxpage>$pages)
	{
		$max_page=$pages;
	}else{
		$max_page=$page+$maxpage;
	}
	
	//$str.= "<a href=".$url."&page=1 class=".$pagebar_pre."></a>";
	if($page-1>0) {
		$ppage=$p-1;
		$str.= "<a href=".$url."&page=".$ppage." class=".$pagebar_pre."></a>";
	}else{
		$str.= "<a href=".$url."&page=1 class=".$pagebar_pre."></a>";
	}
	
	if($numshow==1)
	{	//是否显示数字页码	
	  for($p=$min_page;$p<=$max_page;$p++)
	   {
		if($page==$p)
		  $str.= "<a href=".$url."&page=".$p." class=".$pagebar_current.">".$p."</a>";
		else
		  $str.= "<a href=".$url."&page=".$p." class=".$pagebar_old."> ".$p." </a>";
	   }
	}
	
	if($page+1<=$pages) {
		$npage=$page+1;
		$str.= "<a href=".$url."&page=".$npage." class=".$pagebar_next."></a>";
	}else{
		$str.= "<a href=".$url."&page=".$pages." class=".$pagebar_next."></a>";
	}
	//$str.= "<a href=".$url."&page=".$pages." class=".$pagebar_next."></a>";
	
	//if($showallpage==1)
	// {
		//$str.="&nbsp;&nbsp;共".$total."条 第".$page."/".$pages."页 ";
	// }

	 if($showallpage==1)
	 {
		//$str.=" 每页". $perpage ."条 "; 
	 }
	$str .= "</form>";
	return $str;
}
function get_location($classid,$php_url,$a_class='') {
//取当前位置(分类ID，页面，样式)
if (is_numeric($classid)) {
	global $db,$tablepre;
	$sql = "SELECT * FROM `".$tablepre."class` WHERE id=".$classid;
	$mysql_query = $db->query($sql);
	if ($rs = $db->fetch_array($mysql_query)) {
		$lo_name = $rs['ClassName']; 
		$lo_depth= $rs['Depth'];
		$lo_partid = $rs['partid'];
		if ($lo_depth!=0) {
		$str_location = get_location($lo_partid) ." &gt; <a href=\"".$php_url.".php?cid=$classid\" class=\"".$a_class."\">$lo_name</a>";
		return $str_location;
		}
	}
}
}

function get_classname($classid) {
//取当分类的名称
if (is_numeric($classid)) {
	global $db,$tablepre;
	$sql = "SELECT ClassName FROM `".$tablepre."class` WHERE id=".$classid;
	$mysql_query = $db->query($sql);
	if ($rs = $db->fetch_array($mysql_query)) {
		$lo_name = $rs['ClassName']; 
		return $lo_name;
	}
}
}

function get_areaname($cityid) {
//取当分类的名称
if (is_numeric($cityid)) {
	global $db,$tablepre;
	$sql = "SELECT ClassName FROM `".$tablepre."areas` WHERE id=".$cityid;
	$mysql_query = $db->query($sql);
	if ($rs = $db->fetch_array($mysql_query)) {
		$lo_name = $rs['ClassName']; 
		return $lo_name;
	}
}
}

function get_kjcPrevs($id,$m,$php_url) {
//取得上一页，下一页
if (is_numeric($id)) {
	global $db,$tablepre;	
	if ($m == 1) {
		$sql = "SELECT id,title FROM `".$tablepre."chengguo` WHERE `show`=1 and recover=0 and id<".$id." order by sequence desc,datetime desc LIMIT 0,1";
	}else{
		$sql = "SELECT id,title FROM `".$tablepre."chengguo` WHERE `show`=1 and recover=0 and id>".$id." order by sequence asc,datetime asc LIMIT 0,1";
	}
	$mysql_query = $db->query($sql);
	if ($rs = $db->fetch_array($mysql_query)) {
		$temp_str	.='<a href="'.$php_url.'.php?id='.$rs['id'].'" title="'.$rs['title'].'">';
		$str_newslist .= "<a href=\"".$php_url.".php?id=".$rs['id']."\">".str_len_1($rs['title'],20)."</a>";
	}else{
		$temp_str	.='<a title="没有了">';
		$str_newslist .= "没有了";
	}
	return $temp_str;
}
}
	
//=======================================================================================================
//解决substr截取乱码函数
//=======================================================================================================
function str_len($str,$strlen) 
{ 
	if(empty($str)||!is_numeric($strlen)) {return false;} 
	//echo utf8_strlen(strip_tags($str));
	if(utf8_strlen(strip_tags($str))<=$strlen)
	{
		return strip_tags($str); 
	}else{
		return mb_substr(strip_tags($str),0,$strlen,'utf-8')."...";
	}
}	
function str_len_1($str,$strlen) 
{ 
	if(empty($str)||!is_numeric($strlen))
	{
		return false; 
	} 
	if(strlen(strip_tags($str))<=$strlen)
	{
		return strip_tags($str); 
	}else{
		return mb_substr(strip_tags($str),0,$strlen,'utf-8');
	}
}
function str_len_2($str,$startstrlen,$strlen)//取得时间的中间一部分
{ 
	if(empty($str)||!is_numeric($strlen))
	{
		return false; 
	} 
	if(strlen(strip_tags($str))<=$strlen)
	{
		return strip_tags($str); 
	}else{
		return mb_substr(strip_tags($str),$startstrlen,$strlen,'utf-8');
	}
}	

function utf8_strlen($string = null) {
	preg_match_all("/./us", $string, $match);
	return count($match[0]);
}

function cnsubstr($str,$strlen) 
{ 
	if(empty($str)||!is_numeric($strlen)){ 
	return false; 
	} 
	if(strlen($str)<=$strlen){ 
	return $str; 
	} 
}
function sub_str($text,$length) 
{
	for($i=0;$i<$length;$i++)
	{
		$chr =substr($text,$i,1);
		if (ord($chr)>0x80)//字符是中文
		{
			$length++;    //是中文的话长度就增加
			$i++;
		}
	} 
	$str=substr($text,0,$length);
	return $str;
}


?>