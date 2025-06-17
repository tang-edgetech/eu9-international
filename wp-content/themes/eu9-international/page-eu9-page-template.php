<?php
/**
 * Template Name: EU9 Template
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
                        <div class="post-main col-12 px-0">
                            <div class="post-content pe-md-4">
                                <?php
                                // Elementor Content Rendering
                                while ( have_posts() ) : the_post();
                                    the_content();
                                endwhile;
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
