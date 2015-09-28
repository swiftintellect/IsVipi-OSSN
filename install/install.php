<?php
date_default_timezone_set ('US/Central');
/*******************************************************
 *   Copyright (C) 2014  http://isvipi.org

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License along
    with this program; if not, write to the Free Software Foundation, Inc.,
    51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
 ******************************************************/
	include_once '../init.php';
	include_once DOC_ROOT. '../inc/users.inc/users.func.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Install IsVipi OSSN</title>
        <link rel="shortcut icon" type="image/x-icon" href="../inc/style.lib/images/favicon.png">
      <!-- Bootstrap -->
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
      <link href="<?php echo '../inc/style.lib/css/isvipi-install.css'?>" rel="stylesheet" media="screen">
      <!-- FontAwesome -->
      <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
</head>
<body>
    
    <div class="row">
    	<div class="top-install-header">
          	<div class="install-logo">
            	<a href="http://isvipi.org" target="_blank">
                	<img src="../inc/style.lib/images/site/logo.png">
            	</a>
            </div>
            <div class="install-header-right">
            	<li><a href="http://isvipi.org" target="_blank">IsVipi OSSN</a></li> | 
                <li><a href="http://isvipi.org/docs/general/" target="_blank">Documentation</a></li> | 
                <li><a href="http://forum.isvipi.org/" target="_blank">Forum</a></li> | 
                <li><a href="http://isvipi.org/hire" target="_blank">Hire/Customize</a></li>
            </div>
            <div class="install-help">Having trouble installing? <a href="http://isvipi.org/support" target="_blank">Get install help</a>.</div>
        <div class="clear"></div>
        </div>
            	
                    <div class="col-lg-12 col-md-5 col-sm-8 col-xs-9 bhoechie-tab-container">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 bhoechie-tab-menu">
                          <div class="list-group">
                            <a href="#" class="list-group-item <?php if (isset($_SESSION['sysCheck'])){ echo 'active'; } else { echo  "disabled";} ?> text-center">
                              <h4 class="steps">Step 1</h4><span class="substep">System Requirements</span>
                            </a>
                            <a href="#" class="list-group-item <?php if (isset($_SESSION['stepTwo'])){ echo 'active'; } else { echo  "disabled";}?> text-center">
                              <h4 class="steps">Step 2</h4><span class="substep">Database Details</span>
                            </a>
                            <a href="#" class="list-group-item <?php if (isset($_SESSION['stepThree'])){ echo 'active'; } else { echo  "disabled";}?> text-center">
                              <h4 class="steps">Step 3</h4><span class="substep">Site Details</span>
                            </a>
                            <a href="#" class="list-group-item <?php if (isset($_SESSION['stepFours'])){ echo 'active'; } else { echo  "disabled";}?> text-center">
                              <h4 class="steps">Step 4</h4><span class="substep">Admin Details</span>
                            </a>
                            <a href="#" class="list-group-item <?php if (isset($_SESSION['finish'])){ echo 'active'; } else { echo  "disabled";}?> text-center">
                              <h4 class="steps">Finish</h4><span class="substep">Complete!</span>
                            </a>
                          </div>
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9 bhoechie-tab">
                            <div class="bhoechie-tab-content active">
                            	<?php if (isset($_SESSION['succ'])){?>
                            	<div class="alert alert-success" style="padding:8px; font-size:13px;"><?php echo $_SESSION['succ'] ?></div>
                                <?php unset($_SESSION['succ']); } else if (isset($_SESSION['err'])){?>
                                <div class="alert alert-danger" style="padding:8px; font-size:13px;"><?php echo $_SESSION['err'] ?></div>
                                <?php unset($_SESSION['err']);} ?>
                            	<!-- check if the relevant session is active -->
                            	<?php if (isset($_SESSION['sysCheck'])){
								   //check php version
								   if (phpversion()< 5.3){
									   $sys_req = 'err: php version';
									   $phpVer = "<i class='fa fa-times-circle red'></i> <span class='red'>failed</span>";
								   } else {
									   $phpVer = "<i class='fa fa-check-circle green'></i> <span class='green'>passed</span>";
								   }
								   
								   //check mysql version
									ob_start(); 
									phpinfo(INFO_MODULES); 
									$info = ob_get_contents(); 
									ob_end_clean(); 
									$info = stristr($info, 'Client API version'); 
									preg_match('/[1-9].[0-9].[1-9][0-9]/', $info, $match); 
									$gd = $match[0]; 
									if ($gd<4.1){
										$sys_req = 'err: mysql version';
										$MySQLVer = "<i class='fa fa-times-circle red'></i> <span class='red'>failed</span>";
									} else {
									   $MySQLVer = "<i class='fa fa-check-circle green'></i> <span class='green'>passed</span>";
									}
									
									//check for mod_rewrite
									if(in_array('mod_rewrite',apache_get_modules())) {
										 $mod_rewr = "<i class='fa fa-check-circle green'></i> <span class='green'>passed</span>";
									} else {
										$sys_req = 'err: mod_rewrite';
										$mod_rewr = "<i class='fa fa-times-circle red'></i> <span class='red'>failed</span>";
									}
									
									//check for curl
									if (function_exists('curl_init')){ 
										$curLexs = "<i class='fa fa-check-circle green'></i> <span class='green'>passed</span>";
									} else {
										$sys_req = 'err: curl';
										$curLexs = "<i class='fa fa-times-circle red'></i> <span class='red'>failed</span>";
									}
									
									//check for mcrypt
									if (function_exists('mcrypt_generic_init')){
										$mcryptLexs = "<i class='fa fa-check-circle green'></i> <span class='green'>passed</span>";
									} else {
										$sys_req = 'err: mcrypt';
										$mcryptLexs = "<i class='fa fa-times-circle red'></i> <span class='red'>failed</span>";
									}
									
									//check for GD
									if (function_exists('imagecreatefromstring')){
										$gdLexs = "<i class='fa fa-check-circle green'></i> <span class='green'>passed</span>";
									} else {
										$sys_req = 'err: GD Lib';
										$gdLexs = "<i class='fa fa-times-circle red'></i> <span class='red'>failed</span>";
									}
								?>
                    			<div class="step-title">Step 1 - <span>System Requirements Check</span></div>
                                <li class="list-group-item">PHP version is 5.3 and above <div class="pull-right"><?php echo $phpVer ?></div></li>
                                <li class="list-group-item">MySQL version is 4.1 and above <div class="pull-right"><?php echo $MySQLVer ?></div></li>
                                <li class="list-group-item">mod_rewrite enabled<div class="pull-right"><?php echo $mod_rewr ?></div></li>
                                <li class="list-group-item">Curl installed <div class="pull-right"><?php echo $curLexs ?></div></li>
                                <li class="list-group-item">Mcrypt installed <div class="pull-right"><?php echo $mcryptLexs ?></div></li>
                                <li class="list-group-item">GD Library installed<div class="pull-right"><?php echo $mcryptLexs ?></div></li>
                            <?php if (isset($sys_req)){?>
                            	<div class="alert alert-danger cannot-continue">
                                Oops! Installation cannot continue until the items marked as failed are resolved. Please contact your hosting company to have these sorted out. Sorry <i class="fa fa-frown-o"></i>.
                                </div>
                            <?php } else {
								$_SESSION['proceedOne'] = true;
							?>
                            	
                            	<a href="<?php echo URL_ROOT.'installdb/stepOne/'?>" class="btn btn-success pull-right">Proceed to step 2 &raquo;</a>
                            <?php } ?>
                            <?php } else if (isset($_SESSION['stepTwo'])){?><!-- end of step one and start of step two -->
                            <div class="step-title">Step 2 - <span>Database Details</span></div>
                            <?php 
								$db_file_path = '../inc/db/db.php';
								if (file_exists($db_file_path)){
							  ?>
							  <div class="alert alert-danger">
								<p>db.php file exists. Proceeding with the installation will delete the current db.php file and create a new one. If you are aware of this please proceed with the installation.</p>
							  </div>
							  <?php } ?>
                            <div class="well col-lg-10" style="background:#FFF; padding:10px">
                            <form role="form" action="<?php echo URL_ROOT.'installdb/'?>" method="post">
                              <div class="form-group">
                                <label for="dbhost">Database Host</label>
                                <input type="name" class="form-control" placeholder="localhost" name="dbhost" required>
                              </div>
                              <div class="form-group">
                                <label for="dbusername">Database Username</label>
                                <input type="name" class="form-control" placeholder="username" name="dbusername" required>
                              </div>
                              <div class="form-group">
                                <label for="dbpassword">Database Password</label>
                                <input type="password" class="form-control" placeholder="Password" name="dbpassword" required>
                              </div>
                              <div class="form-group">
                                <label for="dbname">Database Name</label>
                                <input type="name" class="form-control" placeholder="Database" name="dbname" required>
                              </div>
                              <input type="hidden" name="op" value="stepTwo">
                              <button type="submit" class="btn btn-success pull-right" >Connect to the Database &raquo;</button>
                            </form>
                            <div class="clear"></div>
                            </div>

                            <?php } if (isset($_SESSION['stepThree'])){?><!-- end of step two and start of step three -->
                            <div class="step-title">Step 3 - <span>Site Details</span></div>
                            <div class="well col-lg-10" style="background:#FFF; padding:10px">
                            <form role="form" action="<?php echo URL_ROOT.'installdb/'?>" method="post">
                              <div class="form-group">
                                <label for="url">Site URL (WITHOUT the front slash "/" e.g. http://isvipi.org)</label>
                                <input type="text" class="form-control" name="site_url" value="http://" required>
                              </div>
                              <div class="form-group">
                                <label for="url">Site Title/Name</label>
                                <input type="text" class="form-control" placeholder="e.g. IsVipi Open Source Social Networking Script" name="site_title" required>
                              </div>
                              <div class="form-group">
                                <label for="semail">Site E-Mail</label>
                                <input type="email" class="form-control" placeholder="e.g. whatever@yoursite.com" name="site_email" required>
                              </div>
                              
                              <div class="form-group">
                                <label for="time_zone">Default Time Zone</label>
                                <?php
                            $regions = array(
                                'Africa' => DateTimeZone::AFRICA,
                                'America' => DateTimeZone::AMERICA,
                                'Antarctica' => DateTimeZone::ANTARCTICA,
                                'Aisa' => DateTimeZone::ASIA,
                                'Atlantic' => DateTimeZone::ATLANTIC,
                                'Europe' => DateTimeZone::EUROPE,
                                'Indian' => DateTimeZone::INDIAN,
                                'Pacific' => DateTimeZone::PACIFIC
                            );
                             
                            $timezones = array();
                            foreach ($regions as $name => $mask)
                            {
                                $zones = DateTimeZone::listIdentifiers($mask);
                                foreach($zones as $timezone)
                                {
                                    // Lets sample the time there right now
                                    $time = new DateTime(NULL, new DateTimeZone($timezone));
                             
                                    // Us dumb Americans can't handle millitary time
                                    $ampm = $time->format('H') > 12 ? ' ('. $time->format('g:i a'). ')' : '';
                             
                                    // Remove region name and add a sample time
                                    $timezones[$name][$timezone] = substr($timezone, strlen($name) + 1) . ' - ' . $time->format('H:i') . $ampm;
                                }
                            }
                            // View
                            print '<select id="timezone" class="form-control" name="time_zone">';
                            foreach($timezones as $region => $list)
                            {
                                print '<optgroup label="' . $region . '">' . "\n";
                                foreach($list as $timezone => $name)
                                {
                                    print '<option value="' . $timezone . '">' . $name . '</option>' . "\n";
                                }
                                print '<optgroup>' . "\n";
                            }
                            print '</select>';
                            ?>
                              </div>
                              <div class="form-group">
                                <input type="hidden" name="op" value="stepThree">
                              </div>
                              <button type="submit" class="btn btn-success pull-right">Save Settings &raquo;</button>
                            </form>
                            </div>
                                                        
                            <?php } else if(isset($_SESSION['stepFours'])){?><!-- end of step three and start of step four -->
                            <div class="step-title">Step 4 - <span>Admin Details</span></div>
                            <div class="well col-lg-10" style="background:#FFF; padding:10px">
                            <form role="form" action="<?php echo URL_ROOT.'installdb/'?>" method="post">
                              <div class="form-group">
                                <label for="admin_username">Admin Name</label>
                                <input type="text" class="form-control" name="admin_username" value="" placeholder="Admin Username" required>
                              </div>
                              <div class="form-group">
                                <label for="admin_email">Admin Email</label>
                                <input type="email" class="form-control" placeholder="Admin Email" name="admin_email" required>
                              </div>
                              <div class="form-group">
                                <label for="pass1">Admin Password</label>
                                <input type="password" class="form-control"  name="pass1" required>
                              </div>
                              <div class="form-group">
                                <label for="pass2">Repeat Admin Password</label>
                                <input type="password" class="form-control"  name="pass2" required>
                              </div>
                              <div class="form-group">
                                <input type="hidden" name="op" value="stepFour">
                              </div>
                              <button type="submit" class="btn btn-success pull-right">Create Admin</button>
                            </form>
                            </div>
                            <?php } else if (isset($_SESSION['finish'])){?><!-- end of step four and start of step five -->
                            <div class="step-title">Finish - <span>Install Complete</span> <div class="pull-right"><a href="../" target="_blank">View Site</a> | <a href="../admin/" target="_blank">Go to Admin Page </a></div></div>
                            <div class="install-complete-prompt">
                            
                            <p>That was easy, right? Here are some few useful links for you.</p>
                            <div class="well" style="padding:5px;">
                            <p><a href="http://isvipi.org/support" target="_blank">Customization <i class="fa fa-external-link"></i></a> - If you need features that are not essentially available in the current installation, you can simply order customization. There are endless possibilities for this software and therefore you can rest assured that your vision of your site will be in capable hands.</p>
                            <p><a href="http://isvipi.org/hire" target="_blank">Hire <i class="fa fa-external-link"></i></a> - If you have a completely different project that you would like experienced web developers, we are right here. We can build any kind of a site for you. Imagine it, we develop it.</p>
                            </div>
                            <p>Meanwhile, if you have questions or suggestions for new features please visit our <a href="http://forum.isvipi.org" target="_blank">forum <i class="fa fa-external-link"></i></a>. You can also go through our <a href="http://isvipi.org/docs/general/" target="_blank">Documentation <i class="fa fa-external-link"></i></a> to find out more about this free software.</p>
                            <p>If you appreciate our work and would like to support its development, you can <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=8EKWYJABNLDE2" target="_blank">DONATE</a> to the project. Web developer? <a href="https://github.com/IsVipiOfficial/IsVipi-Open-Source-Social-Networking-Script" target="_blank">Find and fork us</a> on github.</p>
                            
                            
                            </div>
                            
                            <?php }?><!-- end of step five -->
                            
                            </div>
                          </div>
                        
                    </div>
                    <div class="clear"></div>
          </div>
<script type="text/javascript" src="http://code.jquery.com/jquery-2.0.3.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</body>
</html>