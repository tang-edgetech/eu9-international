<?php
/**
 * Template Name: EU9 Template - Home
 * Template Post Type: page
 */

get_header();
?>
    <main id="primary" class="site-main">
        <div class="post-outer-box">
            <div class="post-inner-row">
                <div class="post-body">
                    <div class="post-body-inner d-md-flex">
                        <div class="post-main col-12 px-0">
                            <div class="post-content pe-xl-4">
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
