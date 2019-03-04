<?php include('../system_core/admin_left_top.php')?>
<tr>
    <td valign="top" class="listbg">
		<div class="ileft">
            <div class="ilt1">新闻中心</div>
            <ul>
                <li> <a target="mainFrame" href="../news/admin_index.php">新闻列表</a></li>
				<li><a target="mainFrame" href="../news/admin_add.php">添加信息</a></li>
				<?php if (checkManag($_SESSION["adminLov"])==true){?>
                <li> <a target="mainFrame" href="../system_core/add_classtype.php?m=43&act=add">添加分类</a></li>
				<li><a target="mainFrame" href="../system_core/admin_class.php?m=43">分类管理</a></li>
				<?php }?>
                <li><?php if (checkManag($_SESSION["adminLov"])==true){?> <a target="mainFrame" href="../system_core/admin_field.php?m=43&act=add">添加字段</a></li><?php }?>
                <li><a target="mainFrame" href="../news/admin_recover.php">回 收 站</a></li>
            </ul>
        </div>
	</td>
</tr>
<?php include('../system_core/admin_left_foot.php')?>
