<!-- upload prifle pic modal-->
<?php if($_SESSION['isv_user_id'] === $m_info['m_user_id']){?>
<div class="modal fade" id="profilePic" tabindex="-1" role="dialog" aria-labelledby="profilePic">
  <div class="modal-dialog">
    <div class="modal-content">
    <form action="<?php echo ISVIPI_URL .'p/member' ?>" method="post" enctype="multipart/form-data" id="imgFeed" runat="server">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Upload Profile Picture</h4>
      </div>
      <div class="modal-body">
      	<div class="fileUpload btn btn-upload">
        	<span>Click to Choose Image</span>
           	<input type="file" class="upload" name="p_pic" id="imgInp"/>
      	</div>
       	<img id="preview" src="<?php echo ISVIPI_STYLE_URL.'/default/images/preview.png' ?>"/>
       	<input type="hidden" name="isv_op" value="prof_pic" />
      	<div class="clear"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Upload</button>
      </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php } ?>


<!------------------------------------------------------------!>
        <!-- FEED IMAGE PREVIEW -->
        <script>
			function readURL(input) {
			var url = input.value;
			var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
			if (input.files && input.files[0]&& (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) {
				var reader = new FileReader();
		
				reader.onload = function (e) {
					$('#preview2').css('display','none');
					$('#preview').css('display','block');
					$('#preview').attr('src', e.target.result);
				}
		
				reader.readAsDataURL(input.files[0]);
			}else{
				 //$('#preview').attr('src', 'http://localhost/isvipi/isv_inc/isv_style.lib/default/images/logo.png');
			}
		}
		$("#imgInp").change(function(){
			readURL(this);
		});
		</script>
