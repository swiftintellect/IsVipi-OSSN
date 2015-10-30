<?php require_once(ISVIPI_ADMIN_CLS_BASE .'stats.cls.php'); 
	$stats = new site_stats();
?>
<?php require_once(ISVIPI_ADMIN_BASE .'ovr/head.php') ?>
<?php require_once(ISVIPI_ADMIN_BASE .'ovr/sidebar.php') ?>
<?php require_once(ISVIPI_ADMIN_BASE .'ovr/header.php') ?>
        <!-- page content -->
            <div class="right_col" role="main">
            
            <!-- top tiles -->
                <div class="row tile_count">
                    <div class="animated flipInY col-md-2 col-sm-4 col-xs-4 tile_stats_count">
                        <div class="left"></div>
                        <div class="right">
                            <span class="count_top">New Members</span>
                            <div class="count"><?php echo $stats->user_count('all') ?></div>
                            <span class="count_bottom">last 30 days</span>
                        </div>
                    </div>
                    <div class="animated flipInY col-md-2 col-sm-4 col-xs-4 tile_stats_count">
                        <div class="left"></div>
                        <div class="right">
                            <span class="count_top">Activated Accounts</span>
                            <div class="count green"><?php echo $stats->user_count(1) ?></div>
                            <span class="count_bottom">last 30 days</span>
                        </div>
                    </div>
                    <div class="animated flipInY col-md-2 col-sm-4 col-xs-4 tile_stats_count">
                        <div class="left"></div>
                        <div class="right">
                            <span class="count_top">Inactive Accounts</span>
                            <div class="count red"><?php echo $stats->user_count(0) ?></div>
                            <span class="count_bottom">last 30 days</span>
                        </div>
                    </div>
                    <div class="animated flipInY col-md-2 col-sm-4 col-xs-4 tile_stats_count">
                        <div class="left"></div>
                        <div class="right">
                            <span class="count_top">Suspended Accounts </span>
                            <div class="count red"><?php echo $stats->user_count(2) ?></div>
                            <span class="count_bottom">last 30 days</span>
                        </div>
                    </div>
                    <div class="animated flipInY col-md-2 col-sm-4 col-xs-4 tile_stats_count">
                        <div class="left"></div>
                        <div class="right">
                            <span class="count_top">Male Members</span>
                            <div class="count"><?php echo $stats->member_types('male') ?></div>
                            <span class="count_bottom">all time</span>
                        </div>
                    </div>
                    <div class="animated flipInY col-md-2 col-sm-4 col-xs-4 tile_stats_count">
                        <div class="left"></div>
                        <div class="right">
                            <span class="count_top">Female Members</span>
                            <div class="count"><?php echo $stats->member_types('female') ?></div>
                            <span class="count_bottom">all time</span>
                        </div>
                    </div>

                </div>
                <!-- /top tiles -->
                <div class="">

                    <div class="row">
                      
                      <div class="col-md-4 col-sm-4 col-xs-12">
                        <div class="x_panel tile fixed_height_320">
                            <div class="x_title">
                                <h2>Quick Links</h2>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <div class="dashboard-widget-content">
                                    <ul class="quick-list">
                                        <li><i class="fa fa-group"></i><a href="#">All Members</a>
                                        </li>
                                        <li><i class="fa fa-user-plus"></i><a href="#">Add Member</a>
                                        </li>
                                        <li><i class="fa fa-cogs"></i><a href="#">Site Settings</a> </li>
                                        <li><i class="fa fa-envelope"></i><a href="#">Newsletter</a>
                                        </li>
                                        <li><i class="fa fa-user-secret"></i><a href="#">Administrators</a>
                                        </li>
                                        <li><i class="fa fa-sign-out"></i><a href="#">Logout</a>
                                        </li>
                                    </ul>

                                    <div class="sidebar-widget">
                                        <h4>Site Version</h4>
                                        <p class="s_version"><?php echo ISV_VERSION ?></p>
                                        <div class="goal-wrapper">
                                        	<?php if($isv_siteSettings['upd_avail'] === 1){ ?>
                                            <a href="" class="btn btn-success btn-sm bt">update available</a>
                                            <?php } else {?>
                                            <span class="s_version_fl">up to date</span>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    
                                    <?php if(install_folder_exists()){?>
                                    <div class="bg-red sec-error">
                                    	Please delete <strong>isv_install/</strong> folder and its content! This poses a security risk.
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    
                      <div class="col-md-4 col-sm-4 col-xs-12">
                        <div class="x_panel tile fixed_height_320">
                        <?php $feed = $stats->feed_stats(); 
							  $feedpc = $feed['all_feeds'] / $feed['total'] * 100;
							  $likespc = $feed['all_likes'] / $feed['total'] * 100;
							  $commpc = $feed['all_comments'] / $feed['total'] * 100;
							  $sharepc = $feed['all_shares'] / $feed['total'] * 100;
							  $commlikespc = $feed['all_comm_likes'] / $feed['total'] * 100;
						?>
                            <div class="x_title">
                                <h2>Timeline Feeds Stats</h2>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <div class="widget_summary">
                                    <div class="w_left w_25">
                                        <span>All Feeds</span>
                                    </div>
                                    <div class="w_center w_55">
                                        <div class="progress">
                                            <div class="progress-bar bg-green" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $feedpc ?>%;">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="w_right w_20">
                                        <span><?php echo $feed['all_feeds'] ?></span>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>

                                <div class="widget_summary">
                                    <div class="w_left w_25">
                                        <span>Likes</span>
                                    </div>
                                    <div class="w_center w_55">
                                        <div class="progress">
                                            <div class="progress-bar bg-green" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $likespc ?>%;">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="w_right w_20">
                                        <span><?php echo $feed['all_likes'] ?></span>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="widget_summary">
                                    <div class="w_left w_25">
                                        <span>Comments</span>
                                    </div>
                                    <div class="w_center w_55">
                                        <div class="progress">
                                            <div class="progress-bar bg-green" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $commpc ?>%;">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="w_right w_20">
                                        <span><?php echo $feed['all_comments'] ?></span>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="widget_summary">
                                    <div class="w_left w_25">
                                        <span>Shares</span>
                                    </div>
                                    <div class="w_center w_55">
                                        <div class="progress">
                                            <div class="progress-bar bg-green" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $sharepc ?>%;">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="w_right w_20">
                                        <span><?php echo $feed['all_shares'] ?></span>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="widget_summary">
                                    <div class="w_left w_25">
                                        <span>Comment Likes</span>
                                    </div>
                                    <div class="w_center w_55">
                                        <div class="progress">
                                            <div class="progress-bar bg-green" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $commlikespc ?>%;">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="w_right w_20">
                                        <span><?php echo $feed['all_comm_likes'] ?></span>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>

                            </div>
                        </div>
                    </div>
                    
                    
                    
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <div class="x_panel tile fixed_height_320 overflow_hidden">
                            <div class="x_title">
                                <h2>Member Stats</h2>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">

                                <table class="" style="width:100%">
                                    <tr>
                                        <td>
                                            <canvas id="canvas1" height="140" width="140" style="margin: 15px 10px 10px 0"></canvas>
                                        </td>
                                        <td>
                                            <table class="tile_info">
                                                <tr>
                                                    <td>
                                                        <p><i class="fa fa-square blue"></i>Friend Requests </p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <p><i class="fa fa-square green"></i>Friends </p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <p><i class="fa fa-square purple"></i>Request Ignored </p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <p><i class="fa fa-square red"></i>Blocked </p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <p><i class="fa fa-square aero"></i>Messages </p>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    

                    </div>
					
                    <div class="row">
                        <div class="col-md-6">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>Latest from <a href="http://isvipi.org" target="_blank">IsVipi OSSN Blog</a> (Coming Soon)</h2>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <article class="media event">
                                        <div class="pull-left date">
                                            <p class="month">April</p>
                                            <p class="day">23</p>
                                        </div>
                                        <div class="media-body">
                                            <a class="title" href="#">Blog Title</a>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                                        </div>
                                    </article>
                                    <article class="media event">
                                        <div class="pull-left date">
                                            <p class="month">April</p>
                                            <p class="day">23</p>
                                        </div>
                                        <div class="media-body">
                                            <a class="title" href="#">Blog Title</a>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                                        </div>
                                    </article>
                                    <article class="media event">
                                        <div class="pull-left date">
                                            <p class="month">April</p>
                                            <p class="day">23</p>
                                        </div>
                                        <div class="media-body">
                                            <a class="title" href="#">Blog Title</a>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                                        </div>
                                    </article>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>Latest Members</h2>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <div class="col-md-12 col-sm-4 col-xs-12 animated fadeInDown">
                                         <?php $members = array_filter($stats->get_latest_members(8));
										 		if(is_array($members)) foreach ($members as $key => $mi) {
										 ?> 
                                            
                                            <div class="profile_view sty-pr">
                                                <div class="col-sm-12 styl-mb">
                                                    <div class="adm-members">
                                                        <img src="<?php echo user_pic($mi['profile_pic']) ?>" alt="" class="img-square">
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 bottom text-center">
                                                	<a href="<?php echo ISVIPI_URL .'profile/'.$mi['username'] ?>" class="btn btn-primary btn-xs" data-toggle="tooltip" title="<?php echo $mi['fullname'] ?>" target="_blank"> 
                                                    	View Profile 
                                                    </a>
                                                </div>
                                            </div>
                                            
                                            <?php } else {?>
                                            <div class="profile_view sty-pr">
                                            	<p>No members found.</p>
                                            </div>
                                            <?php } ?>
                                            
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                  </div>
        <?php $fr = $stats->friends_stats(); ?>
        <script src="<?php echo ISVIPI_ADMIN_URL .'style/js/chartjs/chart.min.js' ?>"></script>
		<script>
        var doughnutData = [
            {
                value: <?php echo $fr['blocked'] ?>,
                color: "#E74C3C"
            },
            {
                value: <?php echo $fr['ignored'] ?>,
                color: "#9B59B6"
            },
            {
                value: <?php echo $fr['pm'] ?>,
                color: "#BDC3C7"
            },
            {
                value: <?php echo $fr['friends'] ?>,
                color: "#26B99A"
            },
            {
                value: <?php echo $fr['f_request'] ?>,
                color: "#3498DB"
            }
    ];
        var myDoughnut = new Chart(document.getElementById("canvas1").getContext("2d")).Doughnut(doughnutData);
    </script>

<?php require_once(ISVIPI_ADMIN_BASE .'ovr/footer.php') ?>