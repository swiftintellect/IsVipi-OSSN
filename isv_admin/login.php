<?php require_once(ISVIPI_ADMIN_CLS_BASE .'init.cls.php');
	$track = new admin_security();
	if($track->admin_logged_in()){
		header('location:'.ISVIPI_ACT_ADMIN_URL.'dashboard/');
	}
	global $isv_siteSettings;
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?php if(!isset($PAGE[1])) $PAGE[1] = 'login'; ?>
    <title><?php echo adminTitle($PAGE[1]) ?></title>
    <!-- favicon -->
    <link rel="shortcut icon" href="<?php echo ISVIPI_STYLE_URL .'site/imgs/'.$isv_siteSettings['favicon']?>">
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link href="<?php echo ISVIPI_STYLE_URL . 'default/css/bootstrap.min.css' ?>" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?php echo ISVIPI_STYLE_URL . 'default/font-awesome/css/font-awesome.min.css' ?>" rel="stylesheet">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo ISVIPI_ADMIN_URL .'style/css/style.css' ?>">
    <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
          page. However, you can choose any other skin. Make sure you
          apply the skin class to the body tag so the changes take effect.
    -->
    <link rel="stylesheet" href="<?php echo ISVIPI_ADMIN_URL .'style/css/skins/skin-blue.min.css' ?>">
    
    <!-- load jquery -->
    <script src="<?php echo ISVIPI_STYLE_URL . 'default/js/jquery.js' ?>"></script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  
  <body class="hold-transition login-page">
    <div class="login-box">
      <div class="login-logo">
        <a href="<?php echo ISVIPI_URL ?>">
        	<img src="<?php echo ISVIPI_STYLE_URL . 'site/imgs/'.$isv_siteSettings['logo'] ?>" alt="logo">
        </a>
      </div><!-- /.login-logo -->
      <div class="login-box-body">
        <form action="<?php echo ISVIPI_URL .'aa/login' ?>" method="post">
          <div class="form-group has-feedback">
            <input type="email" class="form-control" name="email" placeholder="Email">
          </div>
          <div class="form-group has-feedback">
            <input type="password" class="form-control" name="pwd" placeholder="Password">
          </div>
          <div class="row">
           <?php if(isset($_SESSION['isv_error']) && !empty($_SESSION['isv_error'])){?>
          	<div class="small-box bg-red">
                <div class="inner">
                  <p><?php echo $_SESSION['isv_error']; unset($_SESSION['isv_error']); ?></p>
                </div>
              </div>
            <?php } ?>
            <div class="col-xs-8">
            </div><!-- /.col -->
            <div class="col-xs-4">
              <input type="hidden" name="aop" value="<?php echo $converter->encode('login') ?>">
              <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
            </div><!-- /.col -->
          </div>
        </form>
        <hr>
		<p class="login-box-msg"><?php footerCopyright() ?></p>
    </div><!-- /.login-box -->

    <!-- Bootstrap 3.3.5 -->
    <script src="<?php echo ISVIPI_STYLE_URL . 'default/js/bootstrap.min.js' ?>"></script>
  </body>
</html>
