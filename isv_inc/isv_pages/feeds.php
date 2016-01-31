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
	require_once(ISVIPI_CLASSES_BASE .'global/getFeeds_cls.php'); 
	
	//instantiate our class	
	$getFeeds = new getFeeds();
	
	//get total number of feeds
	$fTotal = $getFeeds->getTotalFeeds();
	
	//set feed limit
	if(isset($PAGE[1]) && is_numeric($PAGE[1])){
		$fLimit = cleanGET($PAGE[1]);
	} else {
		$fLimit = "5";
	}

	//get all fields by this user
	$feed = $getFeeds->allFeeds($fLimit);
	
	//determine end of the feeds
	if($fLimit >= $fTotal){
		$end = 'yes';
	} else {
		$end = 'no';
	}
		
?>
	<script>
		var total_f = Number("<?php echo $fTotal ?>");
		var feeds_to_load = Number("<?php echo ISV_FEEDS_TO_LOAD ?>");
		var feed_limit = Number("<?php echo $fLimit ?>");
		var end_reached = "<?php echo $end ?>";
		//console.log(feeds_to_load);
	</script>
<?php
 	include_once ISVIPI_ACT_THEME.'feeds.php'; 
