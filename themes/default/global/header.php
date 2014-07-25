<?php 
global $adminPath; $site_title; global $logoname;global $faviconname;
global $user; global $noticesno; global $pendreq; global $username; global $site_url;
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
  <link rel="stylesheet" href="<?php echo ISVIPI_STYLE_URL; ?>css/jquery.fs.boxer.css">
  <!-- Alertify -->
  <link rel="stylesheet" href="<?php echo ISVIPI_STYLE_URL; ?>css/alertify.core.css">
  <link rel="stylesheet" href="<?php echo ISVIPI_STYLE_URL; ?>css/alertify.default.css">
  <link rel="stylesheet" href="<?php echo ISVIPI_STYLE_URL; ?>css/jquery.cssemoticons.css">
  <?php if (CHAT_ENB == "yes"){?>
  <link href="<?php echo ISVIPI_INC_MODS_URL; ?>chat/css/chat.css" rel="stylesheet" media="screen">
  <?php } ?>
  
   <script type="text/javascript" src="<?php echo ISVIPI_STYLE_URL; ?>js/jQuery_v2.1.js"></script>
   
   	<script>
		var fullURL = "<?php echo $site_url."/" ?>";
	</script>
   <script type="text/javascript" src="<?php echo ISVIPI_STYLE_URL; ?>js/ajax/ajaxProcesses.js"></script>
   <script type="text/javascript" src="<?php echo ISVIPI_STYLE_URL; ?>js/plugins/timer/jquery.plugin.min.js"></script>
   <script type="text/javascript" src="<?php echo ISVIPI_STYLE_URL; ?>js/plugins/timer/jquery.timer.min.js"></script>
   <script type="text/javascript" src="<?php echo ISVIPI_STYLE_URL; ?>js/jquery.cssemoticons.min.js"></script>

   <script>$(function () { $("[data-toggle='tooltip']").tooltip(); });</script>
 		<noscript>
         <?php echo JAVA_PROMPT ?>
		</noscript>
 </head>
      <body>
      	
        <!-- main / large navbar -->
        <div id="top-menu">
          <nav class="navbar navbar-default top-menu" role="navigation">
            <div class="container">
                <div class="row">
                  <a href="<?php echo ISVIPI_URL.'home/' ?>" title="<?php echo LOGO ?>"><div class="admin_logo"><img src="<?php echo ISVIPI_STYLE_URL.'images/site/'.$logoname.'';?>" width="70%" /></div></a>
                      <div id="refreshNots">
                      	<!-- header notifications will appear here -->
                      </div>
                      <div class="col-lg-6 header_search">
                      <?php global $site_url;?>
                      <form name="search" method="post" action="<?php echo $site_url.'/users/search' ?>">
                      <input type="hidden" name="search" value="search">
                        <div class="input-group">
                          <input type="text" class="form-control" name="searchTerm" value="" placeholder="<?php echo HEADER_SEARCH; ?>" id="searchTerm">
                          <span class="input-group-btn">
                            <button class="btn nobg" type="submit"><i class="fa fa-search"></i></button>
                          </span>
                        </div><!-- /input-group -->
                        </form>
                      </div><!-- /.col-lg-6 -->

                      <div class="user_info pull-right">
                      <?php if (!isAdmin()){?>
                      <?php global $t_thumb; t_thumb($user);?>
                      <?php if(htmlspecialchars($t_thumb, ENT_QUOTES, 'utf-8') == ""){$t_thumb=".gif";}?>
                      <!----Chat Username---
                      ---------------------->

                      <!--------------------
                      ---------------------->
                      <div class="profile_pic"><a href="<?php echo ISVIPI_URL.'profile/' ?><?php echo htmlspecialchars($username, ENT_QUOTES, 'utf-8');?>"><img src="<?php echo ISVIPI_PROFILE_PIC_URL.ISVIPI_THUMB_100.htmlspecialchars($t_thumb, ENT_QUOTES, 'utf-8');?>" height="100%" width="100%" alt="" /></a>
                      <div class="dropdown">
                        <a data-toggle="dropdown" href="#"><?php echo htmlspecialchars($username, ENT_QUOTES, 'utf-8');?><b class="caret"></b></a>
                         <ul class="dropdown-menu" role="menu">
                           <li><a href="<?php echo ISVIPI_URL.'edit_profile/' ?>"><?php echo EDIT_PROFILE ?></a></li>
                           <li class="disabled"><a href="#"><?php echo SETTINGS ?></a></li>
                           <li role="presentation" class="divider"></li>
                           <li><a href="<?php echo ISVIPI_URL.'logout/' ?>">Log Out</a></li>
                         </ul>
                      </div><!--end of dropdown-->
                      <?php } else {?>
                      <div class="admin_front_head">
                      <span class="label label-info"><?php echo LOGGED_IN_AS_ADMIN ?></span>
                      <span class="label label-warning"><a href="<?php echo ISVIPI_URL.$adminPath.'/dashboard/' ?>"><?php echo TO_ADMIN_BACKEND ?></a></span>
                      </div>
                      <?php }?>
                     </div><!--end of user_info-->
                     
                    </div><!--end of row-->
                  </div><!-- /.container -->
                </div><!--end of top-menu-->
           </nav>
<script>
$(document).ready(function() {
	$('#refreshNots').load(fullURL+"/remote/header_notices/");
    $('#refreshNots').timer({
		delay: 3000,
		repeat: true,
		url: fullURL+"/remote/header_notices/"
	});
}); 
</script> 
