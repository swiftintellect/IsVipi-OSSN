<?php
	require_once(ISVIPI_CLASSES_BASE .'global/get_photo_albums_cls.php');
	
	//check if photo_album id is set
	if(!isset($PAGE[3])){
		echo "<li class='list-group-item' style='margin-bottom:10px; margin-top:-10px'>Action not Allowed</li>";
		exit();
	}
	//decode photo album id
	$alb_id = $converter->decode(cleanGET($PAGE[3]));
	$alb = new get_photo_albums();
	
	//check if is numeric
	if(!is_numeric($alb_id)){
		echo "<li class='list-group-item' style='margin-bottom:10px; margin-top:-10px'>Album selected was invalid.</li>";
		exit();
	}
	
	//check if the album exists
	if(!$alb->album_exists_n_allowed($alb_id,$m_info['m_user_id'])){
		echo "<li class='list-group-item' style='margin-bottom:10px; margin-top:10px'>Photo album does not exist or was deleted.</li>";
		echo "<a class='btn btn-success btn-lg' style='margin-bottom:10px' href='".ISVIPI_URL.'profile/'.$m_info['m_username'].'/photos/'."'> Back to Albums</a>";
		exit();
	}
	
	//get photo count
	$photo_count = $alb->album_photo_count($alb_id);
	
	//get all photos under this album
	$all_photos = $alb->all_photos($alb_id);
?>
<!-- Photo Albums Box -->
<div class="box box-primary">
	<div class="box-header with-border">
    	<h3 class="box-title">Album Title</h3>
  	</div><!-- /.box-header -->
   	<div class="box-body">
    <!-- show upload button if is the account owner -->
    <?php if ($_SESSION['isv_user_id'] === $m_info['m_user_id']){?>
    <?php if(MAX_PHOTOS_IN_ALBM > $photo_count){?>
    	<a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#add_photos"><i class="fa fa-plus"></i> Add Photos</a> | 
    <?php } else {?>
    	<button type="button" class="btn btn-sm btn-success disabled">Album Full</button>
    <?php } ?>
    <a class="btn btn-danger btn-sm" data-toggle="modal" data-target="#del_album"><i class="fa fa-trash"></i> Delete Album</a>
    <?php } ?>
    <a class="btn btn-warning btn-sm pull-right" href="<?php echo ISVIPI_URL.'profile/'.$m_info['m_username'].'/photos/'?>"> Back to Albums</a>
	<hr />
    <div class="clearfix"></div>
	<?php if(
						   
		($_SESSION['isv_user_id'] === $m_info['m_user_id']) /* if owner */ ||
		($_SESSION['isv_user_id'] !== $m_info['m_user_id'] && $m_info['m_phone_settings'] === 2) /* everyone */||
		($_SESSION['isv_user_id'] !== $m_info['m_user_id'] && $m_info['m_phone_settings'] === 1 
		&& $friends->are_friends($_SESSION['isv_user_id'],$m_info['m_user_id'])) ||
		$admin->admin_logged_in()

	){?>
    
    <?php if($photo_count > 0) {?>
    	<?php if(is_array($all_photos)) foreach ($all_photos as $key => $ap) {?>
    		<div class='photo-alb'>
                <a class="gallery" href="<?php echo ISVIPI_UPLOADS_URL.'albums/'.ISVIPI_600.$ap['photo']?>">
                    <img class='img-responsive' src="<?php echo ISVIPI_UPLOADS_URL.'albums/'.ISVIPI_600.$ap['photo']?>">
                </a>
                <?php if ($_SESSION['isv_user_id'] === $m_info['m_user_id']){?>
                <div class="album_title bg-gray">
                    <a href="<?php echo ISVIPI_URL .'p/photo_album/'.$converter->encode('del_photo').'/'.$converter->encode($ap['photo_id']) ?>" title="click to delete photo" data-toggle="tooltip" data-placement="bottom" class="btn btn-xs btn-danger">
                        <i class="fa fa-trash"></i> delete
                    </a>
                </div>
                <?php } ?>
            </div>
    	<?php } ?>
    <?php } else {?>
		<li class="list-group-item">No photos were found for this album.</li>
	<?php } ?>  
    <?php } ?>    
    <script>
		$(document).ready(function(){
			$('.gallery').featherlightGallery();
		});
	</script>
    <div class="clearfix"></div>
    </div><!-- /.box-body -->
</div><!-- /.box -->
<!-- end::About Me Box -->

<!-- modals -->
<!-- Delete Album-->
<div class="modal fade" id="del_album" tabindex="-1" role="dialog" aria-labelledby="delete-album">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Delete Album</h4>
      </div>
      <div class="modal-body">
		Are you sure you want to delete this album? All photos associated with this album will be deleted.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <a href="<?php echo ISVIPI_URL .'p/photo_album/'.$converter->encode('del_alb').'/'.$converter->encode($alb_id) ?>" class="btn btn-primary">Yes, Delete Album</a>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<!-- Add photos modal-->
<div class="modal fade" id="add_photos" tabindex="-1" role="dialog" aria-labelledby="add-photos">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Add photos to this album</h4>
      </div>
      <div class="modal-body">
      <form action="<?php echo ISVIPI_URL .'p/photo_album' ?>" method="post" enctype="multipart/form-data" runat="server">
      	<div class="alert alert-info" style="padding:10px">
        	<li>Maximum photo size is 2MB</li>
            <li>Maximum number of photos in an album is <?php echo MAX_PHOTOS_IN_ALBM ?></li>
            <li>Allowed file types 'jpg', 'jpeg', 'png', 'gif'</li>
            <li>Hold ctrl to select multiple pictures (max. 5 photos)</li>
        </div>
        <div style="clear:both"></div>
            <hr style="margin:10px 0"/>
            <input type="file" name="files[]" id="filer_input" multiple="multiple">
        
      </div>
      <div class="modal-footer">
      	<input type="hidden" name="aop" value="<?php echo $converter->encode('add') ?>" />
        <input type="hidden" name="album" value="<?php echo $converter->encode($alb_id) ?>" />
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Upload</button>
      </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

