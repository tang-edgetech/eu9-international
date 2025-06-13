<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class EU9_DateTime_Picker_Widget extends Widget_Base {

    public function get_name() {
        return 'eu9-datetime-picker';
    }

    public function get_title() {
        return __( 'EU9 DateTime Picker', 'elementor-custom' );
    }

    public function get_icon() {
        return 'eicon-calendar';
    }

    public function get_categories() {
        return [ 'eu9-category' ];
    }

    public function get_keywords() {
        return [ 'calendar', 'date', 'time', 'picker', 'eu9' ];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __( 'Settings', 'elementor-custom' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

		$this->add_control(
			'show_icon',
			[
				'label' => esc_html__( 'Show Calender Icon', 'elementor-custom' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'elementor-custom' ),
				'label_off' => esc_html__( 'Hide', 'elementor-custom' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'date_format',
			[
				'label' => esc_html__( 'Date Display Format', 'elementor-custom' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'F j, Y',
				'options' => [
					'F j, Y' => esc_html__( 'June 13, 2025', 'elementor-custom' ),
					'Y-m-d' => esc_html__( '2025-06-13', 'elementor-custom' ),
					'd/m/Y'  => esc_html__( '13/06/2025', 'elementor-custom' ),
					'M j, Y' => esc_html__( 'Jun 13, 2025', 'elementor-custom' ),
				],
			]
		);

        $this->end_controls_section();
        
        $this->start_controls_section(
            'section_date_style',
            [
                'label' => __( 'Date Style', 'elementor-custom' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'space_between',
            [
                'label' => __( 'Space Between', 'elementor-custom' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .eu9-datetime-picker' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label' => __( 'Icon Color', 'elementor-custom' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eu9-datetime-picker i' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'icon_size',
            [
                'label' => __( 'Icon Size', 'elementor-custom' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 60,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .eu9-datetime-picker i' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'text_color',
            [
                'label' => __( 'Text Color', 'elementor-custom' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eu9-datetime-picker p' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'text_typography',
                'label' => __( 'Typography', 'elementor-custom' ),
                'selector' => '{{WRAPPER}} .eu9-datetime-picker p',
            ]
        );

        $this->end_controls_section();
    }
    
    protected function render() {
        $settings = $this->get_settings_for_display();
    ?>
        <div class="eu9-datetime-picker">
            <?php if( $settings['show_icon'] ) {
                echo '<i class="fas fa-calendar-alt"></i>';
            } ?>
            <p><?php echo date($settings['date_format']);?></p>
        </div>
    <?php
    }

    protected function _content_template() {
    ?>
        <#
        var format = settings.date_format;
        var date = new Date();

        function formatDateJS(date, format) {
            switch (format) {
                case 'F j, Y':
                    return date.toLocaleDateString('en-US', {
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric'
                    });
                case 'Y-m-d':
                    return date.getFullYear() + '-' +
                        String(date.getMonth() + 1).padStart(2, '0') + '-' +
                        String(date.getDate()).padStart(2, '0');
                case 'd/m/Y':
                    return String(date.getDate()).padStart(2, '0') + '/' +
                        String(date.getMonth() + 1).padStart(2, '0') + '/' +
                        date.getFullYear();
                case 'M j, Y':
                    return date.toLocaleDateString('en-US', {
                        year: 'numeric',
                        month: 'short',
                        day: 'numeric'
                    });
                default:
                    return date.toDateString(); // fallback
            }
        }

        var iconHtml = settings.show_icon ? '<i class="fas fa-calendar-alt"></i>' : '';
        var formattedDate = formatDateJS(date, format);
        #>

        <div class="eu9-datetime-picker">
            {{{ iconHtml }}}
            <p>{{{ formattedDate }}}</p>
        </div>
        <?php
    }


}