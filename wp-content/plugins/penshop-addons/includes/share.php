<?php
/**
 * Create share links
 *
 * @param string $url
 * @param string $text
 * @param string $media
 */
function penshop_addons_share_link( $social = 'facebook', $url = '', $text = '', $media = '' ) {
	$url   = $url ? $url : get_permalink();
	$text  = $text ? $text : get_the_title();
	$media = $media ? $media : get_the_post_thumbnail_url( get_the_ID(), 'full' );

	switch ( $social ) {
		case 'facebook':
			printf(
				'<a href="%s" target="_blank" class="facebook" data-tip="%s"><i class="fa fa-facebook"></i><span class="screen-reader-text">%s</span></a>',
				esc_url( add_query_arg( array( 'u' => rawurlencode( $url ) ), 'https://www.facebook.com/sharer/sharer.php' ) ),
				esc_html__( 'Share on Facebook', 'penshop-addons' ),
				esc_html__( 'Share on Facebook', 'penshop-addons' )
			);
			break;

		case 'twitter':
			printf(
				'<a href="%s" target="_blank" class="twitter" data-tip="%s"><i class="fa fa-twitter"></i><span class="screen-reader-text">%s</span></a>',
				esc_url( add_query_arg( array(
					'url'  => rawurlencode( $url ),
					'text' => rawurlencode( $text ),
				), 'https://twitter.com/intent/tweet' ) ),
				esc_html__( 'Share on Twitter', 'penshop-addons' ),
				esc_html__( 'Share on Twitter', 'penshop-addons' )
			);
			break;

		case 'googleplus':
			printf(
				'<a href="%s" target="_blank" class="google-plus" data-tip="%s"><i class="fa fa-google-plus"></i><span class="screen-reader-text">%s</span></a>',
				esc_url( add_query_arg( array(
					'url' => rawurlencode( $url ),
				), 'https://plus.google.com/share' ) ),
				esc_html__( 'Share on Google Plus', 'penshop-addons' ),
				esc_html__( 'Share on Google Plus', 'penshop-addons' )
			);
			break;

		case 'pinterest':
			if ( ! $media ) {
				break;
			}

			printf(
				'<a href="%s" target="_blank" class="pinterest" data-tip="%s"><i class="fa fa-pinterest"></i><span class="screen-reader-text">%s</span></a>',
				esc_url( add_query_arg( array(
					'url'         => rawurlencode( $url ),
					'media'       => $media,
					'description' => rawurlencode( $text ),
				), 'http://pinterest.com/pin/create/button' ) ),
				esc_html__( 'Share on Pinterest', 'penshop-addons' ),
				esc_html__( 'Share on Pinterest', 'penshop-addons' )
			);
			break;

		case 'tumblr':
			printf(
				'<a href="%s" target="_blank" class="tumblr" data-tip="%s"><i class="fa fa-tumblr"></i><span class="screen-reader-text">%s</span></a>',
				esc_url( add_query_arg( array( 'url' => rawurlencode( $url ) ), 'http://www.tumblr.com/share/link' ) ),
				esc_html__( 'Share on Tumblr', 'penshop-addons' ),
				esc_html__( 'Share on Tumblr', 'penshop-addons' )
			);
			break;

		case 'email':
			printf(
				'<a href="%s" target="_blank" class="email" data-tip="%s"><i class="fa fa-envelope-o"></i><span class="screen-reader-text">%s</span></a>',
				esc_url( 'mailto:?subject=' . esc_html__( 'You would love this', 'penshop-addons' ) . '&body=' . $url ),
				esc_html__( 'Mail to your friends', 'penshop-addons' ),
				esc_html__( 'Mail to your friends', 'penshop-addons' )
			);
			break;
	}
}

/**
 * Display social sharing in entry footer
 */
function penshop_addons_entry_footer_share() {
	if ( $share = penshop_get_option( 'post_share' ) ) {
		echo '<span class="post-share social-share">';

		echo '<span>' . esc_html__( 'Share', 'penshop-addons' ) . '</span>';

		foreach ( $share as $social ) {
			penshop_addons_share_link( $social );
		}

		echo '</span>';
	}
}

add_action( 'penshop_entry_footer_after', 'penshop_addons_entry_footer_share' );

/**
 * Prints HTML with meta information for the share.
 */
function penshop_addons_project_share() {
	if ( $share = penshop_get_option( 'portfolio_share' ) ) {
		echo '<div class="portfolio-share social-share">';

		echo '<span>' . esc_html__( 'Share', 'penshop-addons' ) . '</span>';

		foreach ( $share as $social ) {
			penshop_addons_share_link( $social );
		}

		echo '</div>';
	}
}

add_action( 'penshop_single_project_footer', 'penshop_addons_project_share' );

/**
 * Show product sharing buttons
 */
function penshop_addons_product_share() {
	$socials = penshop_get_option( 'product_share' );

	if ( empty( $socials ) ) {
		return;
	}

	echo '<div class="product-share social-share">';

	foreach ( $socials as $social ) {
		penshop_addons_share_link( $social );
	}

	echo '</div>';
}

add_action( 'woocommerce_share', 'penshop_addons_product_share' );