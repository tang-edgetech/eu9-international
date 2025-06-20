<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package eu9-international
 */

get_header();
?>

	<main id="primary" class="site-main">

		<?php
		while ( have_posts() ) :
			the_post();
			if( get_post_type() == 'post' ) {
				get_template_part( 'template-parts/content-single-template', 'post' );
			}
			else {
				get_template_part( 'template-parts/content', get_post_type() );

				the_post_navigation(
					array(
						'prev_text' => '<span class="nav-subtitle">' . esc_html__( 'Previous:', 'eu9-international' ) . '</span> <span class="nav-title">%title</span>',
						'next_text' => '<span class="nav-subtitle">' . esc_html__( 'Next:', 'eu9-international' ) . '</span> <span class="nav-title">%title</span>',
					)
				);
			}

		endwhile; // End of the loop.
		?>

	</main><!-- #main -->

<?php
get_footer();
