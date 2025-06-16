$(document).ready(function() {
    var lastScrollTop = 0;
    const mobileNavbar = $('#mobile-menu-navigation');
	headerScrollDetection();
		
	if( window.matchMedia('(min-width: 1200px)').matches ) {
		headerScrollDetection();
	}

	function headerScrollDetection() {
		$(window).bind('scroll', function() {
			var scrollTop = $(this).scrollTop();

			if (scrollTop > 220) {
				if( !mobileNavbar.hasClass('scroll-down') ) {
					mobileNavbar.addClass('scroll-down');
				}
			} else {
				if( mobileNavbar.hasClass('scroll-down') ) {
					mobileNavbar.removeClass('scroll-down');
				}
			}
		});
	}

    document.querySelector('#mobile-menu-navigation .eael-simple-menu-toggle').addEventListener('click', function () {
      	document.getElementById('mobile-menu-navigation').classList.toggle('menu-opened');
    });
});