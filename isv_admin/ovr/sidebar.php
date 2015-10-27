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
                    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">

                        <div class="menu_section">
                            <ul class="nav side-menu">
                            	<li class="active-sm">
                                	<a href="<?php echo ISVIPI_ACT_ADMIN_URL ?>"><i class="fa fa fa-home"></i> Home</a>
                                </li>
                                <li><a><i class="fa fa-users"></i> Members <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu" style="display: none">
                                        <li><a href="<?php echo ISVIPI_ACT_ADMIN_URL .'' ?>">Members</a>
                                        </li>
                                        <li><a href="<?php echo ISVIPI_ACT_ADMIN_URL .'' ?>">Add New</a>
                                    </ul>
                                </li>
                                <li><a><i class="fa fa-cog"></i> Settings <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu" style="display: none">
                                        <li>
                                        	<a href="<?php echo ISVIPI_ACT_ADMIN_URL .'' ?>">General</a>
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
                                    <ul class="nav child_menu" style="display: none">
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
                                    <ul class="nav child_menu" style="display: none">
                                        <li><a href="<?php echo ISVIPI_ACT_ADMIN_URL .'' ?>">View All</a>
                                        </li>
                                        <li><a href="<?php echo ISVIPI_ACT_ADMIN_URL .'' ?>">Add Admin</a>
                                        </li>
                                    </ul>
                                </li>
                                <li><a><i class="fa fa-bar-chart-o"></i> Help/Support <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu" style="display: none">
                                        <li>
                                        	<a href="<?php echo ISVIPI_ACT_ADMIN_URL .'' ?>">Credit</a>
                                        </li>
                                        <li>
                                        	<a href="<?php echo ISVIPI_ACT_ADMIN_URL .'' ?>">Report Bug</a>
                                        </li>
                                        <li>
                                        	<a href="<?php echo ISVIPI_ACT_ADMIN_URL .'' ?>">Request Customization</a>
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
                        <a data-toggle="tooltip" data-placement="top" title="Members">
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
