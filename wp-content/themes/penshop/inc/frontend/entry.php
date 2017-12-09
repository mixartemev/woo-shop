<?php
/**
 * Template functions that act on single pages
 *
 * @package PenShop
 */
/**
 * Change more string at the end of the excerpt
 *
 * @since  1.0
 *
 * @param string $more
 *
 * @return string
 */
function penshop_excerpt_more( $more ) {
	$more = '&hellip;';

	return $more;
}

add_filter( 'excerpt_more', 'penshop_excerpt_more' );

/**
 * Change length of the excerpt
 *
 * @since  1.0
 *
 * @param string $length
 *
 * @return string
 */
function penshop_excerpt_length( $length ) {
	$excerpt_length = absint( penshop_get_option( 'excerpt_length' ) );

	if ( $excerpt_length > 0 ) {
		return $excerpt_length;
	}

	return $length;
}

add_filter( 'excerpt_length', 'penshop_excerpt_length' );

/**
 * Set portfolio per page
 * @param  object $query
 */
function penshop_set_portfolios_per_page( $query ) {
	if ( is_admin() ) {
		return;
	}

	if ( ! $query->is_main_query() ) {
		return;
	}

	if ( ( $query->get( 'page_id' ) == get_option( 'page_on_front' ) || is_front_page() )
		&& ( get_option( 'woocommerce_shop_page_id' ) !=  get_option( 'page_on_front' ) ) ) {
		return;
	}

	$number  = absint( get_option( 'posts_per_page' ) );

	if ( is_post_type_archive( 'portfolio' ) || is_tax( 'portfolio_type' ) ) {
		$default = absint( penshop_get_option( 'portfolio_per_page' ) );

		if( $default ){
			$number = $default;
		}

		$query->set( 'posts_per_page', $number );
	}
}

add_action( 'pre_get_posts', 'penshop_set_portfolios_per_page' );