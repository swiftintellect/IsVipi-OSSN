      <!-- load this when a user is on the timeline feed -->
	  <?php if (isset($PAGE[0]) && $PAGE[0] == 'profile'){ ?>
        <!-- LOAD WALL -->
        <script>
			function loadWall($user){
				$('#tWall').load('<?php echo ISVIPI_URL .'wall/' ?>' +$user);
			}
		</script>
        
        <!-- FEED ACTIONS (Like, Unlike, Delete) -->
        <script>
			function feedAction($feed,$type,$owner){
				$('#FAction' + $feed).css('display','inline-block');
				$.ajax({
				  type: "POST",
				  url: <?php echo ISVIPI_URL ?>+"/p/feeds/"+$type+"/"+$feed,
				})
				setTimeout(function(){
					$('#FAction' + $feed).css('display','none');
					loadWall($owner);
					return false;
				}, 2000);
			}
		</script>
        
        <!-- DELETE FEED -->
        <script>
			function deleteFeed($feed,$type,$owner){
				$('#f_content' + $feed).fadeTo( "slow" , 0.4, function() {});
				$.ajax({
				  type: "POST",
				  url: <?php echo ISVIPI_URL ?>+"/p/feeds/"+$type+"/"+$feed,
				})
				setTimeout(function(){
					loadWall($owner);
					return false;
				}, 2000);
			}
		</script>
        
        <!-- COMMENT FEED ACTIONS (Like, Unlike) -->
        <script>
			function commentAction($commentID,$type,$owner){
				$('#CAction' + $commentID).css('display','inline-block');
				$.ajax({
				  type: "POST",
				  url: <?php echo ISVIPI_URL ?>+"/p/feeds/"+$type+"/"+$commentID,
				})
				setTimeout(function(){
					$('#CAction' + $commentID).css('display','none');
					loadWall($owner);
					return false;
				}, 2000);
			}
		</script>
        
        <!-- DELETE COMMENT -->
        <script>
			function deleteComment($comm_id,$type,$owner){
				$('#comBox' + $comm_id).fadeTo( "slow" , 0.2, function() {});
				$.ajax({
				  type: "POST",
				  url: <?php echo ISVIPI_URL ?>+"/p/feeds/"+$type+"/"+$comm_id,
				})
				setTimeout(function(){
					$('#comBox' + $comm_id).fadeOut();
					loadWall($owner);
					return false;
				}, 2000);
			}
		</script>

        <?php } ?>
