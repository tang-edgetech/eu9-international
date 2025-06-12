<?php
$post_id = $args['post_id'];
$post_title = get_the_title($post_id);
$categories = get_the_category($post_id);
$permalink = get_permalink($post_id);
$settings = get_field('settings', $post_id);
$reading_duration = $settings['reading_duration'];
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