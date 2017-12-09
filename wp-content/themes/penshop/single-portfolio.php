<?php
/**
 * The template for displaying all single portfolios.
 *
 * @link    https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Sober
 */

get_header(); ?>

	<div id="primary" class="content-area col-md-12">
		<main id="main" class="site-main" role="main">

			<?php

			while ( have_posts() ) : the_post();

				get_template_part( 'template-parts/content-single', 'portfolio' );

			endwhile; // End of the loop.

			if ( penshop_get_option( 'portfolio_navigation' ) ) {
				echo '<div class="portfolio-navigation col-lg-8 col-md-12 col-lg-offset-2">';

				the_post_navigation( array(
					'prev_text' => '<i class="fa fa-long-arrow-left" aria-hidden="true"></i>' . penshop_get_option( 'portfolio_nav_text_prev' ) . '</span>',
					'next_text' => '<span>' . penshop_get_option( 'portfolio_nav_text_next' ) . '</span><i class="fa fa-long-arrow-right" aria-hidden="true"></i>',
					'screen_reader_text' => esc_html__( 'Project navigation', 'penshop' ),
				) );

				echo '</div>';
			}

			?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
