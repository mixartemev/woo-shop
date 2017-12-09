<?php
/**
 * Template part for displaying the site header V3
 *
 * @package PenShop
 */

?>
<div class="header-main">
	<div class="container">
		<?php penshop_mobile_header_menu_button() ?>

		<nav id="site-navigation" class="main-navigation primary-menu" role="navigation">

			<?php
			wp_nav_menu( array(
				'theme_location' => 'primary',
				'container'      => false,
				'menu_id'        => 'primary-menu',
				'menu_class'     => 'nav-menu primary-menu',
				'walker'         => new PenShop_Walker_Mega_Menu,
				'fallback_cb'    => false,

			) );
			?>

		</nav><!-- #site-navigation -->

		<div class="site-branding">
			<?php get_template_part( 'template-parts/logo' ); ?>
		</div><!-- .site-branding -->

		<nav id="site-navigation" class="main-navigation secondary-menu" role="navigation">

			<?php get_template_part( 'template-parts/menu-icons' ); ?>

			<?php
			wp_nav_menu( array(
				'theme_location' => 'secondary',
				'container'      => false,
				'menu_id'        => 'secondary-menu',
				'menu_class'     => 'nav-menu secondary-menu',
				'walker'         => new PenShop_Walker_Mega_Menu,
				'fallback_cb'    => false,

			) );
			?>

		</nav><!-- #site-navigation -->

		<?php penshop_mobile_header_icon() ?>
	</div>
</div><!-- .header-main -->

