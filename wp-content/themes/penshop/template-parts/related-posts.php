<?php
/**
 * The template part for displaying related posts
 *
 * @package PenShop
 */

// Only support posts
if ( 'post' != get_post_type() ) {
	return;
}

$related_posts = new WP_Query(
	array(
		'posts_per_page'         => 3,
		'ignore_sticky_posts'    => 1,
		'category__in'           => wp_get_post_categories( get_the_ID() ),
		'post__not_in'           => array( get_the_ID() ),
		'no_found_rows'          => true,
		'update_post_term_cache' => false,
		'update_post_meta_cache' => false,
	)
);

if ( ! $related_posts->have_posts() ) {
	return;
}
?>

	<div class="related-posts">
		<h2 class="related-title"><?php esc_html_e( 'You May Also Like', 'penshop' ) ?></h2>
		<div class="related-content row">
			<?php while ( $related_posts->have_posts() ) : $related_posts->the_post(); ?>

				<?php
				$class = has_post_thumbnail() ? '' : 'no-thumb';

				$class .= ' col-sm-12 col-sm-6 col-md-4';
				?>

				<div <?php post_class( $class ) ?>>
					<?php if ( has_post_thumbnail() ) : ?>
						<a href="<?php the_permalink() ?>" class="post-thumbnail" rel="bookmark"><?php the_post_thumbnail( 'penshop-blog-thumb' ) ?></a>
					<?php endif; ?>

					<h3 class="post-title"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title() ?></a></h3>

					<?php
					$time_string = sprintf(
						'<time class="entry-date published updated" datetime="%1$s">%2$s</time>',
						esc_attr( get_the_date( 'c' ) ),
						esc_html( get_the_date( get_option( 'date_format', 'd.m Y' ) ) )
					);

					echo '<span class="posted-on">' . $time_string . '</span>';
					?>
				</div>

			<?php endwhile; ?>
		</div>
	</div>

<?php
wp_reset_postdata();