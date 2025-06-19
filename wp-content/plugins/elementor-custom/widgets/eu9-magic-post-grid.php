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

        $this->add_control(
            'posts_per_page',
            [
                'label' => __('Posts Per Page', 'elementor-custom'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    '' => [
                        'min' => 1,
                        'max' => 5,
                    ],
                ],
                'default' => [
                    'size' => 4,
                ],
            ]
        );

        $this->end_controls_section();
    }
    
    protected function render() {
        $settings = $this->get_settings_for_display();
        $ppp = intval($settings['posts_per_page']['size']);
        $args = array(
            'post_type' => 'post',
            'post_status' => 'publish',
            'posts_per_page' => $ppp,
            'orderby' => 'date',
            'order' => 'desc',
            'ignore_sticky_posts' => true,
        );
        $query = new \WP_Query($args);
        ?>
        <div class="magic-post-grid magic-<?php echo $ppp;?>">
        <?php
        if( $query->have_posts() ) {
            $index = 1;
            while( $query->have_posts() ) {
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
                if( has_excerpt() ) {
                    $excerpt = get_the_excerpt();
                }
                else {
                    $content = wp_strip_all_tags(strip_shortcodes(get_the_content()));
                    $excerpt = wp_trim_words($content, 20, '');
                }
            ?>
            <div class="post-item post-item-<?php echo $post_id;?> emr-<?php echo $index;?>" id="post-item-<?php echo $post_id;?>">
                <div class="post-thumbnail">
                    <a href="<?php echo get_permalink();?>"class="post-link">
                    <?php
                    if( has_post_thumbnail() ) {
                        echo '<img src="'.get_the_post_thumbnail_url().'" class="img-fluid w-100"/>';
                    }
                    ?>
                    </a>    
                </div>
                <div class="post-entry post-caption">
                    <div class="post-category"><?php echo $cat_labels;?></div>
                    <h4 class="post-title"><a href="<?php echo get_permalink();?>"><?php echo $post_title;?></a></h4>
                    <div class="post-meta">
                        <div class="meta-item meta-time-passed"><i class="far fa-clock"></i><?php echo $time_diff;?></div>
                    </div>
                    <div class="post-excerpt"><?php echo $excerpt;?></div>
                </div>
            </div>
            <?php
                $index++;
            }
            wp_reset_postdata();
        }
        ?>
        </div>
        <?php
    }

    protected function _content_template() {
    ?>
    <?php
    }
}