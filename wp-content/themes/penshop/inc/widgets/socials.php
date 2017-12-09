<?php

class PenShop_Social_Links_Widget extends WP_Widget {
	/**
	 * Holds widget settings defaults, populated in constructor.
	 *
	 * @var array
	 */
	protected $default;

	/**
	 * List of supported socials
	 *
	 * @var array
	 */
	protected $socials;

	/**
	 * Constructor
	 */
	function __construct() {
		$socials = array(
			'facebook'    => esc_html__( 'Facebook', 'penshop' ),
			'twitter'     => esc_html__( 'Twitter', 'penshop' ),
			'google-plus' => esc_html__( 'Google Plus', 'penshop' ),
			'tumblr'      => esc_html__( 'Tumblr', 'penshop' ),
			'linkedin'    => esc_html__( 'Linkedin', 'penshop' ),
			'pinterest'   => esc_html__( 'Pinterest', 'penshop' ),
			'flickr'      => esc_html__( 'Flickr', 'penshop' ),
			'instagram'   => esc_html__( 'Instagram', 'penshop' ),
			'dribbble'    => esc_html__( 'Dribbble', 'penshop' ),
			'stumbleupon' => esc_html__( 'StumbleUpon', 'penshop' ),
			'github'      => esc_html__( 'Github', 'penshop' ),
			'rss'         => esc_html__( 'RSS', 'penshop' ),
		);

		$this->socials = apply_filters( 'penshop_social_media', $socials );
		$this->default = array(
			'title' => '',
		);

		foreach ( $this->socials as $k => $v ) {
			$this->default["{$k}_title"] = $v;
			$this->default["{$k}_url"]   = '';
		}

		parent::__construct(
			'penshop-social-links-widget',
			esc_html__( 'PenShop - Social Links', 'penshop' ),
			array(
				'classname'   => 'penshop-social-links-widget',
				'description' => esc_html__( 'Display links to social media networks.', 'penshop' ),
			),
			array( 'width' => 600 )
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
		$instance = wp_parse_args( $instance, $this->default );

		echo $args['before_widget'];

		if ( $title = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base ) ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}

		foreach ( $this->socials as $social => $label ) {
			if ( ! empty( $instance[$social . '_url'] ) ) {
				printf(
					'<a href="%s" class="share-%s tooltip-enable social" rel="nofollow" title="%s" data-toggle="tooltip" data-placement="top" target="_blank"><i class="fa fa-%s"></i></a>',
					esc_url( $instance[$social . '_url'] ),
					esc_attr( $social ),
					esc_attr( $instance[$social . '_title'] ),
					esc_attr( $social )
				);
			}
		}

		echo $args['after_widget'];
	}

	/**
	 * Displays the form for this widget on the Widgets page of the WP Admin area.
	 *
	 * @param array $instance
	 *
	 * @return string|void
	 */
	function form( $instance ) {
		$instance = wp_parse_args( $instance, $this->default );
		?>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title', 'penshop' ); ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" />
		</p>

		<?php
		foreach ( $this->socials as $social => $label ) {
			printf(
				'<div style="width: 280px; float: left; margin-right: 10px;">
					<label>%s</label>
					<p><input type="text" class="widefat" name="%s" placeholder="%s" value="%s"></p>
				</div>',
				$label,
				$this->get_field_name( $social . '_url' ),
				esc_html__( 'URL', 'penshop' ),
				$instance[$social . '_url']
			);
		}
	}
}
