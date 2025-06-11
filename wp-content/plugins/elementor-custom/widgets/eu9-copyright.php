<?php
if ( ! defined( 'ABSPATH' ) ) exit;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

class EU9_Copyright_Widget extends Widget_Base {

    public function get_name() {
        return 'eu9-copyright';
    }

    public function get_title() {
        return __( 'EU9 Copyright', 'elementor-custom' );
    }

    public function get_icon() {
        return 'eicon-lock-user';
    }

    public function get_categories() {
        return [ 'eu9-category' ];
    }

    public function get_keywords() {
        return [ 'copyright', 'eu9', 'footer' ];
    }

    public function get_style_depends() {
        return [ 'eu9-widget-style' ];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __( 'Content', 'elementor-custom' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'copyright_type',
            [
                'label'       => __( 'Copyright Text', 'elementor-custom' ),
                'type'        => Controls_Manager::SELECT,
                'default' => 'type1',
                'options' => [
                    'type1' => __( 'Type 1', 'elementor-custom' ),
                    'type2' => __( 'Type 2', 'elementor-custom' ),
                    'type3' => __( 'Type 3', 'elementor-custom' ),
                    'type4' => __( 'Type 4', 'elementor-custom' ),
                ],
            ]
        );

        $this->add_control(
            'copyright_text',
            [
                'label'       => __( 'Copyright Text', 'elementor-custom' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => __( 'EU9 International.', 'elementor-custom' ),
                'placeholder' => __( 'Enter your copyright text', 'elementor-custom' ),
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'style_section',
            [
                'label' => __( 'Style', 'elementor-custom' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        // Typography Control
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'typography',
                'label'    => __( 'Typography', 'elementor-custom' ),
                'selector' => '{{WRAPPER}} .eu9-copyright',
            ]
        );

        // Text Alignment Control
        $this->add_responsive_control(
            'text_align',
            [
                'label'     => __( 'Text Alignment', 'elementor-custom' ),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'left' => [
                        'title' => __( 'Left', 'elementor-custom' ),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'elementor-custom' ),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => __( 'Right', 'elementor-custom' ),
                        'icon'  => 'eicon-text-align-right',
                    ],
                    'justify' => [
                        'title' => __( 'Justify', 'elementor-custom' ),
                        'icon'  => 'eicon-text-align-justify',
                    ],
                ],
                'default'   => 'left',
                'selectors' => [
                    '{{WRAPPER}} .eu9-copyright' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $type_class = esc_attr( $settings['copyright_type'] );
        $year = date('Y');
        echo '<p class="eu9-copyright ' . $type_class . '">';
        if( $type_class == 'type2' ) {
            echo 'Copyright &copy; ' .  $year . ' ';
        }
        else if( $type_class == 'type3' ) {
            echo 'Copyright ';
        }
        else if( $type_class == 'type4' ) {
            echo '&copy; ';
        }
        else {
            echo '&copy; ' . $year . ' ';
        }
        echo esc_html( $settings['copyright_text'] ) . ' All Right Reserved.';
        echo '</p>';
    }

    protected function _content_template() {
        ?>
        <# 
        var type = settings.copyright_type;
        var year = new Date().getFullYear();
        var output = '';

        if (type === 'type2') {
            output += 'Copyright © ' + year + ' ';
        } else if (type === 'type3') {
            output += 'Copyright ';
        } else if (type === 'type4') {
            output += '© ';
        } else {
            output += '© ' + year + ' ';
        }

        output += settings.copyright_text + ' All Right Reserved.';
        #>

        <p class="eu9-copyright {{ settings.copyright_type }}">{{{ output }}}</p>
        <?php
    }
}
