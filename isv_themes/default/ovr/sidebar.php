      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">

        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">

          <!-- Sidebar user panel (optional) -->
          <div class="user-panel">
            <div class="pull-left image">
            <img src="<?php echo user_pic($memberinfo['profile_pic']) ?>" class="img-square" alt="Profile Picture <?php echo $memberinfo['full_name'] ?>">
            </div>
            <div class="pull-left info">
              <p><?php echo $memberinfo['full_name'] ?></p>
              <!-- Status -->
              <a href="<?php echo ISVIPI_URL .'profile/'.$memberinfo['username'] ?>"><i class="fa fa-pencil-square-o"></i> Edit Profile</a>
            </div>
          </div>
			<hr style="margin:10px 0 0 0;" />
          <!-- Sidebar Menu -->
          <ul class="sidebar-menu" style="margin-left:30px;">
            <li <?php if ($PAGE['0'] === "home"){?> class="active" <?php } ?>>
            	<a href="<?php echo ISVIPI_URL .'home/' ?>"><i class="fa fa-feed"></i> <span>News Feed</span></a>
            </li>
            <li>
            	<a href="#"><i class="fa fa-envelope-o"></i> <span>Messages</span></a>
            </li>
            <li <?php if ($PAGE['0'] === "friends"){?> class="active" <?php } ?>>
            	<a href="<?php echo ISVIPI_URL .'friends/' ?>"><i class="fa fa-users"></i> <span>Friends</span></a>
            </li>
            <li <?php if ($PAGE['0'] === "members"){?> class="active" <?php } ?>>
            	<a href="<?php echo ISVIPI_URL .'members/' ?>"><i class="fa fa-search"></i> <span>Browse</span></a>
            </li>
          </ul><!-- /.sidebar-menu -->
        </section>
        <!-- /.sidebar -->
      </aside>
