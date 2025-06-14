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

    public function get_style_depends() {
        return [ 'eu9-widget-style' ];
    }

    public function get_script_depends() {
        return [ 'eu9-widget-script' ];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'section_button',
            [
                'label' => __( 'Button', 'elementor-custom' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_responsive_control(
            'button_width',
            [
                'label' => __( 'Width (px)', 'elementor-custom' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 500,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .eu9-search-button > .btn-search' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'button_height',
            [
                'label' => __( 'Height (px)', 'elementor-custom' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 200,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .eu9-search-button > .btn-search' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'button_icon_color',
            [
                'label' => __( 'Search Icon Color', 'elementor-custom' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eu9-search-button > .btn-search i' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_bg_color',
            [
                'label' => __( 'Button Background Color', 'elementor-custom' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eu9-search-button > .btn-search' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
        
        $this->start_controls_section(
            'section_form',
            [
                'label' => __( 'Form', 'elementor-custom' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_responsive_control(
            'form_max_width',
            [
                'label' => __( 'Search Form Max Width', 'elementor-custom' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 100,
                        'max' => 1000,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 500,
                ],
                'tablet_default' => [
                    'unit' => 'px',
                    'size' => 300,
                ],
                'selectors' => [
                    '{{WRAPPER}} .eu9-search-form input' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'form_icon_color',
            [
                'label' => __( 'Search Icon Color (Form)', 'elementor-custom' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eu9-search-form .btn-search i' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'form_bg_color',
            [
                'label' => __( 'Button Background Color (Form)', 'elementor-custom' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eu9-search-form .btn-search' => 'background-color: {{VALUE}};',
                ],
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
                <button type="button" class="btn btn-close" data-parent=".eu9-search-button"><span class="d-none">Close</span></button>
                <div class="form-inner">
                    <input type="text" name="s"/>
                    <button type="submit" class="btn btn-search"><span class="d-none">Submit</span><i class="fas fa-search"></i></button>
                </div>
            </form>
        </div>
    <?php
    }

    protected function _content_template() {
    ?>
        <div class="eu9-search-button">
            <button type="button" class="btn btn-search" id="eu9-search-button">
                <span class="d-none">Search</span>
                <i class="fas fa-search"></i>
            </button>
            <form class="eu9-search-form" id="eu9-search-form" role="search" method="get" action="/">
                <button type="button" class="btn btn-close" data-parent=".eu9-search-button"><span class="d-none">Close</span></button>
                <div class="form-inner">
                    <input type="text" name="s"/>
                    <button type="submit" class="btn btn-search"><span class="d-none">Submit</span><i class="fas fa-search"></i></button>
                </div>
            </form>
        </div>
    <?php
    }

}