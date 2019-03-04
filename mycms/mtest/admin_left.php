<?php include('../system_core/admin_left_top.php')?>
<?php include('admin_config.php')?>
<tr>
    <td valign="top" class="listbg">
		<div class="ileft">
            <div class="ilt1" id="menuTitle103" onClick="showsubmenu(103)">测试</div>
            <ul id="submenu103">
                <li> <a target="mainFrame" href="../mtest/admin_index.php">信息列表</a></li>
				<li><a target="mainFrame" href="../mtest/admin_add.php">添加信息</a></li>
				<?php if (checkManag($_SESSION["adminLov"])==true){?>
                <li> <a target="mainFrame" href="../system_core/add_classtype.php?m=103&act=add">添加分类</a></li>
				<li><a target="mainFrame" href="../system_core/admin_class.php?m=103">分类管理</a></li>
				<?php }?>
                <li><?php if (checkManag($_SESSION["adminLov"])==true){?> <a target="mainFrame" href="../system_core/admin_field.php?m=103&act=add">添加字段</a></li><?php }?>
                <li><a target="mainFrame" href="../mtest/admin_recover.php">回 收 站</a></li>
            </ul>
        </div>
	</td>
</tr>
<?php include('../system_core/admin_left_foot.php')?>
