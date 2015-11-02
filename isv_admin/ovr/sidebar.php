<body class="nav-md">

    <div class="container body">

        <div class="main_container">

            <div class="col-md-3 left_col" >
                <div class="left_col scroll-view">

                    <div class="navbar nav_title" style="border: 0;">
                        <a href="<?php echo ISVIPI_ACT_ADMIN_URL ?>" class="site_title">
                        	<?php echo $isv_siteDetails['s_title'] ?>
                        </a>
                    </div>
                    <div class="clearfix"></div>

                    <!-- sidebar menu -->
                    <div id="sidebar-menu" class="">

                        <div class="menu_section">
                            <ul class="nav side-menu">
                            	<li <?php if ($PAGE[1] === 'dashboard'){?> class="active" <?php } ?>>
                                	<a href="<?php echo ISVIPI_ACT_ADMIN_URL ?>"><i class="fa fa fa-home"></i> Home</a>
                                </li>
                                
                                <li <?php if ($PAGE[1] === 'members' || $PAGE[1] === 'add_new' || $PAGE[1] === 'edit' || $PAGE[1] === 'search'){?> class="active" <?php } ?>>
                                <a><i class="fa fa-users"></i> Members <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu no-display
                                    <?php if ($PAGE[1] === 'members' || $PAGE[1] === 'add_new'){?> 
									drop-it
									<?php } ?>
                                    ">
                                        <li <?php if ($PAGE[1] === 'members'){?> class="current-page" <?php } ?>>
                                        	<a href="<?php echo ISVIPI_ACT_ADMIN_URL .'members' ?>">Members</a>
                                        </li>
                                        <li><a href="<?php echo ISVIPI_ACT_ADMIN_URL .'add_new' ?>">Add New</a>
                                    </ul>
                                </li>
                                <li <?php if ($PAGE[1] === 'blank' || $PAGE[1] === 'sett'){?> class="active current-page" <?php } ?>>
                                <a><i class="fa fa-cog"></i> Settings <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu no-display 
									<?php if ($PAGE[1] === 'blank' || $PAGE[1] === 'sett'){?> 
									drop-it
									<?php } ?>
                                    ">
                                        <li <?php if ($PAGE[1] === 'blank'){?> class="current-page" <?php } ?>>
                                        	<a href="<?php echo ISVIPI_ACT_ADMIN_URL .'blank' ?>">General</a>
                                        </li>
                                        <li>
                                        	<a href="<?php echo ISVIPI_ACT_ADMIN_URL .'' ?>">Users</a>
                                        </li>
                                        <li>
                                        	<a href="<?php echo ISVIPI_ACT_ADMIN_URL .'' ?>">Appearance</a>
                                        </li>
                                    </ul>
                                </li>
                                <li><a><i class="fa fa-envelope"></i> Mailing <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu no-display">
                                        <li>
                                        	<a href="<?php echo ISVIPI_ACT_ADMIN_URL .'' ?>">Newsletter</a>
                                        </li>
                                        <li>
                                        	<a href="<?php echo ISVIPI_ACT_ADMIN_URL .'' ?>">Email Member</a>
                                        </li>
                                        <li>
                                        	<a href="<?php echo ISVIPI_ACT_ADMIN_URL .'' ?>">Sent Messages</a>
                                        </li>
                                    </ul>
                                </li>
                                <li><a><i class="fa fa-user-secret"></i> Administrators <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu no-display">
                                        <li><a href="<?php echo ISVIPI_ACT_ADMIN_URL .'' ?>">View All</a>
                                        </li>
                                        <li><a href="<?php echo ISVIPI_ACT_ADMIN_URL .'' ?>">Add Admin</a>
                                        </li>
                                    </ul>
                                </li>
                                <li <?php if ($PAGE[1] === 'credits' || $PAGE[1] === 'report_bug' || $PAGE[1] === 'support'){?> class="active" <?php } ?>>
                                <a><i class="fa fa-header"></i> Help/Support <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu no-display
                                    <?php if ($PAGE[1] === 'credits' || $PAGE[1] === 'report_bug' || $PAGE[1] === 'support'){?> 
									drop-it
									<?php } ?>
                                    ">
                                        <li <?php if ($PAGE[1] === 'credits'){?> class="current-page" <?php } ?>>
                                        	<a href="<?php echo ISVIPI_ACT_ADMIN_URL .'credits/' ?>">Credits</a>
                                        </li>
                                        <li <?php if ($PAGE[1] === 'report_bug'){?> class="current-page" <?php } ?>>
                                        	<a href="<?php echo ISVIPI_ACT_ADMIN_URL .'report_bug/' ?>">Report Bug</a>
                                        </li>
                                        <li <?php if ($PAGE[1] === 'support'){?> class="current-page" <?php } ?>>
                                        	<a href="<?php echo ISVIPI_ACT_ADMIN_URL .'support/' ?>">Request Customization</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- /sidebar menu -->
                    
                    <!-- /menu footer buttons -->
                    <div class="sidebar-footer hidden-small">
                        <a data-toggle="tooltip" data-placement="top" title="Settings">
                            <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                        </a>
                        <a href="<?php echo ISVIPI_ACT_ADMIN_URL .'members' ?>" data-toggle="tooltip" data-placement="top" title="Members">
                            <span class="fa fa-users" aria-hidden="true"></span>
                        </a>
                        <a data-toggle="tooltip" data-placement="top" title="Maintenance Mode">
                            <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
                        </a>
                        <a href="<?php echo ISVIPI_ACT_ADMIN_URL .'log_out' ?>" data-toggle="tooltip" data-placement="top" title="Logout">
                            <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
                        </a>
                    </div>
                    <!-- /menu footer buttons -->
                </div>
            </div>
