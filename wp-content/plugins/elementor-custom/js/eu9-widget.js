jQuery(document).ready(function($) {
    console.log('Reading');
    $(document).on('click', '.elementor-widget-eu9-search-keyword .eu9-search-button > .btn-search', function(e) {
        e.preventDefault();
        var $this = $(this),
            $parent = $this.parents('.eu9-search-button');
        $parent.addClass('overlay-search-opened');
        $this.siblings('.eu9-search-form').fadeIn();
        $('body').addClass('search-form-opened');
    });

    $(document).on('click', '.elementor-widget-eu9-search-keyword .btn-close', function(e) {
        e.preventDefault();
        var $this = $(this),
            $data_target = $this.attr('data-parent'),
            $parent = $this.parents($data_target),
            $form = $this.parents('.eu9-search-form');
        if( $parent.hasClass('overlay-search-opened') ) {
            $parent.removeClass('overlay-search-opened');
            $form.fadeOut();
            $('body').removeClass('search-form-opened');
        }
    });
});

jQuery(window).on('load', function () {

    if( $('.post-grid-swiper').length > 0 ) {
        $('.post-grid-swiper').each(function() {
            var $this = $(this),
                $unique_id = $this.attr('data-unique-id'),
                $ppp = parseInt($this.attr('data-ppp')),
                $spaceBetween = parseInt($this.attr('data-spaceBetween'));
            new Swiper(this, {
                spaceBetween: $spaceBetween,
                loop: true,
                navigation: {
                    prevEl: '.btn-prev-' + String($unique_id),
                    nextEl: '.btn-next-' + String($unique_id),
                },
                breakpoints: {
                    0: {
                        slidesPerView: 1,
                    }, 
                    768: {
                        slidesPerView: $ppp,
                    }
                }
            });
        });
    }
});