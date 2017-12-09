<?php
/**
 * Load and register widgets
 *
 * @package
 */

/**
 * Widgets
 */

require_once get_theme_file_path( 'inc/widgets/account.php' );
require_once get_theme_file_path( 'inc/widgets/socials.php' );
require_once get_theme_file_path( 'inc/widgets/languages.php' );
require_once get_theme_file_path( 'inc/widgets/currency.php' );
require_once get_theme_file_path( 'inc/widgets/popular-posts.php' );
require_once get_theme_file_path( 'inc/widgets/products-order.php' );
require_once get_theme_file_path( 'inc/widgets/price-ranges.php' );
require_once get_theme_file_path( 'inc/widgets/instagram.php' );

/**
 * Register widgets
 *
 * @since  1.0
 *
 * @return void
 */
function penshop_register_widgets() {
	register_widget( 'PenShop_Social_Links_Widget' );
	register_widget( 'PenShop_Language_Switcher_Widget' );
	register_widget( 'PenShop_Currency_Switcher_Widget' );
	register_widget( 'PenShop_Account_Widget' );
	register_widget( 'PenShop_Popular_Posts_Widget' );
	register_widget( 'PenShop_Products_Order_Widget' );
	register_widget( 'PenShop_Price_Ranges_Widget' );
	register_widget( 'PenShop_Instagram_Widget' );
}
add_action( 'widgets_init', 'penshop_register_widgets' );

/**
 * Change markup of archive and category widget to include .count for post count
 *
 * @param string $output
 *
 * @return string
 */
function penshop_widget_archive_count( $output ) {
	$output = preg_replace( '|\((\d+)\)|', '<span class="count">\\1</span>', $output );

	return $output;
}

add_filter( 'wp_list_categories', 'penshop_widget_archive_count' );
add_filter( 'get_archives_link', 'penshop_widget_archive_count' );