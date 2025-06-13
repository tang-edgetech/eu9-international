<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class EU9_Search_Keyword_Widget extends Widget_Base {

    public function get_name() {
        return 'eu9-search-keyword';
    }

    public function get_title() {
        return __( 'EU9 Search Keyword', 'elementor-custom' );
    }

    public function get_icon() {
        return 'eicon-search';
    }

    public function get_categories() {
        return [ 'eu9-category' ];
    }

    public function get_keywords() {
        return [ 'search', 'keyword', 'eu9' ];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __( 'Settings', 'elementor-custom' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->end_controls_section();
    }
    
    protected function render() {
        $settings = $this->get_settings_for_display();
    ?>
        <div class="eu9-search-button">
            <button type="button" class="btn btn-search" id="eu9-search-button">
                <span class="d-none">Search</span>
                <i class="fas fa-search"></i>
            </button>
            <form class="eu9-search-form" id="eu9-search-form" role="search" method="get" action="<?php echo home_url('/'); ?>">
                <input type="text" name="s"/>
            </form>
        </div>
    <?php
    }

    protected function _content_template() {
    ?>
    <?php
    }
}