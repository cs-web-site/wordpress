<?php
/**
 * Theme functions and definitions.
 *
 * @link https://codex.wordpress.org/Functions_File_Explained
 *
 * @package X_Corporate
 */

if ( ! function_exists( 'x_corporate_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function x_corporate_setup() {

		// Make theme available for translation.
		load_theme_textdomain( 'x-corporate', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		// Let WordPress manage the document title.
		add_theme_support( 'title-tag' );

		// Enable support for Post Thumbnails.
		add_theme_support( 'post-thumbnails' );
		add_image_size( 'x-corporate-thumb', 360, 270 );

		// Register menu locations.
		register_nav_menus( array(
			'primary' => esc_html__( 'Primary Menu', 'x-corporate' ),
			'footer'  => esc_html__( 'Footer Menu', 'x-corporate' ),
			'social'  => esc_html__( 'Social Menu', 'x-corporate' ),
		) );

		// Add support for HTML5 markup.
		add_theme_support( 'html5', array(
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'x_corporate_custom_background_args', array(
			'default-color' => 'FFFFFF',
			'default-image' => '',
		) ) );

		// Enable support for selective refresh of widgets in Customizer.
		add_theme_support( 'customize-selective-refresh-widgets' );

		// Enable support for custom logo.
		add_theme_support( 'custom-logo', array(
			'width'       => 300,
			'height'      => 100,
			'flex-width'  => true,
			'flex-height' => true,
		) );

		add_theme_support( 'custom-header', apply_filters( 'x_corporate_custom_header_args', array(
			'default-image' => get_template_directory_uri() . '/images/custom-header.jpg',
			'width'         => 1920,
			'height'        => 850,
			'flex-height'   => true,
			'header-text'   => false,
		) ) );

		// Register default custom headers.
		register_default_headers( array(
			'main-banner' => array(
				'url'           => '%s/images/custom-header.jpg',
				'thumbnail_url' => '%s/images/custom-header.jpg',
				'description'   => esc_html__( 'Main Banner', 'x-corporate' ),
			),
		) );

	}
endif;

add_action( 'after_setup_theme', 'x_corporate_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function x_corporate_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'x_corporate_content_width', 640 );
}
add_action( 'after_setup_theme', 'x_corporate_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function x_corporate_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Primary Sidebar', 'x-corporate' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here to appear in your Primary Sidebar.', 'x-corporate' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Secondary Sidebar', 'x-corporate' ),
		'id'            => 'sidebar-2',
		'description'   => esc_html__( 'Add widgets here to appear in your Secondary Sidebar.', 'x-corporate' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Front Page Widget Area', 'x-corporate' ),
		'id'            => 'sidebar-front-page-widget-area',
		'description'   => esc_html__( 'Add widgets here to appear in your Front Page.', 'x-corporate' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s"><div class="container">',
		'after_widget'  => '</div></aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '<span class="divider"></span></h2>',
	) );
	register_sidebar( array(
		'name'          => sprintf( esc_html__( 'Footer %d', 'x-corporate' ), 1 ),
		'id'            => 'footer-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	register_sidebar( array(
		'name'          => sprintf( esc_html__( 'Footer %d', 'x-corporate' ), 2 ),
		'id'            => 'footer-2',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	register_sidebar( array(
		'name'          => sprintf( esc_html__( 'Footer %d', 'x-corporate' ), 3 ),
		'id'            => 'footer-3',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	register_sidebar( array(
		'name'          => sprintf( esc_html__( 'Footer %d', 'x-corporate' ), 4 ),
		'id'            => 'footer-4',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'x_corporate_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function x_corporate_scripts() {

	$min = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/vendors/font-awesome/css/font-awesome' . $min . '.css', '', '4.7.0' );

	$fonts_url = x_corporate_fonts_url();
	if ( ! empty( $fonts_url ) ) {
		wp_enqueue_style( 'x-corporate-google-fonts', $fonts_url, array(), null );
	}

	wp_enqueue_style( 'jquery-sidr', get_template_directory_uri() . '/vendors/sidr/css/jquery.sidr.dark' . $min . '.css', '', '2.2.1' );

	wp_enqueue_style( 'jquery-letitsnow', get_template_directory_uri() . '/vendors/letitsnow/css/letitsnow' . $min . '.css', '', '1.0.0' );

	wp_enqueue_style( 'x-corporate-style', get_stylesheet_uri(), array(), '2.0.2' );

	wp_enqueue_script( 'x-corporate-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix' . $min . '.js', array(), '20130115', true );

	wp_enqueue_script( 'jquery-cycle2', get_template_directory_uri() . '/vendors/cycle2/js/jquery.cycle2' . $min . '.js', array( 'jquery' ), '2.1.6', true );

	wp_enqueue_script( 'jquery-sidr', get_template_directory_uri() . '/vendors/sidr/js/jquery.sidr' . $min . '.js', array( 'jquery' ), '2.2.1', true );

	wp_register_script( 'x-corporate-modernizr', get_template_directory_uri() . '/vendors/modernizr/modernizr' . $min . '.js', array( 'jquery' ), '3.5.0', true );

	wp_register_script( 'jquery-letitsnow', get_template_directory_uri() . '/vendors/letitsnow/js/letitsnow' . $min . '.js', array( 'jquery', 'x-corporate-modernizr' ), '1.0.0', true );

	wp_enqueue_script( 'x-corporate-custom', get_template_directory_uri() . '/js/custom' . $min . '.js', array( 'jquery' ), '2.0.2', true );

	$show_snowflakes = x_corporate_get_option( 'show_snowflakes' );

	if ( true === $show_snowflakes ) {
		wp_enqueue_script( 'jquery-letitsnow' );
		wp_add_inline_script( 'jquery-letitsnow', 'jQuery("body").letItSnow();' );
	}

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}

add_action( 'wp_enqueue_scripts', 'x_corporate_scripts' );

// Load starting file.
require_once trailingslashit( get_template_directory() ) . 'includes/start.php';
