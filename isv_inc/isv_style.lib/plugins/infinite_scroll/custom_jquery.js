_debug = false;

function dbg(msg) {
    if (_debug)
        console.log (msg);
}

$(document).ready(function() {
    doMouseWheel = 1 ;
    $("#tFeeds").append( "<p id='last'></p>" );
    dbg("Document Ready");

    $(window).scroll(function() {
        dbg("Window Scroll Start");

        if (!doMouseWheel)
            return;

        var distanceTop = $('#last').offset().top - $(window).height();
        if  ($(window).scrollTop() > distanceTop) {
            dbg("Window distanceTop to scrollTop Start");
            $('div#loadMoreFeeds').show();
            doMouseWheel = 0 ;
            
            dbg("Another window to the end !!!! "+$(".tFeeds:last").attr('id'));
            $.ajax({
                dataType : "html",
                url: "feeds.php/"+ $(".tFeeds:last").attr('id'),
                success: function(html) {
                    doMouseWheel = 1 ;
                    if(html){
                        $("#tFeeds").append(html);
                        dbg('Append html: ' + $(".tFeeds:first").attr('id'));
                        dbg('Append html: ' + $(".tFeeds:last").attr('id'));

                        $("#last").remove();
                        $("#tFeeds").append( "<p id='last'></p>" );
                        $('div#loadMoreFeeds').hide();
                    } else {
                        //Disable Ajax when result from PHP-script is empty (no more DB-results )
                        $('div#loadMoreFeeds').replaceWith( "<center><h1 style='color:red'>End of countries !!!!!!!</h1></center>" );
                        doMouseWheel = 0 ;
                    }
                }
            });
        }
    });
});


