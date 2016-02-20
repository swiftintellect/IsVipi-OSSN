<?php require_once(ISVIPI_ADMIN_BASE .'ovr/head.php') ?>
<?php require_once(ISVIPI_ADMIN_BASE .'ovr/header.php') ?>
<?php require_once(ISVIPI_ADMIN_BASE .'ovr/sidebar.php') ?>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Update to Version 2.0.1 
          </h1>
          <ol class="breadcrumb">
            <li>
            	<a href="<?php echo ISVIPI_ACT_ADMIN_URL ?>">
                	<i class="fa fa-dashboard"></i> Dashboard
                </a>
            </li>
            <li class="active">Update to Version 2.0.1 </li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
        	<div class="col-md-12">
            	<div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Update to Version 2.0.1</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                <?php if(isset($PAGE[2]) && $PAGE[2] == "update"){
					for ($x = 0; $x <= 0; $x++){
						
						echo "<div style='line-height:22px'>";
						//switch to maintenance mode
						echo "Switching on maintenance mode... <br/>";
						switch_system_status('1');
						echo "<span class='text-blue'>Maintenance mode On</span><br/>";
						
						//import sql
						
						//delete old files
						
						//switch from maintenance mode
						echo "Switching off maintenance mode... <br/>";
						switch_system_status('0');
						echo "<span class='text-blue'>Maintenance mode Off</span><br/>";
						
						//return success
						echo "Finishing upgrade...<br/>";
						echo "<span class='text-blue'>Your site has been successfully updated to version ".ISV_VERSION.". You can check out the changelog at </span><br/>";
						echo '</div>';
					
					}?>
                    <hr />
                    <div class="well alert alert-default" style="margin-top:10px; padding:10px;">
                    	<div class="col-md-12">
                    	If you enjoy using our software and appreciate the time and work put into it, please consider making a donation.</div>
                        <div class="col-md-5">
                        <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top" style="margin-top:20px">
                            <input type="hidden" name="cmd" value="_s-xclick">
                            <input type="hidden" name="hosted_button_id" value="ZMWP83F3ACBBC">
                            <input type="hidden" name="on0" value="Donation Amount">
                            <div class="col-md-5">
                            <select name="os0" class="form-control">
                                <option value="10">$10.00 USD</option>
                                <option value="25">$25.00 USD</option>
                                <option value="50">$50.00 USD</option>
                                <option value="100">$100.00 USD</option>
                                <option value="250">$250.00 USD</option>
                                <option value="500">$500.00 USD</option>
                                <option value="1000">$1,000.00 USD</option>
                            </select> 
                            </div>
                            <div class="col-md-7">
                            <input type="submit" class="btn btn-primary" name="submit" alt="PayPal - The safer, easier way to pay online!" value="Make a Donation">
                            </div>
                            <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
                        </form>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    
					
				<?php } else { ?>
                <p>When you click “Update”, the site will be automatically switched to maintenance mode. Site upgrade will begin right away and shouldn’t take more than a few seconds. Once complete, Maintenance Mode will be deactivated.</p>
                <hr />
                    <a href="<?php echo ISVIPI_ACT_ADMIN_URL .'update/update' ?>" class="btn btn-lg btn-lg btn-primary">
                    	Update
                    </a>
                    
                <?php } ?>
                
                </div>
              </div><!-- /.box -->
            
            </div>
            
        <div class="clearfix"></div>
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
<?php require_once(ISVIPI_ADMIN_BASE .'ovr/footer.php') ?>
