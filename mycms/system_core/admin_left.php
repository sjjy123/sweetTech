<?php include('admin_left_top.php')?>
<tr>
    <td valign="top" class="listbg">
 <div class="ileft">
		<?php 
        $CmsItems= $_REQUEST['m'];
        switch ($CmsItems)
        {
            case 0:
                CmsItems0();	
                //CmsItems999();
                break;
            default:
                CmsItems0();
                break;
        }
        ?>
 <?php
        function CmsItems0()
        { 
		  if (checkManag($_SESSION["adminLov"])==true)
		  {?>
          <div class="ilt1" id="menuTitle11" onClick="showsubmenu(11)">常规设置</div>
          <ul id="submenu11">
            <li><a target="mainFrame" href="../system_core/admin_setting.php">基本信息</a></li>
            <li><a target="mainFrame" href="../system_core/admin_setting.php?action=upload">联系方式</a></li>
            <li><a target="mainFrame" href="../system_core/admin_member.php">管 理 员</a></li>
            <li><a target="mainFrame" href="../system_core/admin_areas.php">城市管理</a></li>
			<?php if (checkManag($_SESSION["adminLov"])==true)
            {?>
             <li><a target="mainFrame" href="../system_core/admin_channel.php">栏目管理</a></li>
             <?php }?>
          </ul>
          <?php 
		  } 
		}?>
        <?php
        function CmsItems999()
        {
        ?>
        <div class="ilt1">系统相关</div>
            <ul>
                <li><a target="mainFrame" href="../system_core/admin_member.php">管 理 员</a></li>
                <?php if (checkManag($_SESSION["adminLov"])==true)
		  		{?>
                 <li><a target="mainFrame" href="../system_core/admin_channel.php">栏目管理</a></li>
                 <?php }?>
            </ul>
          
        <?php }?>
        </div>
    </td>
</tr>
<?php include('admin_left_foot.php')?>