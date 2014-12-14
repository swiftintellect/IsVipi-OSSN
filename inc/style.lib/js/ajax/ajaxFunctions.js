//Initialize Timeline
function TimelineInit(){
$('.refresh_timeline').load(fullURL+"/remote/t_feed/");
    $('.refresh_timeline').timer({
		delay: 60000,
		repeat: true,
		url: fullURL+"/remote/t_feed/"
	});	
	
}
//JQuery Function to load the timeline
function LoadTimeline(){
		$('.refresh_timeline').load(fullURL+"/remote/t_feed/");
	}

//JQuery function for like, unlike, delete
function postFunction(processIDencr,feedID,feedPoster){
		$.ajax({
		  type: "POST",
		  url: fullURL+"/users/processFeed/"+processIDencr+"/"+feedID+"/"+feedPoster+"",
		})
	$("#working"+feedID).show();
	LoadTimeline();
}
//JQuery function for like,unlike,delete comment
function postCommentFunction(commAction,feedID,CommId){
		$.ajax({
		  type: "POST",
		  url: fullURL+"/users/processFeed/"+commAction+"/"+feedID+"/"+CommId+"/",
		})
	$("#save"+CommId).show();
	LoadTimeline();
}

function pmList(convUsr){ $(function(){
	 $(pmLoading).show();
	interval = setInterval(function() {
	$( "#pmRefresh" ).load( fullURL+"/remote/pm/"+convUsr, function() {
		$('.emoticon').emoticonize({
				animate: false,
			});
	  $("[data-toggle='tooltip']").tooltip();
	});
	}, 500);
  });
}
function pagiNation(urlTo){
		$.ajax({
		  type: "POST",
		  url: urlTo,
		})
}
