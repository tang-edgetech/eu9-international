$(document).ready(function() {
    var lastScrollTop = 0;
    const mobileNavbar = $('#mobile-menu-navigation');
    $(window).bind('scroll', function() {
        headerScrollDetection();
    });
	function headerScrollDetection() {
		var scrollTop = $(this).scrollTop();

		if (scrollTop > 70) {
			if (scrollTop > lastScrollTop) {
				mobileNavbar.addClass('scroll-down');
			} else {
				mobileNavbar.removeClass('scroll-down');
			}
		} else {
			mobileNavbar.removeClass('scroll-down');
		}

		lastScrollTop = scrollTop;
	}
	
    document.querySelector('#mobile-menu-navigation .eael-simple-menu-toggle').addEventListener('click', function () {
      	document.getElementById('mobile-menu-navigation').classList.toggle('menu-opened');
    });
});