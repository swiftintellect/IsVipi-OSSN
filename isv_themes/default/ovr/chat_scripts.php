<?php require_once(ISVIPI_CLASSES_BASE .'global/getMessages_cls.php'); 
	$ch = new get_messages();
	
	if(id_from_username($user_name))
	$l_m_id = $ch->last_msg_id($_SESSION['isv_user_id'],$user_id);
	
	$other_user = $user_id;
?>

<!-- load the chat users sidebar -->
<script>
	function load_chat_sidebar($username){
		$("#msg_users").load(site_url +'/chat_sidebar/' +$username);
		$("#msg_users").timer({
			delay: 30000, //poll every 30 sec (30000)
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
	$.post( site_url +"p/messaging/", { isv_op: "last_msg_id", other_user: $other_user })
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