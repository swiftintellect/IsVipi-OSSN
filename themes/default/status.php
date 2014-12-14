<?php get_header()?>
<script>
$(document).ready(function() {
$('#refresh_timeline').load(fullURL+"/remote/single_feed/<?php echo $statusID ?>");
});
</script>
<script>
function LoadSingTimeline(){
		$('#refresh_timeline').load(fullURL+"/remote/single_feed/<?php echo $statusID ?>");
	}

//JQuery function for like,unlike,delete single comment
function postSingCommentFunction(commAction,feedID,CommId){
		$.ajax({
		  type: "POST",
		  url: fullURL+"/users/processFeed/"+commAction+"/"+feedID+"/"+CommId+"/",
		})
	$("#save"+CommId).show();
	LoadSingTimeline();
}
 
</script>
<link href="<?php echo ISVIPI_STYLE_URL; ?>css/isvipi-timeline.css" rel="stylesheet" type="text/css" />
<?php get_sidebar();
?>
	<div class="dash_content">
    <div class="panel panel-primary full-length">
    <div id="nobgcolor">
    	<div class="emoticon">
    	<div id="refresh_timeline">
    		<center>
            <div id="loadingFeeds" style="font-size:18px">
            <img src="<?php echo ISVIPI_STYLE_URL.'images/t_loading.gif'?>" height="20" />
            </div>
            </center>
		</div>
		</div>
    </div>
    </div>
    </div>
                                    
<?php get_r_sidebar()?>
<?php get_footer()?>