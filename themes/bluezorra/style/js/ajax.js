//JQuery function for like, unlike, delete
function postFunction(processIDencr,feedID,feedPoster){
		$.ajax({
		  type: "POST",
		  url: fullURL+"/users/processFeed/"+processIDencr+"/"+feedID+"/"+feedPoster+"",
		})
	$("#working"+feedID).show();
}
//JQuery function for like,unlike,delete comment
function postCommentFunction(commAction,feedID,CommId){
		$.ajax({
		  type: "POST",
		  url: fullURL+"/users/processFeed/"+commAction+"/"+feedID+"/"+CommId+"/",
		})
	$("#processing"+CommId).show();
}
