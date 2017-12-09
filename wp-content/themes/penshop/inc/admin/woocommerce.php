<?php
/**
 * Adds more settings for WooCommerce plugin
 *
 * @package PenShop
 */

/**
 * Class PenShop_WC_Product_Settings
 *
 * Add for fields into a product data meta box
 */
class PenShop_Product_Settings {
	/**
	 * Initialize
	 */
	public static function init() {
		add_action( 'woocommerce_product_options_advanced', array( __CLASS__, 'add_advanced_options' ) );
		add_action( 'save_post', array( __CLASS__, 'save_product_data' ) );
	}

	/**
	 * Add more fields to "Advanced" product data tab
	 */
	public static function add_advanced_options() {
		woocommerce_wp_checkbox( array(
			'id'            => '_is_new',
			'label'         => esc_html__( 'New product?', 'penshop' ),
			'description'   => esc_html__( 'Mark this product as a new product', 'penshop' ),
		) );
	}

	/**
	 * Save product data
	 *
	 * @param int $post_id
	 */
	public static function save_product_data( $post_id ) {
		if ( 'product' !== get_post_type( $post_id ) ) {
			return;
		}

		if ( ! isset( $_POST['_is_new'] ) ) {
			delete_post_meta( $post_id, '_is_new' );
		} else {
			update_post_meta( $post_id, '_is_new', 'yes' );
		}
	}
}
