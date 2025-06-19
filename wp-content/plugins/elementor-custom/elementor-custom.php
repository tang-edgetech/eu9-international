<?php
/**
 * Plugin Name: Elementor Custom Widgets
 * Description: Custom widgets for Elementor.
 * Version: 1.0.0
 * Text Domain: elementor-custom
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// Register widgets
function eu9_register_custom_widgets( $widgets_manager ) {
    // Load custom REST API logic
    require_once( __DIR__ . '/includes/rest-api.php' );
    
    require_once( __DIR__ . '/widgets/eu9-copyright.php' );
    require_once( __DIR__ . '/widgets/eu9-datetime-picker.php' );
    require_once( __DIR__ . '/widgets/eu9-magic-post-grid.php' );
    require_once( __DIR__ . '/widgets/eu9-post-tag.php' );
    require_once( __DIR__ . '/widgets/eu9-post-list.php' );
    require_once( __DIR__ . '/widgets/eu9-post-list-slider.php' );
    require_once( __DIR__ . '/widgets/eu9-search-keyword.php' );
    require_once( __DIR__ . '/widgets/eu9-post-list-special.php' );
    $widgets_manager->register( new \EU9_Copyright_Widget() );
    $widgets_manager->register( new \EU9_DateTime_Picker_Widget() );
    $widgets_manager->register( new \EU9_Magic_Post_Grid_Widget () );
    $widgets_manager->register( new \EU9_Post_Tag_Widget () );
    $widgets_manager->register( new \EU9_Post_List_Widget () );
    $widgets_manager->register( new \EU9_Post_List_Slider_Widget () );
    $widgets_manager->register( new \EU9_Search_Keyword_Widget () );
    $widgets_manager->register( new \EU9_Post_List_Special_Widget () );
}
add_action( 'elementor/widgets/register', 'eu9_register_custom_widgets' );

// Register custom category
function eu9_add_elementor_widget_categories( $elements_manager ) {
    $elements_manager->add_category(
        'eu9-category',
        [
            'title' => __( 'EU9', 'elementor-custom' ),
            'icon'  => 'fa fa-plug',
        ]
    );
}
add_action( 'elementor/elements/categories_registered', 'eu9_add_elementor_widget_categories' );

function eu9_register_widget_styles() {
    wp_register_style(
        'eu9-widget-style',
        plugin_dir_url( __FILE__ ) . 'css/eu9-widget.css',
        [],
        '1.0.'.time()
    );
    wp_register_script(
        'eu9-widget-script',
        plugin_dir_url( __FILE__ ) . 'js/eu9-widget.js',
        ('jQuery'),
        '1.0.'.time()
    );
}
add_action( 'wp_enqueue_scripts', 'eu9_register_widget_styles' );