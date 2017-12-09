<?php
/**
 * Template part for displaying portfolio
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package PenShop
 */

global $penshop_portfolio_loop;

if ( 'fullwidth' != $penshop_portfolio_loop['layout'] ) {
	$portfolio_class = 'col-xs-12 col-sm-6 col-md-' . 12 / $penshop_portfolio_loop['columns'];
} else {
	global $wp_query;

	$current_project = $wp_query->current_post + 1;
	$current_project_mod = $current_project % 8;
	$portfolio_class = 'col-xs-12 col-md-6';

	if ( in_array( $current_project_mod, array( 1, 6 ) ) ) {
		$portfolio_class = 'portfolio-large col-md-6';
	} elseif ( in_array( $current_project_mod, array( 2, 5 ) ) ) {
		$portfolio_class = 'portfolio-wide col-md-6';
	} elseif ( in_array( $current_project_mod, array( 3, 4, 7, 0 ) ) ) {
		$portfolio_class = 'portfolio-normal col-md-3';
	}

	$portfolio_class .= ' col-xs-12 col-sm-6';
}
?>

<div id="portfolio-<?php the_ID() ?>" <?php post_class( $portfolio_class ) ?>>
	<?php if ( has_post_thumbnail() ) : ?>
		<a href="<?php the_permalink() ?>" class="portfolio-thumbnail">
			<?php if ( 'masonry' == $penshop_portfolio_loop['layout'] ) : ?>
				<?php the_post_thumbnail( 'full' ) ?>
			<?php else : ?>
				<span class="image-holder" style="background-image: url(<?php echo wp_get_attachment_image_url( get_post_thumbnail_id(), 'full' ) ?>)"><?php the_title(); ?></span>
			<?php endif; ?>
		</a>
	<?php endif; ?>
	<div class="portfolio-summary">
		<h3 class="portfolio-title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h3>
		<?php
		if ( has_term( null, 'portfolio_type' ) ) {
			the_terms( get_the_ID(), 'portfolio_type', '<div class="portfolio-type">', ', ', '</div>' );
		}
		?>
	</div>
</div>