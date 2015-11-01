<?php  require_once(ISVIPI_ADMIN_BASE .'ovr/head.php'); 
	
	if(!isset($_SERVER['HTTP_REFERER'])){
		$from_url = ISVIPI_ACT_ADMIN_URL.'members/';
	} else {
		$from_url = $_SERVER['HTTP_REFERER'];
	}
	
	$username = cleanGET($PAGE[2]);
	$username = $converter->decode($username);
	
	//check if user exists and get user id
	global $user_id;
	if(!id_from_username($username)){
		 $_SESSION['isv_error'] = 'No such user found. Please try again';
		 header('location:'.$from_url.'');
		 exit();
	}
	
	//instantiate our get member class
	require_once(ISVIPI_ADMIN_CLS_BASE .'get_members.cls.php'); 
	$member = new get_single_member();
	
	//get user's full name
	$fullname = full_name_from_id($user_id);
	require_once(ISVIPI_ADMIN_BASE .'ovr/sidebar.php');
	require_once(ISVIPI_ADMIN_BASE .'ovr/header.php') 
?>
<!-- page content -->
<div class="right_col" role="main">
	<div class="page-title">
    	<div class="title_left">
        	<h3>Edit <?php echo $fullname ?></h3>
        </div>
        <div class="title_right">
    
    	</div>
    </div>
    <div class="clearfix"></div>
    <div class="row min-height"><!-- row -->
    	
        <div class="col-md-6 col-sm-6 col-xs-12"><!-- col-md-6 -->
        	<div class="x_panel">
          	<h3 class="cred_title">Developers</h3>
            <p><strong>Jones Baraza</strong> - He is the Founder, Project Manager and Co-ordinator of IsVipi OSSN.</p>
            

			</div>
		</div><!-- end::col-md-6 -->
        
        <div class="col-md-6 col-sm-6 col-xs-12"><!-- col-md-6 -->
        	<div class="x_panel">
          	<h3 class="cred_title">Developers</h3>
            <p><strong>Jones Baraza</strong> - He is the Founder, Project Manager and Co-ordinator of IsVipi OSSN.</p>
            

			</div>
		</div><!-- end::col-md-6 -->
        
        
	</div><!-- end::row -->

<?php require_once(ISVIPI_ADMIN_BASE .'ovr/footer.php') ?>