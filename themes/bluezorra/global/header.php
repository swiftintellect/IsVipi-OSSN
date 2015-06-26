<?php 
	include_once(ISVIPI_THEMES_BASE.'functions.php');
	global $adminPath, $logoname, $faviconname, $site_url,$username;
	if (!isset($logoname)){$logoname == "logo.png";}
	if (!isset($faviconname)){$faviconname == "favicon.png";}
?>
	<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo ISVIPI_STYLE_URL.'images/site/'.$faviconname.'';?>">
<?php 
	//if the user is not logged in, we load the required stylesheet
	if (!signedIn()){
?>
	<link href="<?php echo ISVIPI_STYLE_URL; ?>css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo ISVIPI_STYLE_URL; ?>fontawesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo ISVIPI_THEME_URL ?>style/css/main/front.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo ISVIPI_THEME_URL ?>style/css/notices/amaran.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo ISVIPI_THEME_URL ?>style/css/notices/animate.min.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="<?php echo ISVIPI_STYLE_URL; ?>js/jQuery_v2.1.js"></script>
    <script type="text/javascript" src="<?php echo ISVIPI_STYLE_URL; ?>js/ajax/form-submit.js"></script>
    <script>$(function () { $("[data-toggle='tooltip']").tooltip(); });</script>
    
</head>
<!-- end of head section-->
    	<!-- start of body -->
        <body>
        <!-- General header -->
        <header class="header navbar-default">
        	<div class="header-inner">
                <a class="logo" href="<?php echo ISVIPI_URL.'home/' ?>" title="<?php echo LOGO ?>">
                    <img src="<?php echo ISVIPI_STYLE_URL.'images/site/'.$logoname.'';?>" width="60%" />
                </a>
                <div class="navbar-right">
                    <form class="navbar-form" role="search" action="<?php echo ISVIPI_USER_PROCESS; ?>" method="POST">
                        <div class="form-group">
                            <input type="email" class="form-control" name="email" placeholder="<?php echo EMAIL ?>">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" name="pass" placeholder="<?php echo PASSWORD ?>">
                        </div>
                        <input type="hidden" name="op" value="login">
                        <button type="submit" class="btn btn-success"><?php echo SIGN_IN ?></button>
                    </form>
                    <div class="nav-bar-extra">
                    <a href="<?php echo ISVIPI_URL.'auth/forgot_password' ?>"><?php echo FORGOT_PASSWORD ?>?</a>
                    </div>
                </div>
            <div class="clear"></div>
            </div>
        <div class="clear"></div>
        </header>
<?php } else {?>
	<?php $user = $_SESSION['user_id']; ?>
	<link href="<?php echo ISVIPI_STYLE_URL; ?>css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo ISVIPI_STYLE_URL; ?>fontawesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo ISVIPI_THEME_URL ?>style/css/main/main.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo ISVIPI_THEME_URL ?>style/css/notices/amaran.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo ISVIPI_THEME_URL ?>style/css/notices/animate.min.css" rel="stylesheet" type="text/css" />
    
    <link href="<?php echo ISVIPI_THEME_URL ?>style/js/plugins/jbox/jBox.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="<?php echo ISVIPI_STYLE_URL; ?>js/jQuery_v2.1.js"></script>
    <script type="text/javascript" src="<?php echo ISVIPI_STYLE_URL; ?>js/ajax/form-submit.js"></script>
    <script type="text/javascript" src="<?php echo ISVIPI_STYLE_URL; ?>js/plugins/timer/jquery.plugin.min.js"></script>
    <script type="text/javascript" src="<?php echo ISVIPI_STYLE_URL; ?>js/plugins/timer/jquery.timer.min.js"></script> 
    <script type="text/javascript" src="<?php echo ISVIPI_THEME_URL ?>style/js/plugins/jbox/jBox.min.js"></script>
    <script type="text/javascript" src="<?php echo ISVIPI_THEME_URL ?>style/js/ajax.js"></script>
    <script>
		var fullURL = "<?php echo $site_url."/" ?>";
	</script>
    <!--load header notifications -->
		<script>
			$(document).ready(function() {
				$('.user_notifications').load(fullURL+"/remote/header_notices/");
				$('.user_notifications').timer({
					delay: 3000,
					repeat: true,
					url: fullURL+"/remote/header_notices/"
				});
			}); 
		</script> 
        	
    <!-- user notification when javascript is not enabled in the browser-->
    <noscript>
         <?php echo JAVA_PROMPT ?>
	</noscript>
    </head>
    <body>
        <!-- header logo: style can be found in header.less -->
        <header class="header">
            <a class="logo" href="<?php echo ISVIPI_URL.'home/' ?>" title="<?php echo LOGO ?>">
                    <img src="<?php echo ISVIPI_STYLE_URL.'images/site/'.$logoname.'';?>" width="60%" />
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
            <?php global $site_url;?>
                <form name="search" method="post" action="<?php echo $site_url.'/users/search' ?>" id="user_search">
                	<input type="hidden" name="search" value="search">
                  	<div class="input-group">
       <input type="text" class="form-control" name="searchTerm" value="" placeholder="<?php echo HEADER_SEARCH; ?>" id="searchTerm">
                    <span class="input-group-btn">
                    <button class="btn nobg" type="submit"><i class="fa fa-search"></i></button>
                    </span>
                    </div><!-- /input-group -->
                </form>
                	<!-- header notifications -->
                    <div class="user_notifications">
					
                    </div>
                    <!-- /header notifications -->
                <div class="navbar-right">
                
                        <ul class="nav navbar-nav">
                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-user"></i>
                                <?php if (isset($_SESSION['user_id'])){getUserDetails($_SESSION['user_id']);} ?>
                                <span><?php echo $username ?> <i class="caret"></i></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- Menu Body -->
                                <li class="user-body">
                                    <div class="col-xs-4 text-center">
                                        <strong><?php echo USER_ID ?></strong> <br/><?php echo $user ?>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                    	<?php global $level ?>
                                        <strong><?php echo LEVEL ?></strong> <br/><?php echo $level ?>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                    <?php getMyFriends($user); global $MyfriendCount ?>
                                        <strong><?php echo MY_FRIENDS ?></strong> <br/><?php echo $MyfriendCount ?>
                                    </div>
                                </li>
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="<?php echo ISVIPI_URL.'profile/'.$username ?>" class="btn btn-default btn-flat"><?php echo PROFILE ?></a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="<?php echo ISVIPI_URL.'logout'?>" class="btn btn-default btn-flat"><?php echo LOGOUT ?></a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
		<!-- stop timer when user_notifications is clicked -->
		<script>
			$( ".user_notifications" ).click(function() {
			  $('.user_notifications').timer('stop');
			  evt.stopPropagation();
			});
			$( document ).click(function() {
			  $('.user_notifications').timer('start');
			});
		</script>	

<?php } ?>
		<!-- notifications -->
        <?php if (isset($_SESSION['succ'])){?>
        <div class="site_notifications">
           <script>
			$(function(){
				$.amaran({
					content:{
						bgcolor:'#090',
						color:'#fff',
						message:'<?php echo $_SESSION['succ'] ?>'
					   },
					theme:'colorful',
					position:'top right',
					closeButton:true,
					cssanimationIn: 'zoomIn',
					cssanimationOut: 'zoomOutUp',
					delay:4000
				 
				});
			}); 
		</script>

        </div>
        <?php unset($_SESSION['succ']);} else if (isset($_SESSION['err'])){?>
        <div class="site_notifications">
        <script>
			$(function(){
				$.amaran({
					content:{
						bgcolor:'#B70404',
						color:'#fff',
						message:'<?php echo $_SESSION['err'] ?>'
					   },
					theme:'colorful',
					position:'top right',
					closeButton:true,
					cssanimationIn: 'shake',
					cssanimationOut: 'fadeOutDown',
					delay:4000
				});
			}); 
		</script>
        </div>
        <?php unset($_SESSION['err']);} ?>
        
