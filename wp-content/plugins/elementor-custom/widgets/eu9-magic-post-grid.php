<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class EU9_Magic_Post_Grid_Widget extends Widget_Base {

    public function get_name() {
        return 'eu9-magic-post-grid';
    }

    public function get_title() {
        return __( 'EU9 Magic Post Grid', 'elementor-custom' );
    }

    public function get_icon() {
        return 'eicon-posts-grid';
    }

    public function get_categories() {
        return [ 'eu9-category' ];
    }

    public function get_keywords() {
        return [ 'post', 'tag', 'eu9', 'category', 'grid' ];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __( 'Tag Filter', 'elementor-custom' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->end_controls_section();
    }
    
    protected function render() {
        $settings = $this->get_settings_for_display();

    }

    protected function _content_template() {
    ?>
    <?php
    }
}