        <!-- FEED ACTIONS (Like, Unlike, Delete) -->
        <script>
			function feedAction($feed,$type){
				$('#FAction'+$feed).css('display','inline-block');
				$.ajax({
				  type: "POST",
				  url: site_url+"/p/feeds/"+$type+"/"+$feed,
				})
				setTimeout(function(){
					$('#FAction' + $feed).css('display','none');
					loadTimeline();
					return false;
				}, 500);
			}
		</script>
        
        <!-- DELETE FEED -->
        <script>
			function deleteFeed($feed,$type){
				$('#f_content' + $feed).fadeTo( "slow" , 0.4, function() {});
				$.ajax({
				  type: "POST",
				  url: site_url+"/p/feeds/"+$type+"/"+$feed,
				})
				setTimeout(function(){
					loadTimeline();
					return false;
				}, 500);
			}
		</script>
        
        <!-- COMMENT FEED ACTIONS (Like, Unlike) -->
        <script>
			function commentAction($commentID,$type){
				$('#CAction' + $commentID).css('display','inline-block');
				$.ajax({
				  type: "POST",
				  url: site_url+"/p/feeds/"+$type+"/"+$commentID,
				})
				setTimeout(function(){
					$('#CAction' + $commentID).css('display','none');
					loadTimeline();
					return false;
				}, 500);
			}
		</script>
        
        <!-- DELETE COMMENT -->
        <script>
			function deleteComment($comm_id,$type){
				$('#comBox' + $comm_id).fadeTo( "slow" , 0.2, function() {});
				$.ajax({
				  type: "POST",
				  url: site_url+"/p/feeds/"+$type+"/"+$comm_id,
				})
				setTimeout(function(){
					$('#comBox' + $comm_id).fadeOut();
					//loadTimeline();
					return false;
				}, 500);
			}
		</script>
