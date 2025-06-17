<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package eu9-international
 */

get_header();
?>

	<main id="primary" class="site-main">
		<section class="error-404 not-found" id="error-404">
			<div class="post-outer-box">
				<div class="post-inner-row">
					<div class="post-header">
						<div class="breadcrumb">
							<div class="breadcrumb-item"><a href="<?php echo $home_url;?>" class="breadcrumb-link">Home</a></div>
							<div class="breadcrumb-divider"><i class="fas fa-chevron-right"></i></div>
							<div class="breadcrumb-item"><span class="breadcrumb-link">Error 404: Page not found</span></div>
						</div>
					</div>
					<div class="post-body">
						<div class="post-body-inner d-md-flex">
							<div class="post-main col-12 col-xl-9 px-0">
								<div class="post-content pe-md-4">
									<h3 class="title-card"><span>Search Results For - <?php echo get_search_query(); ?></span></h3>
									<?php echo get_eu9_search_form();?>
									<div class="divider"></div>
									<?php 
									$paged = get_query_var('paged') ? get_query_var('paged') : 1;
									$search_query = get_search_query();
									$posts_per_page = get_option( 'posts_per_page' );
									
									$args = array(
										'post_type'      => 'post',
										's'              => $search_query,
										'paged'          => $paged,
										'posts_per_page' => $posts_per_page,
									);
									$query = new WP_Query($args);
									
									if( $query->have_posts() ) {
										echo '<div class="post-grid post-listing-grid">';
										$index=0;
										while( $query->have_posts() ) {
											$query->the_post();
											get_template_part('template-parts/template-post-item', 'grid', array('post_id' => get_the_ID(), 'type' => 'listing', 'index'=>$index) );
											$index++;
										}
										echo '</div>';
										if( $query->max_num_pages > $posts_per_page ) {
										echo '<div class="post-pagination">';
											echo paginate_links(array(
												'total'   => $query->max_num_pages,
												'current' => $paged,
												'format'  => 'page/%#%/?s=' . urlencode($search_query),
												'base'    => home_url('/') . '%_%',
												'prev_text' => '<i class="fa fa-chevron-left"></i><span class="d-none d-md-block">Prev</span>',
												'next_text' => '<span class="d-none d-md-block">Next</span><i class="fa fa-chevron-right"></i>',
											));
										echo '</div>';
										}
										wp_reset_postdata();
									}
									else {
										echo '<div class="dialog"><p>No results found. Please try again with a different keyword.</p></div>';
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
		</section>
	</main><!-- #main -->
<?php
get_footer();
