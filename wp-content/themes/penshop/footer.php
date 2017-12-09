<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package PenShop
 */

?>

	<?php do_action( 'penshop_after_content' ); ?>
	</div><!-- #content -->

	<?php do_action( 'penshop_before_footer' ) ?>

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="container">
			<div class="site-info">
				<?php echo wp_kses_post( penshop_get_option( 'footer_copyright' ) ) ?>
			</div><!-- .site-info -->
			<?php
			if ( '2-columns' == penshop_get_option( 'footer_layout' ) ) {
				echo '<div class="footer-right">';

				if ( 'content' == penshop_get_option( 'footer_right' ) ) {
					printf( '<div class="footer-extra">%s</div>', do_shortcode( wp_kses_post( penshop_get_option( 'footer_right_content' ) ) ) );
				} elseif ( has_nav_menu( 'footer' ) ) {
					wp_nav_menu( array(
						'container'       => 'nav',
						'container_class' => 'footer-menu',
						'theme_location'  => 'footer',
						'menu_id'         => 'footer-menu',
						'depth'           => 1,
					) );
				}

				echo '</div>';
			}
			?>
		</div>
	</footer><!-- #colophon -->

	<?php do_action( 'penshop_after_footer' ); ?>

</div><!-- #page -->

<div class="off-canvas-backdrop"></div>

<?php wp_footer(); ?>

</body>
</html>
