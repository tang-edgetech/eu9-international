<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package eu9-international
 */

get_header();
?>

	<main id="primary" class="site-main">

		<?php if ( have_posts() ) {
			if( is_category() ) {
				$home_url = home_url();
				$archive_title = get_the_archive_title();
				$term = get_queried_object();
				$category = $term->slug;
				$paged = isset($_GET['paged']) ? max(1, intval($_GET['paged'])) : 1;
				?>
				<div class="post-outer-box">
					<div class="post-inner-row">
						<div class="post-header">
							<div class="breadcrumb">
								<div class="breadcrumb-item"><a href="<?php echo $home_url;?>" class="breadcrumb-link">Home</a></div>
								<div class="breadcrumb-divider"><i class="fas fa-chevron-right"></i></div>
								<div class="breadcrumb-item"><span class="breadcrumb-link"><?php echo preg_replace('/^[^:]+:\s*/', '', $archive_title);?></span></div>
							</div>
						</div>
						<div class="post-body">
							<div class="post-body-inner d-md-flex">
								<div class="post-main col-xl-9 px-0">
									<div class="post-content pe-md-4">
										<h3 class="title-card"><span>Category</span></h3>
										<?php
										$args = array(
											'post_type' => 'post',
											'post_status' => 'publish',
											'order' => 'date',
											'orderby' => 'desc',
											// 'posts_per_page' => $ppp,
											'category_name'  => $category,
											'paged' => $paged,
										);
										$items = new WP_Query($args);
										if( $items->have_posts() ) {
											?>
											<div class="post-grid post-listing-grid">
											<?php
												$index=0;
												while( $items->have_posts() ) {
													$items->the_post();
													get_template_part('template-parts/template-post-item', 'grid', array('post_id' => get_the_ID(), 'type' => 'listing', 'index'=>$index) );
													$index++;
												}
												wp_reset_postdata();
												echo '<div class="post-pagination">';
													echo paginate_links([
														'base' => trailingslashit(get_pagenum_link(1)) . '%_%',
														'current' => max(1, get_query_var('paged')),
														'format' => 'page/%#%/',
														'total'   => $items->max_num_pages,
														'prev_text' => '<i class="fa fa-chevron-left"></i><span class="d-none d-md-block">Prev</span>',
														'next_text' => '<span class="d-none d-md-block">Next</span><i class="fa fa-chevron-right"></i>',
													]);
												echo '</div>';
											?>
											</div>
											<?php
										}
										else {
											echo '<div class="dialog">There is no post found!</div>';
										}
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
			<?php
			}
			else { ?>
				<header class="page-header">
					<?php
					the_archive_title( '<h1 class="page-title">', '</h1>' );
					the_archive_description( '<div class="archive-description">', '</div>' );
					?>
				</header><!-- .page-header -->
			<?php
				/* Start the Loop */
				while ( have_posts() ) :
					the_post();

					/*
					* Include the Post-Type-specific template for the content.
					* If you want to override this in a child theme, then include a file
					* called content-___.php (where ___ is the Post Type name) and that will be used instead.
					*/
					get_template_part( 'template-parts/content', get_post_type() );

				endwhile;
			}
		}
		else {
			if( is_category() ) {
				get_template_part( 'template-parts/content-archive-template', 'post' );
			}
		}
		?>

	</main><!-- #main -->

<?php
get_sidebar();
get_footer();
