<?php

//判断当前进行的操作
switch ($_REQUEST['actn'])
{
case "del":
	$arr=$_REQUEST['ids'];
	if (count($arr)>0)
	{       
		$id = implode(',', $_POST['ids']); 
		$db->query("DELETE FROM $tabName WHERE id IN ($id)");
		ok("信息删除成功!!",$_SERVER["HTTP_REFERER"],2);
	}else{
		ok("没有选中项目!!",$_SERVER["HTTP_REFERER"],2);
		exit;
	} 
	break;
case "sdel":
	$sid=$_REQUEST["stids"];
	$db->query("DELETE FROM $tabName WHERE id =$sid");
	ok("信息删除成功!!",$_SERVER["HTTP_REFERER"],2);
	break;	
case "move":
	$arr=$_REQUEST['ids'];
	$strclassid =$_REQUEST['strclassid'];
	if (count($arr)>0)
	{       
		$id = implode(',', $_POST['ids']); 
		$db->query("update $tabName set classid=$strclassid WHERE id IN ($id)");
		ok("信息移动成功!!",$_SERVER["HTTP_REFERER"],2);
	}else{
		ok("没有选中项目!!",$_SERVER["HTTP_REFERER"],2);
		exit;
	} 
	break;
case "rec":
	$arr=$_REQUEST['ids'];
	if (count($arr)>0)
	{       
		$id = implode(',', $_POST['ids']); 
		$db->query("update $tabName set recover=1 WHERE id IN ($id)");
		ok("所选信息已移动到回收站!!",$_SERVER["HTTP_REFERER"],2);
	}else{
		ok("没有选中项目!!",$_SERVER["HTTP_REFERER"],2);
		exit;
	} 
	break;		
}

?>


<?php 
	//$_SESSION["adminlov"]<1;
	$listsql="Select * from ".$tablepre."field where islist=1 and SystemID=$SystemID order by sequence asc";
	$listresult= $db->query($listsql);
	$listcount = $db->num_rows($listresult);
	echo "<table id='tablehovered1' border='0' align='center' cellpadding='3' cellspacing='1' class='tableborder'>";
	echo "<tr>";
	echo "<th colspan='".($listcount+2)."'>信息列表 </th>";
	echo"</tr>";
	echo"<tr>";
	echo "<td class='tablerow3' style='width:55px;'>";
	echo "<span style='vertical-align:middle'><input type='checkbox' name='checkall' id='checkall' onclick='checkall();' />编号</span>";
	echo "</td>";
	$j=0;
	while ($listrow=$db->fetch_array($listresult))
	{
		echo "<td class='tablerow3'>".$listrow["fieldtxt"]."</td>";
		$field_arr[] =array($listrow["fieldName"],$listrow["fieldout"],$listrow["iscontent"]);//定义数组
		$j++;
	}
	echo "<td class='tablerow3' align='center'>操作</td>";
	echo "</tr>";
  
  
	//整理要输出的内容
	if (addslashes($_REQUEST["str_classid"])!="") {$classid_arr=listid($SystemID,$_REQUEST["str_classid"]);}
	if ($_REQUEST["Keyword"]!=""){$Keyword=urldecode($_REQUEST["Keyword"]);}
	if ($_REQUEST["uid"]!=""){$uid=urldecode($_REQUEST["uid"]);}
	if ($_REQUEST["u_id"]!=""){$u_id=urldecode($_REQUEST["u_id"]);}
	if ($_REQUEST["activeid"]!=""){$activeid=urldecode($_REQUEST["activeid"]);}
	if ($_REQUEST["typeid"]!=""){$typeid=urldecode($_REQUEST["typeid"]);}
    if ($_REQUEST["Kjid"]!=""){$Kjid=urldecode($_REQUEST["Kjid"]);}
    
	
	//if (empty($Kjid)) {
	
	$kjclass = $Kjid . get_classsql($Kjid);
	//echo "Kjid不为空：".$kjclass."<br>";
	//}
	//统计总数 Sql
	if($_SESSION["adminlov"]!=520&&$_SESSION["adminclassKj"]!="")//对旅游活动进行分类权限设置
	{
		$count_sql="select  count(*) as count  from `$tabName` where recover=0 and classid in(".$_SESSION["adminclassKj"].")";
	}else{
		$count_sql="select  count(*) as count  from `$tabName` where recover=0 ";
	}

	//echo $count_sql."<br>";

	if ($classid_arr!="") {$count_sql=$count_sql." and classid in ($classid_arr) ";} //classid end 
	
	//keyword start
	if($Keyword!=''){
	$count_sql=$count_sql." and title like '%$Keyword%'";
	}
	
	if ($activeid!=""){$count_sql=$count_sql." and activeid=$activeid ";}
	if ($u_id!=""){$count_sql=$count_sql." and uid=$u_id ";}
	if($typeid!=""){$count_sql=$count_sql." and systemid=$typeid ";}
  
  
	$query =$db->query($count_sql); //统计总数 //统计总数结束
	
	//echo $count_sql."<br>";
	
	$count =$db->fetch_array($query);
	$count=$count['count'];
  
	if ($uid!=""){$urls=$urls."&uid=$uid";}
	if ($activeid!=""){$urls=$urls."&activeid=$activeid";}
	if ($u_id!=""){$urls=$urls."&u_id=$u_id";}
	if($typeid!=""){$urls=$urls."&typeid=$typeid";}
	
	if($urls!=""){
		$pages = new PageClass($count,20,$_GET['page'],'?page={page}'.$urls);//
	}else{
		$pages = new PageClass($count,20,$_GET['page'],'?page={page}');//
	}
	//统计总数 Sql
	if($_SESSION["adminlov"]<1&&$SystemID==22)//对快拍活动进行分类权限设置
	{
		$classids=0;
		$class_arrs=explode(",",$_SESSION["adminclass"]);
		for ($mk=0;$mk<count($class_arrs);$mk++) {
			$classids=$classids.",".childrenid($SystemID,$class_arrs[$mk]);
		}
		$Cms_sql="select * from `$tabName` where recover=0 and classid in(".$classids.")";//对快拍活动进行分类权限设置
	}else{
		$Cms_sql  = "select * from `$tabName` where recover=0 ";
	}
  
	if ($classid_arr!=""){$Cms_sql=$Cms_sql." and classid in ($classid_arr) ";} //classid end 
	//keyword start
	if ($Keyword!="") {
		//if ($SystemID==7) {
//			$Cms_sql=$Cms_sql."and (title like '%$Keyword%' or username like '%$Keyword%') ";
//		}else{
			$Cms_sql=$Cms_sql." and title like  '%$Keyword%' ";
		//}
	}
	
	//keyword end
	if ($u_id!=""){$Cms_sql=$Cms_sql." and uid=$u_id "; }
	if($uid!="") {
		if($SystemID==19){
			$Cms_sql=$Cms_sql." and (userid=$uid or houserid=$uid) ";
		}else{
			$Cms_sql=$Cms_sql." and userid=$uid ";
		}
	}
  
	if($activeid!=""){$Cms_sql=$Cms_sql." and activeid=$activeid ";}
	if($typeid!=""){$Cms_sql=$Cms_sql." and systemid='".$_REQUEST['typeid']."'";}


	//生成当前用户的权限SQL	
	if ($_SESSION["adminlov"]!=520&&$_SESSION["adminclassKj"]!=3&&$_SESSION["adminclassKj"]!=""&&$Systemid!=33) {
		if (strpos($_SESSION["adminclassKj"],",")) {
			$Cms_sql=$Cms_sql." and classid in (".$_SESSION["adminclassKj"].") ";
		}else{
			$Cms_sql=$Cms_sql." and classid=".$_SESSION["adminclassKj"]." ";
		}
	}
	
	$Cms_sql=$Cms_sql. "order by ";
	$Cms_sql  = $Cms_sql. "sequence Desc,datetime desc limit ".$pages -> page_limit.",".$pages -> myde_size;
	
	//echo $Cms_sql;
  
  $Cms_result=$db->query($Cms_sql);
  echo "<form id='myform' name='myform' method='post' action='' onsubmit='return checkform()'>"; 
  $k=0;
  while ($Cms_Row=$db->fetch_array($Cms_result))
  {
	  if($k % 2==0){$str_classname='tablerow2';}
	  else{$str_classname='tablerow1';}
     echo "<tr>";
       echo "<td class='$str_classname'><input name='ids[]' id='ids".$Cms_Row["id"]."' type='checkbox'  value=".$Cms_Row["id"]." />".$Cms_Row["id"]."</td>";     
       for ($x=0;$x<count($field_arr);$x++)
       {  
       	 echo "<td class='$str_classname'>";
       	// if($field_arr[$x][0]=="sequence"){echo "ffffff";}
		  switch ($field_arr[$x][1]) //fieldout的值
       	  {
       	  	case 0://单行文本
			     if($field_arr[$x][0]=="sequence")
			     {
			      echo "<span id=\"sequence_".$Cms_Row["id"]."\" class='dbclick' style=\"width:100%; font-size:12px;display:block;\" >".$Cms_Row[$field_arr[$x][0]]."</span>";
			     }elseif($field_arr[$x][0]=="title")
				 {
					 echo ("<a href='admin_eidt.php?stids=".$Cms_Row["id"]."' title='".strip_tags($Cms_Row[$field_arr[$x][0]])."'>".mb_substr(strip_tags($Cms_Row[$field_arr[$x][0]]),0,20,'utf-8')."</a>");
				 }
				elseif($field_arr[$x][0]=="datetime" || $field_arr[$x][0]=="dates" )
				{	echo(substr(stripslashes($Cms_Row[$field_arr[$x][0]]),0,11));
		  		}
				 else{
				 	echo stripslashes($Cms_Row[$field_arr[$x][0]]);
				 }
       	  		break;
       	  	case 1://多行文本
       	  		echo substr(stripslashes(trim($Cms_Row[$field_arr[$x][0]])),100);
       	  		break;
       	  	case 2: //密码框
       	  		echo "<font color='#ff0000'>密码请不要显示</font>";
       	  		break;
       	  	case 3: //单选框
			if ($field_arr[$x][2]==1)
			{
				echo "<span id='".$field_arr[$x][0]."_".$Cms_Row["id"]."'>";
				switch ($Cms_Row[$field_arr[$x][0]])
				{
					case 0:
					 //echo "<a href=?act=upd&field=".$field_arr[$x][0]."&strnum=1&cmsid=".$Cms_Row["id"]."><b style='color:#ff0000' id='stem_".$Cms_Row["id"]."'>×</b></a>";
						echo "<b style='color:#ff0000;cursor:pointer' onclick=\"stemp('".$field_arr[$x][0]."',".$Cms_Row["id"].",".$Cms_Row[$field_arr[$x][0]].")\">×</b>";
						break;
					case 1:
						//echo "<a href=?act=upd&field=".$field_arr[$x][0]."&strnum=0&cmsid=".$Cms_Row["id"]."><b style='color:#386BC8'>√</b></a>";
						echo "<b style='color:#386BC8;cursor:pointer' onclick=\"stemp('".$field_arr[$x][0]."',".$Cms_Row["id"].",".$Cms_Row[$field_arr[$x][0]].")\">√</b>";
						break;	
				}
				echo "<span>";
       	  		}
       	  		else {echo "<font color='#ff0000'>单选框请启用普通模式</font>";}
       	  		break;	
       	  	case 4:
       	  		echo str_replace("‖","、",$Cms_Row[$field_arr[$x][0]]);
       	  		//echo "多选框暂时无法显示";
       	  		break;
       	  	case 5:
       	  		if ($field_arr[$x][2]==2)
       	  		{
       	  		   $isclass =0;
				   echo ShowClassName($Cms_Row[$field_arr[$x][0]]);
       	  		}
       	  		else {echo "<font color='#ff0000'>下拉选项请尽量启用Sql语句，否则不要再列表中显示</font>";}
       	  	    break;
       	  	 case 6:
       	  	 	echo "编辑框";
       	  	    break;   	
       	  	 case 7:
       	  	 	echo "简单编辑框";
       	  	 	break; 
       	  	 case 8:
       	  	 	$imgsrc=substr($Cms_Row[$field_arr[$x][0]],0,7);
                echo "<a href='#' title='<img src=../../uploadfle/".$imgsrc."/".$Cms_Row["s_".$field_arr[$x][0]]." /> ' >".$Cms_Row[$field_arr[$x][0]]."</a>";
               //echo "<a href=# _fcksavedurl=# onMouseOver=toolTip('标题', '#000000', '#ffffff') onMouseOut=toolTip()>";
              // echo $Cms_Row[$field_arr[$x][0]];
              // echo "</a>";
       	  	 	break;
       	  	 case 9:
       	  	 	$drop_arr=explode("‖",$Cms_Row[$field_arr[$x][0]]);
				for ($m=0;$m<count($drop_arr);$m++)
				{
				  echo $drop_arr[$m]."<br>";
				}
       	  	 	break;
			 case 10:
       	  	 	echo $Cms_Row[$field_arr[$x][0]]." ";
       	  	 	break;	
			 case 11:
			 if($field_arr[$x][0]=="title")
			{
				echo ("<a href='admin_eidt.php?stids=".$Cms_Row["id"]."' title='".strip_tags($Cms_Row[$field_arr[$x][0]])."'>".mb_substr(strip_tags($Cms_Row[$field_arr[$x][0]]),0,22,'utf-8')."</a>");
			}elseif($field_arr[$x][0]=="datetime"){//时间
					 echo(substr(stripslashes($Cms_Row[$field_arr[$x][0]]),0,11));
			}else{
				echo $Cms_Row[$field_arr[$x][0]];
			}
       	  	 	break;
			case 12: //单图
       	  	 	echo $Cms_Row[$field_arr[$x][0]]." ";
       	  	 	break;	
       	  }
       	 echo "</td>";
       }
	   
	   
        echo "<td class='$str_classname' align='center'>";
	 if($SystemID=="7"){
		   echo("<a href='../booking/admin_index.php?uid=".$Cms_Row['id']."'>预约情况</a> | ");
		   echo("<a href='../product/admin_index.php?u_id=".$Cms_Row['id']."'>作品</a> | ");
		   echo "<a href='admin_eidt.php?stids=".$Cms_Row["id"]."'>编辑</a> | <a ".confirm()." href='admin_index.php?actn=sdel&stids=".$Cms_Row["id"]."'><span style='cursor:pointer;'>删除</span></a>";
		  
	  }elseif($SystemID=="20"){
		   echo("<a href='../orderlist/admin_index.php?orderno=".$Cms_Row['title']."'>查看详情</a>");
		   echo(" <a href='../member/admin_eidt.php?stids=".$Cms_Row["userid"]."'>会员资料</a>");		   
	  }elseif($SystemID=="22"){
		   echo("<a href='../batch/admin_index.php?activeid=".$Cms_Row['id']."'>批次</a> | ");
		   echo "<a href='admin_eidt.php?stids=".$Cms_Row["id"]."'>编辑</a> | <a href='../comments/admin_index.php?typeid=".$SystemID."&activeid=".$Cms_Row['id']."'>评论</a> | <a ".confirm()." href='admin_index.php?actn=sdel&stids=".$Cms_Row["id"]."'><span style='cursor:pointer;'>删除</span></a>";
	  }elseif($SystemID=="24"){
		   echo("<a href='../booking/admin_index.php?activeid=".$Cms_Row['id']."&str_classid=153'>预约详情</a> | ");
		   echo "<a href='admin_eidt.php?strid=".$Cms_Row["id"]."&activeid=".$_REQUEST['activeid']."'>查看编辑</a> | <a ".confirm()." href='admin_index.php?actn=sdel&stids=".$Cms_Row["id"]."'><span style='cursor:pointer;'>删除</span></a>";
	  }elseif($SystemID=="26"){
		  echo "<a href='admin_eidt.php?stids=".$Cms_Row["id"]."'>查看编辑</a> | <a href='../comments/admin_index.php?typeid=".$SystemID."&activeid=".$Cms_Row['id']."'>评论</a> | <a ".confirm()." href='admin_index.php?actn=sdel&stids=".$Cms_Row["id"]."'><span style='cursor:pointer;'>删除</span></a>";
	  }elseif($SystemID=="11"){
		echo "<a href='admin_eidt.php?stids=".$Cms_Row["id"]."'>查看编辑</a>";
	  }else{
		echo "<a href='admin_eidt.php?stids=".$Cms_Row["id"]."'>查看编辑</a> | <a ".confirm()." href='admin_index.php?actn=sdel&stids=".$Cms_Row["id"]."'><span style='cursor:pointer;'>删除</span></a>";
	  }
     echo "</td></tr>";
     $k++;	
  }
  
  echo "<tr><td colspan=".(count($field_arr)+2)." class='tablerow1'>";
  echo "<table id='tablehovered1' border='0' align='center' cellpadding='2' cellspacing='2' width=100%>";

	  echo "<tr><td width=20%>";
	  echo "<font color='#333'>选择：</font> <span style='cursor:pointer;' onclick='return viode(0)'>全部</span> - ";
	  echo "<span style='cursor:pointer;' onclick='return viode(1)'>反选</span> - ";
	  echo "<span style='cursor:pointer;' onclick='return viode(2)'>取消</span>";
	  echo "</td>";
	  echo "<td style='border-left:1px #ffffff solid;'>";
	  
	  if (intval($SystemID)!=11 || $_SESSION["adminlov"]==520){
	  echo "<span><input type='radio' name='actn' id='actn' value='del' /><font color='#333'>删除</font></span>";
	  echo "&nbsp;<span><input type='radio' name='actn' id='actn' value='rec' /><font color='#333'>回收</font></span>";
	  
	  if(isshow($SystemID,"classid")==true)
	  {
		  echo "&nbsp;<span><input type='radio' name='actn' id='actn' value='move' /><font color='#333'>移动</font></span>";
		  echo "&nbsp;<select name='strclassid' id='strclassid'>" ;
		  //echo "<option value='0'>作为一级类</option>";
		  
		if($_SESSION["adminlov"]!=520 && $_SESSION["adminclassKj"]!="")//对快拍活动进行分类权限设置
		{
			$ClaSql="Select * from ".$tablepre."class where SystemID=$SystemID and ID in(".$_SESSION["adminclassKj"].") order by sequence asc";
		}else{
			$ClaSql="Select * from ".$tablepre."class where SystemID=$SystemID order by sequence asc";
		}
	
	//$ClaSql="Select * from ".$tablepre."class where SystemID=$SystemID order by sequence Asc";
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
		   SelectClass(0,true);
		   echo "</select>";
	  }
	  echo "&nbsp;<span><input type='submit' name='button' id='button' value='提交' /></span>";
	  //echo("&nbsp;<a href=".$_SERVER['HTTP_REFERER'].">返 回</a>");  
	  
	  }//作用在331
	  
	  echo "</td>";
	  echo "</tr>";
    echo "</form>";
    echo "<tr><td colspan=2 style='border-top:1px #ffffff solid;'>";
    echo "<table  border='0' align='center' cellpadding='0' cellspacing='0' width=100% style='margin-top:6px;'><tr>";
    echo "<td style='color:333'>"; //搜索开始
    echo "<form id='myseach' name='myseach' method='post' action='' >";
    echo "<b><font color='#333'>搜索信息</font></b>："; 
    if(isshow($SystemID,"classid")==true && ishavaclass($SystemID)==true)
    {
    	$Class_arr="";
	    echo "&nbsp;<select name='str_classid' id='str_classid' style='vertical-align:middle'>" ;
	    echo "<option value=''>所有分类</option>";
	    
		if($_SESSION["adminlov"]!=520 && $_SESSION["adminclassKj"]!="")//对快拍活动进行分类权限设置
		{
			$ClaSql="Select * from ".$tablepre."class where SystemID=$SystemID and ID in(".$_SESSION["adminclassKj"].") order by sequence asc";
		}else{
			$ClaSql="Select * from ".$tablepre."class where SystemID=$SystemID order by sequence asc";
		}
		
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
	     SelectClass(0,true);
	     echo "</select>";
    }
	
    echo "&nbsp;&nbsp;<font color='#333'><b>关键字</b>：</font><input type='text' name='Keyword' id='Keyword' style='vertical-align:middle' />"; 
    echo  "&nbsp;&nbsp;<input type='submit' name='button' id='button' value='' style='vertical-align:middle;background:url(../system_style/images/yc_search.gif) no-repeat; width:28px; height:20px;' />";
    echo "</form>";
    echo "</td>"; //搜索结束
    echo "<td>".$pages -> myde_write()."</td>";
    echo "</tr></table>";
   echo "</td></tr>";
  echo "</table>";
  echo "</td></tr>"; //全选项目
  ?>
</table>
</body>
</html>
<script language="javascript">
  function checkform()
  {
	 var actncheck=document.getElementsByName("actn");
	 for   (var i=0;i<actncheck.length;i++)
	 {
          if(actncheck[i].checked==true)
		  {
			  var flag=true;
			  break;
		  }  
     }
	if(!flag)
	   {
		 alert("请选择操作方式");
		 return false;   
	   }
  }
  function checkall()
  {
	  if(document.getElementById("checkall").checked==true) 
	  {
		  viode(0);
		  return false;
	  }
	  else
	  {
		 viode(1);
		 return false;
	  }
  }
  function viode(sign) //单选 全选
  {   
      //var strbox=document.getElementsByName("ids");
      var strbox=document.getElementsByTagName("input");
  	
	  for (var i=0; i<strbox.length;i++   )
	  {   
		 if(strbox[i].type =="checkbox")
		 {   
		  var e=strbox[i];   
		  if (sign==0)
		  {
		  	e.checked= true; 
		  	document.getElementById("checkall").checked=true;   
		  } 
		  if (sign==1) 
		  {
		  	e.checked= !e.checked; 
		  	//document.getElementById("checkall").checked =!document.getElementById("checkall").checked;
		  }  
		  if (sign==2) 
		  {
		  	e.checked= false;
		    document.getElementById("checkall").checked=false; 
		  } 
		 }   
	  }  
	    
  }

	var editHTML;
	var editText;
	var tabname ='<?=$tabName?>';
	function setEditHTML(value){
	editHTML = '<input type="text" value="'+value+'" style="font-size:12px; width:50px;" /> ';
	editHTML += '<input type="button" onclick="ok(this)" value="修改" /> ';
	editHTML += '<input type="button" onclick="cancel(this)" value="取消" />';
	}
	
	
	$(document).ready(function(){
	$(".dbclick").dblclick(function(){
		editText=$(this).html();//获取双击对象的内容
		setEditHTML(editText); //
		$(this).data("oldtxt",editText)
		.html(editHTML)
		.unbind('dblclick');
		})
	})
							
	//取消
	function cancel(cbtn){
	var $obj = $(cbtn).parent(); //'取消'按钮的上一级，即span
		$obj.html($obj.data("oldtxt")); //将单元格内容设为原始数据，取消修改
		
		$obj.bind("dblclick",function(){ //重新绑定单元格双击事件
		editText = $(this).html();
		setEditHTML(editText);
		$(this).data("oldtxt",editText)
		.html(editHTML).unbind("dblclick");
		});
	}
	
	//修改
	function ok(smbt){
		var $obj =$(smbt).parent(); //获取上一级ID;
		var id  =$obj.attr("id").replace("sequence_","");
		var value =$obj.find("input:text")[0].value;
		if(value!=="")
		{
			if(isNaN(value)){alert("请输入数字");return false;}
			else{
				$.get("../sys/admin_sequence.php?t="+new Date(),{val:value,tabname:tabname,id:id},function(response){
		if(true){
			//alert("修改成功");
			$obj.data("oldtxt",value); //设置此单元格缓存为新数据
			cancel(smbt); //调用'取消'方法，
			//在此应传'取消'按钮过去，
			//但在'取消'事件中没有用'取消'按钮这个对象,
			//用的只是它的上一级，即td，
			//固在此直接用'修改'按钮替代
		} 
		//失败
		else{
			alert("error");
			cancel(obtn);
		}

				})
			}
		}else{alert("数据不能为空!");return false;}
		}
		
		//审核机制
		
		function stemp(stemp,id,value)
		{
			$.get("../system_core/admin_stemp.php?t="+new Date()+")",{action:'stemp',field:stemp,id:id,tabname:tabname,val:value},function(responseHTML){
			$("#"+stemp+"_"+id).html(responseHTML);
			// alert(responseHTML)
			})	
		}	
</script> 