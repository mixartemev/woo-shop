<?php
/**
 * Additional features to allow styling of the templates
 *
 * @package PenShop
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 *
 * @return array
 */
function penshop_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of layout
	$classes[] = penshop_get_layout();

	// Adds a class of blog layout
	$classes[] = 'blog-layout-' . penshop_get_option( 'blog_layout' );

	// Adds classes of site header
	$header_color = penshop_get_option( 'header_color_scheme' );
	$classes[]    = 'header-layout-' . penshop_get_option( 'header_layout' );

	if ( is_singular() || ( function_exists( 'is_shop' ) && is_shop() ) ) {
		$page_id      = is_singular() ? get_the_ID() : wc_get_page_id( 'shop' );
		$custom_color = get_post_meta( $page_id, 'header_color_scheme', true );

		if ( $custom_color ) {
			$classes[] = 'header-' . $custom_color;

			if ( 'dark' == $custom_color ) {
				$classes[] = 'header-text-light';
			} elseif ( 'light' == $custom_color ) {
				$classes[] = 'header-text-dark';
			} elseif ( $text_color = get_post_meta( $page_id, 'header_text_color', true ) ) {
				$classes[] = 'header-text-' . $text_color;
			}
		} else {
			$classes[] = 'header-' . $header_color;

			if ( $text_color = get_post_meta( $page_id, 'header_text_color', true ) ) {
				$classes[] = 'header-text-' . $text_color;
			} else {
				if ( 'dark' == $header_color ) {
					$classes[] = 'header-text-light';
				} elseif ( 'light' == $header_color ) {
					$classes[] = 'header-text-dark';
				} else {
					$classes[] = 'header-text-' . penshop_get_option( 'header_text_color' );
				}
			}
		}
	} else {
		$classes[] = 'header-' . $header_color;

		if ( 'dark' == $header_color ) {
			$classes[] = 'header-text-light';
		} elseif ( 'light' == $header_color ) {
			$classes[] = 'header-text-dark';
		} else {
			$classes[] = 'header-text-' . penshop_get_option( 'header_text_color' );
		}
	}

	// Adds classes of page header
	$classes[] = penshop_has_page_header() ? 'has-page-header' : 'no-page-header';
	if ( penshop_has_page_header() ) {
		if ( function_exists( 'is_woocommerce' ) && is_woocommerce() ) {
			if ( is_shop() && ( $color = get_post_meta( wc_get_page_id( 'shop' ), 'page_header_text_color', true ) ) ) {
				$classes[] = 'page-header-text-' . $color;
			} else {
				$classes[] = 'page-header-text-' . penshop_get_option( 'page_header_shop_text_color' );
			}
		} else {
			if ( is_singular() && ( $color = get_post_meta( get_the_ID(), 'page_header_text_color', true ) ) ) {
				$classes[] = 'page-header-text-' . $color;
			} else {
				$classes[] = 'page-header-text-' . penshop_get_option( 'page_header_text_color' );
			}
		}

	}

	// Add classes of shop
	if ( function_exists( 'WC' ) ) {
		if ( is_shop() || is_product_taxonomy() ) {
			$classes[] = 'shop-' . penshop_get_option( 'shop_layout' );
			$classes[] = 'woocommerce-pagination-' . penshop_get_option( 'shop_nav_type' );
		}
	}

	// Add classes of site content padding
	if ( is_page() || ( function_exists( 'is_shop' ) && is_shop() ) ) {
		$page_id = is_singular() ? get_the_ID() : wc_get_page_id( 'shop' );

		if ( get_post_meta( $page_id, 'remove_top_padding', true ) ) {
			$classes[] = 'content-no-top-padding';
		}

		if ( get_post_meta( $page_id, 'remove_bottom_padding', true ) ) {
			$classes[] = 'content-no-bottom-padding';
		}
	}

	// Adds a classes of footer background
	$classes[] = 'footer-' . penshop_get_option( 'footer_background' );
	$classes[] = 'footer-' . penshop_get_option( 'footer_layout' );

	return $classes;
}

add_filter( 'body_class', 'penshop_body_classes' );


/**
 * Enqueues front-end CSS for theme customization
 */
function penshop_customize_css() {
	$css = '';

	// 404 Background image
	if ( is_404() ) {
		$image = penshop_get_option( '404_bg' );

		if ( $image ) {
			$css .= 'body.error404 .error-404 { background-image: url( ' . esc_url( $image ) . '); }';
		}
	}

	// Typography
	$css .= penshop_typography_css();

	// Topbar
	if ( 'custom' == penshop_get_option( 'topbar_color_scheme' ) ) {
		$text_color = penshop_get_option( 'topbar_text_color' );
		$topbar_css = 'background-color: ' . penshop_get_option( 'topbar_color' );
		$topbar_css .= ';color: ' . $text_color;

		$css .= '.topbar.custom {' . $topbar_css . '}';
		$css .= '.topbar.custom a {color:' . $text_color . '}';
	}

	// Header color scheme
	if ( 'custom' == penshop_get_option( 'header_color_scheme' ) && ( $color = penshop_get_option( 'header_color' ) ) ) {
		$css .= '.header-custom .site-header, .header-custom.header-layout-v1 .main-navigation { background-color: ' . esc_attr( $color ) . '}';
	}

	// Logo width
	$logo_width  = penshop_get_option( 'logo_width' );
	$logo_height = penshop_get_option( 'logo_height' );

	if ( $logo_width || $logo_height ) {
		$logo_css = '';
		$logo_css_sticky = '';

		if ( $logo_width ) {
			$logo_css .= 'width: ' . esc_attr( $logo_width ) . 'px;';
			$logo_css_sticky .= 'width: ' . esc_attr( $logo_width/1.5 ) . 'px;';
		}

		if ( $logo_height ) {
			$logo_css .= 'height: ' . esc_attr( $logo_height ) . 'px;';
			$logo_css_sticky .= 'height: ' . esc_attr( $logo_height/1.5 ) . 'px;';
		}

		$css .= '.site-branding .logo img {' . $logo_css . '} .is-sticky .site-branding .logo img {' . $logo_css_sticky . '}';
	}

	// Logo margin
	$logo_margin = penshop_get_option( 'logo_margin' );
	$logo_margin = array_filter( (array) $logo_margin );

	if ( $logo_margin ) {
		$logo_css = '';

		foreach ( $logo_margin as $pos => $value ) {
			$logo_css .= 'margin-' . $pos . ': ' . esc_attr( $value ) . ';';
		}

		$css .= '.site-branding .logo {' . $logo_css . '}';
	}

	// Page header
	if ( penshop_has_page_header() ) {
		$image = penshop_get_page_header_image();

		if ( function_exists( 'is_woocommerce' ) && is_woocommerce() ) {
			$shop_page_id    = wc_get_page_id( 'shop' );
			$custom_image    = get_post_meta( $shop_page_id, 'page_header_image', true );
			$deskop_position = get_post_meta( $shop_page_id, 'page_header_image_position', true );

			// Desktop background position
			if ( is_shop() && $custom_image && $deskop_position ) {
				if ( 'custom' == $deskop_position ) {
					$css_pos = get_post_meta( $shop_page_id, 'page_header_image_position_x', true ) . '% ';
					$css_pos .= get_post_meta( $shop_page_id, 'page_header_image_position_y', true ) . '%';
				} else {
					$css_pos = $deskop_position;
				}
			} else {
				$position = penshop_get_option( 'page_header_shop_image_position' );

				if ( 'custom' == $position ) {
					$css_pos = penshop_get_option( 'page_header_shop_image_position_x' ) . '% ';
					$css_pos .= penshop_get_option( 'page_header_shop_image_position_y' ) . '%';
				} else {
					$css_pos = $position;
				}
			}

			$css .= '.woocommerce .page-header {
				background-color: ' . penshop_get_option( 'page_header_shop_color' ) . ';
				background-image: url(' . $image . ');
				background-position: ' . $css_pos . ';
			}';

			// Mobile background position
			if ( is_shop() && $custom_image && ( $mobile_position = get_post_meta( $shop_page_id, 'page_header_image_mobile_position', true ) ) ) {
				if ( 'custom' == $mobile_position ) {
					$css_pos_mobile = get_post_meta( $shop_page_id, 'page_header_image_mobile_position_x', true ) . '% ';
					$css_pos_mobile .= get_post_meta( $shop_page_id, 'page_header_image_mobile_position_y', true ) . '%';
				} else {
					$css_pos_mobile = $mobile_position;
				}
			} else {
				$position_mobile = penshop_get_option( 'mobile_page_header_shop_image_position' );

				if ( 'custom' == $position_mobile ) {
					$css_pos_mobile = penshop_get_option( 'mobile_page_header_shop_image_position_x' ) . '% ';
					$css_pos_mobile .= penshop_get_option( 'mobile_page_header_shop_image_position_y' ) . '%';
				} else {
					$css_pos_mobile = $position_mobile;
				}
			}

			$css .= '@media (max-width: 767px) {
				.woocommerce .page-header { background-position: ' . $css_pos_mobile . '}
			}';
		} else {
			// Desktop background position
			if (
				is_singular()
				&& ( $page_id = get_the_ID() )
				&& ( $custom_image = get_post_meta( $page_id, 'page_header_image', true ) )
				&& ( $deskop_position = get_post_meta( $page_id, 'page_header_image_position', true ) )
			) {
				if ( 'custom' == $deskop_position ) {
					$css_pos = get_post_meta( $page_id, 'page_header_image_position_x', true ) . '% ';
					$css_pos .= get_post_meta( $page_id, 'page_header_image_position_y', true ) . '%';
				} else {
					$css_pos = $deskop_position;
				}
			} else {
				$position = penshop_get_option( 'page_header_image_position' );

				if ( 'custom' == $position ) {
					$css_pos = penshop_get_option( 'page_header_image_position_x' ) . '% ';
					$css_pos .= penshop_get_option( 'page_header_image_position_y' ) . '%';
				} else {
					$css_pos = $position;
				}
			}

			$css .= '.page-header {
				background-color: ' . penshop_get_option( 'page_header_color' ) . ';
				background-image: url(' . $image . ');
				background-position: ' . $css_pos . '
			}';

			// Mobile background position
			if (
				is_singular()
				&& ( $page_id = get_the_ID() )
				&& ( $custom_image = get_post_meta( $page_id, 'page_header_image', true ) )
				&& ( $mobile_position = get_post_meta( $page_id, 'page_header_image_mobile_position', true ) )
			) {
				if ( 'custom' == $mobile_position ) {
					$css_pos_mobile = get_post_meta( get_the_ID(), 'page_header_image_mobile_position_x', true ) . '% ';
					$css_pos_mobile .= get_post_meta( get_the_ID(), 'page_header_image_mobile_position_y', true ) . '%';
				} else {
					$css_pos_mobile = $mobile_position;
				}
			} else {
				$position_mobile = penshop_get_option( 'mobile_page_header_image_position' );

				if ( 'custom' == $position_mobile ) {
					$css_pos_mobile = penshop_get_option( 'mobile_page_header_image_position_x' ) . '% ';
					$css_pos_mobile .= penshop_get_option( 'mobile_page_header_image_position_y' ) . '%';
				} else {
					$css_pos_mobile = $position_mobile;
				}
			}

			$css .= '@media (max-width: 767px) {
				.page-header { background-position: ' . $css_pos_mobile . '}
			}';
		}
	}

	// Page header spacing
	if ( function_exists( 'is_woocommerce' ) && is_woocommerce() ) {
		$shop_page_id       = wc_get_page_id( 'shop' );
		$spacing            = penshop_get_option( 'page_header_shop_spacing' );
		$css_spacing        = 'padding-top: ' . $spacing['top'] . '; padding-bottom: ' . $spacing['bottom'];
		$css                .= '.woocommerce .page-header {' . $css_spacing . '}';
		$spacing_mobile     = penshop_get_option( 'page_header_shop_spacing_mobile' );
		$css_spacing_mobile = '';

		if ( ! empty( $spacing_mobile['top'] ) ) {
			$css_spacing_mobile .= 'padding-top: ' . $spacing_mobile['top'] . ';';
		}

		if ( ! empty( $spacing_mobile['bottom'] ) ) {
			$css_spacing_mobile .= 'padding-bottom: ' . $spacing_mobile['bottom'] . ';';
		}

		if ( $css_spacing_mobile ) {
			$css .= '@media (max-width: 767px) { .woocommerce .page-header {' . $css_spacing_mobile . '} }';
		}

		// Shop page header spacing
		if ( is_shop() && get_post_meta( $shop_page_id, 'page_header_custom_spacing', true ) ) {
			$spacing            = get_post_meta( get_the_ID(), 'page_header_spacing', true );
			$spacing_mobile     = get_post_meta( get_the_ID(), 'page_header_spacing_mobile', true );
			$css_spacing        = '';
			$css_spacing_mobile = '';

			// Desktop spacing
			if ( ! empty( $spacing['top'] ) ) {
				$css_spacing .= 'padding-top: ' . $spacing['top'] . ';';
			}

			if ( ! empty( $spacing['bottom'] ) ) {
				$css_spacing .= 'padding-bottom: ' . $spacing['bottom'] . ';';
			}

			if ( $css_spacing ) {
				$css .= '.woocommerce .page-header {' . $css_spacing . '}';
			}

			// Mobile spacing
			if ( ! empty( $spacing_mobile['top'] ) ) {
				$css_spacing_mobile .= 'padding-top: ' . $spacing_mobile['top'] . ';';
			}

			if ( ! empty( $spacing_mobile['bottom'] ) ) {
				$css_spacing_mobile .= 'padding-bottom: ' . $spacing_mobile['bottom'] . ';';
			}

			if ( $css_spacing_mobile ) {
				$css .= '@media (max-width: 767px) { .woocommerce .page-header {' . $css_spacing_mobile . '} }';
			}
		}
	} else {
		$spacing            = penshop_get_option( 'page_header_spacing' );
		$css_spacing        = 'padding-top: ' . $spacing['top'] . '; padding-bottom: ' . $spacing['bottom'];
		$css                .= '.page-header {' . $css_spacing . '}';
		$spacing_mobile     = penshop_get_option( 'page_header_spacing_mobile' );
		$css_spacing_mobile = '';

		if ( ! empty( $spacing_mobile['top'] ) ) {
			$css_spacing_mobile .= 'padding-top: ' . $spacing_mobile['top']  . ';';
		}

		if ( ! empty( $spacing_mobile['bottom'] ) ) {
			$css_spacing_mobile .= 'padding-bottom: ' . $spacing_mobile['bottom'] . ';';
		}

		if ( $css_spacing_mobile ) {
			$css .= '@media (max-width: 767px) { .page-header {' . $css_spacing_mobile . '} }';
		}

		if ( is_singular() && get_post_meta( get_the_ID(), 'page_header_custom_spacing', true ) ) {
			$spacing            = get_post_meta( get_the_ID(), 'page_header_spacing', true );
			$spacing_mobile     = get_post_meta( get_the_ID(), 'page_header_spacing_mobile', true );
			$css_spacing        = '';
			$css_spacing_mobile = '';

			// Desktop spacing
			if ( ! empty( $spacing['top'] ) ) {
				$css_spacing .= 'padding-top: ' . $spacing['top'] . ';';
			}

			if ( ! empty( $spacing['bottom'] ) ) {
				$css_spacing .= 'padding-bottom: ' . $spacing['bottom'] . ';';
			}

			if ( $css_spacing ) {
				$css .= '.page-header {' . $css_spacing . '}';
			}

			// Mobile spacing
			if ( ! empty( $spacing_mobile['top'] ) ) {
				$css_spacing_mobile .= 'padding-top: ' . $spacing_mobile['top'] . ';';
			}

			if ( ! empty( $spacing_mobile['bottom'] ) ) {
				$css_spacing_mobile .= 'padding-bottom: ' . $spacing_mobile['bottom'] . ';';
			}

			if ( $css_spacing_mobile ) {
				$css .= '@media (max-width: 767px) { .page-header {' . $css_spacing_mobile . '} }';
			}
		}
	}

	wp_add_inline_style( 'penshop', $css );
}

add_action( 'wp_enqueue_scripts', 'penshop_customize_css', 20 );

/**
 * Get CSS for typography settings
 *
 * @return string
 */
function penshop_typography_css() {
	$css        = '';
	$properties = array(
		'font-family'    => 'font-family',
		'font-size'      => 'font-size',
		'variant'        => 'font-weight',
		'line-height'    => 'line-height',
		'letter-spacing' => 'letter-spacing',
		'color'          => 'color',
		'text-transform' => 'text-transform',
		'text-align'     => 'text-align',
	);

	$settings = array(
		'typo_body'              => 'body,button,input,select,textarea',
		'typo_link'              => 'a',
		'typo_link_hover'        => 'a:hover, a:visited',
		'typo_h1'                => 'h1, .h1',
		'typo_h2'                => 'h2, .h2',
		'typo_h3'                => 'h3, .h3',
		'typo_h4'                => 'h4, .h4',
		'typo_h5'                => 'h5, .h5',
		'typo_h6'                => 'h6, .h6',
		'typo_menu'              => '.nav-menu > li > a, .off-canvas .side-menu > li > a',
		'typo_submenu'           => '.nav-menu .sub-menu a, .off-canvas .side-menu .sub-menu a',
		'typo_page_header_title' => '.page-header .page-title',
		'typo_breadcrumb'        => '.woocommerce .woocommerce-breadcrumb, .breadcrumb',
		'type_widget_title'      => '.widget-title',
		'type_footer_info'       => '.site-footer',
	);

	foreach ( $settings as $setting => $selector ) {
		$typography = penshop_get_option( $setting );
		$default    = (array) penshop_get_option_default( $setting );
		$style      = '';

		foreach ( $properties as $key => $property ) {
			if ( ! empty( $typography[ $key ] ) ) {
				if ( ! empty( $default[ $key ] ) && strtoupper( $default[ $key ] ) == strtoupper( $typography[ $key ] ) ) {
					continue;
				}

				$value = 'font-family' == $key ? '"' . rtrim( $typography[ $key ], ', ' ) . '"' : $typography[ $key ];
				$value = 'variant' == $key ? str_replace( 'regular', '400', $value ) : $value;

				if ( $value ) {
					$style .= $property . ': ' . $value . ';';
				}
			}
		}

		if ( ! empty( $style ) ) {
			$css .= $selector . '{' . $style . '}';
		}
	}

	return $css;
}

/**
 * Open content container
 */
function penshop_open_content_container() {
	$class = 'container';

	if (
		(
			function_exists( 'WC' )
			&& ( is_shop() || is_product_taxonomy() )
			&& 'full-width' == penshop_get_option( 'shop_container' )
			&& 'grid' == penshop_get_option( 'shop_layout' )
		)
		|| is_page_template( 'templates/homepage-parallax.php' )
		|| is_page_template( 'templates/fullwidth.php' )
	) {
		$class = 'container-fluid';
	}

	$class = apply_filters( 'penshop_site_content_container_class', $class );

	echo '<div class="' . $class . '">';

	if ( 'no-sidebar' != penshop_get_layout() ) {
		echo '<div class="row">';
	}
}

add_action( 'penshop_before_content', 'penshop_open_content_container', 5 );

/**
 * Close content container
 */
function penshop_close_content_container() {
	echo '</div>';

	if ( 'no-sidebar' != penshop_get_layout() ) {
		echo '</div>';
	}
}

add_action( 'penshop_after_content', 'penshop_close_content_container', 50 );
