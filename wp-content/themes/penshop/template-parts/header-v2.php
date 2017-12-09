<?php
/**
 * Template part for displaying the site header V2
 *
 * @package PenShop
 */

?>
<div class="header-main">
	<div class="container">
		<?php penshop_mobile_header_menu_button() ?>

		<div class="site-branding">
			<?php get_template_part( 'template-parts/logo' ); ?>
		</div><!-- .site-branding -->

		<nav id="site-navigation" class="main-navigation" role="navigation">

			<?php
			wp_nav_menu( array(
				'theme_location' => 'primary',
				'container'      => false,
				'menu_id'        => 'primary-menu',
				'menu_class'     => 'nav-menu',
				'walker'         => new PenShop_Walker_Mega_Menu,
				'fallback_cb'    => false,

			) );
			?>

			<?php get_template_part( 'template-parts/menu-icons' ); ?>

		</nav><!-- #site-navigation -->

		<?php penshop_mobile_header_icon() ?>
	</div>
</div><!-- .header-main -->

