<!-- settins -->
<h2 class="profile-header"><?php echo SETTINGS ?></h2>
<hr/>
<div class="col-md-5 well" style="margin:5px">
	<div class="list-group">
    	<li class="list-group-item bg-teal-gradient" style="font-size:16px; font-weight:700"><?php echo PERSONAL_SETT ?></li>
      	<li class="list-group-item">
        <?php getPersonalSettings($_SESSION['user_id'])?>
        <form action="<?php echo ISVIPI_URL.'users/userSettings'?>" method="POST">
        	<div class="checkbox">
                <label>
                <input type="checkbox" name="view_profile" value="1" <?php if ($view_profile == 1){echo 'checked';}?>> 
                	<?php echo FRIENDS_ONLY_PROFILE ?>
                </label>
            </div>
            <div class="checkbox">
                <label>
                <input type="checkbox" name="act_timeline" value="1" <?php if ($act_timeline == 1){echo 'checked';}?>> 
                	<?php echo FRIENDS_ONLY_COMMENT ?>
                </label>
            </div>
            <input type="hidden" name="p_settings" value="yes">
           	<input type="submit" class="btn btn-primary" value="Save" style="font-size:12px; padding:5px;">
        </form>
        </li>
    </div>
</div>
<div class="col-md-5 well" style="margin:5px 50px">
	<div class="list-group">
    	<li class="list-group-item bg-blue-gradient" style="font-size:16px; font-weight:700"><?php echo SECURITY_SETT ?></li>
      	<li class="list-group-item">
        <form class="c_pass" id="userPassword" action="<?php echo ISVIPI_USER_PROCESS; ?>" method="POST">
        	<input type="hidden" name="op" value="change">
           	<input type="hidden" name="user" value="<?php echo $username?>">
           	<div class="form-group">
         	<input type="password" class="form-control" name="newpass" placeholder="<?php echo NEW_PASS ?>">
          	</div>
          	<div class="form-group">
         	<input type="password" class="form-control" name="newpass2" placeholder="<?php echo REP_NEW_PASS ?>">
           	</div>
         	<button type="submit" class="btn btn-primary"><?php echo CHANGE_PASS ?></button>
         	</form>
        </li>
    </div>
</div>
<div class="clear"></div>
<!-- ./settings -->                               