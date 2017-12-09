<?php
/**
 * Template part for displaying page header
 *
 * @package PenShop
 */

$image = penshop_get_page_header_image();
?>

<div id="page-header" class="page-header <?php echo $image ? 'has-image' : '' ?>">
	<div class="container clearfix">
		<?php
		if ( ! is_singular() ) {

			if( is_post_type_archive( 'portfolio' ) ) {
				printf( '<h1 class="page-title">%s</h1>', esc_html__( 'Portfolio', 'penshop' ));
			} else {
				the_archive_title( '<h1 class="page-title">', '</h1>' );
				the_archive_description( '<div class="archive-description">', '</div>' );
			}

		} elseif ( is_page() ) {
			printf( '<div class="page-title">%s</div>', single_post_title( '', false ) );
		} else {
			printf( '<h1 class="page-title">%s</h1>', single_post_title( '', false ) );
		}

		penshop_the_breadcrumbs();
		?>
	</div>
</div>