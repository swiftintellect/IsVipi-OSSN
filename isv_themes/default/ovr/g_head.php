<!DOCTYPE html>
<html lang="<?php echo SITE_LANG ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo $s_m['meta_descr']; ?>">
    <meta name="keywords" content="<?php echo $s_m['meta_tags']; ?>">
    <meta name="generator" content="IsVipi OSSN">
    <?php if(DISCOURAGE_INDEXING){?>
    <meta name="robots" content="noindex, nofollow">
    <?php } else { ?>
    <meta name="robots" content="index, follow">
    <?php } ?>
    <title><?php siteTitle($p) ?></title>
	
	<!-- core CSS -->
    <link href="<?php echo ISVIPI_STYLE_URL . 'default/css/bootstrap.min.css' ?>" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link href="<?php echo ISVIPI_STYLE_URL . 'default/css/main.css' ?>" rel="stylesheet">
    <link href="<?php echo ISVIPI_STYLE_URL . 'default/css/responsive.css' ?>" rel="stylesheet">
    
    <!-- jQuery -->
    <script src="<?php echo ISVIPI_STYLE_URL . 'default/js/jquery.js' ?>"></script>
    <script src="<?php echo ISVIPI_STYLE_URL.'plugins/formsubmit/form.submit.min.js'?>"></script>

    <link rel="shortcut icon" href="<?php echo ISVIPI_STYLE_URL .'site/imgs/'.$isv_siteSettings['favicon']?>">
    
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<!--/head-->
