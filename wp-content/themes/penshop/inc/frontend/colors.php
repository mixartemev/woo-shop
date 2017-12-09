<?php
/**
 * Color Patterns
 *
 * @package PenShop
 */

/**
* Generate the CSS for the color scheme.
*/
function penshop_custom_colors_css() {
	$scheme = penshop_get_option( 'color_scheme' );

	if ( 'default' == $scheme ) {
		return '';
	}

	if ( 'custom' == $scheme ) {
		$color = penshop_get_option( 'color_scheme_custom' );
	} else {
		$colors = array(
			'cerulean' => '#00ADB5',
			'berry'    => '#B83B5E',
			'pink'     => '#FF2E63',
			'orange'   => '#F07B3F',
			'purple'   => '#B61AAE',
		);
		$color = isset( $colors[$scheme] ) ? $colors[$scheme] : '';
	}

	if ( empty( $color ) ) {
		return '';
	}

	$css = '
/**
 * Custom color scheme
 */

.list-dropdown ul li:hover,
a:hover, 
a:focus,
a:active, 
.nav-menu a:hover,
.nav-menu a:hover:after,
.header-text-light .nav-menu a:hover,
.header-text-light .nav-menu a:hover:after,
.topbar.dark a:hover,
.header-transparent .is-sticky .header-main a:hover,
.header-transparent.header-layout-v1 .is-sticky .main-navigation a:hover,
.breadcrumb a:hover,
.breadcrumb.woocommerce-breadcrumb a:hover,
.list-post .read-more:after,
.comment-respond .comment-form input[type="submit"]:hover,
.portfolio-items.layout-fullwidth .portfolio .portfolio-title a:hover,
.portfolio-items.layout-masonry .portfolio .portfolio-title a:hover,
.post-type-archive-portfolio .navigation .nav-previous a:hover,
.tax-portfolio_type .navigation .nav-previous a:hover,
.woocommerce .star-rating:before,
.woocommerce .star-rating span:before,
.woocommerce div.product .woocommerce-tabs ul.tabs li .count,
.woocommerce .products-toolbar .filter-panel .widget_product_categories li.current-cat a,
.woocommerce .products-toolbar .filter-panel .widget_layered_nav .chosen a,
.woocommerce.woocommerce-pagination-infinite .woocommerce-pagination ul li .next:focus, 
.woocommerce.woocommerce-pagination-infinite .woocommerce-pagination ul li .next:hover, 
.woocommerce.woocommerce-pagination-ajax .woocommerce-pagination ul li .next:focus, 
.woocommerce.woocommerce-pagination-ajax .woocommerce-pagination ul li .next:hover,
.site-footer a:hover,
.footer-light .site-footer a:hover,
.widget ul.menu a:hover,
.widget_archive li span.count,
.widget_categories li span.count,
.widget_rss li .count,
.widget_meta li .count,
.widget_recent_comments li .count,
.widget_pages li .count,
.widget_recent_entries li .count,
.widget_product_categories li .count,
.widget-products-order .current a,
.widget-price-ranges .current a,
.footer-sidebar ul li a:hover,
.footer-sidebar .widget_products .product_list_widget a:hover,
.penshop-button.button-type-underline:hover,
.penshop-button.button-type-arrow:hover,
.penshop-tabs .tabs li:hover,
.penshop-product-grid .ajax-load-products.failed,
.penshop-product-tabs .tabs li.active,
.penshop-product-tabs .tabs li.active:hover,
.penshop-post-grid .entry-title a:hover
{
	color: ' . $color . ';
}

.counter,
.portfolio-filter ul li.active, .portfolio-filter ul li:hover,
.woocommerce span.badge.onsale,
.woocommerce div.product .woocommerce-tabs ul.tabs li:after,
.woocommerce #review_form #respond .form-submit .submit:hover,
.woocommerce ul.products li.product .buttons a:hover,
.woocommerce ul.products.product-style-hidden_buttons li.product .buttons .yith-wcwl-add-to-wishlist a:hover, 
.woocommerce ul.products.product-style-hidden_buttons li.product .buttons .yith-wcwl-add-to-wishlist a.loading,
.woocommerce ul.products.product-style-hidden_buttons li.product .buttons .yith-wcwl-wishlistaddedbrowse a,
.woocommerce ul.products.product-style-hidden_buttons li.product .buttons .yith-wcwl-wishlistexistsbrowse a,
.woocommerce ul.products.product-style-dark_name li.product .buttons .yith-wcwl-add-to-wishlist a.loading, 
.woocommerce ul.products.product-style-dark_name li.product .buttons .yith-wcwl-add-to-wishlist a:hover,
.woocommerce ul.products.product-style-dark_name li.product .buttons .yith-wcwl-wishlistaddedbrowse a,
.woocommerce ul.products.product-style-dark_name li.product .buttons .yith-wcwl-wishlistexistsbrowse a,
.woocommerce .products-toolbar .shop-quick-access ul .current a,
.woocommerce .products-toolbar .shop-tools ul .current a,
.woocommerce .products-toolbar .filter-panel .widget_product_tag_cloud a.current,
.woocommerce a.button.alt:hover,
.woocommerce button.button.alt:hover,
.woocommerce input.button.alt:hover,
.woocommerce #respond input#submit.alt:hover,
.woocommerce .yith-wcwl-add-to-wishlist a.loading,
.woocommerce .yith-wcwl-add-to-wishlist a:hover,
.woocommerce .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistaddedbrowse a,
.woocommerce .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistexistsbrowse a,
.gotop,
.modal-popup .popup-content button:hover,
.modal-popup .popup-content input[type=submit]:hover,
.widget .tagcloud a:hover,
.widget_mc4wp_form_widget .mc4wp-form-fields input[type=submit]:hover,
.widget_mc4wp_form_widget .mc4wp-form-fields button:hover,
.penshop-newsletter .mc4wp-form-fields input[type=submit]:hover,
.penshop-button.button-type-normal:hover,
.penshop-button.button-type-normal.button-color-white:hover,
.penshop-button:hover,
.penshop-tabs .tabs li.active {
	background-color: ' . $color . ';
}

.post-type-archive-portfolio .navigation .nav-previous a:after,
.tax-portfolio_type .navigation .nav-previous a:after,
.woocommerce #review_form #respond .form-submit .submit:hover,
.woocommerce ul.products li.product .buttons a:hover,
.woocommerce ul.products.product-style-hidden_buttons li.product .buttons .yith-wcwl-wishlistaddedbrowse a,
.woocommerce ul.products.product-style-hidden_buttons li.product .buttons .yith-wcwl-wishlistexistsbrowse a,
.woocommerce ul.products.product-style-dark_name li.product .buttons .yith-wcwl-add-to-wishlist a.loading, 
.woocommerce ul.products.product-style-dark_name li.product .buttons .yith-wcwl-add-to-wishlist a:hover,
.woocommerce ul.products.product-style-dark_name li.product .buttons .yith-wcwl-wishlistaddedbrowse a,
.woocommerce ul.products.product-style-dark_name li.product .buttons .yith-wcwl-wishlistexistsbrowse a,
.woocommerce.woocommerce-pagination-infinite .woocommerce-pagination ul li .next:after, 
.woocommerce.woocommerce-pagination-ajax .woocommerce-pagination ul li .next:after,
.woocommerce .yith-wcwl-add-to-wishlist a.loading,
.woocommerce .yith-wcwl-add-to-wishlist a:hover,
.woocommerce .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistaddedbrowse a,
.woocommerce .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistexistsbrowse a,
.widget_mc4wp_form_widget .mc4wp-form-fields input[type=submit]:hover,
.widget_mc4wp_form_widget .mc4wp-form-fields button:hover,
.penshop-button:hover,
.penshop-button.button-type-underline:after {
	border-color: ' . $color . ';
}

.penshop-product-tabs .tabs li.active,
.woocommerce-account .woocommerce-MyAccount-navigation ul li.is-active {
	border-bottom-color: ' . $color . ';
}
';

	return apply_filters( 'penshop_custom_color_css', $css );
}

/**
 * Add inline style for color scheme
 */
function penshop_color_scheme() {
	$css = penshop_custom_colors_css();

	if ( empty( $css ) ) {
		return;
	}

	wp_add_inline_style( 'penshop', $css );
}

add_action( 'wp_enqueue_scripts', 'penshop_color_scheme' );