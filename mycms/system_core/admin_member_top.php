<table class="table1" cellspacing="1" cellpadding="3" align="center" border="0">
	<tr>
		<td class="tableline linetitle" width="200" align="left">管理员管理</td>
		<td class="tableline" width="*" align="right"><a href="admin_member.php">添加管理员</a>
			| <a href="admin_member.php">管理页面</a>
           <!-- | <a href="add_classtype.php?m=< ?php echo $SystemID;?>&act=add">一级分类排序</a>-->
		</td>
	</tr>
</table>
<table id="tablehovered1" border="0" align="center" cellpadding="3" cellspacing="1" class="tableborder">
  <tr>
    <th noWrap width="5%">编号</th>
    <th>管理员名称</th>
    <th  width="20%">管理权限</th>
    <th  width="20%">管理操作</th>
  </tr>
<?php 
$cms_sql="select * from ".$tablepre."admin ";
if (checkManag($_SESSION["adminLov"])==false){$cms_sql=$cms_sql." where adminLov<>520 ";}
$cms_sql =$cms_sql." order by id asc";
$cms_result=$db->query($cms_sql);
$i=1;
while ($cms_row=$db->fetch_array($cms_result))
{
	if($i % 2==0){$strclassname="tablerow1";}
	else{$strclassname="tablerow2";}
	if($i<10){$itemNum="0".$i;}
	if($i>=10){$itemNum=$i;}
  echo "<tr>";
  echo "<td class=$strclassname>$itemNum</td>";
  echo "<td class=$strclassname>".$cms_row["adminName"];
  if (checkManag($cms_row["adminLov"])==true) {echo " <font color=red>[超级管理员]</font>";}
  if (checkManag($cms_row["adminLov"])==false)
  {
  	if ($cms_row["adminLov"]==1){echo " <font color=#016AA9>[超级管理员]</font>";}
  	if ($cms_row["adminLov"]==0){echo " <font color=blue>[普通管理员]</font>";}
  }
  echo "</td>";
  echo "<td class=$strclassname>";
   if (checkManag($cms_row["adminLov"])==true){echo "<font color=red>网站制作着权限</font>";}
   if (checkManag($cms_row["adminLov"])==false)
  {
  	if ($cms_row["adminLov"]==1){echo " <font color=#016AA9>[所有权限]</font>";}
  	if ($cms_row["adminLov"]==0){echo " <font color=blue>[普通权限]</font>";}
  }
  $str_herf="&nbsp;<a href='admin_permis.php?act=perm&strid=".$cms_row["ID"]."'>设置权限</a>";
  $str_herf1="&nbsp;<font color=#CCCCCC>设置权限</font>";
  if($_SESSION["adminLov"]==520)
  {
  	if ($cms_row["adminLov"]==520){$admin_herf="";}
  	if ($cms_row["adminLov"]==1||$cms_row["adminLov"]==0){$admin_herf=$str_herf;}
  }
  if($_SESSION["adminLov"]==1) 
  {
  	if ($cms_row["adminLov"]==1){$admin_herf=$str_herf1;}
  	if ($cms_row["adminLov"]==0){  	$admin_herf=$str_herf;}
  }
  if($_SESSION["adminLov"]==0) {$admin_herf=$str_herf1;}
  echo $admin_herf;
  echo "</td>";
  echo "<td class=$strclassname>";
  $stredit = "<a href='admin_member.php?act=edit&strid=".$cms_row["ID"]."' >编辑</a> |";
  $stredit1= "<font color=#CCCCCC>编辑 |";
  $strdel  = "<a ".confirm()." href='admin_member.php?action=del&strid=".$cms_row["ID"]."'> 删除</a>";
  $strdel1 = "<font color=#CCCCCC> 删除</font>";

  if($_SESSION["adminLov"]==520)
  {
  	if ($cms_row["adminLov"]==520&&$cms_row["adminName"]=='admin'){$str_edit=$stredit.$strdel1;}
  	if ($cms_row["adminLov"]==520&&$cms_row["adminName"]!='admin'){$str_edit=$stredit.$strdel;}
  	if ($cms_row["adminLov"]==1||$cms_row["adminLov"]==0){$str_edit=$stredit.$strdel;}
  }
  if($_SESSION["adminLov"]==1) 
  {
  	if ($cms_row["adminLov"]==1){$str_edit=$stredit.$strdel1;}
  	if ($cms_row["adminLov"]==0){$str_edit=$stredit.$strdel;}
  }
  if($_SESSION["adminLov"]==0) {$str_edit=$stredit1.$strdel1;}
  echo $str_edit;

  echo "</td>";
  echo "</tr>";
  $i++;
}?> 
</table>