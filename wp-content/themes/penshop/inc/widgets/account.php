<?php
/**
 * Furnde_My_Account widget class
 *
 * @since 1.0
 */
class PenShop_Account_Widget extends WP_Widget {
	/**
	 * Holds widget default settings, populated in constructor.
	 *
	 * @var array
	 */
	protected $defaults;

	/**
	 * Check if popup is added to footer or not
	 *
	 * @var bool
	 */
	static $popup;

	/**
	 * Class constructor
	 * Set up the widget
	 */
	function __construct() {
		$this->defaults = array(
			'title' => ''
		);

		parent::__construct(
			'penshop-account-widget',
			esc_html__( 'PenShop - Sign in / Sign Up', 'penshop' ),
			array(
				'classname'   => 'penshop-account-widget',
				'description' => esc_html__( 'Display sign in link on the topbar', 'penshop' ),
			)
		);

		if ( ! is_admin() && ! self::$popup ) {
			self::$popup = true;
			add_action( 'wp_footer', array( $this, 'popup' ) );
		}
	}

	/**
	 * Outputs the HTML for this widget.
	 *
	 * @param array $args     An array of standard parameters for widgets in this theme
	 * @param array $instance An array of settings for this widget instance
	 *
	 * @return void Echoes it's output
	 */
	public function widget( $args, $instance ) {
		if ( ! function_exists( 'WC' ) ) {
			return;
		}

		$instance = wp_parse_args( $instance, $this->defaults );

		if ( $title = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base ) ) {
			echo $args['before_title'] . esc_html( $title ) . $args['after_title'];
		}

		echo $args['before_widget'];

		if( is_user_logged_in() ) {
			printf(
				'<a href="%s" class="account-link">%s</a><span class="sep"> / </span><a href="%s" class="logout-link">%s</a>',
				esc_url( wc_get_page_permalink( 'myaccount' ) ),
				esc_html__( 'My Account', 'penshop' ),
				esc_url( wc_get_page_permalink( 'myaccount' ) ),
				esc_html__( 'Sign Out', 'penshop' )
			);
		} else {
			$label = esc_html__( 'Sign In', 'penshop');

			if ( 'yes' == get_option( 'woocommerce_enable_myaccount_registration' ) ) {
				$label .= ' / ' . esc_html__( 'Join', 'penshop');
			}

			printf(
				'<a href="%s" class="login" data-toggle="modal" data-target="#modal-login">%s</a>',
				esc_url( wc_get_page_permalink( 'myaccount' ) ),
				$label
			);
		}

		echo $args['after_widget'];
	}

	/**
	 * Display widget settings
	 *
	 * @param array $instance Widget settings
	 *
	 * @return void
	 */
	public function form( $instance ) {
		$instance = wp_parse_args( $instance, $this->defaults );
		?>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title', 'penshop' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>">
		</p>

		<?php
	}

	/**
	 * Add HTML of login form to footer
	 */
	public function popup() {
		?>

		<div id="modal-login" class="modal modal-login woocommerce-account" tabindex="-1" role="dialog">
			<div class="close-trigger modal-backdrop"></div>

			<?php echo do_shortcode( '[woocommerce_my_account]' ) ?>
		</div>

		<?php
	}
}
