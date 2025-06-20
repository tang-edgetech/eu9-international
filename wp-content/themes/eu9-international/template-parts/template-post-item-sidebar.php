<?php
$post_id = $args['post_id'];
$post_title = get_the_title($post_id);
$categories = get_the_category($post_id);
$permalink = get_permalink($post_id);
?>
<div class="post-item">
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
            <h4 class="post-title"><a href="<?php echo $permalink;?>" class="post-link"><?php echo $post_title;?></a></h4>
        </div>
    </div>
</div>