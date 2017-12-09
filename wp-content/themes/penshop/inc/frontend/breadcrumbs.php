<?php
/**
 * Breadcrumbs functions
 *
 * @package PenShop
 */

/**
 * Display the breadcrumbs
 */
function penshop_the_breadcrumbs() {
	if ( function_exists( 'is_woocommerce' ) && is_woocommerce() ) {
		if ( is_shop() ) {
			if ( get_post_meta( wc_get_page_id( 'shop' ), 'hide_breadcrumbs', true ) ) {
				return;
			} elseif ( ! penshop_get_option( 'page_header_shop_breadcrumbs' ) ) {
				return;
			}
		} elseif ( ! penshop_get_option( 'page_header_shop_breadcrumbs' ) ) {
			return;
		}
	} elseif ( ! penshop_get_option( 'page_header_breadcrumbs' ) ) {
		return;
	}

	$yoast = get_option( 'wpseo_internallinks' );

	if ( function_exists( 'yoast_breadcrumb' ) && $yoast && $yoast['breadcrumbs-enable'] ) {
		yoast_breadcrumb( '<div class="breadcrumb">', '</div>' );
	} elseif ( function_exists( 'is_woocommerce' ) && is_woocommerce() ) {
		woocommerce_breadcrumb();
	} else {
		penshop_breadcrumbs();
	}
}

/**
 * Display breadcrumbs for posts, pages, archive page
 *
 * @param array|string $args
 */
function penshop_breadcrumbs( $args = '' ) {
	$args = wp_parse_args( $args, array(
		'separator'         => '<i class="fa fa-angle-right" aria-hidden="true"></i>',
		'home_class'        => 'home',
		'before'            => '<nav class="breadcrumb" itemprop="breadcrumb">',
		'after'             => '</nav>',
		'before_item'       => '',
		'after_item'        => '',
		'taxonomy'          => 'category',
		'display_last_item' => true,
		'show_on_front'     => false,
		'labels'            => array(
			'home'      => esc_html__( 'Home', 'penshop' ),
			'archive'   => esc_html__( 'Archives', 'penshop' ),
			'blog'      => esc_html__( 'Blog', 'penshop' ),
			'search'    => esc_html__( 'Search results for', 'penshop' ),
			'not_found' => esc_html__( 'Not Found', 'penshop' ),
			'author'    => esc_html__( 'Author Archives:', 'penshop' ),
			'day'       => esc_html__( 'Daily Archives:', 'penshop' ),
			'month'     => esc_html__( 'Monthly Archives:', 'penshop' ),
			'year'      => esc_html__( 'Yearly Archives:', 'penshop' ),
		),
	) );

	$args = apply_filters( 'penshop_breadcrumbs_args', $args );

	if ( is_front_page() && ! $args['show_on_front'] ) {
		return;
	}

	$items = array();

	// HTML template for each item
	$item_tpl      = $args['before_item'] . '<a href="%s" itemprop="url"><span itemprop="title">%s</span></a>' . $args['after_item'];
	$item_text_tpl = $args['before_item'] . '<span itemprop="title">%s</span>' . $args['after_item'];

	// Home
	if ( ! $args['home_class'] ) {
		$items[] = sprintf( $item_tpl, get_home_url(), $args['labels']['home'] );
	} else {
		$items[] = sprintf(
			'%s<a class="%s" href="%s" itemprop="url"><span itemprop="title">%s</span></a>%s',
			$args['before_item'],
			$args['home_class'],
			get_home_url(),
			$args['labels']['home'],
			$args['after_item']
		);
	}

	// Front page
	if ( is_front_page() ) {
		$items   = array();
		$items[] = sprintf( $item_text_tpl, $args['labels']['home'] );
	}
	// Blog
	elseif ( is_home() && ! is_front_page() ) {
		$items[] = sprintf(
			$item_text_tpl,
			$args['labels']['blog']
		);
	}
	// Single
	elseif ( is_single() ) {
		// Terms

		$taxonomy = $args['taxonomy'];
		$terms   = get_the_terms( get_the_ID(),  $taxonomy );
		if( $terms ) {
			$term    = current( $terms );
			$terms   = penshop_get_term_parents( $term->term_id, $taxonomy );
			$terms[] = $term->term_id;

			foreach ( $terms as $term_id ) {
				$term    = get_term( $term_id, $taxonomy );
				$items[] = sprintf( $item_tpl, get_term_link( $term, $taxonomy ), $term->name );
			}
		}

		if ( $args['display_last_item'] ) {
			$items[] = sprintf( $item_text_tpl, get_the_title() );
		}
	}
	// Page
	elseif ( is_page() ) {
		$pages = penshop_get_post_parents( get_queried_object_id() );
		foreach ( $pages as $page )
		{
			$items[] = sprintf( $item_tpl, get_permalink( $page ), get_the_title( $page ) );
		}
		if ( $args['display_last_item'] )
			$items[] = sprintf( $item_text_tpl, get_the_title() );
	}
	// Taxonomy
	elseif ( is_tax() || is_category() || is_tag() ) {
		$current_term = get_queried_object();

		if( $current_term ) {
			$terms        = penshop_get_term_parents( get_queried_object_id(), $current_term->taxonomy );
			if( $terms ) {
				foreach ( $terms as $term_id )
				{
					$term    = get_term( $term_id, $current_term->taxonomy );
					$items[] = sprintf( $item_tpl, get_category_link( $term_id ), $term->name );
				}
			}

			if ( $args['display_last_item'] )
				$items[] = sprintf( $item_text_tpl, $current_term->name );
		}

	}
	// Search
	elseif ( is_search() ) {
		$items[] = sprintf( $item_text_tpl, $args['labels']['search'] . ' &quot;' . get_search_query() . '&quot;' );
	}
	// 404
	elseif ( is_404() ) {
		$items[] = sprintf( $item_text_tpl, $args['labels']['not_found'] );
	}
	// Author archive
	elseif ( is_author() ) {
		// Queue the first post, that way we know what author we're dealing with (if that is the case).
		the_post();
		$items[] = sprintf(
			$item_text_tpl,
			$args['labels']['author'] . ' <span class="vcard"><a class="url fn n" href="' . get_author_posts_url( get_the_author_meta( 'ID' ) ) . '" title="' . esc_attr( get_the_author() ) . '" rel="me">' . get_the_author() . '</a></span>'
		);
		rewind_posts();
	}
	// Day archive
	elseif ( is_day() ) {
		$items[] = sprintf(
			$item_text_tpl,
			sprintf( esc_html__( '%s %s', 'penshop' ), $args['labels']['day'], get_the_date() )
		);
	}
	// Month archive
	elseif ( is_month() ) {
		$items[] = sprintf(
			$item_text_tpl,
			sprintf( esc_html__( '%s %s', 'penshop' ), $args['labels']['month'], get_the_date( 'F Y' ) )
		);
	}
	// Year archive
	elseif ( is_year() ) {
		$items[] = sprintf(
			$item_text_tpl,
			sprintf( esc_html__( '%s %s', 'penshop' ), $args['labels']['year'], get_the_date( 'Y' ) )
		);
	}
	// Portfolio
	elseif ( is_post_type_archive( 'portfolio' ) ) {

		$items[] = sprintf(
			$item_text_tpl,
			esc_html__( 'Portfolio', 'penshop' )
		);

	}
	// Archive
	else {
		$items[] = sprintf(
			$item_text_tpl,
			$args['labels']['archive']
		);
	}

	echo $args['before'] . implode( $args['separator'], $items ) . $args['after'];
}

/**
 * Searches for term parents' IDs of hierarchical taxonomies, including current term.
 * This function is similar to the WordPress function get_category_parents() but handles any type of taxonomy.
 * Modified from Hybrid Framework
 *
 * @param int|string    $term_id  The term ID
 * @param object|string $taxonomy The taxonomy of the term whose parents we want.
 *
 * @return array Array of parent terms' IDs.
 */
function penshop_get_term_parents( $term_id = '', $taxonomy = 'category' ) {
	// Set up some default arrays.
	$list = array();

	// If no term ID or taxonomy is given, return an empty array.
	if ( empty( $term_id ) || empty( $taxonomy ) ) {
		return $list;
	}

	do {
		$list[] = $term_id;

		// Get next parent term
		$term    = get_term( $term_id, $taxonomy );
		$term_id = $term->parent;
	} while ( $term_id );

	// Reverse the array to put them in the proper order for the trail.
	$list = array_reverse( $list );
	array_pop( $list );

	return $list;
}

/**
 * Gets parent posts' IDs of any post type, include current post
 * Modified from Hybrid Framework
 *
 * @param int|string $post_id ID of the post whose parents we want.
 *
 * @return array Array of parent posts' IDs.
 */
function penshop_get_post_parents( $post_id = '' ) {
	// Set up some default array.
	$list = array();

	// If no post ID is given, return an empty array.
	if ( empty( $post_id ) ) {
		return $list;
	}

	do {
		$list[] = $post_id;

		// Get next parent post
		$post    = get_post( $post_id );
		$post_id = $post->post_parent;
	} while ( $post_id );

	// Reverse the array to put them in the proper order for the trail.
	$list = array_reverse( $list );
	array_pop( $list );

	return $list;
}
