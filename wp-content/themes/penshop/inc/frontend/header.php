<?php
/**
 * Template functions that act on the header
 *
 * @package PenShop
 */


/**
 * Enqueue scripts and styles.
 */
function penshop_scripts() {
	// Register then enqueue styles
	wp_register_style( 'penshop-fonts', penshop_fonts_url() );
	wp_register_style( 'bootstrap', get_theme_file_uri( 'assets/css/bootstrap.css' ), array(), '3.3.6' );
	wp_register_style( 'font-awesome', get_theme_file_uri( 'assets/css/font-awesome.min.css' ), array(), '4.7.0' );
	wp_register_style( 'penshop', get_template_directory_uri() . '/style.css', array(
		'penshop-fonts',
		'font-awesome',
		'bootstrap',
	), '20170612' );

	wp_enqueue_style( 'penshop' );

	// Register then enqueue scripts
	wp_register_script( 'isotope', get_theme_file_uri( 'assets/js/isotope.pkgd.min.js' ), array( 'imagesloaded' ), '3.0.1', true );
	wp_register_script( 'jquery-sticky', get_theme_file_uri( 'assets/js/jquery.sticky.js' ), array( 'jquery' ), '1.0.4', true );
	wp_register_script( 'headroom', get_theme_file_uri( 'assets/js/headroom.min.js' ), array(), '0.9.3', true );
	wp_register_script( 'pentip', get_theme_file_uri( 'assets/js/pentip.js' ), array( 'jquery' ), '1.0.0', true );
	wp_register_script( 'select2', get_theme_file_uri( 'assets/js/select2.min.js' ), array( 'jquery' ), '4.0.3', true );
	wp_register_script( 'resize-sensor', get_theme_file_uri( 'assets/js/resize-sensor.min.js' ), array( 'jquery' ), '1.0.0', true );
	wp_register_script( 'theia-sticky-sidebar', get_theme_file_uri( 'assets/js/theia-sticky-sidebar.min.js' ), array(
		'jquery',
		'resize-sensor',
	), '1.7.0', true );

	if ( penshop_get_option( 'shop_quick_view_button' ) ) {
		if ( wp_script_is( 'wc-add-to-cart-variation', 'registered' ) ) {
			wp_enqueue_script( 'wc-add-to-cart-variation' );
		}

		if ( wp_script_is( 'flexslider', 'registered' ) ) {
			wp_enqueue_script( 'flexslider' );
		}

		if ( wp_script_is( 'wc-single-product', 'registered' ) ) {
			wp_enqueue_script( 'wc-single-product' );
		}
	}

	if ( 'normal' == penshop_get_option( 'header_sticky' ) ) {
		wp_enqueue_script( 'jquery-sticky' );
	} elseif ( 'smart' == penshop_get_option( 'header_sticky' ) ) {
		wp_enqueue_script( 'headroom' );
	}

	if ( penshop_get_option( 'sidebar_sticky' ) ) {
		wp_enqueue_script( 'theia-sticky-sidebar' );
	}

	$min = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '.js' : '.min.js';

	wp_register_script( 'penshop', get_template_directory_uri() . '/assets/js/penshop' . $min, array(
		'jquery',
		'isotope',
		'pentip',
		'select2',
		'jquery-ui-autocomplete',
	), '20170612', true );

	wp_enqueue_script( 'penshop' );

	wp_localize_script( 'penshop', 'penShopData', array(
		'isRTL'           => is_rtl(),
		'ajax_url'        => admin_url( 'admin-ajax.php' ),
		'sticky_header'   => penshop_get_option( 'header_sticky' ),
		'shop_nav_type'   => penshop_get_option( 'shop_nav_type' ),
		'auto_open_cart'  => penshop_get_option( 'wc_auto_open_cart' ),
		'sticky_sidebar'  => penshop_get_option( 'sidebar_sticky' ),
		'popup_frequency' => penshop_get_option( 'popup_frequency' ),
		'popup_visible'   => penshop_get_option( 'popup_visible' ),
		'popup_delay'     => penshop_get_option( 'popup_visible_delay' ),
	) );

	// Enqueue comment reply script
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}

add_action( 'wp_enqueue_scripts', 'penshop_scripts' );


/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function penshop_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}

add_action( 'wp_head', 'penshop_pingback_header' );

/**
 * Adds the topbar before the master header
 */
function penshop_topbar() {
	if ( ! penshop_get_option( 'topbar' ) ) {
		return;
	}

	get_template_part( 'template-parts/topbar' );
}

add_action( 'penshop_before_header', 'penshop_topbar' );

/**
 * Display site header
 */
function penshop_header() {
	get_template_part( 'template-parts/header', penshop_get_option( 'header_layout' ) );
}

add_action( 'penshop_header', 'penshop_header' );

/**
 * Display the page header
 */
function penshop_page_header() {
	if ( ! penshop_has_page_header() ) {
		return;
	}

	if ( is_page_template( 'templates/homepage-parallax.php' ) ) {
		return;
	}

	get_template_part( 'template-parts/page-header' );
}

add_action( 'penshop_after_header', 'penshop_page_header' );

/**
 * Filter to archive title and add page title for singular pages
 *
 * @param string $title
 *
 * @return string
 */
function penshop_the_archive_title( $title ) {
	if ( function_exists( 'is_shop' ) && is_shop() ) {
		$title = get_the_title( wc_get_page_id( 'shop' ) );
	} elseif ( function_exists( 'is_checkout' ) && is_checkout() ) {
		$title = get_the_title( wc_get_page_id( 'checkout' ) );
	} elseif ( function_exists( 'is_cart' ) && is_cart() ) {
		$title = get_the_title( wc_get_page_id( 'cart' ) );
	} elseif ( function_exists( 'yith_wcwl_is_wishlist_page' ) && yith_wcwl_is_wishlist_page() ) {
		$wishlist_page_id = yith_wcwl_object_id( get_option( 'yith_wcwl_wishlist_page_id' ) );
		$title            = get_the_title( $wishlist_page_id );
	} elseif ( function_exists( 'is_account_page' ) && is_account_page() ) {
		$title = get_the_title( wc_get_page_id( 'myaccount' ) );
	} elseif ( is_category() || is_tag() || is_tax() ) {
		$title = single_term_title( '', false );
	} elseif ( is_home() ) {
		$title = 'page' == get_option( 'show_on_front' ) ? get_the_title( get_option( 'page_for_posts' ) ) : esc_html__( 'Blog', 'penshop' );
	} elseif ( is_search() ) {
		$title = esc_html__( 'Search results', 'penshop' );
	}

	return $title;
}

add_filter( 'get_the_archive_title', 'penshop_the_archive_title' );
