<?php
$post_id = $args['post_id'];
$index = isset($args['index']) ? intval($args['index']) : 1;
$type = '';
if( !empty($args['type']) ) {
    $type = $args['type'];
}
$post_title = get_the_title($post_id);
$categories = get_the_category($post_id);
$permalink = get_permalink($post_id);
$settings = get_field('settings', $post_id);
$reading_duration = $settings['reading_duration'];
$temp = get_the_content();
$word_limit = ($index < 1) ? 38 : 25;
$content = get_the_content();
$content = strip_shortcodes( $content );
$content = wp_strip_all_tags( $content );
$words = explode( ' ', $content );
if ( count( $words ) > $word_limit ) {
    $excerpt = implode( ' ', array_slice( $words, 0, $word_limit ) ) . '...';
} else {
    $excerpt = $content;
}

if( $type == 'listing' ) { 
    
?>
<div class="post-item post-item-id-<?php echo $post_id;?> item-<?php echo $index;?>" id="post-item-id-<?php echo $post_id;?>">
    <div class="post-item-inner">
        <div class="post-thumbnail">
            <a href="<?php echo $permalink;?>" class="post-link">
            <?php if( has_post_thumbnail() ) {
                echo '<img src="'.get_the_post_thumbnail_url().'" alt="'.$post_title.'"/>';
            } ?>
            </a>
        </div>
        <div class="post-entry">
            <div class="post-entry-head">
                <div class="post-category">
                    <?php if (!empty($categories)) {
                        $first_category = $categories[0];
                        $cat_name = esc_html($first_category->name);
                        $cat_link = esc_url(get_category_link($first_category->term_id));
                        echo '<a href="' . $cat_link . '" class="cat-link">' . $cat_name . '</a>';
                    } ?>
                </div>
                <h4 class="post-title"><a href="<?php echo $permalink;?>"><?php echo $post_title;?></a></h4>
                <div class="post-meta">
                    <div class="meta-item meta-time-passed">
                        <?php
                    $post_time = get_the_time('U');
                    $current_time = current_time('timestamp');
                    $diff = $current_time - $post_time;
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
                </div>
            </div>
            <div class="post-entry-body">
                <div class="post-excerpt"><?php echo $excerpt;?></div>
            </div>
        </div>
    </div>
</div>
<?php
}
else {
?>
<div class="post-item post-item-id-<?php echo $post_id;?>" id="post-item-id-<?php echo $post_id;?>">
    <div class="post-item-inner">
        <div class="post-thumbnail">
            <a href="<?php echo $permalink;?>" class="post-link">
            <?php if( has_post_thumbnail() ) {
                echo '<img src="'.get_the_post_thumbnail_url().'" alt="'.$post_title.'"/>';
            } ?>
            </a>
        </div>
        <div class="post-entry">
            <div class="post-category">
            <?php if (!empty($categories)) {
                $first_category = $categories[0];
                $cat_name = esc_html($first_category->name);
                $cat_link = esc_url(get_category_link($first_category->term_id));
                echo '<a href="' . $cat_link . '" class="cat-link">' . $cat_name . '</a>';
            } ?>
            </div>
            <h4 class="post-title"><a href="<?php echo $permalink;?>"><?php echo $post_title;?></a></h4>
            <div class="post-reading meta-item meta-reading-duration"><i class="fas fa-book-open"></i><?php echo $reading_duration;?> Min Read</div>
        </div>
    </div>
</div>
<?php
}
?>