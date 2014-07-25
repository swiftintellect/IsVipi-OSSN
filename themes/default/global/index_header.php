<?php global $adminPath; global $logoname; global $faviconname;
if (!isset($logoname)){$logoname == "logo.png";}
if (!isset($faviconname)){$faviconname == "favicon.png";}
?>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" type="image/x-icon" href="<?php echo ISVIPI_STYLE_URL.'images/site/'.$faviconname.'';?>">
  <!-- Bootstrap -->
  <link href="<?php echo ISVIPI_STYLE_URL; ?>css/bootstrap.min.css" rel="stylesheet" type="text/css" />
  <!-- Main Style -->
  <link href="<?php echo ISVIPI_STYLE_URL; ?>css/isvipi.css" rel="stylesheet" media="screen">
  <!-- FontAwesome -->
  <link rel="stylesheet" href="<?php echo ISVIPI_STYLE_URL; ?>fontawesome/css/font-awesome.min.css">
  <!-- Alertify -->
  <link rel="stylesheet" href="<?php echo ISVIPI_STYLE_URL; ?>css/alertify.core.css">
  <link rel="stylesheet" href="<?php echo ISVIPI_STYLE_URL; ?>css/alertify.default.css">
  		<noscript>
         For full functionality of this site it is necessary to enable JavaScript.
         Here are the <a href="http://www.enable-javascript.com/" target="_blank">
         instructions how to enable JavaScript in your web browser</a>.
		</noscript>
  </head>
      <body>
      
        <!-- main / large navbar -->
        <div id="top-menu">
          <nav class="navbar navbar-default top-menu" role="navigation">
            <div class="container">
                <div class="row">
                  <a href="<?php echo ISVIPI_URL ?>" title="IsVipi Logo"><div class="admin_logo"><img src="<?php echo ISVIPI_STYLE_URL.'images/site/'.$logoname.'';?>" width="70%" alt="" /></div></a>
                  
                  			<div class="index_login">
                            <form class="form-inline" action="<?php echo ISVIPI_USER_PROCESS; ?>" method="POST">
                                <div class="form-group">
                                    <input type="email" class="form-control" name="email" placeholder="<?php echo ENTER_EMAIL ?>" required>
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control" name="pass" placeholder="<?php echo PASSWORD ?>" required>
                                </div>
                                <input type="hidden" name="op" value="login">
                                <button type="submit" class="btn btn-primary"><?php echo SIGN_IN ?></button>
                                <script>$(function () { $("[data-toggle='tooltip']").tooltip(); });</script>
                                <a href="<?php echo ISVIPI_URL.'auth/forgot_password' ?>" data-toggle="tooltip" data-placement="bottom" title="<?php echo FORGOT_PASSWORD ?>"><span style="margin-left:10px; font-size:20px; color:#0C0;"><i class="fa fa-question-circle"></i></span></a>
                            </form>
                           </div>
                    </div><!--end of row-->
                  </div><!-- /.container -->
                </div><!--end of top-menu-->
           </nav>