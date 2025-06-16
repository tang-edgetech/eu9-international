<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package eu9-international
 */

$home_url = home_url();

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
							<div class="post-main">
								<div class="image-overlay">
									<img src="<?php echo $home_url;?>/wp-content/uploads/2025/06/error404-default.jpg" class="img-fluid w-100"/>
									<div class="image-caption"><h2>404 error: Page not found</h2></div>
								</div>
								<div class="d-flex justify-content-center content-wrapper">
									<div class="col-12 col-md-9 px-0">
										<h3 class="entry-title">What is happening?</h3>
										<p>The page that you are looking for does not exist on this website. You may have accidentally mistype the page address, or followed an expired link. Anyway, we will help you get back on track. Why not try to search for the page you were looking for:</p>
										<?php echo get_eu9_search_form(); ?>
									</div>
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
