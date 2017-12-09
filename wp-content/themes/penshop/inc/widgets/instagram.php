<?php
/**
 * Instagram feed widget
 *
 * @package PenShop
 */

/**
 * Class PenShop_Instagram_Widget
 */
class PenShop_Instagram_Widget extends WP_Widget {
	protected $defaults;

	function __construct() {
		$this->defaults = array(
			'title'    => '',
			'username' => '',
			'number'   => 6,
			'video'    => false,
			'size'     => 'large',
			'target'   => '_blank',
		);

		parent::__construct(
			'widget-instagram-feed',
			esc_html__( 'PenShop - Instagram', 'penshop' ),
			array(
				'classname'   => 'widget-instagram-feed',
				'description' => esc_html__( 'Display Instagram photos', 'penshop' ),
			)
		);
	}

	/**
	 * Outputs the HTML for this widget.
	 *
	 * @param array $args     An array of standard parameters for widgets in this theme
	 * @param array $instance An array of settings for this widget instance
	 *
	 * @return void Echoes it's output
	 */
	function widget( $args, $instance ) {
		$instance = wp_parse_args( $instance, $this->defaults );

		echo $args['before_widget'];

		if ( $title = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base ) ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}

		if ( $instance['username'] ) :
			$media = $this->scrape_instagram( $instance['username'] );

			if ( is_wp_error( $media ) ) {
				echo wp_kses_post( $media->get_error_message() );
			} else {
				$list  = array();

				if ( ! $instance['video'] ) {
					$media = array_filter( $media, array( $this, 'image_only_filter' ) );
				}
				$media = array_slice( $media, 0, $instance['number'] );

				foreach ( $media as $item ) {
					$list[] = sprintf(
						'<a href="%s" target="%s"><img src="%s" alt="%s"></a>',
						esc_url( $item['link'] ),
						esc_attr( $instance['target'] ),
						esc_url( $item[$instance['size']] ),
						esc_attr( $item['description'] )
					);
				}

				if ( $list ) {
					echo '<div class="instagram-feed instagram-size-' . esc_attr( $instance['size'] ) . ' clearfix">';
					echo implode( "\n\t", $list );
					echo '</div>';
				}
			}
		endif;

		echo $args['after_widget'];
	}

	/**
	 * Update widget
	 *
	 * @param array $new_instance New widget settings
	 * @param array $old_instance Old widget settings
	 *
	 * @return array
	 */
	function update( $new_instance, $old_instance ) {
		$new_instance['title']    = strip_tags( $new_instance['title'] );
		$new_instance['username'] = strip_tags( $new_instance['username'] );
		$new_instance['number']   = intval( $new_instance['number'] );
		$new_instance['video']    = ! empty( $new_instance['video'] );
		$new_instance['size']     = strip_tags( $new_instance['size'] );
		$new_instance['target']   = strip_tags( $new_instance['target'] );

		return $new_instance;
	}

	/**
	 * Displays the form for this widget on the Widgets page of the WP Admin area.
	 *
	 * @param array $instance
	 *
	 * @return array
	 */
	function form( $instance ) {
		$instance = wp_parse_args( $instance, $this->defaults );
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title', 'penshop' ); ?></label>
			<input type="text" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>">
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'username' ) ); ?>"><?php esc_html_e( 'Username', 'penshop' ); ?></label>
			<input type="text" id="<?php echo esc_attr( $this->get_field_id( 'username' ) ); ?>" class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'username' ) ); ?>" value="<?php echo esc_attr( $instance['username'] ); ?>">
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"><?php esc_html_e( 'Number of photos', 'penshop' ); ?></label>
			<input type="text" id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>" class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" value="<?php echo esc_attr( $instance['number'] ); ?>" />
		</p>

		<p>
			<input type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'video' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'video' ) ); ?>" value="1" <?php checked( 1, $instance['video'] ) ?> />
			<label for="<?php echo esc_attr( $this->get_field_id( 'video' ) ); ?>"><?php esc_html_e( 'Include videos', 'penshop' ); ?></label>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'size' ) ); ?>"><?php esc_html_e( 'Photo size', 'penshop' ); ?>:</label>
			<select id="<?php echo esc_attr( $this->get_field_id( 'size' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'size' ) ); ?>" class="widefat">
				<option value="thumbnail" <?php selected( 'thumbnail', $instance['size'] ) ?>><?php esc_html_e( 'Thumbnail', 'penshop' ); ?></option>
				<option value="small" <?php selected( 'small', $instance['size'] ) ?>><?php esc_html_e( 'Small', 'penshop' ); ?></option>
				<option value="large" <?php selected( 'large', $instance['size'] ) ?>><?php esc_html_e( 'Large', 'penshop' ); ?></option>
				<option value="original" <?php selected( 'original', $instance['size'] ) ?>><?php esc_html_e( 'Original', 'penshop' ); ?></option>
			</select>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'target' ) ); ?>"><?php esc_html_e( 'Open link in', 'penshop' ); ?>:</label>
			<select id="<?php echo esc_attr( $this->get_field_id( 'target' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'target' ) ); ?>" class="widefat">
				<option value="_self" <?php selected( '_self', $instance['target'] ) ?>><?php esc_html_e( 'Current window', 'penshop' ); ?></option>
				<option value="_blank" <?php selected( '_blank', $instance['target'] ) ?>><?php esc_html_e( 'New window', 'penshop' ); ?></option>
			</select>
		</p>

		<?php
	}

	/**
	 * Get images from Instagram profile page
	 *
	 * @since 2.0
	 *
	 * @param string $username
	 *
	 * @return array | WP_Error
	 */
	protected function scrape_instagram( $username ) {
		$username      = strtolower( $username );
		$username      = str_replace( '@', '', $username );
		$transient_key = 'penshop_instagram-' . sanitize_title_with_dashes( $username );

		if ( false === ( $instagram = get_transient( $transient_key ) ) ) {
			$remote = wp_remote_get( 'http://instagram.com/' . trim( $username ) . '/?__a=1' );

			if ( is_wp_error( $remote ) ) {
				return new WP_Error( 'site_down', esc_html__( 'Unable to communicate with Instagram.', 'penshop' ) );
			}

			if ( 200 != wp_remote_retrieve_response_code( $remote ) ) {
				return new WP_Error( 'invalid_response', esc_html__( 'Instagram did not return a 200.', 'penshop' ) );
			}

			$data = json_decode( $remote['body'], true );

			if ( ! $data ) {
				return new WP_Error( 'bad_json', esc_html__( 'Instagram has returned invalid data.', 'penshop' ) );
			}

			if ( isset( $data['user']['media']['nodes'] ) ) {
				$images = $data['user']['media']['nodes'];
			} else {
				return new WP_Error( 'bad_json_2', esc_html__( 'Instagram has returned invalid data.', 'penshop' ) );
			}

			if ( ! is_array( $images ) ) {
				return new WP_Error( 'bad_array', esc_html__( 'Instagram has returned invalid data.', 'penshop' ) );
			}

			$instagram = array();

			foreach ( $images as $image ) {

				$image['thumbnail_src'] = preg_replace( '/^https?\:/i', '', $image['thumbnail_src'] );
				$image['display_src']   = preg_replace( '/^https?\:/i', '', $image['display_src'] );

				// handle both types of CDN url
				if ( ( strpos( $image['thumbnail_src'], 's640x640' ) !== false ) ) {
					$image['thumbnail'] = str_replace( 's640x640', 's160x160', $image['thumbnail_src'] );
					$image['small']     = str_replace( 's640x640', 's320x320', $image['thumbnail_src'] );
				} else {
					$urlparts  = wp_parse_url( $image['thumbnail_src'] );
					$pathparts = explode( '/', $urlparts['path'] );
					array_splice( $pathparts, 3, 0, array( 's160x160' ) );
					$image['thumbnail'] = '//' . $urlparts['host'] . implode( '/', $pathparts );
					$pathparts[3]       = 's320x320';
					$image['small']     = '//' . $urlparts['host'] . implode( '/', $pathparts );
				}

				$image['large'] = $image['thumbnail_src'];

				if ( $image['is_video'] == true ) {
					$type = 'video';
				} else {
					$type = 'image';
				}

				$instagram[] = array(
					'description' => $image['caption'],
					'link'        => trailingslashit( '//instagram.com/p/' . $image['code'] ),
					'time'        => $image['date'],
					'comments'    => $image['comments']['count'],
					'likes'       => $image['likes']['count'],
					'thumbnail'   => $image['thumbnail'],
					'small'       => $image['small'],
					'large'       => $image['large'],
					'original'    => $image['display_src'],
					'type'        => $type,
				);
			}

			// do not set an empty transient - should help catch private or empty accounts
			if ( ! empty( $instagram ) ) {
				$instagram = serialize( $instagram );
				set_transient( $transient_key, $instagram, 2 * 3600 );
			}
		}

		if ( ! empty( $instagram ) ) {
			return unserialize( $instagram );
		} else {
			return new WP_Error( 'no_images', esc_html__( 'Instagram did not return any images.', 'penshop' ) );
		}
	}

	/**
	 * Filter images only
	 *
	 * @param array $item
	 *
	 * @return bool
	 */
	protected function image_only_filter( $item ) {
		return $item['type'] == 'image';
	}
}