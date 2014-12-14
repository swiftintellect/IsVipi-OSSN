<h2 class="profile-header"><?php echo MY_CONV ?></h2>
<?php 
	if (isset($ACTION[1])){
		updMsgRead($ACTION[1],$_SESSION['user_id']);
	}?>
<hr/>
<div class="mailbox row">
<div class="col-xs-12">
<div class="box box-solid">
<div class="box-body">
<div class="row">
<div class="col-md-3 col-sm-4" style="border-right:solid thin #DDDBDB">
 <!--load active chats -->
 <?php if (isset($ACTION[1])){
	 $chatwth = $ACTION[1];
 } else {
	 $chatwth = '';
 }
 ?>
		<script>
			$(document).ready(function() {
				$('.active_chats').load(fullURL+"/remote/convos/<?php echo $chatwth ?>");
				$('.active_chats').timer({
					delay: 3000,
					repeat: true,
					url: fullURL+"/remote/convos/<?php echo $chatwth ?>"
				});
			}); 
		</script>

<div style="margin-top: 15px;" class="active_chats">

</ul>
</div>
</div>
 
<?php 
	if (isset($ACTION[1])){
	xtractUID($ACTION[1]);?>
<div class="col-md-9 col-sm-8">
<div class="row pad">
<div class="col-sm-6">
<div class="btn-group" style="margin-left:-10px">
<button type="button" class="btn btn-default btn-sm btn-flat dropdown-toggle disabled" data-toggle="dropdown">
<?php echo ACTION ?> <span class="caret"></span>
</button>
<ul class="dropdown-menu" role="menu">
	<li><a href="#"><?php echo DELETE ?></a></li>
</ul>

</div>
</div>
<?php isBlocked($_SESSION['user_id'],$uid);
	if ($blockCount > 0){?>
	<span class="label label-danger pull-left" style="font-size:13px;">
		<?php echo N_BLOCK_NOTICE ?>
	</span>
<?php } ?>
</div> 
<!--load conversation -->
		<script>
			$(document).ready(function() {
				$('.table-responsive').load(fullURL+"/remote/chat/<?php echo $ACTION[1] ?>/");
				$('.table-responsive').timer({
					delay: 3000,
					repeat: true,
					url: fullURL+"/remote/chat/<?php echo $ACTION[1] ?>/"
				});
			}); 
		</script> 
        
<div class="table-responsive">
</div>
	<script>
		$( ".table-responsive" ).hover(
		  function() {
			$('.table-responsive').timer('stop');
		  }, function() {
			$('.table-responsive').timer('start');
		  }
		);
	</script>
	<form method="post" action="<?php echo ISVIPI_URL. 'users/processPM'?>" id="pmSend">
		<input type="hidden" name="msg" value="0">
		<div class="form-group">
		<input class="form-control" type="hidden" name="recip" value="<?php echo $uid; ?>">
		</div>
		<div class="form-group">
		<textarea id="message" name="message" class="col-md-12" <?php if ($blockCount > 0){ echo "disabled"; }?> required></textarea>
		</div>
        <div class="form-group">
		<button class="btn btn-primary pull-left" style="margin-top:10px" type="submit" <?php if ($blockCount > 0){ echo "disabled"; }?>><?php echo REPLY ?></button>
        <div id="workingGen" style="float:left; margin-left:20px; margin-top:15px; display:none">
         	<img src="<?php echo ISVIPI_STYLE_URL.'images/t_loading.gif'?>" height="15" />
        </div>
        </div>
	</form>
    
</div>
<script>
        $(document).ready(function() { 
            $('#pmSend').ajaxForm(function() { 
			$("#workingGen").show();
			setTimeout(function(){
			$("#workingGen").hide();
			$("#pmSend").resetForm();
			$("#pmSend").clearForm();
			}, 1000);
            }); 
        }); 
</script>

<?php } else {
	echo "<span style='margin:20px;'>".SELECT_CONV."</span>";
	} ?>
 
</div> 
</div> 
</div> 
</div> 
</div> 
</section> 



<div class="clear"></div>