<div class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-left" id="cbp-spmenu-s1">
  <ul class="nav nav-pills nav-stacked nav-admin">
    <li <?php if ($ACTION[1]=="dashboard"){echo "class='active'";}?>><a href="<?php echo ISVIPI_URL.$adminPath.'/dashboard' ?>"><i class="fa fa-dashboard"></i>&nbsp;<?php echo DASHBOARD ?></a></li>
    <li <?php if ($ACTION[1]=="gen_settings"){echo "class='active'";}?>><a href="<?php echo ISVIPI_URL.$adminPath.'/gen_settings' ?>"><i class="fa fa-wrench"></i> <?php echo GENERAL_SETT ?></a></li>
        <li <?php if ($ACTION[1]=="pages"){echo "class='active'";}?>><a href="<?php echo ISVIPI_URL.$adminPath.'/pages' ?>"><i class="fa fa-print"></i> <?php echo MANAGE_PAGES ?></a></li>
    <li class="dropdown <?php if($ACTION[1]=="members" || $ACTION[1]=="add_new" || $ACTION[1]=="edit_profile"){echo "has_active";}?>">
      <a class="dropdown-toggle" data-toggle="dropdown" href="#">
        <i class="fa fa-users"></i>&nbsp;<?php echo MEMBER_MGMT ?><span class="caret"></span>
      </a>
      <ul class="dropdown-menu">
        <li <?php if ($ACTION[1]=="members"){echo "class='active'";}?>><a href="<?php echo ISVIPI_URL.$adminPath.'/members' ?>">&raquo; <?php echo MEMBERS ?></a></li>
        <li <?php if ($ACTION[1]=="add_new"){echo "class='active'";}?>><a href="<?php echo ISVIPI_URL.$adminPath.'/add_new' ?>">&raquo; <?php echo ADD_NEW_USER ?></a></li>
        <li <?php if ($ACTION[1]=="edit_profile"){echo "class='active'";}?>><a href="<?php echo ISVIPI_URL.$adminPath.'/edit_profile' ?>">&raquo; <?php echo EDIT_MY_PROFILE ?></a></li>
        </ul>
    </li>
    <li <?php if ($ACTION[1]=="emails"){echo "class='active'";}?>><a href="<?php echo ISVIPI_URL.$adminPath.'/emails' ?>"><i class="fa fa-envelope"></i>&nbsp;<?php echo ADM_EMAILS ?></a></li>
    <li <?php if ($ACTION[1]=="sys_management"){echo "class='active'";}?>><a href="<?php echo ISVIPI_URL.$adminPath.'/sys_management' ?>"><i class="fa fa-cog"></i>&nbsp;<?php echo SYS_MGMT ?></a></li>
    <li class="dropdown <?php if($ACTION[1]=="addons" || $ACTION[1]=="addon"){echo "has_active";}?>">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
    <i class="fa fa-plus-square"></i>&nbsp;<?php echo ADDONS ?><span class="caret"></span></a>
    	<ul class="dropdown-menu">
        	<li <?php if ($ACTION[1]=="addons"){echo "class='active'";}?>>
    		<a href="<?php echo ISVIPI_URL.$adminPath.'/addons' ?>">
            &raquo; <?php echo ADDONS." ".SETTINGS ?>
            </a>
            </li>
            <!---This is where we will include any addon admin urls--->
            <?php getModUrls();
            while ($getModUrl->fetch()){
                if (file_exists(ISVIPI_INC_MODS.$modName.'/admin/settings.php')){
            ?>
            <li <?php if (isset($ACTION[2]))if ($ACTION[2]==$modName){echo "class='active'";}?>>
            <a href="<?php echo ISVIPI_URL."settings/addon/".$modName."/settings/"?>">
            &raquo; <?php echo ADDON." <i class='fa fa-angle-double-right'></i> ".$modName ?>
            </a>
            </li>
            <?php } ?>
            <?php } ?>
            <!-- they end here -->
    	</ul>
    </li>
    
  </ul> 
</div>