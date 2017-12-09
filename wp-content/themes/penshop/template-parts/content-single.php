<?php
/**
 * Template part for display single post content
 *
 * @package PenShop
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header <?php echo 'no-sidebar' == penshop_get_layout() ? 'text-center' : '' ?>">
		<?php if ( 'no-sidebar' != penshop_get_layout() ) : ?>
			<div class="entry-thumbnail"><?php penshop_entry_thumbnail( 'full' ); ?></div>
		<?php endif; ?>
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		<div class="entry-meta"><?php penshop_entry_meta(); ?></div>
	</header>

	<div class="entry-content">
		<?php the_content(); ?>
		<?php
		wp_link_pages( array(
			'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'penshop' ),
			'after'  => '</div>',
		) );
		?>
	</div>
	<!-- .entry-content -->

	<footer class="entry-footer clearfix">
		<?php penshop_entry_footer() ?>
	</footer>
	<!-- .entry-footer -->

</article><!-- #post-## -->

