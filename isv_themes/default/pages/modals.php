<?php if($_SESSION['isv_user_id'] === $m_info['m_user_id']){?>
<!-- upload prifle pic modal-->
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
           	<input type="file" class="upload" name="p_pic" id="imgInp1"/>
      	</div>
       	<img id="preview1" src="<?php echo ISVIPI_STYLE_URL.'/default/images/preview.png' ?>"/>
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


<!-- upload cover photo modal-->
<div class="modal fade" id="cover" tabindex="-1" role="dialog" aria-labelledby="cover">
  <div class="modal-dialog">
    <div class="modal-content">
    <form action="<?php echo ISVIPI_URL .'p/member' ?>" method="post" enctype="multipart/form-data" id="imgFeed" runat="server">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Upload Cover Photo</h4>
      </div>
      <div class="modal-body">
      	<div class="alert alert-info" style="padding:10px">
        	Your cover photo should be approximately 800px by 250 px
        </div>
      	<div class="fileUpload btn btn-upload">
        	<span>Click to Choose Image</span>
           	<input type="file" class="upload" name="cover" id="imgInp2"/>
      	</div>
       	<img id="preview2" src="<?php echo ISVIPI_STYLE_URL.'/default/images/preview.png' ?>"/>
       	<input type="hidden" name="isv_op" value="cover_pic" />
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

<!------------------------------------------------------------!>
        <!-- FEED IMAGE PREVIEW -->
        <script>
			function readURL1(input) {
			var url = input.value;
			var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
			if (input.files && input.files[0]&& (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) {
				var reader = new FileReader();
		
				reader.onload = function (e) {
					$('#preview1').css('display','block');
					$('#preview1').attr('src', e.target.result);
				}
		
				reader.readAsDataURL(input.files[0]);
			}
		}
		$("#imgInp1").change(function(){
			readURL1(this);
		});
		</script>
        
        <script>
			function readURL(input) {
			var url = input.value;
			var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
			if (input.files && input.files[0]&& (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) {
				var reader = new FileReader();
		
				reader.onload = function (e) {
					$('#preview2').css('display','block');
					$('#preview2').attr('src', e.target.result);
				}
		
				reader.readAsDataURL(input.files[0]);
			}
		}
		$("#imgInp2").change(function(){
			readURL(this);
		});
		</script>

<?php } ?>


