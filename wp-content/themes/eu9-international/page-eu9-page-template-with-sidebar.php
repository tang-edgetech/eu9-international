<?php
/**
 * Template Name: EU9 Template - Sidebar
 * Template Post Type: page
 */

get_header();

$home_url = home_url();
if (is_category() || is_tag() || is_tax()) {
    $term = get_queried_object();
    $page_title = esc_html($term->name);
}
else if( is_post_type_archive() ) {
    $page_title = post_type_archive_title('', false);
}
else {
    $page_title = get_the_title();
}
?>
    <main id="primary" class="site-main">
        <div class="post-outer-box">
            <div class="post-inner-row">
                <div class="post-header">
                    <?php echo get_eu9_breadcrumb($page_title);?>
                </div>
                <div class="post-body">
                    <div class="post-body-inner d-md-flex">
                        <div class="post-main col-12 col-xl-9 px-0">
                            <div class="post-content pe-xl-4">
                                <?php
                                // Elementor Content Rendering
                                while ( have_posts() ) : the_post();
                                    the_content();
                                endwhile;
                                ?>
                            </div>
                        </div>
                        <div class="post-sidebar col-xl-3 px-0 px-md-4 pe-md-0">
                            <?php 
                            $sticky_posts = get_option('sticky_posts');

                            $args = array(
                                'post_type'      => 'post',
                                'post_status'    => 'publish',
                                'post__in'       => $sticky_posts,
                                'posts_per_page' => 6,
                                'orderby'        => 'date',
                                'order'          => 'DESC',
                            );
                            $sticky_query = new WP_Query($args);
                            if ($sticky_query->have_posts()) {
                                echo '<div class="sidebar-post-grid">';
                                echo '<h3 class="title-card"><span>Featured</span></h3>';
                                echo '<div class="post-grid post-layout-horizontal">';
                                while ($sticky_query->have_posts()) {
                                    $sticky_query->the_post();
                                    get_template_part('template-parts/template-post-item', 'sidebar', array('post_id' => get_the_ID()) );
                                }
                                wp_reset_postdata();
                                echo '</div>';
                            } else {
                                echo '<div class="sidebar-post-grid post-empty">';
                                echo '<h3 class="title-card"><span>Featured</span></h3>';
                                echo '<div class="post-grid">';
                                get_template_part('template-parts/template-post-item', 'empty' );
                                echo '</div>';
                            }
                            ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

<?php
get_footer();
?>
