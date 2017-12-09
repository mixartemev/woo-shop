<?php
/**
 * Plugin Name: PenShop Addons
 * Plugin URI: http://pencidesign.com/penshop
 * Description: A collection of extra elements for Visual Composer. It is made for PenShop premium theme and requires PenShop theme installed in order to work properly.
 * Author: PenciDesign
 * Author URI: http://themeforest.net/user/pencidesign?ref=pencidesign
 * Version: 1.3.3
 * Text Domain: penshop-addons
 * License: GPLv2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class PenShop_Addons
 */
class PenShop_Addons {
	/**
	 * Constructor function.
	 */
	public function __construct() {
		$this->define_constants();
		$this->includes();
		$this->init();
	}

	/**
	 * Defines constants
	 */
	public function define_constants() {
		define( 'PENSHOP_ADDONS_DIR', plugin_dir_path( __FILE__ ) );
		define( 'PENSHOP_ADDONS_URL', plugin_dir_url( __FILE__ ) );
	}

	/**
	 * Load files
	 */
	public function includes() {
		include_once( PENSHOP_ADDONS_DIR . 'includes/import.php' );
		include_once( PENSHOP_ADDONS_DIR . 'includes/visual-composer.php' );
		include_once( PENSHOP_ADDONS_DIR . 'includes/shortcodes.php' );
		include_once( PENSHOP_ADDONS_DIR . 'includes/portfolio.php' );
		include_once( PENSHOP_ADDONS_DIR . 'includes/slider.php' );
		include_once( PENSHOP_ADDONS_DIR . 'includes/share.php' );
	}

	/**
	 * Initialize
	 */
	public function init() {
		add_action( 'admin_notices', array( $this, 'check_dependencies' ) );

		load_plugin_textdomain( 'penshop-addons', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );

		add_action( 'vc_after_init', array( 'PenShop_Addons_VC', 'init' ), 50 );
		add_action( 'init', array( 'PenShop_Addons_Shortcodes', 'init' ), 50 );
		add_action( 'init', array( 'PenShop_Addons_Portfolio', 'init' ), 50 );
		add_action( 'plugins_loaded', array( 'PenShop_Addons_Slider', 'init' ) );
	}

	/**
	 * Check plugin dependencies
	 * Check if Visual Composer plugin is installed
	 */
	public function check_dependencies() {
		if ( ! defined( 'WPB_VC_VERSION' ) ) {
			$plugin_data = get_plugin_data( __FILE__ );

			printf(
				'<div class="updated"><p>%s</p></div>',
				sprintf(
					__( '<strong>%s</strong> requires <strong><a href="http://bit.ly/vcomposer" target="_blank">Visual Composer</a></strong> plugin to be installed and activated on your site.', 'penshop-addons' ),
					$plugin_data['Name']
				)
			);
		}
	}
}

new PenShop_Addons();
