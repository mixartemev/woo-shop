<?php
/**
 * The template for displaying portfolio archive pages
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Sober
 */

get_header(); ?>

	<div id="primary" class="content-area col-md-12">
		<main id="main" class="site-main" role="main">

			<?php
			if ( have_posts() ) :

				if ( penshop_get_option( 'portfolio_filter' ) ) {
					penshop_portfolio_filter();
				}

				global $penshop_portfolio_loop;

				$penshop_portfolio_loop['layout'] = penshop_get_option( 'portfolio_layout' );
				$css_class                        = array( 'layout-' . $penshop_portfolio_loop['layout'] );

				if ( 'fullwidth' != $penshop_portfolio_loop['layout'] ) {
					$penshop_portfolio_loop['columns'] = penshop_get_option( 'portfolio_columns' );
					$css_class[]                       = 'layout-' . $penshop_portfolio_loop['columns'] . '-columns';
				}

				echo '<div class="portfolio-items ' . esc_attr( implode( ' ', $css_class ) ) . ' row">';

				/* Start the Loop */
				while ( have_posts() ) : the_post();

					get_template_part( 'template-parts/content-portfolio' );

				endwhile;

				echo '</div><!-- .portfolio-items -->';

				if ( 'numeric' == penshop_get_option( 'portfolio_pagination' ) ) {
					the_posts_pagination( array(
						'prev_text' => '<i class="fa fa-angle-left"></i>',
						'next_text' => '<i class="fa fa-angle-right"></i>',
					) );
				} else {
					the_posts_navigation( array(
						'prev_text' => '<span class="link-text">' . esc_html__( 'Load More', 'penshop' ) . '</span><span class="loading-bubbles"><span class="bounce1"></span><span class="bounce2"></span><span class="bounce3"></span></span>',
						'next_text' => esc_html__( 'Previous Projects', 'penshop' ),
					) );
				}
			else :

				get_template_part( 'template-parts/content', 'none' );

			endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
