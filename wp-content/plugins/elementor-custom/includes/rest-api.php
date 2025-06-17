<?php
// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

add_action('rest_api_init', function () {
    register_rest_route('custom/v1', '/posts', [
        'methods' => 'GET',
        'callback' => 'fetch_post_with_category',
        'args' => [
            'category' => [
                'required' => false,
                'type'     => 'integer',
            ],
            'per_page' => [
                'required' => false,
                'type'     => 'integer',
                'default'  => 3,
            ],
        ],
        'permission_callback' => '__return_true',
    ]);
});

function fetch_post_with_category($request) {
    $category = $request->get_param('category');
    $per_page = $request->get_param('per_page');

    $args = [
        'post_type'      => 'post',
        'post_status'    => 'publish',
        'posts_per_page' => $per_page,
    ];

    if (!empty($category)) {
        $args['cat'] = $category;
    }

    $query = new WP_Query($args);
    $posts = [];

    while ($query->have_posts()) {
        $query->the_post();
        $settings = get_field('settings', get_the_ID());

        $posts[] = [
            'post_id'               => get_the_ID(),
            'post_title'            => get_the_title(),
            'post_thumbnail_url'    => get_the_post_thumbnail_url(get_the_ID(), 'medium'),
            'post_category_ids'     => wp_get_post_categories(get_the_ID()),
            'post_date'             => get_the_date('c'),
            'post_reading_duration' => $settings['reading_duration'] ?? '',
            'link'                  => get_permalink(),
        ];
    }

    wp_reset_postdata();
    return rest_ensure_response($posts);
}
