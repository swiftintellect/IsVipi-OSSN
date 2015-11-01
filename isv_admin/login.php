<?php require_once(ISVIPI_ADMIN_CLS_BASE .'init.cls.php');
	$track = new admin_security();
	if($track->admin_logged_in()){
		header('location:'.ISVIPI_ACT_ADMIN_URL.'dashboard/');
	}
	global $isv_siteSettings;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php if(!isset($PAGE[1])) $PAGE[1] = 'login'; ?>
    <title><?php echo adminTitle($PAGE[1]) ?></title>

    <link href="<?php echo ISVIPI_STYLE_URL . 'default/css/bootstrap.min.css' ?>" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

    <link href="<?php echo ISVIPI_ADMIN_URL .'style/css/custom.css' ?>" rel="stylesheet">
    <link href="<?php echo ISVIPI_ADMIN_URL .'style/css/login.css' ?>" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
	<link rel="shortcut icon" href="<?php echo ISVIPI_STYLE_URL .'site/imgs/'.$isv_siteSettings['favicon']?>">
</head>

<body class="login_page">
    
    <div class="">
        <div id="wrapper">
            <div id="login" class="animate form">
            	<div class="login_logo">
                	<img src="<?php echo ISVIPI_STYLE_URL . 'site/imgs/'.$isv_siteSettings['logo'] ?>" alt="logo">
                </div>
                
                <?php if(isset($_SESSION['isv_error']) && !empty($_SESSION['isv_error'])){?>
                	<div class="error_alert"><?php echo $_SESSION['isv_error']; unset($_SESSION['isv_error']); ?></div>
                <?php } ?>
                
                <div class="admin_ip">
                    <span class="pull-left">IP: <?php echo get_user_ip() ?></span> 
                    <span class="pull-right">Date: <?php echo date('d/m/Y', time()); ?></span>
                </div>
                <hr>
                <section class="login_content">
                    <form action="<?php echo ISVIPI_URL .'aa/login' ?>" method="POST">
                        <h1>Admin Login</h1>
                        <div>
                            <input type="email" class="form-control" name="email" placeholder="Email" required/>
                        </div>
                        <div>
                            <input type="password" class="form-control" name="pwd" placeholder="Password" required />
                        </div>
                        <div>
                        	<input type="hidden" name="aop" value="login">
                            <button type="submit" class="btn btn-primary pull-left">Log in</button>
                        </div>
                        <div class="clearfix"></div>
                        
                        <div class="separator">

                            <div class="footer_copy">
                                <p style="text-align:left"><?php footerCopyright() ?></p>
                            </div>
                        </div>
                    </form>
                    <!-- form -->
                </section>
                <!-- content -->
            </div>
        </div>
    </div>

</body>
<script src="<?php echo ISVIPI_ADMIN_URL .'style/js/jquery.min.js' ?>"></script>
</html>