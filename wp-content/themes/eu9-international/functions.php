<?php
/**
 * eu9-international functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package eu9-international
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	// define( '_S_VERSION', '1.0.0' );
	define( '_S_VERSION', '1.0.'.time() );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function eu9_international_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on eu9-international, use a find and replace
		* to change 'eu9-international' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'eu9-international', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'eu9-international' ),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'eu9_international_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'eu9_international_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function eu9_international_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'eu9_international_content_width', 640 );
}
add_action( 'after_setup_theme', 'eu9_international_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function eu9_international_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'eu9-international' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'eu9-international' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'eu9_international_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function eu9_international_scripts() {
    wp_enqueue_style('bootstrap-css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css', [], null);
	wp_enqueue_style( 'eu9-international-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'eu9-international-style', 'rtl', 'replace' );
    wp_enqueue_style( 'eu9-custom', get_template_directory_uri() . '/css/custom.css', array(), _S_VERSION, 'all' );
	if( is_singular() ) {
		wp_enqueue_style( 'eu9-single', get_template_directory_uri() . '/css/single.css', array(), _S_VERSION, 'all' );
	}
	wp_enqueue_style( 'media-query', get_template_directory_uri() . '/css/media.css', array(), _S_VERSION, 'all' );

	wp_enqueue_script('jQuery', 'https://code.jquery.com/jquery-3.7.1.min.js', [], null, true);
	wp_enqueue_script('bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js', [], null, true);
	wp_enqueue_script( 'eu9-international-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );
}
add_action( 'wp_enqueue_scripts', 'eu9_international_scripts' );

function add_attributes_to_bootstrap($html, $handle) {
    if ('bootstrap-css' === $handle) {
        $integrity = 'sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC';
        $html = str_replace('/>', ' integrity="' . $integrity . '" crossorigin="anonymous" />', $html);
    }
    return $html;
}
add_filter('style_loader_tag', 'add_attributes_to_bootstrap', 10, 2);
function add_crossorigin_to_jquery($tag, $handle) {
    if ('jQuery' === $handle) {
        $integrity = 'sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=';
        return str_replace(' src', ' integrity="' . $integrity . '" crossorigin="anonymous" src', $tag);
    }
    else if ('bootstrap-js' === $handle) {
        $integrity = 'sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM';
        return str_replace(' src', ' integrity="' . $integrity . '" crossorigin="anonymous" src', $tag);
    }
    return $tag;
}
add_filter('script_loader_tag', 'add_crossorigin_to_jquery', 10, 2);

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Allow SVG uploads for administrator users.
 */
add_filter(
	'upload_mimes',
	function ( $upload_mimes ) {
		if ( ! current_user_can( 'administrator' ) ) {
			return $upload_mimes;
		}

		$upload_mimes['svg']  = 'image/svg+xml';
		$upload_mimes['svgz'] = 'image/svg+xml';

		return $upload_mimes;
	}
);

/**
 * Add SVG files mime check.
 */
add_filter(
	'wp_check_filetype_and_ext',
	function ( $wp_check_filetype_and_ext, $file, $filename, $mimes, $real_mime ) {

		if ( ! $wp_check_filetype_and_ext['type'] ) {

			$check_filetype  = wp_check_filetype( $filename, $mimes );
			$ext             = $check_filetype['ext'];
			$type            = $check_filetype['type'];
			$proper_filename = $filename;

			if ( $type && 0 === strpos( $type, 'image/' ) && 'svg' !== $ext ) {
				$ext  = false;
				$type = false;
			}

			$wp_check_filetype_and_ext = compact( 'ext', 'type', 'proper_filename' );
		}

		return $wp_check_filetype_and_ext;

	},
	10,
	5
);

add_action('admin_init', function () {
    // Redirect any user trying to access comments page
    global $pagenow;
    
    if ($pagenow === 'edit-comments.php') {
        wp_safe_redirect(admin_url());
        exit;
    }

    // Remove comments metabox from dashboard
    remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');

    // Disable support for comments and trackbacks in post types
    foreach (get_post_types() as $post_type) {
        if (post_type_supports($post_type, 'comments')) {
            remove_post_type_support($post_type, 'comments');
            remove_post_type_support($post_type, 'trackbacks');
        }
    }
});

// Close comments on the front-end
add_filter('comments_open', '__return_false', 20, 2);
add_filter('pings_open', '__return_false', 20, 2);

// Hide existing comments
add_filter('comments_array', '__return_empty_array', 10, 2);

// Remove comments page in menu
add_action('admin_menu', function () {
    remove_menu_page('edit-comments.php');
});

// Remove comments links from admin bar
add_action('init', function () {
    if (is_admin_bar_showing()) {
        remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
    }
});

function eu9_search_only_posts( $query ) {
    if ( $query->is_search && !is_admin() && $query->is_main_query() ) {
        $query->set( 'post_type', 'post' );
    }
}
add_action( 'pre_get_posts', 'eu9_search_only_posts' );

function get_eu9_search_form() {
    $home_url = esc_url(home_url('/'));
    ob_start();
    ?>
    <form class="eu9-search-form" id="eu9-search-form" role="search" method="get" action="<?php echo $home_url; ?>">
        <div class="form-inner">
            <input type="text" name="s" placeholder="Type here to search..." value="<?php echo get_search_query(); ?>">
            <button type="submit" class="btn btn-search">
                <span class="d-none">Submit</span>
                <i class="fas fa-search"></i>
            </button>
        </div>
    </form>
    <?php
    return ob_get_clean();
}

function get_eu9_breadcrumb($page_title) {
    $home_url = esc_url(home_url('/'));
	?>
	<div class="breadcrumb">
		<div class="breadcrumb-item"><a href="<?php echo $home_url;?>" class="breadcrumb-link">Home</a></div>
		<div class="breadcrumb-divider"><i class="fas fa-chevron-right"></i></div>
		<div class="breadcrumb-item"><span class="breadcrumb-link"><?php echo $page_title;?></span></div>
	</div>
	<?php
}