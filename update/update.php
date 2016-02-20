<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="IsVipi OSSN is a free and open source social networking, community, dating and membership software.">
    <meta name="keywords" content="free and open source, social network, community, dating, membership, software, script, php/mysql">
    <meta name="generator" content="IsVipi OSSN">
    <link rel="icon" href="../isv_inc/isv_style.lib/site/imgs/favicon.png" type="image/x-icon" />

    <title>IsVipi OSSN - Setup Prompt</title>

    <!-- Bootstrap Core CSS -->
    <link href="../isv_inc/isv_style.lib/pre_install/css/bootstrap.min.css" rel="stylesheet">
    <link href="../isv_inc/isv_style.lib/pre_install/css/style.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">
                	<img src="../isv_inc/isv_style.lib/site/imgs/logo.png" alt="logo">
                </a>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>
	<!-- Page Content -->
    <div class="container">

        <div class="row">
            <div class="text-center" style="width:70%; margin:10px auto !important">
                <p class="lead">You are one step away from updraging your IsVipi OSSN installation to version 1.2.1. Click the upgrade button below and wait for a few seconds as your system is upgraded.</p>
                <p style="text-align:left; margin-left:15px;">
                	<?php if(isset($_GET['update']) && $_GET['update'] == "update"){
						
						//require important files
						require_once('../isv_inc/isv_db/db.php');
						require_once('../isv_admin/functions.php');
						
						//define important functions
						function outputProgress($current, $total) {
							myFlush();
							sleep(1);
						}

						function myFlush() {
							echo(str_repeat(' ', 256));
							if (@ob_get_contents()) {
								@ob_end_flush();
							}
							flush();
						}

						//Switch to Maintenance Mode
						$array1  = array(1);
						$current = 0;
						echo "<p class='update-txt'>Switching to Maintenance Mode... </p>";
						foreach ($array1 as $element) {
							$current++;
							switch_system_status(1);
							outputProgress($current, count($array1));
						}
						echo "<p class='update-txt2'>Maintenance Mode On</p>";
						echo "<br>";
						
						//import sql
						$array1  = array(1,1);
						$current = 0;
						echo "<p class='update-txt'>Importing updated sql... </p>";
						
						global $isv_db;
						
						$filename = 'sql.sql';
						$op_data = '';
						$lines = file($filename);
							foreach ($lines as $line){
								if (substr($line, 0, 2) == '--' || $line == ''){
									continue;
								}
								$op_data .= $line;
								if (substr(trim($line), -1, 1) == ';'){
									$isv_db->query($op_data);
									$op_data = '';
								}
							}
						foreach ($array1 as $element) {
							$current++;
							
							outputProgress($current, count($array1));
						}
						echo "<p class='update-txt2'>Database tables updated</p>";
						echo "<br>";
						
						//switch from maintenance mode
						$array1  = array(1);
						$current = 0;
						echo "<p class='update-txt'>Switching off Maintenance Mode... </p>";
						switch_system_status(1);
						foreach ($array1 as $element) {
							switch_system_status(0);
							$current++;
							
							outputProgress($current, count($array1));
						}
						echo "<p class='update-txt2'>Maintenance Mode Off</p>";
						echo "<br>";
						
						//return success
						$array1  = array(1);
						$current = 0;
						echo "<p class='update-txt'>Upgrade Complete... </p>";
						echo "<p class='update-txt2'>Your upgrade has been completed successfully. Please remember to delete the update folder and all its content from your server.</p>";
						echo "<hr>";
						echo "<p style='text-align:left'>If you think we are doing a good job, please consider donating.<p>";
						echo '<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top" style="margin-bottom:20px">
                    <input type="hidden" name="cmd" value="_s-xclick">
                    <input type="hidden" name="hosted_button_id" value="ZMWP83F3ACBBC">
                    <input type="hidden" name="on0" value="Donation Amount">
                    <div class="col-md-6">
					<div class="col-md-6">
                    <select name="os0" class="form-control">
                        <option value="10">$10.00 USD</option>
                        <option value="25">$25.00 USD</option>
                        <option value="50">$50.00 USD</option>
                        <option value="100">$100.00 USD</option>
                        <option value="250">$250.00 USD</option>
                        <option value="500">$500.00 USD</option>
                        <option value="1000">$1,000.00 USD</option>
                    </select> 
                    </div>
                    <div class="col-md-6">
                    <input type="submit" class="btn btn-primary" name="submit" alt="PayPal - The safer, easier way to pay online!" value="Make a Donation">
                    </div>
					</div>
                    <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
                </form>';
					}
				  ?>
                </p>
                <?php if(!isset($_GET['update'])){?>
                <ul class="list-unstyled">
                    <li><a href="update.php?update=update" class="btn btn-success btn-lg">Upgrade</a></li>
                </ul>
                <?php } ?>
            </div>
        </div>
        <!-- /.row -->

    </div>
    <!-- /.container -->
<!-- jQuery Version 1.11.1 -->
    <script src="../isv_inc/isv_style.lib/pre_install/js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../isv_inc/isv_style.lib/pre_install/js/bootstrap.min.js"></script>

</body>

</html>