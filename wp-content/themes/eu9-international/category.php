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
			$home_url = home_url();
			$page_title = get_the_archive_title();
			$term = get_queried_object();
			$category = $term->slug;
			$paged = get_query_var('paged') ? get_query_var('paged') : 1;
			$posts_per_page = get_option( 'posts_per_page' );
			?>
			<div class="post-outer-box">
				<div class="post-inner-row">
					<div class="post-header">
                    	<?php echo get_eu9_breadcrumb($page_title);?>
					</div>
					<div class="post-body">
						<div class="post-body-inner d-md-flex">
							<div class="post-main col-12 col-xl-9 px-0">
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
                                        'ignore_sticky_posts' => true,
									);
									$items = new WP_Query($args);
									if( $items->have_posts() ) {
										?>
										<div class="post-grid post-listing-grid post-first-highlight">
										<?php
											$index=0;
											while( $items->have_posts() ) {
												$items->the_post();
												get_template_part('template-parts/template-post-item', 'grid', array('post_id' => get_the_ID(), 'type' => 'listing', 'index'=>$index) );
												$index++;
											}
											wp_reset_postdata();
											if( $items->max_num_pages > $posts_per_page ) {
											echo '<div class="post-pagination">';
												echo paginate_links([
													// 'base' => trailingslashit(get_pagenum_link(1)) . '%_%',
            										'base' => get_pagenum_link(1) . '%_%',
													'current' => $paged,
													'format' => 'page/%#%/',
													'total'   => $items->max_num_pages,
													'prev_text' => '<i class="fa fa-chevron-left"></i><span class="d-none d-md-block">Prev</span>',
													'next_text' => '<span class="d-none d-md-block">Next</span><i class="fa fa-chevron-right"></i>',
												]);
											echo '</div>';
											}
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
