/***********************************************************************************************************
* Attribution to Vasplus Programming Blog
*************************************************************************************************************/
(function($) 
{
	$.fn.isvipi_load_more = function(options) {
		
		var scroll_config = { 
			scroll_total_per_load  : 5, // Total number of posts per scroll to be loaded on the page
			scroll_start           : 0, // Default - loading start at 0 offset
			scroll_end         : '<center><i class="fa fa-circle"></i><i class="fa fa-circle"></i><i class="fa fa-circle"></i></center>', // This is the message shown to the user when the post is finished
			scroll_load_more       : '<center><img src="'+fullURL+'/inc/style.lib/images/t_loading.gif" height="15"/></center>', // This is the message shown to the user when set auto scroll to false to load more data    
			scroll_delay           : 1000, // Wait after this time when a user scrolls down to start again
			scroll_auto_load       : true, // Set to true for auto scroll and set to false to scroll manually
			sroll_p_identifier : 'laod-more-post', // Not really necessary unless you need it otherwise leave it alone
			scroll_url             : fullURL+'/remote/t_feed/', // This is the URL to the page that gets content from the database
			scroll_loading_div  : 'scroll_loading_box' // This is the ID of the div where the loaded contents will be displayed
		}
		
		if(options) { $.extend(scroll_config, options); }
		return this.each(function() 
		{
			$this = $(this);
			$scroll_config = scroll_config;
			var scroll_start = $scroll_config.scroll_start;
			var vpb_process_started = false; // If the scroll process is running then pause
			
			$this.append('<div class="vpb-datas"></div><div id="'+$scroll_config.scroll_loading_div+'">'+$scroll_config.scroll_load_more+'</div>');
			
			function vasplus_load_more_data_system() {
				if($scroll_config.scroll_url == "") { alert('Error: the page to load data was not passed.\nThank You!'); }
				else {
					$.post($scroll_config.scroll_url, {
							
						page   : $scroll_config.sroll_p_identifier,
						scroll_total  : $scroll_config.scroll_total_per_load,
						scroll_start  : scroll_start
							
					}, function(response) {
						$this.find('#'+$scroll_config.scroll_loading_div).html($scroll_config.scroll_load_more);
						
						var response_brought = response.indexOf('scroll_finished');
						if(response_brought != -1) { 
							$this.find('#'+$scroll_config.scroll_loading_div).show().html($scroll_config.scroll_end);	
						}
						else {
							scroll_start = scroll_start+$scroll_config.scroll_total_per_load; 
							$this.find('.vpb-datas').append(response);	
							vpb_process_started = false;
							$this.find('#'+$scroll_config.scroll_loading_div).show();
						}	
							
					});
				}
			}	
			vasplus_load_more_data_system(); // Called on page load
			if( $scroll_config.scroll_auto_load == true ) // Auto Scroll
			{
				$(window).scroll(function() {
					if($(window).scrollTop() + $(window).height() > $this.height() && !vpb_process_started) {
						
						vpb_process_started = true;
						$this.find('#'+$scroll_config.scroll_loading_div).html('<center><img src="'+fullURL+'/inc/style.lib/images/t_loading.gif" height="15"/></center>');
						setTimeout(function() {
							vasplus_load_more_data_system();
						}, $scroll_config.scroll_delay);
					}	
				});
			}
			else {}
			$this.find('#'+$scroll_config.scroll_loading_div).click(function() // Manual Scroll
			{
				if(vpb_process_started == false) {
					vpb_process_started = true;
					vasplus_load_more_data_system();
				}
			});
		});
	}
})(jQuery);