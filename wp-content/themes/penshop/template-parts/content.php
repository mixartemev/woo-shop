<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package PenShop
 */

$blog_post_class = 'blog-wrapper';

if ( 'grid' == penshop_get_option( 'blog_layout' ) ) {

	if ( 'no-sidebar' == penshop_get_layout() ) {
		$blog_post_class .= ' grid-post col-3 col-md-4';
	} else {
		$blog_post_class .= ' grid-post col-2 col-md-6';
	}
} elseif ( 'list' == penshop_get_option( 'blog_layout' ) ) {
	$blog_post_class .= ' list-post clearfix';
} else {
	$blog_post_class .= ' classic-post';
}

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( $blog_post_class ); ?>>
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
		<?php endif; ?>

		<div class="entry-summary">
			<?php the_excerpt(); ?>
		</div><!-- .entry-content -->

		<?php if ( 'list' == penshop_get_option( 'blog_layout' ) ) : ?>
			<a class="read-more" href="<?php the_permalink() ?>" data-label="<?php esc_attr_e( 'Read more', 'penshop' ) ?>"><?php esc_html_e( 'Read more', 'penshop' ) ?></a>
		<?php endif; ?>
	</div>

</article><!-- #post-<?php the_ID(); ?> -->
