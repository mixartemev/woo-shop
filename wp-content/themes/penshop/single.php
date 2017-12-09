<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package PenShop
 */

get_header(); ?>

	<div id="primary" class="content-area <?php echo penshop_content_column_class() ?>">

		<?php
		if ( 'no-sidebar' == penshop_get_layout() ) {
			printf( '<div class="entry-thumbnail">%s</div>', get_the_post_thumbnail( null, 'full' ) );
		}
		?>

		<main id="main" class="site-main <?php echo 'no-sidebar' == penshop_get_layout() ? 'col-md-8 col-md-offset-2' : ''; ?>" role="main">

		<?php
		while ( have_posts() ) : the_post();

			get_template_part( 'template-parts/content', 'single' );

			if ( penshop_get_option( 'post_navigation' ) ) {
				the_post_navigation( array(
					'prev_text' => _x( '<i class="fa fa-long-arrow-left" aria-hidden="true"></i><span>' . esc_html__( 'Previous Post', 'penshop' ) . '</span>', 'Previous post link', 'penshop' ),
					'next_text' => _x( '<span>' . esc_html__( 'Next Post', 'penshop' ) . '</span><i class="fa fa-long-arrow-right" aria-hidden="true"></i>', 'Next post link', 'penshop' ),
				) );
			}

			if ( penshop_get_option( 'post_related_posts' ) ) {
				get_template_part( 'template-parts/related-posts' );
			}

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		endwhile; // End of the loop.
		?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
