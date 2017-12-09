<?php
/**
 * Products order widget
 *
 * @package PenShop
 */

/**
 * Class PenShop_Product_SortBy_Widget
 */
class PenShop_Products_Order_Widget extends WP_Widget {
	protected $defaults;

	function __construct() {
		$this->defaults = array(
			'title' => esc_html__( 'Sort by', 'penshop' ),
		);

		parent::__construct(
			'widget-products-order',
			esc_html__( 'PenShop - Products Ordering', 'penshop' ),
			array(
				'classname'   => 'widget-products-order',
				'description' => esc_html__( 'Display options for ordering products', 'penshop' ),
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

		if ( ! function_exists( 'WC' ) ) {
			echo '<p>' . esc_html__( 'This widget requires WooCommerce installed in order to work.', 'penshop' ) . '</p>';

			echo $args['after_widget'];

			return;
		}

		$orderby                 = isset( $_GET['orderby'] ) ? wc_clean( $_GET['orderby'] ) : apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby' ) );
		$show_default_orderby    = 'menu_order' === apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby' ) );
		$catalog_orderby_options = apply_filters( 'woocommerce_catalog_orderby', array(
			'menu_order' => esc_html__( 'Default', 'penshop' ),
			'popularity' => esc_html__( 'Popularity', 'penshop' ),
			'rating'     => esc_html__( 'Average rating', 'penshop' ),
			'date'       => esc_html__( 'Newness', 'penshop' ),
			'price'      => esc_html__( 'Price: low to high', 'penshop' ),
			'price-desc' => esc_html__( 'Price: high to low', 'penshop' ),
		) );

		if ( ! $show_default_orderby ) {
			unset( $catalog_orderby_options['menu_order'] );
		}

		if ( 'no' === get_option( 'woocommerce_enable_review_rating' ) ) {
			unset( $catalog_orderby_options['rating'] );
		}

		echo '<ul class="products-order">';
		foreach ( $catalog_orderby_options as $option => $label ) {
			$params = $_GET;

			if ( $orderby == $option && ! in_array( $option, array( 'price', 'price-desc' ) ) ) {
				$params['order'] = isset( $params['order'] ) ? $this->reverse_order( $params['order'] ) : 'asc';
			} else {
				$params['orderby'] = $option;
			}

			printf(
				'<li class="%s"><a href="%s">%s</a></li>',
				$option == $orderby ? 'current' : '',
				esc_url( add_query_arg( $params ) ),
				$label
			);
		}
		echo '</ul>';

		echo $args['after_widget'];
	}

	/**
	 * Reverse the order param
	 *
	 * @param string $order
	 *
	 * @return string
	 */
	protected function reverse_order( $order = 'desc' ) {
		return 'desc' == strtolower( $order ) ? 'asc' : 'desc';
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
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>">
		</p>
		<?php
	}
}