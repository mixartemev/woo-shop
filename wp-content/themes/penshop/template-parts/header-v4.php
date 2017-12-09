<?php
/**
 * Template part for displaying the site header V4
 *
 * @package PenShop
 */

$menu_display = penshop_get_option( 'header_menu_display' );
?>
<div class="header-main menu-<?php echo esc_attr( $menu_display ) ?>">
	<div class="container-fluid">
		<?php penshop_mobile_header_menu_button() ?>

		<div class="site-branding">
			<?php get_template_part( 'template-parts/logo' ); ?>
		</div><!-- .site-branding -->

		<nav id="site-navigation" class="main-navigation" role="navigation">

			<?php
			if ( 'none' != $menu_display ) {
				wp_nav_menu( array(
					'theme_location' => 'primary',
					'container'      => false,
					'menu_id'        => 'primary-menu',
					'menu_class'     => 'nav-menu',
					'walker'         => new PenShop_Walker_Mega_Menu,
					'fallback_cb'    => false,

				) );
			}
			?>

			<?php get_template_part( 'template-parts/menu-icons' ); ?>

		</nav><!-- #site-navigation -->

		<?php penshop_mobile_header_icon() ?>
	</div>
</div><!-- .header-main -->

