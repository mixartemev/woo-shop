<?php
/**
 * PenShop functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package PenShop
 */

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function penshop_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'penshop_content_width', 770 );
}

add_action( 'after_setup_theme', 'penshop_content_width', 0 );

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function penshop_setup() {
	// Make theme available for translation.
	load_theme_textdomain( 'penshop', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	// Let WordPress manage the document title.
	add_theme_support( 'title-tag' );

	// Enable support for Post Thumbnails on posts and pages.
	add_theme_support( 'post-thumbnails' );

	// Register menus
	register_nav_menus( array(
		'primary'   => esc_html__( 'Primary Menu', 'penshop' ),
		'secondary' => esc_html__( 'Secondary Menu', 'penshop' ),
		'footer'    => esc_html__( 'Footer Menu', 'penshop' ),
		'mobile'    => esc_html__( 'Mobile Menu', 'penshop' ),
	) );

	// Switch default core markup for search form, comment form, and comments to output valid HTML5.
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	// Support WooCommerce
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-slider' );
	add_theme_support( 'customize-selective-refresh-widgets' );

	/*
	 * This theme styles the visual editor to resemble the theme style,
	 * specifically font, colors, and column width.
 	 */
	add_editor_style( array( 'assets/css/editor-style.css', penshop_fonts_url() ) );

	// Add image size
	add_image_size( 'penshop-blog-thumb', 1170, 780, true );
	add_image_size( 'penshop-widget-thumbnail', 120, 80, true );

}

add_action( 'after_setup_theme', 'penshop_setup' );

/**
 * Initialize instances
 *
 * Priority 20 to make sure it run after plugin's callbacks,
 * such as register custom post types...
 */
function penshop_init() {
	global $penshop_customize;

	$penshop_customize = new PenShop_Customize( penshop_customize_config() );

	PenShop_WooCommerce::instance();

	if ( is_admin() ) {
		new PenShop_Mega_Menu_Edit();
		PenShop_Product_Settings::init();
	}
}

add_action( 'init', 'penshop_init', 20 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 * @todo remove register languages widgets
 */
function penshop_widgets_init() {
	$sidebars = array(
		'blog-sidebar' => array(
			'name' => esc_html__( 'Blog Sidebar', 'penshop' ),
			'desc' => esc_html__( 'Add widgets here to display on blog pages', 'penshop' ),
		),
		'topbar-left'  => array(
			'name' => esc_html__( 'Topbar Left', 'penshop' ),
			'desc' => esc_html__( 'Add widgets here to display on the left side of topbar', 'penshop' ),
		),
		'topbar-right' => array(
			'name' => esc_html__( 'Topbar Right', 'penshop' ),
			'desc' => esc_html__( 'Add widgets here to display on the right side of topbar', 'penshop' ),
		),
		'shop-sidebar' => array(
			'name' => esc_html__( 'Shop Sidebar', 'penshop' ),
			'desc' => esc_html__( 'Add widgets here to display on the shop pages', 'penshop' ),
		),
		'filter-sidebar' => array(
			'name' => esc_html__( 'Products Filter', 'penshop' ),
			'desc' => esc_html__( 'Add widgets here to display in the products filter panel of shop toolbar', 'penshop' ),
		),
		'page-sidebar' => array(
			'name' => esc_html__( 'Page Sidebar', 'penshop' ),
			'desc' => esc_html__( 'Add widgets here to display on single pages', 'penshop' ),
		),
		'off-sidebar'  => array(
			'name' => esc_html__( 'Off-Screen Sidebar', 'penshop' ),
			'desc' => esc_html__( 'Add widgets here to display on the off screen sidebar', 'penshop' ),
		),
	);

	foreach ( $sidebars as $id => $args ) {
		register_sidebar( array(
			'name'          => $args['name'],
			'id'            => $id,
			'description'   => $args['desc'],
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>',
		) );
	}

	for ( $i = 1; $i < 5; $i ++ ) {
		register_sidebar( array(
			'name'          => sprintf( esc_html__( 'Footer Sidebar %s', 'penshop' ), $i ),
			'id'            => 'footer-' . $i,
			'description'   => esc_html__( 'Add widgets here in order to display on footer', 'penshop' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>',
		) );
	}


	if ( function_exists( 'WC' ) ) {
		register_widget( 'PenShop_Account_Widget' );
	}

	if ( class_exists( 'WOOCS' ) ) {
		register_widget( 'PenShop_Currency_Switcher_Widget' );
	}

	if ( defined( 'ICL_LANGUAGE_CODE' ) ) {
		register_widget( 'PenShop_Language_Switcher_Widget' );
	}

	// For testing only
	register_widget( 'PenShop_Language_Switcher_Widget' );
	register_widget( 'PenShop_Social_Links_Widget' );
}

add_action( 'widgets_init', 'penshop_widgets_init' );


/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer/customizer.php';

/**
 * WooCommerce
 */
require get_template_directory() . '/inc/woocommerce.php';

/**
 * Widgets
 */
require get_template_directory() . '/inc/widgets/widgets.php';

/**
 * Custom functions that act in the backend.
 */
require get_template_directory() . '/inc/admin/plugins.php';
require get_template_directory() . '/inc/admin/meta-boxes.php';
require get_template_directory() . '/inc/admin/nav-menus.php';
require get_template_directory() . '/inc/admin/ajax.php';
require get_template_directory() . '/inc/admin/woocommerce.php';

/**
 * Custom functions that act on the frontend.
 */
require get_template_directory() . '/inc/frontend/header.php';
require get_template_directory() . '/inc/frontend/frontend.php';
require get_template_directory() . '/inc/frontend/colors.php';
require get_template_directory() . '/inc/frontend/menus.php';
require get_template_directory() . '/inc/frontend/footer.php';
require get_template_directory() . '/inc/frontend/entry.php';
require get_template_directory() . '/inc/frontend/comments.php';
require get_template_directory() . '/inc/frontend/breadcrumbs.php';
