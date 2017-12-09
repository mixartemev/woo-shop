<?php
/**
 * Products price ranges widget
 *
 * @package PenShop
 */

/**
 * Class PenShop_Price_Ranges_Widget
 */
class PenShop_Price_Ranges_Widget extends WP_Widget {
	protected $defaults;

	function __construct() {
		$this->defaults = array(
			'title'  => esc_html__( 'Price', 'penshop' ),
			'ranges' => "0 - 100\n100 - 200\n200 - 500\n500 - 1000\n1000+",
		);

		parent::__construct(
			'widget-price-ranges',
			esc_html__( 'PenShop - Price Ranges', 'penshop' ),
			array(
				'classname'   => 'widget-price-ranges',
				'description' => esc_html__( 'Display price ranges filter on shop page', 'penshop' ),
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

		$ranges = array_filter( explode( "\n", $instance['ranges'] ) );
		$prices = $this->get_filtered_price();
		$min    = floor( $prices->min_price );
		$max    = ceil( $prices->max_price );

		if ( empty( $ranges ) || $min === $max ) {
			echo $args['after_widget'];

			return;
		}

		$current_filter              = array();
		$current_filter['min_price'] = isset( $_GET['min_price'] ) ? $_GET['min_price'] : 0;

		if ( isset( $_GET['max_price'] ) ) {
			$current_filter['max_price'] = $_GET['max_price'];
		}

		echo '<ul>';

		foreach ( $ranges as $range ) {
			$range    = array_map( 'floatval', explode( '-', $range ) );
			$range[0] = max( 0, $range[0] );
			$query    = array( 'min_price' => $range[0] );

			if ( isset( $range[1] ) ) {
				$query['max_price'] = $range[1];
			}

			if ( count( $query ) == 2 && $query['min_price'] > $query['max_price'] ) {
				continue;
			}

			if ( $query['min_price'] > $max ) {
				continue;
			}

			if ( isset( $query['max_price'] ) && $query['max_price'] < $min ) {
				continue;
			}

			$params = array_merge( $_GET, $query );
			$label  = array_map( 'wc_price', $query );
			$diff   = array_diff( $query, $current_filter );

			if ( isset( $query['max_price'] ) ) {
				$label = implode( ' - ', $label );
			} else {
				$label = $label['min_price'] . '+';
			}

			// Active filter
			if ( empty( $diff ) ) {
				$url = remove_query_arg( array( 'min_price', 'max_price' ), add_query_arg( $params ) );
			} else {
				$url = add_query_arg( $params );
			}

			printf(
				'<li class="%s"><a href="%s">%s</a></li>',
				empty( $diff ) ? 'current' : '',
				esc_url( $url ),
				$label
			);
		}

		echo '</ul>';

		echo $args['after_widget'];
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

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'ranges' ) ); ?>"><?php esc_html_e( 'Ranges', 'penshop' ); ?></label>
			<textarea class="widefat" rows="8" id="<?php echo esc_attr( $this->get_field_id( 'ranges' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'ranges' ) ); ?>"><?php echo esc_textarea( $instance['ranges'] ) ?></textarea>
			<small class="description"><?php esc_html_e( 'Enter each range in format "from - to". Separate them by newline.', 'penshop' ) ?></small>
		</p>
		<?php
	}

	/**
	 * Get filtered min price for current products.
	 * @return int
	 */
	protected function get_filtered_price() {
		global $wpdb, $wp_the_query;

		$args       = $wp_the_query->query_vars;
		$tax_query  = isset( $args['tax_query'] ) ? $args['tax_query'] : array();
		$meta_query = isset( $args['meta_query'] ) ? $args['meta_query'] : array();

		if ( ! is_post_type_archive( 'product' ) && ! empty( $args['taxonomy'] ) && ! empty( $args['term'] ) ) {
			$tax_query[] = array(
				'taxonomy' => $args['taxonomy'],
				'terms'    => array( $args['term'] ),
				'field'    => 'slug',
			);
		}

		foreach ( $meta_query + $tax_query as $key => $query ) {
			if ( ! empty( $query['price_filter'] ) || ! empty( $query['rating_filter'] ) ) {
				unset( $meta_query[ $key ] );
			}
		}

		$meta_query = new WP_Meta_Query( $meta_query );
		$tax_query  = new WP_Tax_Query( $tax_query );

		$meta_query_sql = $meta_query->get_sql( 'post', $wpdb->posts, 'ID' );
		$tax_query_sql  = $tax_query->get_sql( $wpdb->posts, 'ID' );

		$sql  = "SELECT min( FLOOR( price_meta.meta_value ) ) as min_price, max( CEILING( price_meta.meta_value ) ) as max_price FROM {$wpdb->posts} ";
		$sql .= " LEFT JOIN {$wpdb->postmeta} as price_meta ON {$wpdb->posts}.ID = price_meta.post_id " . $tax_query_sql['join'] . $meta_query_sql['join'];
		$sql .= " 	WHERE {$wpdb->posts}.post_type IN ('" . implode( "','", array_map( 'esc_sql', apply_filters( 'woocommerce_price_filter_post_type', array( 'product' ) ) ) ) . "')
					AND {$wpdb->posts}.post_status = 'publish'
					AND price_meta.meta_key IN ('" . implode( "','", array_map( 'esc_sql', apply_filters( 'woocommerce_price_filter_meta_keys', array( '_price' ) ) ) ) . "')
					AND price_meta.meta_value > '' ";
		$sql .= $tax_query_sql['where'] . $meta_query_sql['where'];

		if ( $search = WC_Query::get_main_search_query_sql() ) {
			$sql .= ' AND ' . $search;
		}

		return $wpdb->get_row( $sql );
	}
}