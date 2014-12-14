<?php
/*
Theme Name: Default
Theme URL: http://isvipi.com
Description: Default IsVipi Theme
Version: 1.1.0
Author: IsVipi
Author URL: http://isvipi.com
*/
get_home_header();
if ($sysCron=="1"){
tenMinsCron();
}
?>
<div class="home_content">
    <div class="home_welcome">
	    <h1><?php echo MEET_NEW_PEOPLE ?></h1>
    </div>
    <div class="home_register">
      <form method="post" action="<?php echo ISVIPI_USER_PROCESS; ?>" class="login-form" id="regForm">
        <input type="hidden" name="op" value="new">
      <h3><?php echo CREATE_NEW_ACCOUNT ?></h3>
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
        <select name="user_gender" class="form-control" required="required">
           <option selected="selected"><?php echo MALE ?></option>
           <option><?php echo FEMALE ?></option>
        </select>
      </div>
      <div class="form-group">
      	<div class="dob">
            <input class="form-control" type="text" name="month" placeholder="mm" >/
            <input class="form-control" type="text" name="day" placeholder="dd" >/
            <input class="form-control" type="text" name="year" placeholder="yyyy" >        
    		<span class="label label-info"><?php echo DOB ?></span>
        </div>
      </div>
      <div class="form-group">
        <input class="form-control" type="text" name="user_city" placeholder="<?php echo CITY ?>" required="required">
      </div>
      <div class="form-group">
        <?php cSelect();?>
      </div>
      <?php getAdminGenSett(); if ($usrReg == "1"){?>
      <button class="btn btn-lg btn-primary" type="submit" disabled="disabled"><?php echo REG_DISABLED ?></button>
      <?php } else {?>
        <button class="btn btn-lg btn-primary" type="submit" ><?php echo REGISTER ?></button>
        <?php }?>
       <div class="alert" id="notice" style="margin-top:5px; padding:5px; color:#03F;font-size:13px; font-weight:700; display:none; background:#FF9; max-width:360px"></div> 
     </form>
     
     
     </div>
     
</div>

<?php get_home_footer()?>