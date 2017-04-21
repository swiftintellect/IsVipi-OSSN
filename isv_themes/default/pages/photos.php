<?php if(!$friends->blocked_users($_SESSION['isv_user_id'],$m_info['m_user_id'])){?>
<?php
	require_once(ISVIPI_CLASSES_BASE .'global/get_photo_albums_cls.php');
	$alb = new get_photo_albums();
	$alb_count = $alb->album_count($m_info['m_user_id']);
	$albums = array_filter($alb->get_user_albums($m_info['m_user_id']));

?>
<!-- Photo Albums Box -->
<div class="box box-primary">
	<div class="box-header with-border">
    	<h3 class="box-title">Photo Albums <?php if($alb_count > 0){?>(<?php echo $alb_count ?>)<?php } ?></h3>
  	</div><!-- /.box-header -->
   	<div class="box-body">
    <!-- show upload button if is the account owner -->
    <?php if ($_SESSION['isv_user_id'] === $m_info['m_user_id'] && $alb_count < MAX_PHOTO_ALBMS){?>
    <a class="btn btn-primary btn-large" data-toggle="modal" data-target="#photo_album"><i class="fa fa-photo"></i> New Photo Album</a>
    <hr style="margin:10px 0;" />
    <?php } ?>

	<?php if(
						   
		($_SESSION['isv_user_id'] === $m_info['m_user_id']) /* if owner */ ||
		($_SESSION['isv_user_id'] !== $m_info['m_user_id'] && $m_info['m_phone_settings'] === 2) /* everyone */||
		($_SESSION['isv_user_id'] !== $m_info['m_user_id'] && $m_info['m_phone_settings'] === 1 
		&& $friends->are_friends($_SESSION['isv_user_id'],$m_info['m_user_id'])) ||
		$admin->admin_logged_in()

	){?>
    <?php if($alb_count > 0) {?>
    	<?php if(is_array($albums)) foreach ($albums as $key => $alb) {?>
        	<div class="photo-alb">
                <a href="<?php echo ISVIPI_URL.'profile/'.$m_info['m_username'].'/photos/'.$converter->encode($alb['album_id'])?>">
                    <img class='img-responsive' src="<?php load_default_photo($alb['album_id']) ?>" alt="<?php echo $alb['album'] ?>">
                </a>
                <div class="album_title bg-blue">
                	<a href="<?php echo ISVIPI_URL.'profile/'.$m_info['m_username'].'/photos/'.$converter->encode($alb['album_id'])?>">
						<span class="text-gray"><?php echo $alb['album'] ?></span>
                    </a>
                </div>
        	</div>
        <?php } else {?>
            <li class="list-group-item">An error occurred. We are looking into this.</li>
            <div class="clearfix"></div>
        <?php } ?>
        <div class="clearfix"></div>
    <?php } else { ?>
    	<li class="list-group-item">No photo albums found</li>
        <div class="clearfix"></div>
    <?php } ?>                      
	<?php } ?>
    
    <?php if ($_SESSION['isv_user_id'] === $m_info['m_user_id'] && $alb_count < MAX_PHOTO_ALBMS){?>
    <hr style="margin:10px 0;" />
    <a class="btn btn-primary btn-large" data-toggle="modal" data-target="#photo_album"><i class="fa fa-photo"></i> New Photo Album</a>
    
    <?php } ?>
    <div class="clearfix"></div>
    </div><!-- /.box-body -->
</div><!-- /.box -->
<!-- end::About Me Box -->
<?php } ?>