/* sidebar menu toggle */
$('#menu_toggle').click(function () {
        if ($('body').hasClass('nav-md')) {
            $('body').removeClass('nav-md');
            $('body').addClass('nav-sm');
            $('.left_col').removeClass('scroll-view');
            $('.left_col').removeAttr('style');
            $('.sidebar-footer').hide();

            if ($('#sidebar-menu li').hasClass('active')) {
                $('#sidebar-menu li.active').addClass('active-sm');
                $('#sidebar-menu li.active').removeClass('active');
            }
        } else {
            $('body').removeClass('nav-sm');
            $('body').addClass('nav-md');
            $('.sidebar-footer').show();

            if ($('#sidebar-menu li').hasClass('active-sm')) {
                $('#sidebar-menu li.active-sm').addClass('active');
                $('#sidebar-menu li.active-sm').removeClass('active-sm');
            }
        }
});

if($('#sidebar-menu ul li ul').hasClass( "actived" )){
	$(this).attr('style','display: block !important');
	$(this).slideDown();

} else {
	$('ul', this).slideUp();
}

/**   left sidebar menu  dropdowns **/
$('#sidebar-menu li').click(function () {
	if ($(this).is('.active')){
		$('ul', this).slideUp();
		$('ul', this).css('display','none');
		$(this).removeClass('active');
	} else {
		$('ul', this).slideDown();
		$('ul', this).css('display','block');
		$(this).addClass('active');
	}
	
});	

/** ******  tooltip  *********************** **/
$(function () {
	$('[data-toggle="tooltip"]').tooltip()
})
