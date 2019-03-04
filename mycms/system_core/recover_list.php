<?php 
  $listsql="Select * from ".$tablepre."field where islist=1 and SystemID=$SystemID order by sequence asc";
  $listresult=$db->query($listsql);
  $listcount =$db->num_rows($listresult);
  echo "<table id='tablehovered1' border='0' align='center' cellpadding='3' cellspacing='1' class='tableborder'>";
  echo "<tr>";
  echo "<th colspan='".($listcount+2)."'>回 收 站</th>";
  echo"</tr>";
  echo"<tr>";
  echo "<td class='tablerow3' style='width:20px;'>";
  echo "<span style='vertical-align:middle'><input type='checkbox' name='checkall' id='checkall' onclick='checkall();' /></span>";
 // echo "<span style='cursor:pointer;vertical-align:middle;' onclick='return viode(0)'>全选</span>";
  //echo "<span style='cursor:pointer;' onclick='return viode(1)'>反选</span> - ";
  //echo "<span style='cursor:pointer;' onclick='return viode(2)'>取消</span>";
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
   if (addslashes($_REQUEST["str_classid"])!="") {$classid_arr=listid($SystemID,$_REQUEST["str_classid"]);}
   if ($_REQUEST["Keyword"]!=""){$Keyword=urldecode($_REQUEST["Keyword"]);}
     //统计总是 Sql
  $count_sql="select  count(*)  as count  from `$tabName` where recover=1 ";
  if ($classid_arr!="") {$count_sql=$count_sql." and classid in ($classid_arr) ";} //classid end 
  //keyword start
  if ($Keyword!=""){$count_sql=$count_sql." and title like  '%$Keyword%' ";}
  //keyword end
  $query =$db->query($count_sql); //统计总数
  //统计总算结束
 // echo $count_sql;
  $count =$db->fetch_array($query);
  $count=$count['count'];
  $pages = new PageClass($count,20,$_GET['page'],'?page={page}&str_classid='.$str_classid.'&Keyword='.urlencode($Keyword));//
  $Cms_sql  = "select * from `$tabName` where recover=1 ";
   if ($classid_arr!=""){$Cms_sql=$Cms_sql." and classid in ($classid_arr) ";} //classid end 
  //keyword start
  if ($Keyword!=""){$Cms_sql=$Cms_sql." and title like '%$Keyword%' "; }
  //keyword end
  $Cms_sql=$Cms_sql. "order by ";
  $Cms_sql  = $Cms_sql. "id Desc limit ".$pages -> page_limit.",".$pages -> myde_size;
  $Cms_result=$db->query($Cms_sql);
  echo "<form id='myform' name='myform' method='post' action='' onsubmit='return checkform()'>"; 
  $k=0;
  while ($Cms_Row=$db->fetch_array($Cms_result))
  {
	  if($k % 2==0){$str_classname='tablerow2';}
	  else{$str_classname='tablerow1';}
     echo "<tr>";
       echo "<td class='$str_classname'><input name='ids[]' id='ids' type='checkbox'  value=".$Cms_Row["id"]." /></td>";     
       for ($x=0;$x<count($field_arr);$x++)
       {  
       	 echo "<td class='$str_classname'>";
       	  switch ($field_arr[$x][1]) //fieldout的值
       	  {
       	  	case 0://单行文本
       	  		echo stripslashes($Cms_Row[$field_arr[$x][0]]);
       	  		break;
       	  	case 1://多行文本
       	  		echo subtostr(stripslashes($Cms_Row[$field_arr[$x][0]]),100);
       	  		break;
       	  	case 2: //密码框
       	  		echo "<font color='#ff0000'>密码请不要显示</font>";
       	  		break;
       	  	case 3: //单选框
       	  		if ($field_arr[$x][2]==1)
       	  		{
       	  			switch ($Cms_Row[$field_arr[$x][0]])
       	  			{
       	  				case 0:
       	  					echo "<a href=?act=upd&field=".$field_arr[$x][0]."&strnum=1&cmsid=".$Cms_Row["id"]."><b style='color:#ff0000'>×</b></a>";
       	  					break;
       	  				case 1:
       	  					echo "<a href=?act=upd&field=".$field_arr[$x][0]."&strnum=0&cmsid=".$Cms_Row["id"]."><b style='color:#386BC8'>√</b></a>";
       	  					break;	
       	  			}
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
       	  	 	echo "编辑框内容请不要再列表项中显示";
       	  	    break;   	
       	  	 case 7:
       	  	 	echo "编辑框内容请不要再列表项中显示";
       	  	 	break; 
       	  	 case 8:
       	  	 	$imgsrc=substr($Cms_Row[$field_arr[$x][0]],0,7);
                echo "<a href='#' title='<img src=../../uploadfile/".$imgsrc."/".$Cms_Row["s_".$field_arr[$x][0]]." /> ' >".$Cms_Row[$field_arr[$x][0]]."</a>";
               //echo "<a href=# _fcksavedurl=# onMouseOver=toolTip('标题', '#000000', '#ffffff') onMouseOut=toolTip()>";
              // echo $Cms_Row[$field_arr[$x][0]];
              // echo "</a>";
       	  	 	break;
       	  	 case 9:
       	  	 	echo "<a title='<img src=http://www.baidu.com/img/lm.gif width=137 height=46 />>百度</a>";
       	  	 	break;		  		
       	  }
       	 echo "</td>";
       }
        echo "<td class='$str_classname' align='center'><a href='admin_eidt.php?stids=".$Cms_Row["id"]."'>编辑</a> | <a ".confirm()." href='admin_index.php?actn=sdel&stids=".$Cms_Row["id"]."'><span style='cursor:pointer;'>删除</span></a></td>";
     echo "</tr>";
     $k++;	
  }
  
  echo "<tr><td colspan=".(count($field_arr)+2)." class='tablerow1'>";
  echo "<table id='tablehovered1' border='0' align='center' cellpadding='2' cellspacing='2' width=100%>";
  echo "<tr><td width=20%>";
  echo "<font color='#333'>选择： </font><span style='cursor:pointer;' onclick='return viode(0)'>全部</span> - ";
  echo "<span style='cursor:pointer;' onclick='return viode(1)'>反选</span> - ";
  echo "<span style='cursor:pointer;' onclick='return viode(2)'>取消</span>";
  echo "</td>";
  echo "<td style='border-left:1px #ffffff solid;'>";
  echo "<span><input type='radio' name='actn' id='actn' value='del' /><font color='#333'>删除</font></span>";
  echo "&nbsp;<span><input type='radio' name='actn' id='actn' value='rec' /><font color='#333'>还原</font></span>";
  if(isshow($SystemID,"classid")==true)
  {
  	  echo "&nbsp;<span><input type='radio' name='actn' id='actn' value='move' /><font color='#333'>移动</font></span>";
	  echo "&nbsp;<select name='strclassid' id='strclassid'>" ;
	  //echo "<option value='0'>作为一级类</option>";
	   $ClaSql="Select * from ".$tablepre."class where SystemID=$SystemID order by sequence Asc";
	   $Result=$db->query($ClaSql);
	   while ($Row=$db->fetch_array($Result)) 
	   {
		$Class_arr[]=array($Row["ID"],$Row["ClassName"],$Row["ClassNameEng"],$Row["Depth"],$Row["partid"],$Row["Sequence"]);
	   }
	   
	   //调用无限级分类函数
	   SelectClass(0,true);
	   echo "</select>";
  }

  echo "&nbsp;<span><input type='submit' name='button' id='button' value='提交' /></span>";
  echo "</td>";
  echo "</tr>";
  echo "</form>";
  echo "<tr><td colspan=2 style='border-top:1px #ffffff solid;'>";
    echo "<table  border='0' align='center' cellpadding='0' cellspacing='0' width=100% style='margin-top:6px'><tr>";
    echo "<td>"; //搜索开始
    echo "<form id='myseach' name='myseach' method='post' action=''>";
    echo "<b><font color='#333'>搜索信息</font></b>："; 
    if(isshow($SystemID,"classid")==true)
    {
    	$Class_arr="";
	    echo "&nbsp;<select name='str_classid' id='str_classid' style='vertical-align:middle'>" ;
	    echo "<option value='0'>所有分类</option>";
	    $ClaSql="Select * from ".$tablepre."class where SystemID=$SystemID order by sequence Asc";
	    $Result=$db->query($ClaSql);
	    while ($Row=$db->fetch_array($Result)) 
	    {
		   $Class_arr[]=array($Row["ID"],$Row["ClassName"],$Row["ClassNameEng"],$Row["Depth"],$Row["partid"],$Row["Sequence"]);
	    }
	    //调用无限级分类函数
	     SelectClass(0,true);
	     echo "</select>";
    }
    echo "&nbsp;&nbsp;<font color='#333'><b>关键字</b>：</font><input type='text' name='Keyword' id='Keyword' style='vertical-align:middle' />"; 
    echo  "&nbsp;&nbsp;<input type='submit' name='button' id='button' value='' style='vertical-align:middle;;background:url(../system_style/images/yc_search.gif) no-repeat; width:28px; height:20px;' />";
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
<?php 
switch ($_REQUEST['actn'])
{
	case "del":
		$arr=$_REQUEST['ids'];
		if (count($arr)>0)
	    {       
	        $id = implode(',', $_POST['ids']); 
	        $db->query("DELETE FROM $tabName WHERE id IN ($id)");
	        ok("信息删除成功!!",$_SERVER["HTTP_REFERER"],2);
        } 
       else
       {
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
        } 
       else
       {
      	ok("没有选中项目!!",$_SERVER["HTTP_REFERER"],2);
      	exit;
       } 
		break;
	case "rec":
		$arr=$_REQUEST['ids'];
		if (count($arr)>0)
	    {       
	        $id = implode(',', $_POST['ids']); 
	        $db->query("update $tabName set recover=0 WHERE id IN ($id)");
	        ok("所选信息已全部还原!!",$_SERVER["HTTP_REFERER"],2);
        } 
       else
       {
      	ok("没有选中项目!!",$_SERVER["HTTP_REFERER"],2);
      	exit;
       } 
		break;		
}
?>
<script   language="javascript">
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
      var strbox=document.getElementsByName("ids");
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
  </script> 