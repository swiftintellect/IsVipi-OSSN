<?php if(!$friends->blocked_users($_SESSION['isv_user_id'],$m_info['m_user_id'])){?>
<!-- About Me Box -->
<div class="box box-primary">
	<div class="box-header with-border">
    	<h3 class="box-title">About</h3>
  	</div><!-- /.box-header -->
   	<div class="box-body">
    <?php if(empty($m_info['m_rel_status'])){
		$relStatus = '';
	} else {
		$relStatus = ' - ' .$m_info['m_rel_status'];
	}?>
  	<strong><i class="fa fa-file-text-o margin-r-5"></i> Gender (Age):</strong>
    <?php echo ucfirst($m_info['m_gender']) ?> (<?php echo age($m_info['m_dob']).$relStatus ?>)
                             
	<?php if(
						   
		($_SESSION['isv_user_id'] === $m_info['m_user_id']) /* if owner */ ||
		($_SESSION['isv_user_id'] !== $m_info['m_user_id'] && $m_info['m_phone_settings'] === 2) /* everyone */||
		($_SESSION['isv_user_id'] !== $m_info['m_user_id'] && $m_info['m_phone_settings'] === 1 
		&& $friends->are_friends($_SESSION['isv_user_id'],$m_info['m_user_id'])) ||
		$admin->admin_logged_in()

	){?>
   	<hr style="margin:5px 0">
   	<strong><i class="fa fa-phone margin-r-5"></i>  Phone</strong> <?php echo $m_info['m_phone'] ?>
                           
	<?php } ?>
 	<hr style="margin:5px 0">
  	<strong><i class="fa fa-map-marker margin-r-5"></i> Location</strong>
  	<?php 
		if(empty($m_info['m_city'])){
			$city = '';
		} else {
			$city = $m_info['m_city']. ', ';
		}
	?>
 	<span class="text-muted"><?php echo $city.$m_info['m_country'] ?></span>
  	<hr style="margin:5px 0">
            
  	<strong><i class="fa fa-file-text-o margin-r-5"></i> Hobbies</strong>
  	<span class="text-muted"><?php echo $m_info['m_hobbies'] ?></span>
    </div><!-- /.box-body -->
</div><!-- /.box -->
<!-- end::About Me Box -->
<?php } ?>