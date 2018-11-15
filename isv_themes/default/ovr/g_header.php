<body class="homepage">
    <header id="header">
        <nav class="navbar navbar-inverse drop-shadow-bottom" role="banner">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="sign-in-fa"><i class="fa fa-unlock-alt"></i></span>
                    </button>
                    <a class="navbar-brand" href="<?php echo ISVIPI_URL ?>"><img src="<?php echo ISVIPI_STYLE_URL . 'site/imgs/'.$isv_siteSettings['logo'] ?>" alt="logo"></a>
                </div>
				
                <div class="collapse navbar-collapse navbar-right" style="border:none !important">
                <form action="<?php echo ISVIPI_URL .'p/users' ?>" method="post" class="navbar-form navbar-right" role="login">
                    <div class="form-group">
                        <input type="text" class="form-control" name="user" placeholder="Email or Username">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="pwd" placeholder="Password">
                    </div>
                    <input type="hidden" name="isv_op" value="<?php echo $converter->encode('signin') ?>" />
                    <button type="submit" class="btn btn-default">Sign In</button>
                    <a href="<?php echo ISVIPI_URL .'forgot' ?>" class="forgot-pwd">Forgot Password?</a>
                </form>
                
                </div>
            </div><!--/.container-->
        </nav><!--/nav-->
		
    </header><!--/header-->
    
    <!--notification alerts -->
    <?php if (isset($_SESSION['isv_error']) && !empty($_SESSION['isv_error']) ){?>
    	<div class="headerAlerts error"><?php echo $_SESSION['isv_error']; unset($_SESSION['isv_error']); ?></div>
    <?php } else if(isset($_SESSION['isv_success']) && !empty($_SESSION['isv_success'])){?>
    	<div class="headerAlerts success"><?php echo $_SESSION['isv_success']; unset($_SESSION['isv_success']); ?></div>
    <?php } ?>
