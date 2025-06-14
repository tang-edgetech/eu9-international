jQuery(document).ready(function($) {
    console.log('Reading');
    $(document).on('click', '.elementor-widget-eu9-search-keyword #eu9-search-button', function(e) {
        e.preventDefault();
        var $this = $(this),
            $parent = $this.parents('.eu9-search-button');
        $parent.addClass('overlay-search-opened');
        $this.siblings('#eu9-search-form').fadeIn();
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
        }
    });
});