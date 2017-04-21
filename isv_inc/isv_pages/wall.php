<?php
	/*******************************************************
	 *   Copyright (C) 2014  http://isvipi.org
	
		This program is free software; you can redistribute it and/or modify
		it under the terms of the GNU General Public License as published by
		the Free Software Foundation; either version 2 of the License, or
		(at your option) any later version.
	
		This program is distributed in the hope that it will be useful,
		but WITHOUT ANY WARRANTY; without even the implied warranty of
		MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
		GNU General Public License for more details.
	
		You should have received a copy of the GNU General Public License along
		with this program; if not, write to the Free Software Foundation, Inc.,
		51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
	 ******************************************************/
	require_once(ISVIPI_PAGES_BASE .'m_base.php'); 
	require_once(ISVIPI_CLASSES_BASE .'global/getWall_cls.php'); 
	require_once(ISVIPI_CLASSES_BASE .'global/getFriends_cls.php'); 
	$friends = new get_friends();
	
	//get the user id
	if(!isset($PAGE[1])){
		exit();
	}
	
	$user = $PAGE[1];
	//check if it is numeric
	if(!is_numeric($user)){
		exit();
	}
	
	//instantiate our class
	$getFeeds = new getFeeds($user);
	
	//get total feeds
	$fTotal = $getFeeds->getTotalFeeds($user);
	
	//set feed limit
	if(isset($PAGE[2]) && is_numeric($PAGE[2])){
		$fLimit = cleanGET($PAGE[2]);
	} else {
		$fLimit = "5";
	}

	//determine end of the feeds
	if($fLimit >= $fTotal){
		$end = 'yes';
	} else {
		$end = 'no';
	}
	
	//retrieve all wall feeds
	$feed = $getFeeds->allFeeds($user,$fLimit);
?>
	<script>
		var total_f = Number("<?php echo $fTotal ?>");
		var feeds_to_load = Number("<?php echo ISV_FEEDS_TO_LOAD ?>");
		var feed_limit = Number("<?php echo $fLimit ?>");
		var end_reached = "<?php echo $end ?>";
		//console.log(feeds_to_load);
	</script>
<?php

 	include_once ISVIPI_ACT_THEME.'wall.php'; 
