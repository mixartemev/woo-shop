<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package PenShop
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'blog-wrapper list-post clearfix' ); ?>>
	<header class="entry-header">
		<?php

		if ( has_post_thumbnail() ) {
			printf( '<div class="entry-thumbnail"><a href="%s">%s</a></div>', get_permalink(), get_the_post_thumbnail( null, 'penshop-blog-thumb' ) );
		}
		?>
	</header><!-- .entry-header -->

	<div class="post-summary">
		<?php the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>

		<?php if ( 'post' === get_post_type() ) : ?>
			<div class="entry-meta">
				<?php penshop_entry_meta(); ?>
			</div><!-- .entry-meta -->
		<?php elseif ( 'product' === get_post_type() ) : ?>
			<?php woocommerce_template_loop_price(); ?>
		<?php endif; ?>

		<div class="entry-summary">
			<?php the_excerpt(); ?>
		</div><!-- .entry-content -->

		<a class="read-more" href="<?php the_permalink() ?>" data-label="<?php esc_attr_e( 'Read more', 'penshop' ) ?>"><?php esc_html_e( 'Read more', 'penshop' ) ?></a>
	</div>

</article><!-- #post-<?php the_ID(); ?> -->
