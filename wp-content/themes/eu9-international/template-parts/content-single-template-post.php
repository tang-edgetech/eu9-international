<?php
$home_url = home_url();
$post_id = get_the_ID();
$post_title = get_the_title();
$categories = get_the_category();
$category_ids = array();
$settings = get_field('settings');
$reading_duration = '';
if( $settings['reading_duration'] ) {
    $reading_duration = $settings['reading_duration'];
}
$post_time = get_the_time('U');
$current_time = current_time('timestamp');
$diff = $current_time - $post_time;

?>
<div class="post-outer-box">
    <div class="post-inner-row">
        <div class="post-header">
            <div class="breadcrumb">
                <div class="breadcrumb-item"><a href="<?php echo $home_url;?>" class="breadcrumb-link">Home</a></div>
                <div class="breadcrumb-divider"><i class="fas fa-chevron-right"></i></div>
                <div class="breadcrumb-item"><span class="breadcrumb-link"><?php echo $post_title;?></span></div>
            </div>
        </div>
        <div class="post-body">
            <div class="post-body-inner d-md-flex">
                <div class="post-main col-xl-9 px-0">
                    <div class="post-header">
                        <div class="post-category">
                        <?php if (!empty($categories)) {
                            $first_category = $categories[0];
                            echo '<a href="'.get_category_link($first_category->term_id).'">'.$first_category->name.'</a>';
                        } ?>    
                        </div>
                        <h1 class="post-title"><?php echo $post_title;?></h1>
                        <div class="post-meta">
                            <div class="meta-item meta-time-passed">
                            <?php
                            echo '<i class="far fa-clock"></i>';
                            if ($diff < MINUTE_IN_SECONDS) {
                                echo $diff . ' seconds ago';
                            } elseif ($diff < HOUR_IN_SECONDS) {
                                echo floor($diff / MINUTE_IN_SECONDS) . ' minutes ago';
                            } elseif ($diff < DAY_IN_SECONDS) {
                                echo floor($diff / HOUR_IN_SECONDS) . ' hours ago';
                            } elseif ($diff < WEEK_IN_SECONDS) {
                                echo floor($diff / DAY_IN_SECONDS) . ' days ago';
                            } elseif ($diff < MONTH_IN_SECONDS) {
                                echo floor($diff / WEEK_IN_SECONDS) . ' weeks ago';
                            } elseif ($diff < YEAR_IN_SECONDS) {
                                echo floor($diff / MONTH_IN_SECONDS) . ' months ago';
                            } else {
                                echo floor($diff / YEAR_IN_SECONDS) . ' years ago';
                            }
                            ?>
                            </div>
                            <div class="meta-item meta-reading-duration">
                                <i class="fas fa-book-open"></i><?php echo $reading_duration;?> Min Read
                            </div>
                        </div>
                    </div>
                    <div class="post-content">
                        <div class="post-thumbnail mb-4">
                        <?php if( has_post_thumbnail() ) { 
                            echo '<img src="'.get_the_post_thumbnail_url().'" alt="'.$post_title.'"/>';
                        } ?>
                        </div>
                        <div class="post-content-inner d-md-flex pe-md-4">
                            <div class="social-media-share mb-5 mb-md-0 col-md-2 px-4">
                                <ul class="social-media-list nav position-relative position-md-sticky text-center">
                                <?php $social_media = array(
                                    'facebook' => 'Facebook',
                                    'instagram' => 'Instagram',
                                    'twitter' => 'Twitter',
                                    'whatsapp' => 'WhatsApp',
                                    'linkedin' => 'LinkedIn',
                                    'pinterest' => 'Pinterest',
                                );
                                foreach( $social_media as $slug => $label) {
                                    echo '<li class="social-media-item '.$slug.'"><a href="#" class="btn btn-icon"><span class="d-none">'.$label.'</span></a></li>';
                                }
                                ?>
                                </ul>
                            </div>
                            <div class="post-content-column col-md-10 px-md-4">
                                <div class="wp-editor">
                                    <?php the_content();?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="post-footer">
                        <div class="extras">
                            <h3 class="extra-title title-card"><span>You may also like</span></h3>
                            <div class="post-grid post-extra">
                            <?php
                            $args_extra = array(
                                'post_type' => 'post',
                                'post_status' => 'publish',
                                'orderby' => 'date',
                                'order' => 'DESC',
                                'post__not_in' => [$post_id],
                                'category__in' => $category_ids,
                                'posts_per_page' => 3,
                                'ignore_sticky_posts' => 1,
                            );
                            $extra = new WP_Query($args_extra);
                            while( $extra->have_posts() ) {
                                $extra->the_post();
                                $extra_id = get_the_ID();
                                get_template_part('template-parts/template-post-item', 'grid', array('post_id' => $extra_id) );
                            }
                            wp_reset_postdata();
                            ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="post-sidebar col-xl-3 px-0 px-xl-4 mt-5 mx-md-auto mx-xl-0">
                    <?php 
                    $sticky_posts = get_option('sticky_posts');

                    $args = array(
                        'post_type'      => 'post',
                        'post_status'    => 'publish',
                        'post__in'       => $sticky_posts,
                        'post__not_in'   => array($post_id),
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