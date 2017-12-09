<?php
/**
 * Template part for displaying menu icons
 *
 * @package PenShop
 */

if ( $icons = penshop_get_option( 'menu_icons' ) ) {
	echo '<ul id="menu-icons" class="menu-icons">';

	foreach ( $icons as $icon ) {
		switch ( $icon ) {
			case 'wishlist':
				if ( ! defined( 'YITH_WCWL' ) ) {
					break;
				}
				$icon_link   = get_permalink( yith_wcwl_object_id( get_option( 'yith_wcwl_wishlist_page_id' ) ) );
				$icon_output = '<i class="fa fa-heart-o"></i>';
				printf(
					'<li class="%s-icon"><a href="%s">%s<span class="wishlist-counter counter">%s</span></a></li>',
					esc_attr( $icon ),
					esc_url( $icon_link ),
					$icon_output,
					yith_wcwl_count_products()
				);
				break;

			case 'cart':
				if ( ! function_exists( 'WC' ) ) {
					break;
				}

				$icon_link   = wc_get_page_permalink( 'cart' );
				$icon_source = penshop_get_option( 'cart_icon_source' );

				if ( 'image' == $icon_source ) {
					$width  = floatval( penshop_get_option( 'cart_icon_width' ) );
					$height = floatval( penshop_get_option( 'cart_icon_height' ) );

					$width  = $width ? ' width="' . $width . 'px"' : '';
					$height = $height ? ' height="' . $height . 'px"' : '';

					$icon_image = penshop_get_option( 'cart_icon_image' );

					if ( $icon_image ) {
						$icon_output = sprintf(
							'<img src="%s" alt="%s" %s>',
							esc_url( $icon_image ),
							esc_attr__( 'Shopping Cart', 'penshop' ),
							$width . $height
						);
					} else {
						$icon_output = '<i class="fa fa-shopping-bag"></i>';
					}
				} else {
					$icon_class  = penshop_get_option( 'cart_icon' );
					$icon_output = '<i class="fa fa-shopping-' . esc_attr( $icon_class ) . '"></i>';
				}

				$icon_output .= '<span class="cart-counter counter">' . intval( WC()->cart->get_cart_contents_count() ) . '</span>';
				printf(
					'<li class="cart-icon"><a href="%s" data-toggle="off-canvas" data-target="#off-canvas-cart">%s</a></li>',
					esc_url( $icon_link ),
					$icon_output
				);

				break;

			case 'search':
				$icon_link   = '#search';
				$icon_output = '<i class="fa fa-search"></i>';
				printf(
					'<li class="search-icon"><a href="%s" data-toggle="modal" data-target="#modal-search">%s</a></li>',
					esc_url( $icon_link ),
					$icon_output
				);
				break;

			case 'hamburger':
				$icon_link   = '#off-canvas-menu';
				$icon_output = '<i class="fa fa-bars"></i>';
				printf(
					'<li class="menu-icon"><a href="%s" data-toggle="off-canvas" data-target="#off-canvas-menu">%s</a></li>',
					esc_url( $icon_link ),
					$icon_output
				);
				break;
		}
	}

	echo '</ul>';
}