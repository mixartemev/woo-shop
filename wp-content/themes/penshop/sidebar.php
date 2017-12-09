<?php
/**
 * The sidebar containing the main widget area
 *
 * @link    https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package PenShop
 */

if ( 'no-sidebar' == penshop_get_layout() ) {
	return;
}

$column_class = 'col-md-4';

if ( function_exists( 'is_woocommerce' ) && is_woocommerce() ) {
	$sidebar = 'shop-sidebar';
	$column_class = 'col-md-3';
} elseif ( is_page() ) {
	$sidebar = 'page-sidebar';
} else {
	$sidebar = 'blog-sidebar';
}
?>

<aside id="secondary" class="widget-area primary-sidebar <?php echo $column_class ?> <?php echo esc_attr( $sidebar ) ?>" role="complementary">
	<?php if ( is_active_sidebar( $sidebar ) ) : ?>
		<div class="theiaStickySidebar">
			<?php dynamic_sidebar( $sidebar ); ?>
		</div>
	<?php endif; ?>
</aside><!-- #secondary -->