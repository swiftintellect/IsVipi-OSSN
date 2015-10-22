<?php require_once(ISVIPI_CLASSES_BASE .'global/getMessages_cls.php'); 
	require_once(ISVIPI_CLASSES_BASE .'utilities/encrypt_decrypt.php'); 
	$converter = new Encryption;
	
	$ch = new get_messages();
	
	if(id_from_username($user_name))
	$l_m_id = '';
	$l_m_id = $ch->last_msg_id($_SESSION['isv_user_id'],$user_id);
	
	$other_user = $user_id;
?>

<!-- load the chat users sidebar -->
<script>
	function load_chat_sidebar($username){
		$("#msg_users").load(site_url +'/chat_sidebar/' +$username);
		$("#msg_users").timer({
			delay: 20000, //poll every 30 sec (30000)
			repeat: true,
			url: site_url +'/chat_sidebar/' +$username
		});
	}
</script>

<!-- load the chat messages -->
<script>
	function load_chat($user){
		$("#load_chat").load(site_url +'/chat/'+$user);
	}
</script>

<!-- submit message -->
<script>
	function empty(){
		var x;
		x = document.getElementById("msg-input").value;
			if (x == ""){ 
				$('#workingBtn').css('display','none');
				$('#sendMsgs').css('display','block');
				alert("Please enter a message");
				return;
			} else {
				submitForm(); 
			}
	}

function submitForm(){
	$('#sendMsgs').css('display','none');
	$('#workingBtn').css('display','block');
	$('#addMessage').ajaxForm({ 
		success: function() { 
			setTimeout(function(){
				$('#addMessage').clearForm();
				load_chat('<?php echo $user_name ?>');
				$('#sendMsgs').css('display','block');
				$('#workingBtn').css('display','none');
			}, 2000);
		} 
	});
}
</script>

<script>
$last_id = "<?php echo $l_m_id ?>";
$other_user = "<?php echo $other_user ?>";
function check_msg_id(){
	$.post( site_url +"/p/messaging/", { isv_op: "last_msg_id", other_user: $other_user })
	  .done(function( data ) {
		  if(data > $last_id){
			  $last_id = data;
			  load_chat('<?php echo $user_name ?>');
			  //console.log($last_id);
			  return;
		  } else {
			  //$last_id = $last_id;
			  //console.log('ignore');
			  return;
		  }
		
	 });
}
</script>

<!-- Block User Modal-->
<div class="modal fade" id="delete_chat" tabindex="-1" role="dialog" aria-labelledby="delete_chat">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Delete Chat</h4>
      </div>
      <div class="modal-body">
		Are you sure you want to delete this chat?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <a href="<?php echo ISVIPI_URL.'p/messaging/delete/'.$converter->encode($other_user) ?>" class="btn btn-primary">Yes, Delete Chat</a>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->