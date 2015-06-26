<?php 
include_once'header.php';
include_once'sidebar.php';?>
    <!-- Start of the container-->
    <div class="container-admin">
      <div class="page-header">
		<ul class="breadcrumb breadcrumb-admin">
  			<li><i class="fa fa-home"></i> <?php echo HOME ?></li>
  			<li class="active"><?php echo ADDONS ?></li>
            <span class="donate_support"><span class="label label-danger"><?php echo DONATE ?></span></span>
        <div class="donate">
        <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=8EKWYJABNLDE2" data-toggle="tooltip" data-placement="bottom" target="_blank" title="<?php echo DONATE_TEXT ?>"><img src="<?php echo ISVIPI_STYLE_URL.'images/donate.png';?>" width="100%" alt="" /></a>
        </div>
        </ul>
     </div>
     <!-- Start of main_content-->
     <div class="main_content">
     <div style="clear:both"></div>
     <div class="dash_admin_panel_cont"> <!--start of dash_cont_stat-->
       <div class="row">
            <div class="panel panel-default">
            <div class="panel-heading"><strong><?php echo SETTINGS ?> </strong></div>
            <div class="padded">
                <div style="min-height:100px; width:45%;border:solid thin #CCC; float:left;padding:10px">
                <form action="<?php echo ISVIPI_URL.'admAddons/addonForms/' ?>" method="post">
                    <input type="hidden" name="action" value="addonSett" />
                    <input type="checkbox" name="enabAddons" value="1"  <?php if ($addonEnabled == 1){echo "checked";}?>/>
                    <span style="margin-top:10px"><?php echo ENABLE_MODS ?></span><br />
                    <hr style="margin:5px"/>
                    
                	<div class="alert alert-info" style="width:100%;padding:5px; font-size:12px; margin-top:10px">
                    <?php echo N_ENABLE_MODS ?>
                    </div>
                    <button type="submit" class="btn btn-primary"><?php echo SAVE_SETT ?></button>
                </form>
                </div>
                <div style="min-height:100px; width:50%;border:solid thin #CCC; float:left; padding:10px; margin-left:10px">
                <?php echo DELETE."/".UNINSTALL." ".ADDONS?>
                <hr style="margin:5px"/>
                <div class="alert alert-warning" style="width:100%;padding:5px; font-size:12px; margin-top:10px; margin-bottom:5px">
                    <?php echo N_DEL_MODS ?>
                    </div>
                <table class="table">
                <thead>
                    <tr>
                        <th><?php echo ADDON ?></th>
                        <th><?php echo ACTION ?></th>
                    </tr>
                </thead>
                <tbody>
                            <?php
				$dir = new DirectoryIterator(ISVIPI_INC_MODS);
					foreach ($dir as $fileinfo) {
            if ($fileinfo->isDir() && !$fileinfo->isDot()) {
				$addonName = $fileinfo->getFilename();
				AddonIsInstalled($addonName);
				?>
                <tr <?php if ($Addcount > 0 && $ADDSTATUS==1){echo "style='display:none'";}
				
				?>>
                    <td style="padding:5px;">
					<?php echo $addonName ?>
                    </td>
                    
                    <td style="padding:5px;">
                    <?php if ($ADDDESC == ""){?>
                    <a href="<?php echo ISVIPI_URL."admAddons/action/del/$addonName"?>">
                    <?php echo DELETE ?>
                    </a>
                    <?php } else{ ?>
                    <a href="<?php echo ISVIPI_URL."admAddons/action/uninst/$addonName"?>">
					<?php echo UNINSTALL ?>
                    </a>
                    <?php } ?>
                    </td>
                    <?php } ?>
                </tr>
                <?php }
				?>
				</tbody>
			</table>
                </div>
                <div style="clear:both"></div>
            </div>
            </div>
            </div>

     	<div class="panel panel-default midi-left">
    	<div class="panel-heading"><strong><?php echo ADDONS ?> </strong></div>
        <div class="padded">
          <table class="table">
            <thead>
                <tr>
                    <th><?php echo ADDON ?></th>
                    <th><?php echo DESCR ?></th>
                    <th><?php echo "Version" ?></th>
                    <th><?php echo AUTHOR ?></th>
                    <th><?php echo STATUS ?></th>
                </tr>
            </thead>
            <tbody>
            <?php
				$dir = new DirectoryIterator(ISVIPI_INC_MODS);
					foreach ($dir as $fileinfo) {
            if ($fileinfo->isDir() && !$fileinfo->isDot()) {
				$addonName = $fileinfo->getFilename();
				AddonIsInstalled($addonName);
				?>
                <tr <?php if ($ADDDESC == ""){echo "class='danger'";}
				else if ($Addcount > 0 && $ADDSTATUS==0){echo "class='warning'";}
				else {echo "class='success'";}
				?>>
                <?php
				if ($ADDDESC == ""){
					$desc = N_NOT_INSTALLED;
				} else {
					$desc = $ADDDESC;
				}?>
                    <?php if ($ADDDESC == "" || $ADDSTATUS == 0){?>
                    <td style="padding:10px 5px 10px 10px; font-weight:700;">
					<?php echo $addonName ?>
                    </td>
                    <?php } else if($ADDSTATUS == 1 && !file_exists(ISVIPI_INC_MODS.$addonName.'/admin/settings.php')){?>
                    <td style="padding:10px 5px 10px 10px; font-weight:700;">
					<?php echo $addonName ?>
                    </td>
                    <?php } else if ($ADDSTATUS == 1 && file_exists(ISVIPI_INC_MODS.$addonName.'/admin/settings.php')){?>
                    <td style="padding:10px 5px 10px 10px; font-weight:700;">
                    <a href="<?php echo ISVIPI_URL."settings/addon/".$addonName."/settings/"?>" data-toggle="tooltip" data-placement="bottom" title="<?php echo ADDON." ".SETTINGS ?>">
					<?php echo $addonName ?>
                    </a>
                    </td>
                    <?php } ?>
                    
                    <td style="padding:10px 5px;"><?php echo trunc_text($desc,7) ?></td>
                    <td style="padding:10px 5px;"><?php echo $ADDVER ?></td>
                    <td style="padding:10px 5px;"><?php echo $ADDAUTH ?></td>
                    
                    <?php if ($Addcount > 0 && $ADDSTATUS==1){?>
                    <td style="padding:10px 5px;"><a href="<?php echo ISVIPI_URL."admAddons/action/deac/$ADDonID"?>"><?php echo DEACTIVATE ?></a></td>
                    <?php } else if ($Addcount > 0 && $ADDSTATUS==0) {?>
                    
                    <td style="padding:10px 5px;">
                    <a href="<?php echo ISVIPI_URL."admAddons/action/act/$ADDonID"?>">
					<?php echo ACTIVATE ?>
                    </a></td>
                    <?php } else {?>
                    <td style="padding:10px 5px;">
                    <a href="<?php echo ISVIPI_URL."admAddons/action/inst/$addonName"?>">
					<?php echo INSTALL ?>
                    </a></td>
                    <?php } ?>
                </tr>
                <?php }
					}
			?>
            </tbody>
        </table>
          
          
          
          
          </div>
        </div>
          
        <div class="panel panel-default midi-left2">
    		<div class="panel-heading"><strong><?php echo ADD_ADDON ?> </strong></div>
        		<div class="padded">
                <div class="alert alert-info">
                <strong>
				<?php echo ADDON_OVWR_ALERT ?>
                </strong>
                </div>
        			<table class="table">
                       <tbody>
                       <form action="<?php echo ISVIPI_URL.'admAddons/newAddon/' ?>" method="post" enctype="multipart/form-data">
                       <tr>
                       <label>&nbsp;&nbsp;<?php echo ADD_ADDON ?></label>
                       <td width="200"><input type="file" class="form-control" name="new"></td>
                       </tr>
                       <tr>
                       <input type="hidden" name="action" value="newAddon">
                       <td><button type="submit" class="btn btn-default"><?php echo UPLOAD ?></button></td>
                       </tr>
                       </form>
                       </tbody>
                  </table>
                </div>
  			</div> 
            <div style="clear:both"></div>
     	</div> 
<div style="clear:both"></div>
     </div>
     </div><!--end of dash_cont_stat-->
     </div><!-- End of main_content-->
    </div> <!-- End of the container-->
<?php include_once'footer.php';?>