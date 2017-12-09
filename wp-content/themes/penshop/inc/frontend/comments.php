<?php
/**
 * Custom functions that act on comments.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Penshop
 */

/**
 * Remove Website field from comment form
 *
 * @param array $fields
 *
 * @return array
 */
function penshop_disable_comment_url( $fields ) {
	unset( $fields['url'] );

	return $fields;
}

add_filter( 'comment_form_default_fields', 'penshop_disable_comment_url' );


/**
 * Template Comment
 *
 * @since  1.0
 *
 * @param  array $comment
 * @param  array $args
 * @param  int   $depth
 *
 * @return mixed
 */
function penshop_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	extract( $args, EXTR_SKIP );

	if ( 'div' == $args['style'] ) {
		$add_below = 'comment';
	} else {
		$add_below = 'div-comment';
	}
	?>

<li <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ) ?> id="comment-<?php comment_ID() ?>">
	<article id="div-comment-<?php comment_ID() ?>" class="comment-body clearfix">

		<div class="comment-author vcard">
			<?php
			if ( $args['avatar_size'] != 0 ) {
				echo get_avatar( $comment, $args['avatar_size'] );
			}
			?>
		</div>
		<div class="comment-meta commentmetadata">
			<?php printf( '<cite class="author-name">%s</cite>', get_comment_author_link() ); ?>

			<a class="author-posted" href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
				<?php printf( '%1$s', get_comment_date( 'F d, Y' ) ); ?>
			</a>

			<?php if ( $comment->comment_approved == '0' ) : ?>
				<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'penshop' ); ?></em>
			<?php endif; ?>

			<div class="comment-content">
				<?php comment_text(); ?>
			</div>

			<?php
			comment_reply_link( array_merge(
				$args,
				array(
					'add_below'  => $add_below,
					'depth'      => $depth,
					'max_depth'  => $args['max_depth'],
					'reply_text' => esc_html__( 'Reply', 'penshop' ),
				)
			) );
			edit_comment_link( esc_html__( 'Edit', 'penshop' ), '  ', '' );
			?>
		</div>
	</article>

	<?php
}

/*
 *  Custom comment form
 */
function penshop_comment_form( $fields ) {
	$commenter = wp_get_current_commenter();
	$req = get_option( 'require_name_email' );
	$aria_req = ( $req ? " aria-required='true'" : '' );

	$fields['author'] = '<p class="comment-form-author"><label>'. esc_html__( 'Your Name', 'penshop' ) . ( $req ? '<span class="required">*</span>' : '' ) . '</label>
						<input id="author" required name="author" type="text" value="' .
		esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' />' .
		'</p>';
	$fields['email'] = '<p class="comment-form-email"><label>'. esc_html__( 'Your Email', 'penshop' ) . ( $req ? '<span class="required">*</span>' : '' ) . '</label>
						<input id="email" required name="email" type="email" value="' . esc_attr(  $commenter['comment_author_email'] ) .
		'" size="30"' . $aria_req . ' />'
		.
		'</p>';
	$fields['url'] = '<p class="comment-form-url"><label>'. esc_html__( 'Website', 'penshop' ) .'</label>
					 <input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /> ' .
		'</p>';
	$fields['clear'] = '<div class="clearfix"></div>';

	return $fields;
}

add_filter('comment_form_default_fields','penshop_comment_form');