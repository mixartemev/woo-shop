<?php
/**
 * Currency switcher widget
 */


/**
 * Class PenShop_Currency_Switcher_Widget
 */
class PenShop_Currency_Switcher_Widget extends WP_Widget {
	/**
	 * Holds widget default settings, populated in constructor.
	 *
	 * @var array
	 */
	protected $defaults;

	/**
	 * Class constructor
	 * Set up the widget
	 */
	function __construct() {
		$this->defaults = array(
			'title'     => '',
			'show_code' => true,
			'show_flag' => false,
		);

		parent::__construct(
			'penshop-currencies-widget',
			esc_html__( 'PenShop - Currency Switcher', 'penshop' ),
			array(
				'classname'   => 'penshop-currencies-widget',
				'description' => esc_html__( 'Display currency switcher', 'penshop' ),
			)
		);
	}

	/**
	 * Outputs the HTML for this widget.
	 *
	 * @param array $args     An array of standard parameters for widgets in this theme
	 * @param array $instance An array of settings for this widget instance
	 */
	public function widget( $args, $instance ) {
		if ( ! class_exists( 'WOOCS' ) ) {
			return;
		}

		global $WOOCS;

		$instance = wp_parse_args( $instance, $this->defaults );

		if ( $title = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base ) ) {
			echo $args['before_title'] . esc_html( $title ) . $args['after_title'];
		}

		echo $args['before_widget'];

		$currencies    = $WOOCS->get_currencies();
		$current       = '';
		$currency_list = array();

		foreach ( $currencies as $key => $currency ) {

			$context = esc_html( $currency['name'] );
			if ( $instance['show_flag'] ) {
				$context = '<img src="' . esc_url( $currency['flag'] ) . '" alt="' . esc_attr( $currency['description'] ) . '">' . $context;
			}

			if ( $instance['show_code'] ) {
				$context .= '/' . $currency['symbol'];
			}

			if ( $WOOCS->current_currency == $key ) {
				array_unshift( $currency_list, sprintf(
					'<li><a href="#" class="woocs_flag_view_item woocs_flag_view_item_current" data-currency="%s">%s</a></li>',
					esc_attr( $currency['name'] ),
					$context
				) );

				$current = $context;
			} else {
				$currency_list[] = sprintf(
					'<li><a href="#" class="woocs_flag_view_item" data-currency="%s">%s</a></li>',
					esc_attr( $currency['name'] ),
					$context
				);
			}

		}
		?>

		<div class="currency list-dropdown">
			<span class="current">
				<?php echo $current; ?>
				<span class="caret"><i class="fa fa-angle-down"></i></span>
			</span>
			<ul>
				<?php echo implode( "\n\t", $currency_list ); ?>
			</ul>
		</div>

		<?php

		echo $args['after_widget'];
	}

	/**
	 * Handles updating settings for the current Custom Menu widget instance.
	 *
	 * @param array $new_instance New settings for this instance as input by the user via WP_Widget::form().
	 * @param array $old_instance Old settings for this instance.
	 *
	 * @return array Updated settings to save.
	 */
	public function update( $new_instance, $old_instance ) {
		$new_instance['title']     = sanitize_text_field( $new_instance['title'] );
		$new_instance['show_code'] = isset( $new_instance['show_code'] );
		$new_instance['show_flag'] = isset( $new_instance['show_flag'] );

		return $new_instance;
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
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title', 'penshop' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>">
		</p>

		<p>
			<input type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'show_code' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_code' ) ); ?>" value="1" <?php checked( 1, $instance['show_code'] ) ?>>
			<label for="<?php echo esc_attr( $this->get_field_id( 'show_code' ) ); ?>"><?php esc_html_e( 'Show currency symbol', 'penshop' ); ?></label>
		</p>

		<p>
			<input type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'show_flag' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_flag' ) ); ?>" value="1" <?php checked( 1, $instance['show_flag'] ) ?>>
			<label for="<?php echo esc_attr( $this->get_field_id( 'show_flag' ) ); ?>"><?php esc_html_e( 'Show flag', 'penshop' ); ?></label>
		</p>

		<?php
	}
}