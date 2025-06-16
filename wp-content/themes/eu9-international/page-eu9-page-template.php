<?php
/**
 * Template Name: EU9 Template
 * Template Post Type: page
 */

get_header();
?>

<div class="eu9-template-wrapper">
    <?php
    // Elementor Content Rendering
    while ( have_posts() ) : the_post();
        the_content();
    endwhile;
    ?>
</div>

<?php
get_footer();
?>
