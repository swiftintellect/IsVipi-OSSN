<?php get_header()?>
<?php get_sidebar()?>
                       <div class="dash_content">
                        <div class="panel panel-primary">
                          <div class="panel-heading"><?php echo CHAT_WITH ?> <span class="chat_with">
                          <?php if ($uid !== $user){$chatWith = $uid;} 
						  else {$chatWith = $user;} getUserDetails($chatWith); echo $username;?>
                           </span>
                           <?php isBlocked($_SESSION['user_id'],$uid);
						   	if ($blockCount > 0){?>
                            <span class="label label-danger" style="font-size:13px;">
                            <?php echo N_BLOCK_NOTICE ?>
                            </span>
                            <?php } ?>
                           </div>
                          <div class="panel-body">
                           <div id="pmRefresh">
                           <center>
                           		<div id="pmLoading">
                            	<img src="<?php echo ISVIPI_STYLE_URL.'images/t_loading.gif'?>" height="15" />
                            	</div>
                           </center>
                           </div>
                           <?php
						   getConv($uid,$user);
						    if ($convCount !== 0){?>
                           <div class="reply_msg">
                                <form method="post" action="<?php echo ISVIPI_URL. 'users/processPM'?>" id="pmSend">
                                <input type="hidden" name="msg" value="0">
                              <div class="form-group">
                                <input class="form-control" type="hidden" name="recip" value="<?php echo $uid; ?>">
                              </div>
                              <div class="form-group">
                                <textarea id="message" name="message" required="required" <?php if ($blockCount > 0){?>disabled="disabled" <?php } ?>></textarea>
                              </div>
                                <button class="btn btn-primary" type="submit"><?php echo REPLY ?></button>
                            <div id="pmSending" style="float:left; margin-right:10px; margin-top:5px; display:none">
                            <img src="<?php echo ISVIPI_STYLE_URL.'images/t_loading.gif'?>" height="15" />
                            </div>
                             </form>
                            </div>
                            <?php } ?>
                           </div>
                          </div><!--end of panel-->
                        </div><!--end of dash_content-->
<script>
$(document).ready(function() {
	$('#pmRefresh').load(fullURL+"/remote/pm/"+"<?php echo $uid ?>");
    $('#pmRefresh').timer({
		delay: 3000,
		repeat: true,
		url: fullURL+"/remote/pm/"+"<?php echo $uid ?>"
	});
}); 
</script> 

<script>
        $(document).ready(function() { 
            $('#pmSend').ajaxForm(function() { 
			$("#pmSending").show();
			setTimeout(function(){
			$("#pmSending").hide();
			$("#pmSend").resetForm();
			$("#pmSend").clearForm();
			}, 1000);
            }); 
        }); 
	</script>
<?php get_r_sidebar()?>
<?php get_footer();?>