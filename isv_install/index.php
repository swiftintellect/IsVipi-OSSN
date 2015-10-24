<?php session_start();
	date_default_timezone_set ('US/Central');
	require_once('isv_install_fnc.php');
	require_once('../isv_init.php');
?>
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

    <title>IsVipi OSSN - Installation</title>

    <!-- Bootstrap Core CSS -->
    <link href="../isv_inc/isv_style.lib/pre_install/css/bootstrap.min.css" rel="stylesheet">
    <link href="../isv_inc/isv_style.lib/pre_install/css/style.css" rel="stylesheet">
    <link href="../isv_inc/isv_style.lib/pre_install/css/prettify.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

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
            <div class="col-lg-8 cont-holder">
			<?php require_once('steps.php') ?>
            </div>
            <div class="col-lg-3 help-holder">
				<h3>About IsVipi OSSN</h3>
                <p>IsVipi OSSN is a free and open source social networking, community, dating and membership software built on PHP/MySQL and Jquery/Ajax.</p>
                <h3>How can I Help?</h3>
                <p>You can help us by <a href="https://github.com/IsVipiOfficial/IsVipi-OSSN" target="_blank">forking</a> and enhancing this software, or by blogging about it. Let more people know about IsVipi OSSN.</p>
                <h3>Customization</h3>
                <p>If you need customization of this software to your feel and liking, or have a project you would like us to handle from scratch, drop us a line by filling in the form from <a href="http://isvipi.org/support" target="_blank">this link</a>.</p>
                <h3>Donate?</h3>
                <p>You can also <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=8EKWYJABNLDE2" target="_blank">make a donation</a> and help support this project. If you are happy with what you have seen, you can say "Thank You".</p>
            </div>
            
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container -->

    <script src="../isv_inc/isv_style.lib/pre_install/js/jquery.js"></script>
    <script src="../isv_inc/isv_style.lib/pre_install/js/bootstrap.min.js"></script>
    <script src="../isv_inc/isv_style.lib/pre_install/js/jquery.bootstrap.wizard.min.js"></script>
    <script src="../isv_inc/isv_style.lib/pre_install/js/prettify.js"></script>
	<script>
	$(document).ready(function() {
	  	$('#rootwizard').bootstrapWizard();
		window.prettyPrint && prettyPrint()
	});
	</script>
</body>

</html>
