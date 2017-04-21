<!DOCTYPE html>
<?php global $isv_siteSettings; ?>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>404 - Page not Found</title>
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
  
  <body class="error-404">
    <div class="err-div">
        <div class="info-box">
        	<span class="info-box-icon bg-blue">404</span>
            	<div class="info-box-content" style="padding-top:35px">
              		<span class="info-box-text">The page you are looking for does not exsist or was removed.</span>
       			</div><!-- /.info-box-content -->
   		</div><!-- /.info-box -->
    </div>
    
  </body>
</html>
