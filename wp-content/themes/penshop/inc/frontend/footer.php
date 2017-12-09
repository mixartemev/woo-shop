<?php
/**
 * Template functions that act on the footer
 *
 * @package PenShop
 */


/**
 * Display footer widgets
 */
function penshop_footer_widgets() {
	if ( ! penshop_get_option( 'footer_widgets' ) ) {
		return;
	}

	if ( is_page_template( 'templates/homepage-parallax.php' ) ) {
		return;
	}

	$columns = penshop_get_option( 'footer_widgets_columns' );
	?>

	<div class="footer-widgets widget-area columns-<?php echo esc_attr( $columns ) ?>">
		<div class="container">
			<div class="row">

				<?php
				for ( $i = 1; $i <= $columns; $i++ ) {
					$column_class = 12 / $columns;

					echo '<div class="footer-sidebar-' . esc_attr( $i ) . ' footer-sidebar col-xs-12 col-sm-6 col-md-' . esc_attr( $column_class ) . '">';

					if ( is_active_sidebar( 'footer-' . $i ) ) {
						dynamic_sidebar( 'footer-' . $i );
					}

					echo '</div>';
				}
				?>

			</div>
		</div>
	</div>

	<?php
}

add_action( 'penshop_before_footer', 'penshop_footer_widgets' );

/**
 * Adds go to top button to footer
 */
function penshop_gotop_button() {
	echo '<a href="#" class="gotop"><i class="fa fa-angle-up"></i></a>';
}

add_action( 'wp_footer', 'penshop_gotop_button' );

/**
 * Adds HTML of off canvas shopping cart to footer
 */
function penshop_off_canvas_cart() {
	if ( ! function_exists( 'WC' ) ) {
		return;
	}

	if ( ! in_array( 'cart', (array) penshop_get_option( 'menu_icons' ) ) ) {
		return;
	}
	?>

	<div id="off-canvas-cart" class="off-canvas off-canvas-cart woocommerce">
		<a href="#" class="close-btn"><i class="fa fa-remove"></i></a>
		<h3 class="panel-title"><?php echo get_the_title( wc_get_page_id( 'cart' ) ) ?></h3>

		<div class="widget_shopping_cart_content">
			<?php woocommerce_mini_cart() ?>
		</div>
	</div>

	<?php
}

add_action( 'wp_footer', 'penshop_off_canvas_cart' );

/**
 * Adds HTML of off canvas menu to footer
 */
function penshop_off_canvas_menu() {
	if ( ! in_array( 'hamburger', (array) penshop_get_option( 'menu_icons' ) ) ) {
		return;
	}

	$menu_type = penshop_get_option( 'hamburger_menu' );
	?>

	<div id="off-canvas-menu" class="off-canvas off-canvas-menu">
		<?php
		if ( 'menu' == $menu_type ) {
			wp_nav_menu( array(
				'theme_location' => 'primary',
				'container'      => false,
				'menu_id'        => 'primary-menu',
				'menu_class'     => 'side-menu',
				'fallback_cb'    => false,
			) );
		} elseif ( is_active_sidebar( 'off-sidebar' ) ) {
			dynamic_sidebar( 'off-sidebar' );
		}
		?>
	</div>

	<?php
}

add_action( 'wp_footer', 'penshop_off_canvas_menu' );

if ( ! function_exists( 'penshop_mobile_menu' ) ) :
	/**
	 * Adds HTML of off canvas menu to footer
	 */
	function penshop_mobile_menu() {
		$menu = has_nav_menu( 'mobile' ) ? 'mobile' : 'primary';
		?>

		<div id="off-canvas-mobile-menu" class="off-canvas off-canvas-menu off-canvas-mobile-menu off-canvas-left">
			<?php
			wp_nav_menu( array(
				'theme_location' => $menu,
				'container'      => false,
				'menu_id'        => 'mobile-menu',
				'menu_class'     => 'side-menu mobile-menu',
				'fallback_cb'    => false,
			) );
			?>
		</div>

		<?php
	}
endif;

add_action( 'wp_footer', 'penshop_mobile_menu' );

/**
 * Adds HTML of the search modal
 */
function penshop_modal_search() {
	if ( ! in_array( 'search', (array) penshop_get_option( 'menu_icons' ) ) ) {
		return;
	}

	$search_type = penshop_get_option( 'search_type' );
	$action      = 'product' == $search_type ? wc_get_page_permalink( 'shop' ) : home_url( '/' );
	?>

	<div id="modal-search" class="modal modal-search">
		<button class="close-btn"><i class="fa fa-remove"></i></button>

		<form role="search" method="get" class="search-form" action="<?php echo esc_url( $action ) ?>">
			<label>
				<span class="screen-reader-text"><?php esc_html_e( 'Search for:', 'penshop' ) ?></span>
				<input type="search" class="search-field" placeholder="<?php esc_attr_e( 'Enter your keyword...', 'penshop' ) ?>" value="<?php get_search_query() ?>" name="s" autocomplete="off" />
			</label>
			<button type="submit" class="search-submit"><i class="fa fa-search"></i></button>
			<span class="spinner"><span class="loading-icon fa-spin"></span></span>

			<?php if ( 'all' != $search_type ) : ?>
				<input type="hidden" name="post_type" value="<?php echo esc_attr( $search_type ) ?>" class="type-field">
			<?php endif; ?>
		</form>
	</div>

	<?php
}

add_action( 'wp_footer', 'penshop_modal_search' );

/**
 * Add HTML of the quick-view modal
 */
function penshop_modal_quick_view() {
	if ( ! penshop_get_option( 'shop_quick_view_button' ) ) {
		return;
	}

	?>

	<div id="modal-quick-view" class="modal modal-quick-view woocommerce">
		<button class="close-btn"><i class="fa fa-remove"></i></button>
		<div class="loading"><span class="loading-icon fa-spin"></span></div>
		<div class="close-trigger modal-backdrop"></div>

		<div class="container"></div>
	</div>

	<?php
}

add_action( 'wp_footer', 'penshop_modal_quick_view' );

/**
 * Add the popup HTML to footer
 *
 * @since 2.0
 */
function penshop_popup() {
	if ( ! penshop_get_option( 'popup' ) ) {
		return;
	}

	$popup_frequency = intval( penshop_get_option( 'popup_frequency' ) );

	if ( $popup_frequency > 0 && isset( $_COOKIE['penshop_popup'] ) ) {
		return;
	}

	get_template_part( 'template-parts/popup' );
}

add_action( 'wp_footer', 'penshop_popup' );
