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

if($('#sidebar-menu ul li').hasClass("active" )){
	$('#sidebar-menu ul li ul.drop-it').removeClass('no-display');
}

/**   left sidebar menu  dropdowns **/
$('#sidebar-menu li').click(function () {
	if ($(this).is('.active')) {
			$('ul', this).addClass('no-display');
            $('ul', this).slideUp();
			$(this).removeClass('active');
        } else {
			$('ul', this).removeClass('no-display');
            $('#sidebar-menu li ul').slideDown();
            $(this).addClass('active');
        }
	
});	

/** ******  tooltip  *********************** **/
$(function () {
	$('[data-toggle="tooltip"]').tooltip()
})
