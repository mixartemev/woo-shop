<?php
/**
 * Template part for display single post content
 *
 * @package Sober
 */
?>

<div id="portfolio-<?php the_ID() ?>" <?php post_class( 'clearfix' ) ?>>
	<div class="portfolio-thumbnail">
		<?php if ( has_post_thumbnail() ) : ?>
			<div class="portfolio-image"><?php the_post_thumbnail( 'penshop-portfolio-single' ) ?></div>
		<?php endif; ?>

	</div>

	<div class="project-summary col-lg-8 col-md-12 col-lg-offset-2">
		<?php the_terms( get_the_ID(), 'portfolio_type', '<div class="portfolio-type">', ', ', '</div>' ); ?>
		<?php the_title( '<h1 class="portfolio-title entry-title">', '</h1>' ) ?>
		<div class="project-content">
			<?php the_content(); ?>
			<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'penshop' ),
				'after'  => '</div>',
			) );
			?>
		</div>
		<?php do_action( 'penshop_single_project_footer' ) ?>
	</div>
</div>
