<?php
/**
 * Template part for displaying the newsletter popup
 *
 * @package PenShop
 */
?>

<div id="popup" class="modal modal-popup">
	<div class="close-trigger modal-backdrop"></div>
	<div class="popup-container">
		<div class="popup-content">
			<span class="close-btn"><i class="fa fa-times"></i></span>
			<?php echo do_shortcode( wp_kses_post( penshop_get_option( 'popup_content' ) ) ); ?>
		</div>
		<div class="popup-image">
			<?php
			if ( $popup_banner = penshop_get_option( 'popup_image' ) ) {
				printf( '<img src="%s">', esc_url( $popup_banner ) );
			}
			?>
		</div>
	</div>
</div>
