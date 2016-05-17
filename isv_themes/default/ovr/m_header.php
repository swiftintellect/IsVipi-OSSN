<body class="hold-transition skin-blue sidebar-mini" style="margin-top:-20px;">
<div class="wrapper">
      <!-- Main Header -->
      <header class="main-header">
        <!-- Logo -->
        <a href="<?php echo ISVIPI_URL .'home/' ?>" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><?php echo $isv_siteDetails['s_title'] ?></span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><img src="<?php echo ISVIPI_STYLE_URL . 'site/imgs/'.$isv_siteSettings['logo'] ?>" alt="logo" height="47"></span>
        </a>
		
        <!-- Header Navbar -->
        <nav class="navbar navbar-fixed-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only"><?php echo ucwords($lang->translate('toggle_navigation')) ?></span>
          </a>
          <?php if(isset($PAGE[0]) && $PAGE[0] === 'search' && isset($PAGE[1]) && !empty($PAGE[1])){
			  $st = $PAGE[1];
		  } else {
			  $st = '';
		  }?>
          <?php if(!$admin->admin_logged_in()){?>
          <form action="<?php echo ISVIPI_URL .'p/search/' ?>" method="post" class="search-form">
            <div class="input-group">
              <input type="text" name="term" class="form-control" value="<?php echo $st ?>" placeholder="<?php echo ucwords($lang->translate('name_or_username')) ?>" required>
              <span class="input-group-btn">
              	<input type="hidden" name="isv_op" value="<?php echo $converter->encode('search') ?>" />
                <button type="submit" name="search" class="btn search-btn"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </form>
          <!-- /.search form -->
          <!-- Navbar Right Menu -->
          
          <div class="navbar-custom-menu">
          
            <ul class="nav navbar-nav pull-left" id="notifications">
            	<!-- load header notices (friend requests,messages,global notifications) -->
                <?php require_once(ISVIPI_ACT_THEME .'pages/notifications.php') ?>
                <script>
                	load_user_notices();
                </script>
            </ul>
          
            	<ul class="nav navbar-nav navbar-right user_header_drop">
                    <li class="dropdown">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-bars"></i><span class="caret"></span></a>
                      <ul class="dropdown-menu">
                        <li><a href="<?php echo ISVIPI_URL .'profile/'.$memberinfo['username'].'/edit/' ?>"><?php echo ucwords($lang->translate('edit_profile')) ?></a></li>
                        <li><a href="<?php echo ISVIPI_URL .'profile/'.$memberinfo['username'].'/settings/' ?>"><?php echo ucwords($lang->translate('account_settings')) ?></a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="<?php echo ISVIPI_URL .'log_out/' ?>"><?php echo ucwords($lang->translate('logout')) ?></a></li>
                      </ul>
                    </li>
                  </ul>

          </div>
          <?php } ?>
        </nav>
        
      </header>
      
      
      <!-- our site notifications -->
      <?php if (isset($_SESSION['isv_error']) && !empty($_SESSION['isv_error'])){?>
      <div class="alert alert-danger alert-dismissable" id="global-alert">
      	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
   		<?php echo $_SESSION['isv_error']; unset($_SESSION['isv_error']); ?>
     </div>
     <?php } else if(isset($_SESSION['isv_success']) && !empty($_SESSION['isv_success'])){?>
     <div class="alert alert-success alert-dismissable" id="global-alert">
      	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
   		<?php echo $_SESSION['isv_success']; unset($_SESSION['isv_success']); ?>
     </div>
     <?php } ?>
     
	 <?php if ($admin->admin_logged_in()){ 
		$back_uri = ISVIPI_ACT_ADMIN_URL .'dashboard/';
	 ?>
     <div class="view-as-admin">
     	<?php echo ucwords($lang->translate('viewing_as_admin',array($back_uri))) ?>
     </div>
     <?php } ?>