           <!-- top navigation -->
            <div class="top_nav">
            	<?php $admin = $track->admin_details($_SESSION['isv_admin_id']); ?>
                <div class="nav_menu">
                    <nav class="" role="navigation">
                        <div class="nav toggle">
                            <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                        </div>
                        
                        <ul class="nav navbar-nav navbar-right">
                            <li class="admin_bar_menu">
                                <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                    <?php echo $admin['name'] ?>
                                    <span class=" fa fa-angle-down"></span>
                                </a>
                                <ul class="dropdown-menu dropdown-usermenu animated fadeInDown pull-right">
                                    <li><a href="<?php echo ISVIPI_ACT_ADMIN_URL .'admin_profile' ?>">  Profile</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo ISVIPI_ACT_ADMIN_URL .'support' ?>">Help</a>
                                    </li>
                                    <li><a href="<?php echo ISVIPI_ACT_ADMIN_URL .'log_out' ?>"><i class="fa fa-sign-out pull-right"></i> Log Out</a>
                                    </li>
                                </ul>
                            </li>

                        </ul>
                    </nav>
                </div>

            </div>
            <!-- /top navigation -->
            <?php if(isset($_SESSION['isv_success']) && !empty($_SESSION['isv_success'])){?>
                <div class="alert alert-success succ-mod">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
                	<?php echo $_SESSION['isv_success']; unset($_SESSION['isv_success']); ?>
                </div>
            <?php } else if(isset($_SESSION['isv_error']) || !empty($_SESSION['isv_error'])){?>
                <div class="alert alert-success err-mod">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
                	<?php echo $_SESSION['isv_error']; unset($_SESSION['isv_error']); ?>
                </div>
            <?php } ?>