<?php
/**
 * Template part for displaying the site header
 *
 * @package PenShop
 */

$header_right = penshop_get_option( 'header_right' );
?>
<div class="header-main">
	<div class="container">
		<?php penshop_mobile_header_menu_button() ?>

		<div class="site-branding">
			<?php get_template_part( 'template-parts/logo' ); ?>
		</div><!-- .site-branding -->

		<?php if ( 'none' != $header_right ) : ?>
			<div class="header-right <?php echo esc_attr( $header_right ) ?>">
				<?php
				switch ( $header_right ) {
					case 'search':
						$form_action = function_exists( 'WC' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/' );
						?>

						<form action="<?php echo esc_url( $form_action ) ?>" method="get" class="product-search-form search-form" role="search">
							<?php if ( taxonomy_exists( 'product_cat' ) && get_terms( 'taxonomy=product_cat' ) ) : ?>
								<input type="hidden" name="post_type" value="product">
								<span class="search-by-cat">
									<?php wp_dropdown_categories( array(
										'show_option_all' => esc_html__( 'Select Category', 'penshop' ),
										'hierarchical'    => 1,
										'name'            => 'product_cat',
										'class'           => 'search-field search-select',
										'taxonomy'        => 'product_cat',
										'value_field'     => 'slug',
										'selected'        => is_search() && get_query_var( 'product_cat' ) ? get_query_var( 'product_cat' ) : 0,
									) ); ?>
								</span>
							<?php endif; ?>
							<input type="search" class="search-field search-text" placeholder="<?php esc_attr_e( 'Enter Your Keyword', 'penshop' ) ?>" name="s" value="<?php echo esc_attr( get_search_query() ) ?>">
							<button type="submit" class="search-submit"><i class="fa fa-search"></i></button>
							<span class="spinner"><span class="loading-icon fa-spin"></span></span>
						</form>

						<?php
						break;

					case 'custom':
						echo do_shortcode( wp_kses_post( penshop_get_option( 'header_right_content' ) ) );
						break;
				}
				?>
			</div><!-- .header-right -->
		<?php endif; ?>

		<?php penshop_mobile_header_icon() ?>
	</div>
</div><!-- .header-main -->

<nav id="site-navigation" class="main-navigation" role="navigation">
	<div class="container">

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

	</div>
</nav><!-- #site-navigation -->
