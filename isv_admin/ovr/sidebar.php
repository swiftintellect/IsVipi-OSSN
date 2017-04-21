      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">

        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">

          <!-- Sidebar Menu -->
          <ul class="sidebar-menu">
          	<li class="header">MENU</li>
            <!-- Optionally, you can add icons to the links -->
            <li <?php if ($PAGE[1] === 'dashboard'){?> class="active" <?php } ?>>
            	<a href="<?php echo ISVIPI_ACT_ADMIN_URL.'dashboard' ?>">
                	<i class="fa fa-home"></i> <span>Dashboard</span>
                </a>
            </li>
            <li class="treeview <?php if ($PAGE[1] == 'general_settings' || $PAGE[1] == 'display_settings' || $PAGE[1] == 'security_settings' || $PAGE[1] == 'member_settings' || $PAGE[1] == 'feed_settings'){?> active <?php } ?>">
              <a href="#">
              	<i class="fa fa-wrench"></i> <span>Settings</span> <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li <?php if ($PAGE[1] == 'general_settings'){?>class="active" <?php } ?>>
                	<a href="<?php echo ISVIPI_ACT_ADMIN_URL .'general_settings' ?>">General Settings</a>
                </li>
                <li <?php if ($PAGE[1] == 'display_settings'){?>class="active" <?php } ?>>
                	<a href="<?php echo ISVIPI_ACT_ADMIN_URL .'display_settings' ?>">Display Settings</a>
                </li>
                <li <?php if ($PAGE[1] == 'security_settings'){?>class="active" <?php } ?>>
                	<a href="<?php echo ISVIPI_ACT_ADMIN_URL .'security_settings' ?>">Security Settings</a>
                </li>
                <li <?php if ($PAGE[1] == 'member_settings'){?>class="active" <?php } ?>>
                	<a href="<?php echo ISVIPI_ACT_ADMIN_URL .'member_settings' ?>">Member Settings</a>
                </li>
                <li <?php if ($PAGE[1] == 'feed_settings'){?>class="active" <?php } ?>>
                	<a href="<?php echo ISVIPI_ACT_ADMIN_URL .'feed_settings' ?>">Feeds Settings</a>
                </li>
              </ul>
            </li>
            
            <li class="treeview <?php if ($PAGE[1] === 'members' || $PAGE[1] === 'add_new' || $PAGE[1] === 'edit' || $PAGE[1] === 'search'){?> active <?php } ?>">
              <a href="#">
              	<i class="fa fa-users"></i> <span>Members</span> <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="<?php echo ISVIPI_ACT_ADMIN_URL .'members' ?>">Members</a></li>
                <li><a href="<?php echo ISVIPI_ACT_ADMIN_URL .'add_new' ?>">Add New</a></li>
              </ul>
            </li>
            
            <li class="treeview <?php if ($PAGE[1] === 'admin_profile'){?> active <?php } ?>">
              <a href="#">
              	<i class="fa fa-user-secret"></i> <span>Administrators</span> <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li <?php if ($PAGE[1] == 'admin_profile'){?>class="active" <?php } ?>><a href="<?php echo ISVIPI_ACT_ADMIN_URL .'admin_profile' ?>">Edit Profile</a></li>
              </ul>
            </li>
            
            <li class="treeview <?php if ($PAGE[1] === 'admin_news' || $PAGE[1] === 'admin_emails'){?> active <?php } ?>">
              <a href="#">
              	<i class="fa fa-bullhorn"></i> <span>Communications</span> <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li <?php if ($PAGE[1] == 'admin_news'){?>class="active" <?php } ?>><a href="<?php echo ISVIPI_ACT_ADMIN_URL .'admin_news' ?>">News & Announcements</a></li>
                <li <?php if ($PAGE[1] == 'admin_emails'){?>class="active" <?php } ?>><a href="<?php echo ISVIPI_ACT_ADMIN_URL .'admin_emails' ?>">Emails</a></li>
              </ul>
            </li>
            
            <li class="treeview <?php if ($PAGE[1] === 'credits' || $PAGE[1] === 'support'){?> active <?php } ?>">
              <a href="#">
              	<i class="fa fa-question-circle"></i> <span>Help/Support</span> <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li <?php if ($PAGE[1] == 'credits'){?>class="active" <?php } ?>><a href="<?php echo ISVIPI_ACT_ADMIN_URL .'credits' ?>">Credits</a></li>
                <li <?php if ($PAGE[1] == 'support'){?>class="active" <?php } ?>><a href="<?php echo ISVIPI_ACT_ADMIN_URL.'support' ?>">Help/Support</a></li>
              </ul>
            </li>
            <div class="clearfix"></div>
            <li class="bg-black">
            	<a href="<?php echo ISVIPI_ACT_ADMIN_URL .'log_out' ?>">
                	<span><i class="fa fa-sign-out"></i> Sign Out</span>
                </a>
            </li>
            
            
          </ul><!-- /.sidebar-menu -->
        </section>
        <!-- /.sidebar -->
      </aside>
