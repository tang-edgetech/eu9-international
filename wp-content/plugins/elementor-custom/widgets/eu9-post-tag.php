<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class EU9_Post_Tag_Widget extends Widget_Base {

    public function get_name() {
        return 'eu9-post-tag';
    }

    public function get_title() {
        return __( 'EU9 Post Tag', 'elementor-custom' );
    }

    public function get_icon() {
        return 'eicon-form-vertical';
    }

    public function get_categories() {
        return [ 'eu9-category' ];
    }

    public function get_keywords() {
        return [ 'post', 'tag', 'eu9' ];
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
            'selected_tags',
            [
                'label'        => __( 'Show Only These Tags', 'elementor-custom' ),
                'type'         => Controls_Manager::SELECT2,
                'multiple'     => true,
                'options'      => $this->get_all_tags(),
                'label_block'  => true,
                'description'  => __( 'Select which tags to display. If empty, all tags assigned to the post will be shown.', 'elementor-custom' ),
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $post_tags = get_the_tags();

        $selected_tag_ids = $settings['selected_tags'];
        
        echo '<div class="eu9-post-tag">';
        foreach ( $selected_tag_ids as $id ) {
            $tag = get_Tag($id);
            if ( empty( $selected_tag_ids ) || in_array( $tag->term_id, $selected_tag_ids ) ) {
                echo '<a href="' . esc_url( get_tag_link( $tag->term_id ) ) . '" class="tag-link">' . esc_html( $tag->name ) . '</a> ';
            }
        }
        echo '</div>';
    }

    protected function _content_template() {
        ?>
        <div class="eu9-post-tag">
            <# if ( settings.selected_tags && settings.selected_tags.length ) { #>
                <# _.each( settings.selected_tags, function( tagId ) { #>
                    <span class="tag-link text-white">{{ tagId }}</span>
                <# }); #>
            <# } else { #>
                <span class="tag-link text-white">Sample Tag A</span>
                <span class="tag-link text-white">Sample Tag B</span>
            <# } #>
        </div>
        <?php
    }
}