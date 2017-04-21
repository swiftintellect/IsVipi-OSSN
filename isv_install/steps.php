<!-- error and success notifications -->
<?php if(isset($_SESSION['isv_error']) && !empty($_SESSION['isv_error'])){?>
	<div class="error-alert"><?php echo $_SESSION['isv_error']; unset($_SESSION['isv_error']); ?></div>
<?php } else if(isset($_SESSION['isv_success']) && !empty($_SESSION['isv_success'])){ ?>
	<div class="success-alert"><?php echo $_SESSION['isv_success']; unset($_SESSION['isv_success']); ?></div>
<?php } ?>
<!-- end::error and success notifications -->

<div id="rootwizard">
	<div class="navbar step-by-step">
		<div class="navbar-inner">
			<div class="container">
				<ul>
					<li <?php if(isset($_SESSION['isv_s1']) && $_SESSION['isv_s1'] === 's1'){ echo 'class="current"'; }?>>
                    	System Requirements
                    </li>
					<li <?php if(isset($_SESSION['isv_s1']) && $_SESSION['isv_s1'] === 's2'){ echo 'class="current"'; }?>>
                    	Database Details
                    </li>
					<li <?php if(isset($_SESSION['isv_s1']) && $_SESSION['isv_s1'] === 's3'){ echo 'class="current"'; }?>>
                    	Site Details
                    </li>
					<li <?php if(isset($_SESSION['isv_s1']) && $_SESSION['isv_s1'] === 's4'){ echo 'class="current"'; }?>>
                    	Admin Details
                    </li>
                    <li <?php if(isset($_SESSION['isv_s1']) && $_SESSION['isv_s1'] === 'end'){ echo 'class="current"'; }?>>
                    	Complete
                    </li>
				</ul>
			</div>
		</div>
	</div>
	<div class="tab-content">
    	
		<?php if(isset($_SESSION['isv_s1']) && $_SESSION['isv_s1'] === 's1'){ ?>
    	<div class="tab-pane">
        <h3 class="titles">System Requirements</h3>
        	<ul>
                <li>PHP version 5.5 and above <?php echo php_version('5.5') ?></li>
                <li>MySQL version 4.1 and above <?php echo mysql_version('4.1') ?></li>
                <li>Curl installed <?php echo curl_exists() ?></li>
                <li>GD installed <?php echo gd_lib_exists() ?></li>
                <li>Installed mod_rewrite Apache module <?php echo mode_rewrite_installed() ?></li>
            </ul>
            
            <ul>
			<?php if(isset($error) && ($error)){?>
            	<p class="check-failed">System Requirements Check Failed: Your server did not meet the minimum system requirements.</p>
            <?php } else { ?>
            	<p class="check-passed">System Requirements Check Passed: Click <strong>Proceed</strong> to continue.</p>
            <?php } ?>
            </ul>
        </div>
        <ul class="pager wizard">
        	<?php if(isset($error) && ($error)){?>
           		<a class="btn btn-danger pull-left btn-styled disabled">Check failed. Cannot proceed</a>
            <?php } else {?>
            	<a href="<?php echo ISVIPI_URL.'install.php?proceed=true'?>" class="btn btn-primary pull-left btn-styled">Proceed</a>
            <?php } ?>
        </ul>
        
        <?php } else if(isset($_SESSION['isv_s1']) && $_SESSION['isv_s1'] === 's2'){?>
        <div class="tab-pane">
        	<h3 class="titles">Database Details</h3>
        	<form action="<?php echo ISVIPI_URL.'install.php'?>" method="post">
            <div class="form-group">
                <div class="input-group input-group-lg">
                  <span class="input-group-addon">Host (localhost)</span>
                  <input type="text" class="form-control" name="host" placeholder="e.g. localhost" required="required">
                </div>
            </div>
            <div class="form-group">
                <div class="input-group input-group-lg">
                  <span class="input-group-addon">Database Name</span>
                  <input type="text" class="form-control" name="db_name" placeholder="e.g. isvipi" required="required">
                </div>
            </div>
            <div class="form-group">
                <div class="input-group input-group-lg">
                  <span class="input-group-addon">Database User</span>
                  <input type="text" class="form-control" name="db_user" placeholder="e.g. root" required="required">
                </div>
            </div>
            <div class="form-group">
                <div class="input-group input-group-lg">
                  <span class="input-group-addon">Database Password</span>
                  <input type="password" class="form-control" name="db_pwd">
                </div>
            </div>
            <div class="form-group">
            	<input type="hidden" name="isv_inst" value="step2" />
            	<button type="submit" class="btn btn-primary pull-left btn-styled">Proceed</button>
            </div>
            <div class="clear"></div>
            </form>
        </div>
        
        <?php } else if(isset($_SESSION['isv_s1']) && $_SESSION['isv_s1'] === 's3'){?>
        <div class="tab-pane">
        	<h3 class="titles">Site Details</h3>
            <form action="<?php echo ISVIPI_URL.'install.php'?>" method="post">
            <div class="form-group">
                <div class="input-group input-group-lg">
                  <span class="input-group-addon">URL</span>
                  <input type="url" class="form-control" name="url" placeholder="e.g. http://mycommunity.org" required="required">
                </div>
            </div>
            <div class="form-group">
                <div class="input-group input-group-lg">
                  <span class="input-group-addon">Title</span>
                  <input type="text" class="form-control" name="title" placeholder="e.g. My Community" required="required">
                </div>
            </div>
            <div class="form-group">
                <div class="input-group input-group-lg">
                  <span class="input-group-addon">Email</span>
                  <input type="email" class="form-control" name="email" placeholder="e.g. info@mycommunity.com" required="required">
                </div>
            </div>
            <div class="form-group">
                <div class="input-group input-group-lg">
                  <span class="input-group-addon">Timezone</span>
                  <select class="form-control" name="timezone">
                  	<?php load_timezones() ?>
                  </select>
                </div>
            </div>
            <div class="form-group">
            	<input type="hidden" name="isv_inst" value="step3" />
            	<button type="submit" class="btn btn-primary pull-left btn-styled">Proceed</button>
            </div>
            <div class="clear"></div>
            
            </form>
        </div>
        <?php } else if(isset($_SESSION['isv_s1']) && $_SESSION['isv_s1'] === 's4'){?>
        <div class="tab-pane">
        	<h3 class="titles">Admin Details</h3>
            <form action="<?php echo ISVIPI_URL.'install.php'?>" method="post">
            <div class="form-group">
                <div class="input-group input-group-lg">
                  <span class="input-group-addon">Full Name</span>
                  <input type="text" class="form-control" name="name" placeholder="e.g. John Doe" required="required">
                </div>
            </div>
            <div class="form-group">
                <div class="input-group input-group-lg">
                  <span class="input-group-addon">Email</span>
                  <input type="email" class="form-control" name="email" placeholder="e.g. me@johndoe.com" required="required">
                </div>
            </div>
            <div class="form-group">
                <div class="input-group input-group-lg">
                  <span class="input-group-addon">Password</span>
                  <input type="password" class="form-control" name="pwd" required="required">
                </div>
            </div>
            <div class="form-group">
                <div class="input-group input-group-lg">
                  <span class="input-group-addon">Repeat Password</span>
                  <input type="password" class="form-control" name="rpwd" required="required">
                </div>
            </div>
            <div class="form-group">
                <div class="form-group">
            	  <input type="hidden" name="isv_inst" value="step4" />
            	  <button type="submit" class="btn btn-primary pull-left btn-styled">Finish</button>
                </div>
                <div class="clear"></div>
            </div>
            </form>
        </div>
        <?php } else if(isset($_SESSION['isv_s1']) && $_SESSION['isv_s1'] === 'end'){?>
        
        <div class="tab-pane">
        	<h3 class="titles">Installation Complete</h3>
            <p class="check-failed">Please delete the install folder/directory "<strong>isv_install</strong>" from your server.</p>
            <p class="completed-ins">That is it! Easy right?</p>
            <p class="completed-ins">If you like or enjoy using this software, you can help spread the word by blogging about it, telling a friend or even <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=8EKWYJABNLDE2" target="_blank">buying us coffee</a> to keep us awake as we continue enhancing its features. IsVipi OSSN is provided for free under <a href="http://www.gnu.org/licenses/gpl-3.0.en.html" target="_blank">GPL V3</a>. By no means should anyone sell you this software.</p>
            <p class="completed-ins">If you would like custom features or enhancements that are not provided on this installation, or have a web project that you would like us to develop for you from scratch, here are a few ways to contact us:</p>
            <ul>
            	<li>Skype - IsVipiOfficial</li>
                <li>Email - project[at]isvipi.org</li>
                <li>Forum - <a href="http://forum.isvipi.org/" target="_blank">here</a></li>
                <li>Contact Form - <a href="http://isvipi.org/support" target="_blank">here</a></li>
            </ul>
            <p class="completed-ins">Looking forward to hearing from you.</p>
        </div>
        
        <?php } else {?>
        <div class="tab-pane">
        	<h3 class="titles">Oops!</h3>
            <p class="completed-ins">You appear lost. Should you really be here?</p>
        </div>
        <?php } ?>
        
	</div>
</div>
