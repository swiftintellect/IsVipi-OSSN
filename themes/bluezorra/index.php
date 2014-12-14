<?php get_header(); ?>
        <div class="index-container"><!-- index-container -->
        	<h2 class="home-welcome"><?php echo MEET_NEW_PEOPLE ?></h2>
            <!-- our latest members -->
            <div class="latest-users pull-left">
            <div class="new-ms">
                  <img src="<?php echo ISVIPI_THEME_URL ?>style/img/banner.jpg"/>
            </div>
            <hr class="home-hr"/>
            <div class="new-ms">
            <!-- if we cannot get a country from the GeoIP services, we assign a default country-->
			<?php if (!isset($countryName) || (empty($countryName))){
				$ipCountry = "Kenya";
			} else {
				$ipCountry = $countryName;
			}
				getMembersFrom($ipCountry);
			?>
            <h3 class="latest-joined"><?php echo N_CHECKOUT_MEMBERS." <span>$ipCountry</span>" ?></h3>
            	<?php while ($getMcountry->fetch()){
					getUserDetails($userC_ID);
					?>
                <div class="col-xs-6 col-md-3">
                <!-- if there is no image to display, we load the predefined ones-->
                <?php if(empty($userC_thumbnail)&& $userC_gender == "Male"){
						$userC_thumbnail="m_.png";
					}else if(empty($userC_thumbnail)&& $userC_gender == "Female"){
						$userC_thumbnail="f_.png";	
					}?>
                <a href="<?php echo ISVIPI_URL.'profile/'.$username?>" class="thumbnail" id="tooltipbg" data-toggle="tooltip" data-placement="bottom" data-html="true" title="<?php echo $username.'&#013;'.$userC_city.', '.$ipCountry ?>">
                  <img src="<?php echo ISVIPI_PROFILE_PIC_URL.ISVIPI_THUMB_150.htmlspecialchars($userC_thumbnail, ENT_QUOTES, 'utf-8');?>" alt=""/>
                </a>
              	</div>
                <?php } ?>
                
                </div>
            </div>
            
            <!-- sign up form -->
            <div class="index-signup pull-left">
            <h2 class="home-welcome" style="margin-bottom:10px;"><?php echo CREATE_NEW_ACCOUNT ?></h2>
            <form method="post" action="<?php echo ISVIPI_USER_PROCESS; ?>" class="login-form" id="regForm">
        	  <input type="hidden" name="op" value="new">
              <div class="form-group">
                <input class="form-control" type="text" name="user" placeholder="<?php echo USERNAME ?>" required="required">
              </div>
              <div class="form-group">
                <input class="form-control" type="text" name="d_name" placeholder="<?php echo DISPLAY_NAME ?>" required="required">
              </div>
              <div class="form-group">
                <input class="form-control" type="email" name="email" placeholder="<?php echo EMAIL ?>" required="required">
              </div>
              <div class="form-group">
                <input class="form-control" type="password" name="pass" placeholder="<?php echo PASSWORD ?>" required="required">
              </div>
              <div class="form-group">
                <input class="form-control" type="password" name="pass2" placeholder="<?php echo REPEAT_PASSWORD ?>" required="required">
              </div>
              <div class="form-group">
                <select name="user_gender" class="form-control" required>
                   <option selected="selected"><?php echo MALE ?></option>
                   <option><?php echo FEMALE ?></option>
                </select>
              </div>
              <div class="form-group">
                <input class="form-control" type="text" name="user_city" placeholder="<?php echo CITY ?>" required="required">
              </div>
              <div class="form-group">
                <?php cSelect();?>
              </div>
              <?php getAdminGenSett(); if ($usrReg == "1"){?>
      			<button class="btn btn-block btn-primary" type="submit" disabled="disabled"><?php echo REG_DISABLED ?></button>
      		  <?php } else {?>
        		<button class="btn btn-block btn-primary" type="submit" ><?php echo REGISTER ?></button>
        	  <?php }?>
       			<!-- all registration related notifications will be displayed below-->
                <div id="notice" class="alert-message notification" style="margin-top:5px; display:none"> 
            	</div>
     		</form>
            </div>
            <div class="clear"></div>
        </div><!-- ./index-container -->
        <div class="clear"></div>
<?php get_footer(); ?>