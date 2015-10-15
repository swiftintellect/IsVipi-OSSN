        <!-- LOAD SINGLE FEED -->
        <script>
			function loadFeed($feed_id){
				$('#tFeeds').load(site_url +'/post_id/'+$feed_id);
			}
		</script>
        <!-- FEED ACTIONS (Like, Unlike, Delete) -->
        <script>
			function feedAction($feed,$type,$feed_id){
				$('#FAction'+$feed).css('display','inline-block');
				$.ajax({
				  type: "POST",
				  url: site_url+"/p/feeds/"+$type+"/"+$feed,
				})
				setTimeout(function(){
					$('#FAction' + $feed).css('display','none');
					loadFeed($feed_id);
					return false;
				}, 2000);
			}
		</script>
        
        <!-- DELETE FEED -->
        <script>
			function deleteFeed($feed,$type,$feed_id){
				$('#f_content' + $feed).fadeTo( "slow" , 0.4, function() {});
				$.ajax({
				  type: "POST",
				  url: site_url+"/p/feeds/"+$type+"/"+$feed,
				})
				setTimeout(function(){
					loadFeed($feed_id);
					return false;
				}, 2000);
			}
		</script>
        
        <!-- COMMENT FEED ACTIONS (Like, Unlike) -->
        <script>
			function commentAction($commentID,$type,$feed_id){
				$('#CAction' + $commentID).css('display','inline-block');
				$.ajax({
				  type: "POST",
				  url: site_url+"/p/feeds/"+$type+"/"+$commentID,
				})
				setTimeout(function(){
					$('#CAction' + $commentID).css('display','none');
					loadFeed($feed_id);
					return false;
				}, 2000);
			}
		</script>
        
        <!-- DELETE COMMENT -->
        <script>
			function deleteComment($comm_id,$type,$feed_id){
				$('#comBox' + $comm_id).fadeTo( "slow" , 0.2, function() {});
				$.ajax({
				  type: "POST",
				  url: site_url+"/p/feeds/"+$type+"/"+$comm_id,
				})
				setTimeout(function(){
					$('#comBox' + $comm_id).fadeOut();
					loadFeed($feed_id);
					return false;
				}, 2000);
			}
		</script>

