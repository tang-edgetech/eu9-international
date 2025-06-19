<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class EU9_Post_List_Special_Widget extends Widget_Base {

    public function get_name() {
        return 'eu9-post-list-special';
    }

    public function get_title() {
        return __( 'EU9 Post List Special', 'elementor-custom' );
    }

    public function get_icon() {
        return 'eicon-post';
    }

    public function get_categories() {
        return [ 'eu9-category' ];
    }

    public function get_keywords() {
        return [ 'post', 'tag', 'eu9', 'most', 'popular', 'discussed' ];
    }

    private function get_all_tags() {
        $tags = get_tags( [ 'hide_empty' => false ] );
        $options = [];

        foreach ( $tags as $tag ) {
            $options[ $tag->term_id ] = $tag->name;
        }

        return $options;
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
            'post_type',
            [
                'label' => __('Post Type', 'elementor-custom'),
                'type' => Controls_Manager::SELECT,
                'options' => [
					'most_popular' => esc_html__( 'Most Popular', 'elementor-custom' ),
					'most_discussed' => esc_html__( 'Most Discussed', 'elementor-custom' ),
                ],
                'default' => 'most_popular',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        $repeater_field = $settings['post_type'];
        if( $repeater_field == 'most_discussed' ) {
            $posts = get_field('most_discussed', 'option');
        }
        else {
            $posts = get_field('most_popular', 'option');
        }
        
        
        ?>
        <div class="eu9-post-list-special" data-field="<?php echo $repeater_field;?>">
            <div class="post-grid">
            <?php
            if( !empty($posts) ) {
                foreach( $posts as $post ) {
                    if ($post instanceof WP_Post) {
                        $post_id = $post->ID;
                        $post_title = get_the_title($post_id);
                        $permalink = get_permalink($post_id);
                    ?>
                        <div class="post-item">
                            <div class="post-item-inner">
                                <div class="post-thumbnail">
                                    <a href="<?php echo $permalink;?>" class="post-link">
                                    <?php if( has_post_thumbnail($post_id) ) {
                                        echo '<img src="'.get_the_post_thumbnail_url($post_id, 'full').'" alt="'.$post_title.'">';
                                    } ?>
                                    </a>
                                </div>
                                <div class="post-entry">
                                    <h4 class="post-title"><a href="<?php echo $permalink;?>" class="post-link"><?php echo $post_title;?></a></h4>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                }
                wp_reset_postdata();
            }
            ?>
            </div>
        </div>
        <?php
    }

    protected function content_template() {
        ?>
        
        <?php
    }

}
