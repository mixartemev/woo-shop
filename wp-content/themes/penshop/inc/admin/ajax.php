<?php
/**
 * Handle ajax requests
 *
 * @package PenShop
 */

/**
 * Autocomplete ajax search
 */
function penshop_ajax_search() {
	if ( ! isset( $_POST['term'] ) ) {
		wp_send_json_error( esc_html__( 'No term to search', 'penshop' ) );
		die();
	}

	$args = array(
		'posts_per_page'         => 5,
		'post_status'            => 'publish',
		'ignore_sticky_posts'    => 1,
		's'                      => $_POST['term'],
		'update_post_term_cache' => false,
		'update_post_meta_cache' => false,
	);

	if ( ! empty( $_POST['type'] ) ) {
		$args['post_type'] = trim( $_POST['type'] );

		if ( 'product' == $_POST['type'] && function_exists( 'WC' ) ) {
			$args['meta_query'] = WC()->query->get_meta_query();
			$args['tax_query']  = WC()->query->get_tax_query();
		}
	}

	if ( ! empty( $_POST['cat'] ) ) {
		if ( ! empty( $_POST['type'] ) && 'product' == $_POST['type'] ) {
			$args['tax_query'][] = array(
				array(
					'taxonomy' => 'product_cat',
					'terms'    => array_map( 'sanitize_title', explode( ',', $_POST['cat'] ) ),
					'field'    => 'slug',
					'operator' => 'IN',
				),
			);
		} elseif ( empty( $_POST['type'] ) ) {
			$args['category_name'] = $_POST['cat'];
		}
	}

	$results = new WP_Query( $args );

	$response = array();

	if ( $results->have_posts() ) {
		while ( $results->have_posts() ) {
			$results->the_post();

			$item = array(
				'value' => get_the_title(),
				'url'   => get_permalink(),
				'thumb' => get_the_post_thumbnail( get_the_ID(), 'thumbnail' ),
				'price' => '',
			);

			if ( 'product' == get_post_type() ) {
				$_product      = wc_get_product( $results->post );
				$item['price'] = $_product->get_price_html();
			}

			$response[] = $item;
		}
	}

	if ( empty( $response ) ) {
		$response[] = array(
			'value' => esc_html__( 'Nothing found', 'penshop' ),
			'url'   => '#',
			'thumb' => '',
			'price' => '',
		);
	}

	wp_send_json_success( $response );
	die();
}

add_action( 'wp_ajax_nopriv_penshop_search', 'penshop_ajax_search' );
add_action( 'wp_ajax_penshop_search', 'penshop_ajax_search' );