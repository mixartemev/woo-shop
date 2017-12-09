<?php
/**
 * The template for displaying archive pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package PenShop
 */

get_header(); ?>

	<div id="primary" class="content-area <?php echo penshop_content_column_class() ?>">
		<main id="main" class="site-main" role="main">

		<?php
		if ( have_posts() ) :
			/* Start the Loop */
			while ( have_posts() ) : the_post();

				/*
				 * Include the Post-Format-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				 */
				get_template_part( 'template-parts/content', get_post_format() );

			endwhile;

			the_posts_pagination( array(
				'prev_text' => '<i class="fa fa-angle-left"></i>',
				'next_text' => '<i class="fa fa-angle-right"></i>',
			));

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif;
		?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
