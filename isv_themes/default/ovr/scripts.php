      <!-- load this when a user is on the timeline feed -->
	  <?php if (isset($PAGE[0]) && $PAGE[0] == 'home'){ ?>
      
      <!-- TEXT FEED -->
      <script>
		$('#text-update').ajaxForm({ 
			dataType: 'json', 
			success: function(json) { 
			$("#processing").show();
			$('#errorLog').css('display','none');
			$('input[type="submit"]').prop('disabled', true);
				setTimeout(function(){
					if(json.err == true) {
						$('#errorLog').css('display','block');
						$('#errorLog').html(json.message);
					} else if (json.err == false){
						$('#errorLog').css('display','none');
						$('#text-update').clearForm();
						$('#text-update').resetForm();
						//reload our timeline
						loadTimeline();
					}
					$('input[type="submit"]').prop('disabled', false);
					$("#processing").hide();
				}, 3000);
			 } 
			});
		</script>
        
      <!-- IMAGE FEED -->
      <script>
		$('#imgFeed').ajaxForm({ 
			dataType: 'json', 
			success: function(json) { 
			$("#processing2").show();
			$('#errorLog').css('display','none');
			$('input[type="submit"]').prop('disabled', true);
				setTimeout(function(){
					if(json.err == true) {
						$('#errorLog').css('display','block');
						$('#errorLog').html(json.message);
					} else if (json.err == false){
						$('#errorLog').css('display','none');
						$('#imgFeed').clearForm();
						$('#preview').css('display','none');
						$('#preview2').css('display','block');
						//reload our timeline
						loadTimeline();
					}
					$('input[type="submit"]').prop('disabled', false);
					$("#processing2").hide();
				}, 3000);
			 } 
			});
		</script>
        
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
				 $('#preview').attr('src', 'http://localhost/isvipi/isv_inc/isv_style.lib/default/images/logo.png');
			}
		}
		$("#imgInp").change(function(){
			readURL(this);
		});
		</script>
        

        
        <!-- LOAD TIMELINE -->
        <script>
			function loadTimeline(){
				$('#tFeeds').load('<?php echo ISVIPI_URL .'feeds/' ?>');
			}
		</script>
        
        <!-- FEED ACTIONS (Like, Unlike, Delete) -->
        <script>
			function feedAction($feed,$type){
				$('#FAction' + $feed).css('display','inline-block');
				$.ajax({
				  type: "POST",
				  url: <?php echo ISVIPI_URL ?>+"/p/feeds/"+$type+"/"+$feed,
				})
				setTimeout(function(){
					$('#FAction' + $feed).css('display','none');
					loadTimeline();
					return false;
				}, 2000);
			}
		</script>
        
                <!-- FEED ACTIONS (Like, Unlike, Delete) -->
        <script>
			function commentAction($commentID,$type){
				$('#CAction' + $commentID).css('display','inline-block');
				$.ajax({
				  type: "POST",
				  url: <?php echo ISVIPI_URL ?>+"/p/feeds/"+$type+"/"+$feed,
				})
				setTimeout(function(){
					$('#CAction' + $feed).css('display','none');
					loadTimeline();
					return false;
				}, 2000);
			}
		</script>

        <?php } ?>
