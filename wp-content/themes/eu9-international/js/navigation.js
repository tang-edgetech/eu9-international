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

	$(document).on('click', '#mobile-menu-navigation .eael-simple-menu-toggle', function (e) {
		e.preventDefault();
		var $this = $(this),
			$parent = $this.parents('.eael-simple-menu-container'),
			$sibling = $this.siblings('.eael-simple-menu');
		if( $parent.hasClass('menu-slidein') ) {
			$parent.removeClass('menu-slidein');
			$this.prop('disabled', true);
			setTimeout(function() {
				$this.prop('disabled', false);
			}, 300);
		}
		else {
			$parent.addClass('menu-slidein');
			$this.prop('disabled', true);
			setTimeout(function() {
				$this.prop('disabled', false);
			}, 300);
		}
	});

    document.querySelector('#mobile-menu-navigation .eael-simple-menu-toggle').addEventListener('click', function () {
      	document.getElementById('mobile-menu-navigation').classList.toggle('menu-opened');
    });

	// Copy the .elementor-grid-item elements from #custom-social-media
	var copiedItems = $('#custom-social-media .elementor-grid-item').clone();

	// Now you can append them somewhere else, for example into another container:
	$('#target-container').append(copiedItems);

	$('#masthead .eael-simple-menu .menu-item').each(function() {
		var $this = $(this);
		if( $this.hasClass('current-menu-item') && !$this.children('a').hasClass('eael-item-active') ) {
			$this.children('a').addClass('eael-item-active');
		}
	});
});