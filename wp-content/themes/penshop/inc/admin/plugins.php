<?php
/**
 * Register the required plugins.
 *
 * @see        http://tgmpluginactivation.com/configuration/
 *
 * @package    PenShop
 */

/**
 * Include the TGM_Plugin_Activation class.
 */
require_once get_template_directory() . '/inc/lib/tgmpa/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'penshop_register_required_plugins' );

/**
 * Register the required plugins for this theme.
 *
 * This function is hooked into `tgmpa_register`, which is fired on the WP `init` action on priority 10.
 */
function penshop_register_required_plugins() {
	$plugins = array(
		array(
			'name'     => esc_html__( 'WooCommerce', 'penshop' ),
			'slug'     => 'woocommerce',
			'required' => true,
		),
		array(
			'name'     => esc_html__( 'Meta Box', 'penshop' ),
			'slug'     => 'meta-box',
			'required' => true,
		),
		array(
			'name'     => esc_html__( 'Meta Box Group', 'penshop' ),
			'slug'     => 'meta-box-group',
			'source'   => 'http://penshop.pencidesign.com/plugins/meta-box-group.zip',
			'required' => true,
		),
		array(
			'name'     => esc_html__( 'Kirki', 'penshop' ),
			'slug'     => 'kirki',
			'required' => true,
		),
		array(
			'name'     => esc_html__( 'WPBakery Visual Composer', 'penshop' ),
			'slug'     => 'js_composer',
			'source'   => 'http://penshop.pencidesign.com/plugins/js_composer.zip',
			'required' => true,
		),
		array(
			'name'     => esc_html__( 'PenShop Addons', 'penshop' ),
			'slug'     => 'penshop-addons',
			'source'   => 'http://penshop.pencidesign.com/plugins/penshop-addons.zip',
			'version'  => '1.3.2',
			'required' => true,
		),
		array(
			'name'     => esc_html__( 'Revolution Slider', 'penshop' ),
			'slug'     => 'revslider',
			'source'   => 'http://penshop.pencidesign.com/plugins/revslider.zip',
			'required' => false,
			'version'  => '5.4.6.3.1',
		),
		array(
			'name'     => esc_html__( 'WooCommerce Currency Switcher', 'penshop' ),
			'slug'     => 'woocommerce-currency-switcher',
			'required' => false,
		),
		array(
			'name'     => esc_html__( 'Contact Form 7', 'penshop' ),
			'slug'     => 'contact-form-7',
			'required' => false,
		),
		array(
			'name'     => esc_html__( 'MailChimp for WordPress', 'penshop' ),
			'slug'     => 'mailchimp-for-wp',
			'required' => false,
		),
		array(
			'name'     => esc_html__( 'WooCommerce Variation Swatches', 'penshop' ),
			'slug'     => 'variation-swatches-for-woocommerce',
			'required' => false,
		),
		array(
			'name'     => esc_html__( 'YITH WooCommerce Wishlist', 'penshop' ),
			'slug'     => 'yith-woocommerce-wishlist',
			'required' => false,
		),
	);

	$config = array(
		'id'           => 'penshop',
		'default_path' => '',
		'menu'         => 'install-plugins',
		'has_notices'  => true,
		'dismissable'  => true,
		'dismiss_msg'  => '',
		'is_automatic' => false,
		'message'      => '',
	);

	tgmpa( $plugins, $config );
}
