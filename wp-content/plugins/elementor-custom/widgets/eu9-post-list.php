<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Responsive;

class EU9_Post_List_Widget extends Widget_Base {

    public function get_name() {
        return 'eu9-post-list';
    }

    public function get_title() {
        return __( 'EU9 Post List', 'elementor-custom' );
    }

    public function get_icon() {
        return 'eicon-posts-grid';
    }

    public function get_categories() {
        return [ 'eu9-category' ];
    }

    public function get_keywords() {
        return [ 'post', 'tag', 'eu9' ];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'section_content',
            [
                'label' => __( 'Settings', 'elementor-custom' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $categories = get_categories([
            'hide_empty' => false,
        ]);
        $category_options = [];

        foreach ($categories as $category) {
            $category_options[$category->term_id] = $category->name;
        }

        $this->add_control(
            'post_category',
            [
                'label' => __('Post Category', 'elementor-custom'),
                'type' => Controls_Manager::SELECT,
                'options' => $category_options,
                'default' => '',
            ]
        );

        $this->add_control(
            'title_display_type',
            [
                'label' => __('Title Display Type', 'elementor-custom'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'category' => __('Category', 'elementor-custom'),
                    'custom'   => __('Custom', 'elementor-custom'),
                ],
                'default' => 'category',
            ]
        );
        
        $this->add_control(
            'custom_section_title',
            [
                'label' => __('Custom Title', 'elementor-custom'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => __('Enter your custom title', 'elementor-custom'),
                'condition' => [
                    'title_display_type' => 'custom',
                ],
            ]
        );

        $this->add_responsive_control(
            'columns',
            [
                'label' => __('Columns', 'elementor-custom'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [''],
                'range' => [
                    '' => [
                        'min' => 1,
                        'max' => 6,
                    ],
                ],
                'default' => [
                    'size' => 3,
                ],
                'selectors' => [
                    '{{WRAPPER}} .eu9-post-list .post-grid' => 'grid-template-columns: repeat({{SIZE}}, 1fr);',
                ],
            ]
        );

        $this->add_responsive_control(
            'posts_per_page',
            [
                'label' => __('Posts Per Page', 'elementor-custom'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    '' => [
                        'min' => 3,
                        'max' => 20,
                    ],
                ],
                'default' => [
                    'size' => 9,
                ],
            ]
        );

        $this->end_controls_section();
        
        $this->start_controls_section(
            'section_switch',
            [
                'label' => __( 'Display', 'elementor-custom' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

		$this->add_control(
			'show_category',
			[
				'label' => esc_html__( 'Show Category', 'elementor-custom' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'elementor-custom' ),
				'label_off' => esc_html__( 'Hide', 'elementor-custom' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_post_date',
			[
				'label' => esc_html__( 'Show Post Date', 'elementor-custom' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'elementor-custom' ),
				'label_off' => esc_html__( 'Hide', 'elementor-custom' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_reading_duration',
			[
				'label' => esc_html__( 'Show Reading Duration', 'elementor-custom' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'elementor-custom' ),
				'label_off' => esc_html__( 'Hide', 'elementor-custom' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

        $this->end_controls_section();

        $this->start_controls_section(
            'section_date_style',
            [
                'label' => __( 'Style', 'elementor-custom' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->end_controls_section();
    }
    
    protected function render() {
        $settings = $this->get_settings_for_display();

        if( $settings['title_display_type'] == 'custom' ) {
            $section_title = $settings['custom_section_title'];
        }
        else {
            $section_title = get_cat_name($settings['post_category']);
        }

        $query_args = [
            'post_type' => 'post',
            'post_status' => 'publish',
            'posts_per_page' => $settings['posts_per_page']['size'],
        ];

        if (!empty($settings['post_category'])) {
            $query_args['cat'] = $settings['post_category'];
        }
        $query = new \WP_Query($query_args);
        echo '<div class="eu9-post-list">';
        echo '<h3 class="title-card"><span>'.$section_title.'</span></h3>';
        if ($query->have_posts()) {
            echo '<div class="post-grid">';
            while ($query->have_posts()) {
                $query->the_post();
                $post_id = get_the_ID();
                $post_title = get_the_title();
                $categories = get_the_category();
                $category_ids = array();
                $cat_labels = '';
                if (!empty($categories)) {
                    foreach( $categories as $cat ) {
                        $cat_labels .= '<a href="'.get_category_link($cat->term_id).'">'.$cat->name.'</a>';
                    }
                }
                $post_thumbnail = '';
                if( has_post_thumbnail() ) {
                    $post_thumbnail = '<img src="'.get_the_post_thumbnail_url().'" class="img-fluid w-100"/>';
                }
                $field_settings = get_field('settings');
                $reading_duration = $field_settings['reading_duration'];
                $post_time = get_the_time('U');
                $current_time = current_time('timestamp');
                $diff = $current_time - $post_time;
                if ($diff < MINUTE_IN_SECONDS) {
                    $time_diff = $diff . ' seconds ago';
                } elseif ($diff < HOUR_IN_SECONDS) {
                    $time_diff = floor($diff / MINUTE_IN_SECONDS) . ' minutes ago';
                } elseif ($diff < DAY_IN_SECONDS) {
                    $time_diff = floor($diff / HOUR_IN_SECONDS) . ' hours ago';
                } elseif ($diff < WEEK_IN_SECONDS) {
                    $time_diff = floor($diff / DAY_IN_SECONDS) . ' days ago';
                } elseif ($diff < MONTH_IN_SECONDS) {
                    $time_diff = floor($diff / WEEK_IN_SECONDS) . ' weeks ago';
                } elseif ($diff < YEAR_IN_SECONDS) {
                    $time_diff = floor($diff / MONTH_IN_SECONDS) . ' months ago';
                } else {
                    $time_diff = floor($diff / YEAR_IN_SECONDS) . ' years ago';
                }
                echo '<div class="post-item"><div class="post-item-inner"><div class="post-thumbnail"><a href="' . get_permalink() . '">'.$post_thumbnail.'</a></div><div class="post-entry">';
                    if( $settings['show_category'] ) {
                        echo '<div class="post-category">'.$cat_labels.'</div>';
                    }
                    echo '<h4 class="post-title"><a href="' . get_permalink() . '">'.$post_title.'</a></h4>';
                    if( $settings['show_post_date'] == 'yes' || $settings['show_reading_duration'] == 'yes' ) {
                        echo '<div class="post-meta">';
                        if( $settings['show_post_date'] == 'yes' ) {
                            echo '<div class="meta-item meta-time-passed"><i class="far fa-clock"></i>'.$time_diff.'</div>';
                        }
                        if( $settings['show_reading_duration'] == 'yes' ) {
                            echo '<div class="meta-item meta-reading-duration"><i class="fas fa-book-open"></i>'.$reading_duration.' Min Read</div>';
                        }
                        echo '</div>';
                    }
                echo '</div></div></div>';
            }
            echo '</div>';
            wp_reset_postdata();
        } else {
            echo '<p>' . __('No posts found.', 'elementor-custom') . '</p>';
        }
        echo '</div>';
    }

    protected function _content_template() {
    ?>
    <?php
    }
}