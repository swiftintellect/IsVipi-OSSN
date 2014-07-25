function postFunction(processIDencr,feedID,feedPoster){
		$.ajax({
		  type: "POST",
		  url: fullURL+"/users/processFeed/"+processIDencr+"/"+feedID+"/"+feedPoster+"",
		})
	$("#working"+feedID).show();
}

function postCommentFunction(commAction,feedID,CommId){
		$.ajax({
		  type: "POST",
		  url: fullURL+"/users/processFeed/"+commAction+"/"+feedID+"/"+CommId+"/",
		})
	$("#save"+CommId).show();
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
