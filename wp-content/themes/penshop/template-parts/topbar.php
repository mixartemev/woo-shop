<?php
/**
 * Template part for displaying the top bar
 *
 * @package PenShop
 */

$topbar_layout  = penshop_get_option( 'topbar_layout' );
$topbar_classes = array(
	'topbar',
	'layout-' . $topbar_layout,
	penshop_get_option( 'topbar_color_scheme' ),
);

if ( ! penshop_get_option( 'mobile_header_topbar' ) ) {
	$topbar_classes[] = 'hidden-xs';
}
?>

<div id="topbar" class="<?php echo esc_attr( implode( ' ', $topbar_classes ) ) ?>">
	<div class="container">
		<?php if ( '1-column' == $topbar_layout ) : ?>

			<?php if ( penshop_get_option( 'topbar_closeable' ) ) : ?>
				<a class="close"><i class="fa fa-remove"></i></a>
			<?php endif; ?>

			<div class="topbar-content"><?php echo do_shortcode( penshop_get_option( 'topbar_content' ) ) ?></div>

		<?php else : ?>

			<div class="row">
				<div class="topbar-left topbar-content col-md-6">
					<?php
					if ( is_active_sidebar( 'topbar-left' ) ) {
						dynamic_sidebar( 'topbar-left' );
					}
					?>
				</div>
				<div class="topbar-right topbar-content col-md-6">
					<?php
					if ( is_active_sidebar( 'topbar-right' ) ) {
						dynamic_sidebar( 'topbar-right' );
					}
					?>
				</div>
			</div>

		<?php endif; ?>
	</div>
</div>
