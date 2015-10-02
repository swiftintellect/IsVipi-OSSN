var is_loading = false; // initialize is_loading by false to accept new loading
var limit = 4; // limit items per page
$(function() {
    $(window).scroll(function() {
        if($(window).scrollTop() >= $('#f_content').offset().top + $('#f_content').outerHeight() - window.innerHeight) {
            if (is_loading == false) { // stop loading many times for the same page
                // set is_loading to true to refuse new loading
                is_loading = true;
                // display the waiting loader
				
                $('#loader-feed').show();
                // execute an ajax query to load more statments
                $.ajax({
                    url: '../more-feeds.php',
                    type: 'POST',
                    data: {last_id:last_id, limit:limit},
                    success:function(data){
                        // now we have the response, so hide the loader
                        $('#loader-feed').hide();
                        // append: add the new statments to the existing data
                        $('#f_content').append(data);
                        // set is_loading to false to accept new loading
                        is_loading = false;
                    }
                });
            }
       }
    });
});
