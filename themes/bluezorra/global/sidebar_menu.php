<?php 	sideBarUserDet($_SESSION['user_id']);
		GetUsernameOnly($_SESSION['user_id']);
		global $ACTION,$s_name,$s_gender,$s_age,$s_city,$s_country,$s_thumbnail,$usrname;
?>
<!-- Left side column. contains the logo and sidebar -->
            <aside class="left-side-bar">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel -->
                    <div class="user-panel">
                    <?php if(empty($s_thumbnail)&& $s_gender == "Male"){
						$s_thumbnail="m_.png";
						}else if(empty($s_thumbnail)&& $s_gender == "Female"){
						$s_thumbnail="f_.png";	
					}?>
                        <div class="pull-left image">
                            <img src="<?php echo ISVIPI_PROFILE_PIC_URL.ISVIPI_THUMB_100.$s_thumbnail ?>" class="img-square" />
                        </div>
                        <div class="pull-left info">
                            <p>
                                <a href="<?php echo ISVIPI_URL.'profile/'.$usrname ?>" style="color:#06F">
                                <?php echo $usrname ?>
                                </a>
                            </p>
                            <?php echo $s_city.", ".$s_country ?>
                        </div>
                    </div>

                    <ul class="sidebar-menu">
                        <li <?php if ($ACTION[0]=="home"){echo "class='active'";}?>>
                            <a href="<?php echo ISVIPI_URL.'home/' ?>">
                                <i class="fa fa-dashboard"></i> <span><?php echo DASHBOARD ?></span>
                            </a>
                        </li>
                        <li <?php if ($ACTION[0]=="profile" && isset($ACTION[2]) && $ACTION[2]=="friends"){echo "class='active'";}?>>
                            <a href="<?php echo ISVIPI_URL.'profile/'.$usrname.'/friends' ?>">
                                <i class="fa fa-users"></i> <span><?php echo MY_FRIENDS ?></span>
                            </a>
                        </li>
                        <li <?php if ($ACTION[0]=="messages"){echo "class='active'";}?>>
                            <a href="<?php echo ISVIPI_URL.'messages/' ?>">
                                <i class="fa fa-envelope-o"></i> <span><?php echo MY_MESSAGES ?></span>
                            </a>
                        </li>
                        <li <?php if ($ACTION[0]=="memberlist"){echo "class='active'";}?>>
                            <a href="<?php echo ISVIPI_URL.'memberlist/' ?>">
                                <i class="fa fa-users"></i> <span><?php echo BROWSE_MEMBERS ?></span>
                            </a>
                        </li>
                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>
