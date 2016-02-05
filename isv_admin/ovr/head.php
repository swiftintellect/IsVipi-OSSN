<?php require_once(ISVIPI_ADMIN_BASE .'ovr/base.php') ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
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
    
    <?php if($PAGE[1] == "admin_news" || $PAGE[1] == "admin_emails"){ ?>
    	<script src="https://cdn.ckeditor.com/4.4.3/standard/ckeditor.js"></script>
    <?php } ?>
    <?php if($PAGE[1] == "add_new"){ ?>
    	<script src="<?php echo ISVIPI_STYLE_URL.'plugins/formsubmit/form.submit.min.js'?>"></script>
    <?php } ?>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  