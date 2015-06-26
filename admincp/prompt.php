<?php 
if (!isset($_SESSION['err_h1'])){
	$_SESSION['err'] =E_SYS_ERR;
	header('location:'.ISVIPI_URL.$adminPath.'/dashboard');
	exit();
}
include_once'header.php';
include_once'sidebar.php';?>
    <!-- Start of the container-->
    <div class="container-admin">
      <div class="page-header">
		<ul class="breadcrumb breadcrumb-admin">
  			<li><i class="fa fa-home"></i> <?php echo HOME ?></li>
  			<li class="active"><?php echo ADM_PROMPT ?></li>
            <span class="donate_support"><span class="label label-danger"><?php echo DONATE ?></span></span>
        <div class="donate">
        <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=8EKWYJABNLDE2" data-toggle="tooltip" data-placement="bottom" target="_blank" title="<?php echo DONATE_TEXT ?>"><img src="<?php echo ISVIPI_STYLE_URL.'images/donate.png';?>" width="100%" alt="" /></a>
        </div>
        </ul>
     </div>
     
     <!-- Start of main_content-->
     <div class="main_content">
     	<div class="padded_content" style="min-height:300px; border-radius:5px;">
        	<h2 style="margin:5px;">
            <?php if (isset($_SESSION['err_h1'])){echo $_SESSION['err_h1'];}?>
            </h2>
            <h3 style="font-size:16px; line-height:20px">
            <?php if (isset($_SESSION['err_info'])){echo $_SESSION['err_info'];} ?>
            </h3>
            <a href="<?php if (isset($_SESSION['proceed_uri'])){echo $_SESSION['proceed_uri'];}?>">
            <button type="button" class="btn btn-lg"><?php echo PROCEED ?></button>
            </a>
            <a href="<?php if (isset($_SESSION['cancel_uri'])){echo $_SESSION['cancel_uri'];} ?>">
            <button type="button" class="btn btn-warning btn-lg"><?php echo CANCEL ?></button>
            </a>
           <?php
		   unset($_SESSION['err_h1']);
		   unset($_SESSION['proceed_uri']);
		   unset($_SESSION['cancel_uri']);
		   unset($_SESSION['err_info']);
		   ?> 
     	</div>
     </div>
<?php include_once'footer.php';?>