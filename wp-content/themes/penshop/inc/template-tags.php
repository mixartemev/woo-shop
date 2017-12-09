<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package PenShop
 */


if ( ! function_exists( 'penshop_fonts_url' ) ) :
	/**
	 * Register fonts
	 *
	 * @return string
	 */
	function penshop_fonts_url() {
		$fonts_url     = '';
		$font_families = array();
		$font_subsets  = array( 'latin', 'latin-ext' );

		/* Translators: If there are characters in your language that are not
		* supported by Roboto, translate this to 'off'. Do not translate
		* into your own language.
		*/
		if ( 'off' !== _x( 'on', 'Roboto font: on or off', 'penshop' ) ) {
			$font_families['Roboto'] = 'Roboto:300,400,500,600,700';
		}

		/* Translators: If there are characters in your language that are not
		* supported by Poppins, translate this to 'off'. Do not translate
		* into your own language.
		*/
		if ( 'off' !== _x( 'on', 'Poppins font: on or off', 'penshop' ) ) {
			$font_families['Poppins'] = 'Poppins:400,500,600,700';
		}

		/* Translators: If there are characters in your language that are not
		* supported by Playfair Display, translate this to 'off'. Do not translate
		* into your own language.
		*/
		if ( 'off' !== _x( 'on', 'Playfair Display: on or off', 'penshop' ) ) {
			$font_families['Playfair Display'] = 'Playfair Display:400,400i,700,700i';
		}

		// Get custom fonts from typography settings
		$settings = array(
			'typo_body',
			'typo_link',
			'typo_link_hover',
			'typo_h1',
			'typo_h2',
			'typo_h3',
			'typo_h4',
			'typo_h5',
			'typo_h6',
			'typo_menu',
			'typo_submenu',
			'typo_toggle_menu',
			'typo_toggle_submenu',
			'typo_page_header_title',
			'typo_breadcrumb',
			'type_widget_title',
			'type_footer_info',
		);

		foreach ( $settings as $setting ) {
			$typography = penshop_get_option( $setting );

			if (
				isset( $typography['font-family'] )
				&& ! empty( $typography['font-family'] )
				&& ! array_key_exists( $typography['font-family'], $font_families )
			) {
				$font_families[ $typography['font-family'] ] = $typography['font-family'];

				if ( isset( $typography['subsets'] ) ) {
					if ( is_array( $typography['subsets'] ) ) {
						$font_subsets = array_merge( $font_subsets, $typography['subsets'] );
					} else {
						$font_subsets[] = $typography['subsets'];
					}
				}
			}
		}

		if ( ! empty( $font_families ) ) {
			$font_subsets = array_unique( $font_subsets );
			$query_args   = array(
				'family' => urlencode( implode( '|', $font_families ) ),
				'subset' => urlencode( implode( ',', $font_subsets ) ),
			);

			$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
		}

		return esc_url_raw( $fonts_url );
	}
endif;

if ( ! function_exists( 'penshop_entry_meta' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time and author.
	 */
	function penshop_entry_meta() {
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ', ', 'penshop' ) );

			if ( $categories_list ) {
				echo '<span class="cat-links"><i class="fa fa-folder-o"></i> ' . $categories_list . '</span>'; // WPCS: XSS OK.
			}
		}

		$time_string = sprintf(
			'<time class="entry-date published updated" datetime="%1$s">%2$s</time>',
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date( get_option( 'date_format', 'd.m Y' ) ) )
		);

		$posted_on = is_singular() ? $time_string : '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>';
		echo '<span class="posted-on"><i class="fa fa-clock-o"></i>' . $posted_on . '</span>';

		if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link"><i class="fa fa-comments-o"></i>';
			comments_popup_link();
			echo '</span>';
		}
	}
endif;

if ( ! function_exists( 'penshop_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function penshop_entry_footer() {
		do_action( 'penshop_entry_footer_before' );

		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'penshop' ) );

			if ( $tags_list ) {
				echo '<span class="tags-links"><span>' . esc_html__( 'Tags:', 'penshop' ) . ' </span>' . $tags_list . '</span>';
			}
		}

		do_action( 'penshop_entry_footer_after' );
	}
endif;

if ( ! function_exists( 'penshop_portfolio_filter' ) ) :
	/**
	 * Get portfolio types and display it as a filter for Isotope script
	 */
	function penshop_portfolio_filter() {
		$types = get_terms( array(
			'taxonomy'   => 'portfolio_type',
			'hide_empty' => true,
		) );

		if ( ! $types || is_wp_error( $types ) || 1 === count( $types ) ) {
			return;
		}

		$filter   = array();
		$filter[] = '<li data-filter="*" class="active">' . esc_html__( 'All', 'penshop' ) . '</li>';

		foreach ( $types as $type ) {
			$filter[] = sprintf( '<li data-filter=".portfolio_type-%s" class="">%s</li>', esc_attr( $type->slug ), esc_html( $type->name ) );
		}

		printf(
			'<div class="portfolio-filter"><ul class="filter">%s</ul></div>',
			implode( "\n\t", $filter )
		);
	}
endif;

if ( ! function_exists( 'penshop_get_layout' ) ) :
	/**
	 * Get layout of current page
	 *
	 * @return string
	 */
	function penshop_get_layout() {
		$layout = penshop_get_option( 'layout_default' );

		if (
			is_404()
			|| is_post_type_archive( 'portfolio' )
			|| ( is_tax() && is_object_in_taxonomy( 'portfolio', get_query_var( 'taxonomy' ) ) )
			|| ( function_exists( 'is_cart' ) && is_cart() )
			|| ( function_exists( 'is_checkout' ) && is_checkout() )
			|| ( function_exists( 'is_account_page' ) && is_account_page() )
			|| ( function_exists( 'yith_wcwl_is_wishlist_page' ) && yith_wcwl_is_wishlist_page() )
		) {
			$layout = 'no-sidebar';
		} elseif ( is_singular() && get_post_meta( get_the_ID(), 'custom_layout', true ) ) {
			$layout = get_post_meta( get_the_ID(), 'layout', true );
		} elseif ( is_singular( 'post' ) ) {
			$layout = penshop_get_option( 'layout_post' );
		} elseif ( is_singular( 'product' ) ) {
			$layout = penshop_get_option( 'layout_product' );
		} elseif ( function_exists( 'is_woocommerce' ) && is_woocommerce() ) {
			$shop_page_id = wc_get_page_id( 'shop' );

			if ( get_post_meta( $shop_page_id, 'custom_layout', true ) ) {
				$layout = get_post_meta( $shop_page_id, 'layout', true );
			} else {
				$layout = penshop_get_option( 'layout_shop' );
			}
		} elseif ( is_page() ) {
			$layout = penshop_get_option( 'layout_page' );
		}

		return $layout;
	}
endif;

if ( ! function_exists( 'penshop_content_column_class' ) ) :
	/**
	 * Get the column class of site content
	 *
	 * @return string
	 */
	function penshop_content_column_class() {
		$class = 'no-sidebar' == penshop_get_layout() ? '' : 'col-md-8';

		return apply_filters( 'penshop_content_column_class', $class );
	}
endif;

if ( ! function_exists( 'penshop_entry_thumbnail' ) ) :
	/**
	 * Show entry thumbnail base on its format
	 *
	 * @since  1.0
	 */
	function penshop_entry_thumbnail( $size = 'thumbnail' ) {
		$html = '';

		switch ( get_post_format() ) {
			case 'gallery':
				$images = get_post_meta( get_the_ID(), 'images' );

				if ( empty( $images ) ) {
					break;
				}

				$gallery = array();
				foreach ( $images as $image ) {
					$gallery[] = wp_get_attachment_image( $image, $size );
				}
				$html .= '<div class="entry-gallery entry-image">' . implode( '', $gallery ) . '</div>';
				break;

			case 'audio':

				$thumb = get_the_post_thumbnail( get_the_ID(), $size );
				if ( ! empty( $thumb ) ) {
					$html .= '<a class="entry-image" href="' . get_permalink() . '">' . $thumb . '</a>';
				}

				$audio = get_post_meta( get_the_ID(), 'audio', true );
				if ( ! $audio ) {
					break;
				}

				// If URL: show oEmbed HTML or jPlayer
				if ( filter_var( $audio, FILTER_VALIDATE_URL ) ) {
					if ( $oembed = @wp_oembed_get( $audio, array( 'width' => 1140 ) ) ) {
						$html .= $oembed;
					} else {
						$html .= '<div class="audio-player">' . wp_audio_shortcode( array( 'src' => $audio ) ) . '</div>';
					}
				} else {
					$html .= $audio;
				}
				break;

			case 'video':
				$video = get_post_meta( get_the_ID(), 'video', true );
				if ( ! $video ) {
					break;
				}

				// If URL: show oEmbed HTML
				if ( filter_var( $video, FILTER_VALIDATE_URL ) ) {
					if ( $oembed = @wp_oembed_get( $video, array( 'width' => 1140 ) ) ) {
						$html .= $oembed;
					} else {
						$atts = array(
							'src'   => $video,
							'width' => 1140,
						);

						if ( has_post_thumbnail() ) {
							$atts['poster'] = get_the_post_thumbnail_url( get_the_ID(), 'full' );
						}
						$html .= wp_video_shortcode( $atts );
					}
				} // If embed code: just display
				else {
					$html .= $video;
				}
				break;

			default:
				$html = get_the_post_thumbnail( get_the_ID(), $size );

				break;
		}

		echo apply_filters( __FUNCTION__, $html, get_post_format() );
	}
endif;

if ( ! function_exists( 'penshop_has_page_header' ) ) :
	/**
	 * Check if current page has page header
	 *
	 * @return bool
	 */
	function penshop_has_page_header() {
		if ( is_page() && get_post_meta( get_the_ID(), 'hide_page_header', true ) ) {
			return false;
		} elseif ( is_singular( array( 'post', 'product' ) ) ) {
			return false;
		} elseif ( is_404() ) {
			return false;
		} elseif ( is_home() ) {
			$posts_page_id = get_option( 'page_for_posts' );

			if ( $posts_page_id && get_post_meta( $posts_page_id, 'hide_page_header', true ) ) {
				return false;
			}
		} elseif ( function_exists( 'is_woocommerce' ) && is_woocommerce() ) {
			if ( is_shop() ) {
				if ( get_post_meta( wc_get_page_id( 'shop' ), 'hide_page_header', true ) ) {
					return false;
				} else {
					return penshop_get_option( 'page_header_shop' );
				}
			} else {
				return penshop_get_option( 'page_header_shop' );
			}
		}

		return penshop_get_option( 'page_header' );
	}
endif;

if ( ! function_exists( 'penshop_get_page_header_image' ) ) :
	/**
	 * Get the image SRC of page header
	 *
	 * @return bool|string
	 */
	function penshop_get_page_header_image() {
		if ( is_page() && ( $image = get_post_meta( get_the_ID(), 'page_header_image', true ) ) ) {
			$image = wp_get_attachment_image_src( $image, 'full' );

			return $image ? $image[0] : false;
		} elseif ( is_home() ) {
			$posts_page_id = get_option( 'page_for_posts' );

			if ( $posts_page_id && ( $image = get_post_meta( $posts_page_id, 'hide_page_header', true ) ) ) {
				$image = wp_get_attachment_image_src( $image, 'full' );

				return $image ? $image[0] : false;
			} else {
				return penshop_get_option( 'page_header_image' );
			}
		} elseif ( function_exists( 'is_woocommerce' ) && is_woocommerce() ) {
			if ( is_shop() ) {
				if ( $image = get_post_meta( wc_get_page_id( 'shop' ), 'page_header_image', true ) ) {
					$image = wp_get_attachment_image_src( $image, 'full' );

					return $image ? $image[0] : false;
				} else {
					return penshop_get_option( 'page_header_shop_image' );
				}
			} else {
				return penshop_get_option( 'page_header_shop_image' );
			}
		}

		return penshop_get_option( 'page_header_image' );
	}
endif;

if ( ! function_exists( 'penshop_mobile_header_menu_button' ) ) :
	/**
	 * Print HTML of the mobile menu toggle button
	 */
	function penshop_mobile_header_menu_button() {
		?>

		<div class="mobile-menu-toggle hidden-lg">
			<a href="#" data-toggle="off-canvas" data-target="#off-canvas-mobile-menu"><i class="fa fa-bars"></i></a>
		</div>

		<?php
	}
endif;

if ( ! function_exists( 'penshop_mobile_header_icon' ) ) :
	/**
	 * Print HTML of the mobile menu toggle button
	 */
	function penshop_mobile_header_icon() {
		$icon = penshop_get_option( 'mobile_header_icon' );

		echo '<div class="mobile-menu-icon hidden-lg">';

		switch ( $icon ) {
			case 'wishlist':
				if ( ! defined( 'YITH_WCWL' ) ) {
					break;
				}
				$icon_link   = get_permalink( yith_wcwl_object_id( get_option( 'yith_wcwl_wishlist_page_id' ) ) );
				$icon_output = '<i class="fa fa-heart-o"></i>';
				printf(
					'<a href="%s">%s<span class="wishlist-counter counter">%s</span></a>',
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
					'<a href="%s" data-toggle="off-canvas" data-target="#off-canvas-cart">%s</a>',
					esc_url( $icon_link ),
					$icon_output
				);

				break;

			case 'search':
				$icon_link   = '#search';
				$icon_output = '<i class="fa fa-search"></i>';
				printf(
					'<a href="%s" data-toggle="modal" data-target="#modal-search">%s</a>',
					esc_url( $icon_link ),
					$icon_output
				);
				break;
		}

		echo '</div>';
	}
endif;