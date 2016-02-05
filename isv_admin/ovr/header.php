<?php $admin = $track->admin_details($_SESSION['isv_admin_id']); ?>
  <body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

      <!-- Main Header -->
      <header class="main-header">

        <!-- Logo -->
        <a href="<?php echo ISVIPI_ACT_ADMIN_URL ?>" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><?php echo $isv_siteDetails['s_title'] ?></span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><?php echo $isv_siteDetails['s_title'] ?></span>
        </a>

        <!-- Header Navbar -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <!-- Navbar Right Menu -->
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <!-- Messages: style can be found in dropdown.less-->

              <!-- User Account Menu -->
              <li class="dropdown user user-menu">
                <!-- Menu Toggle Button -->
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <!-- hidden-xs hides the username on small devices so only the image appears. -->
                  <span class="hidden-xs"><?php echo $admin['name'] ?></span>
                </a>
                <ul class="dropdown-menu">
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-left">
                      <a href="<?php echo ISVIPI_ACT_ADMIN_URL .'admin_profile' ?>" class="btn btn-primary btn-flat">Profile</a>
                    </div>
                    <div class="pull-left" style="margin-left:20px">
                      <a href="<?php echo ISVIPI_ACT_ADMIN_URL .'support' ?>" class="btn btn-warning btn-flat">Help</a>
                    </div>
                    <div class="pull-right">
                      <a href="<?php echo ISVIPI_ACT_ADMIN_URL .'log_out' ?>" class="btn btn-danger btn-flat">Sign out</a>
                    </div>
                  </li>
                </ul>
              </li>
            </ul>
          </div>
        </nav>
      </header>
      <div class="admin_alerts">
      <?php if(isset($_SESSION['isv_success']) && !empty($_SESSION['isv_success'])){?>
      	<div class="alert alert-success alert-dismissable">
        	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
           	<h4> <i class="icon fa fa-check"></i> Alert!</h4>
            	<?php echo $_SESSION['isv_success']; unset($_SESSION['isv_success']); ?>
       	</div>
      <?php } else if(isset($_SESSION['isv_error']) || !empty($_SESSION['isv_error'])){?>
      	<div class="alert alert-danger alert-dismissable">
        	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
           	<h4><i class="icon fa fa-ban"></i> Alert!</h4>
            	<?php echo $_SESSION['isv_error']; unset($_SESSION['isv_error']); ?>
      	</div>
      <?php } ?>
      </div>
      