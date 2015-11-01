<?php if ($_SESSION['isv_user_id'] !== $m_info['m_user_id']){?>
	<div class="col-md-12">
    	<li class="list-group-item">You are not allowed to view this page.</li>
	</div>
<?php } else { ?>
<div class="box box-widget" style="margin-top:-20px">
	<form action="<?php echo ISVIPI_URL .'p/member' ?>" method="post">
	<div class="box-header with-border">
   		<h3 class="box-title">Edit Profile</h3>
        <div class="box-tools pull-right">
       		<button type="submit" class="btn btn-success btn-flat">Save</button>
       	</div><!-- /.box-tools -->
   	</div><!-- /.box-header -->
	<div class='box-body'>
    
    <div class="box box-primary ">
    	<div class="box-header with-border">
       	<h3 class="box-title">Personal Details</h3>
       		<div class="box-tools pull-right">
           	<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
           	</div><!-- /.box-tools -->
       	</div><!-- /.box-header -->
      	<div class="box-body">
        	<div class="row">
                <div class="col-md-6">
                    <label for="full name">Full Name</label>
                    <input type="text" class="form-control" name="fname" value="<?php echo $m_info['m_fullname'] ?>">
                </div><!-- /.col-lg-6 -->
                <div class="col-md-6">
                    <label for="gender">Gender</label>
                    <div class="form-group">
                    <label class="radio-inline">
                      <input type="radio" name="gender" value="male" 
					  <?php if($m_info['m_gender'] === 'male') echo 'checked="checked"'; ?>> Male
                    </label>
                    <label class="radio-inline">
                      <input type="radio" name="gender" value="female" 
					  <?php if($m_info['m_gender'] === 'female') echo 'checked="checked"'; ?>> Female
                    </label>
                    </div>
                </div><!-- /.col-lg-6 -->
                
                
                <div class="col-md-6">
                	<?php $dob = explode_date($m_info['m_dob'], '-'); ?>
                	<label for="date of birth">Date of Birth (dd/mm/yyyy)</label>
                    <div class="clear"></div>
                    <div class="input-group prof-dob">
                      <span class="input-group-addon">Day</span>
                      <input type="text" class="form-control" name="dd" value="<?php echo $dob['dd'] ?>">
                    </div>
                    <div class="input-group prof-dob">
                      <span class="input-group-addon">Month</span>
                      <input type="text" class="form-control" name="mm" value="<?php echo $dob['mm'] ?>">
                    </div>
                    <div class="input-group prof-dob">
                      <span class="input-group-addon">Year</span>
                      <input type="text" class="form-control" name="yyyy" value="<?php echo $dob['yyyy'] ?>">
                    </div>
                </div>
                <div class="col-md-6">
                	<label for="phone number">Phone</label>
                    <input type="text" class="form-control" name="phone" value="<?php echo $m_info['m_phone'] ?>">
                </div>
            </div><!-- /.row -->
      	</div><!-- /.box-body -->
  	</div><!-- /.box -->
    
    <div class="box box-success collapsed-box">
    	<div class="box-header with-border" data-widget="collapse">
       	<h3 class="box-title">Location Details</h3>
       		<div class="box-tools pull-right">
           	<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
           	</div><!-- /.box-tools -->
       	</div><!-- /.box-header -->
      	<div class="box-body">
        	<div class="row">
                <div class="col-md-6">
                <label>Country</label>
                      <select class="form-control" name="country">
                        <?php memberCountry($m_info['m_country']) ?>
                      </select>
                </div><!-- /.col-lg-6 -->
                <div class="col-md-6">
                <label for="city">City</label>
                <input type="text" class="form-control" name="city" value="<?php echo $m_info['m_city'] ?>">
                </div><!-- /.col-lg-6 -->
            </div><!-- /.row -->
      	</div><!-- /.box-body -->
  	</div><!-- /.box -->
    
        <div class="box box-warning collapsed-box">
    	<div class="box-header with-border" data-widget="collapse">
       	<h3 class="box-title">Other Details</h3>
       		<div class="box-tools pull-right">
           	<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
           	</div><!-- /.box-tools -->
       	</div><!-- /.box-header -->
      	<div class="box-body">
        	<div class="row">
                <div class="col-md-6">
                <label>Relationship Status</label>
                      <select class="form-control" name="relnship">
                        <?php relOptions($m_info['m_rel_status']) ?>
                      </select>
                </div><!-- /.col-lg-6 -->
                <div class="col-md-6">
                <label for="hobbies">Hobbies</label>
                <input type="text" class="form-control" name="hobbies" value="<?php echo $m_info['m_hobbies'] ?>">
                </div><!-- /.col-lg-6 -->
            </div><!-- /.row -->
      	</div><!-- /.box-body -->
  	</div><!-- /.box -->
	<div class="box-tools pull-right">
    	<input type="hidden" name="isv_op" value="edit_prof" />
    	<button type="submit" class="btn btn-success btn-flat">Save</button>
    	</div><!-- /.box-tools -->
    <div class="clear"></div>
    
    
    </div>
    </form>
</div>
<?php } ?>