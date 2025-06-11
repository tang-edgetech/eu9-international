<?php
$home_url = home_url();
$post_id = get_the_ID();
$post_title = get_the_title();
$settings = get_field('settings');
$reading_duration = $settings['reading_duration'];
?>
<div class="single-outer-box">
    <div class="single-inner-row">
        <div class="single-header">
            <div class="breadcrumb">
                <div class="breadcrumb-item"><a href="<?php echo $home_url;?>" class="breadcrumb-link">Home</a></div>
                <div class="breadcrumb-divider"><i class="fas fa-chevron-right"></i></div>
                <div class="breadcrumb-item"><span class="breadcrumb-link"><?php echo $post_title;?></span></div>
            </div>
        </div>
        <div class="single-body">
            <div class="single-body-inner">

            </div>
        </div>
    </div>
</div>