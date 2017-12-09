<?php
/**
 * PenShop Theme Customizer
 *
 * @package PenShop
 */

/**
 * Class PenShop_Customize
 */
class PenShop_Customize {
	/**
	 * Customize settings
	 *
	 * @var array
	 */
	protected $config = array();

	/**
	 * The class constructor
	 *
	 * @param array $config
	 */
	public function __construct( $config ) {
		$this->config = $config;

		if ( ! class_exists( 'Kirki' ) ) {
			return;
		}

		$this->register();
	}

	/**
	 * Register settings
	 */
	public function register() {
		/**
		 * Add the theme configuration
		 */
		if ( ! empty( $this->config['theme'] ) ) {
			Kirki::add_config( $this->config['theme'], array(
				'capability'  => 'edit_theme_options',
				'option_type' => 'theme_mod',
			) );
		}

		/**
		 * Add panels
		 */
		if ( ! empty( $this->config['panels'] ) ) {
			foreach ( $this->config['panels'] as $panel => $settings ) {
				Kirki::add_panel( $panel, $settings );
			}
		}

		/**
		 * Add sections
		 */
		if ( ! empty( $this->config['sections'] ) ) {
			foreach ( $this->config['sections'] as $section => $settings ) {
				Kirki::add_section( $section, $settings );
			}
		}

		/**
		 * Add fields
		 */
		if ( ! empty( $this->config['theme'] ) && ! empty( $this->config['fields'] ) ) {
			foreach ( $this->config['fields'] as $name => $settings ) {
				if ( ! isset( $settings['settings'] ) ) {
					$settings['settings'] = $name;
				}

				Kirki::add_field( $this->config['theme'], $settings );
			}
		}
	}

	/**
	 * Get config ID
	 *
	 * @return string
	 */
	public function get_theme() {
		return $this->config['theme'];
	}

	/**
	 * Get customize setting value
	 *
	 * @param string $name
	 *
	 * @return bool|string
	 */
	public function get_option( $name ) {
		$default = $this->get_option_default( $name );

		return get_theme_mod( $name, $default );
	}

	/**
	 * Get default option values
	 *
	 * @param $name
	 *
	 * @return mixed
	 */
	public function get_option_default( $name ) {
		if ( ! isset( $this->config['fields'][ $name ] ) ) {
			return false;
		}

		return isset( $this->config['fields'][ $name ]['default'] ) ? $this->config['fields'][ $name ]['default'] : false;
	}
}

/**
 * This is a short hand function for getting setting value from customizer
 *
 * @param string $name
 *
 * @return bool|string
 */
function penshop_get_option( $name ) {
	global $penshop_customize;

	if ( empty( $penshop_customize ) ) {
		return false;
	}

	if ( class_exists( 'Kirki' ) ) {
		$value = Kirki::get_option( $penshop_customize->get_theme(), $name );
	} else {
		$value = $penshop_customize->get_option( $name );
	}

	return apply_filters( 'penshop_get_option', $value, $name );
}

/**
 * Get default option values
 *
 * @param $name
 *
 * @return mixed
 */
function penshop_get_option_default( $name ) {
	global $penshop_customize;

	if ( empty( $penshop_customize ) ) {
		return false;
	}

	return $penshop_customize->get_option_default( $name );
}

/**
 * Move some default sections to `general` panel that registered by theme
 *
 * @param object $wp_customize
 */
function penshop_customize_modify( $wp_customize ) {
	$wp_customize->get_section( 'title_tagline' )->panel     = 'general';
	$wp_customize->get_section( 'static_front_page' )->panel = 'general';
}

add_action( 'customize_register', 'penshop_customize_modify' );

/**
 * Register theme settings
 *
 * @return array
 */
function penshop_customize_config() {
	$config = array(
		'theme' => 'penshop',
	);

	// Register panels
	$panels = array(
		'general'     => array(
			'priority' => 10,
			'title'    => esc_html__( 'General', 'penshop' ),
		),
		'typography' => array(
			'priority' => 20,
			'title'    => esc_html__( 'Typography', 'penshop' ),
		),
		'header'      => array(
			'priority' => 250,
			'title'    => esc_html__( 'Header', 'penshop' ),
		),
		'page_header' => array(
			'priority' => 300,
			'title'    => esc_html__( 'Page Header', 'penshop' ),
		),
		'shop'        => array(
			'priority' => 350,
			'title'    => esc_html__( 'Shop', 'penshop' ),
		),
		'blog'        => array(
			'priority' => 400,
			'title'    => esc_html__( 'Blog', 'penshop' ),
		),
		'portfolio'   => array(
			'priority' => 450,
			'title'    => esc_html__( 'Portfolio', 'penshop' ),
		),
		'mobile'      => array(
			'priority' => 550,
			'title'    => esc_html__( 'Mobile', 'penshop' ),
		),
	);

	// Register sections
	$sections = array(
		'background'          => array(
			'title'    => esc_html__( 'Background', 'penshop' ),
			'priority' => 20,
		),
		'typo_main'           => array(
			'title'    => esc_html__( 'Main', 'penshop' ),
			'priority' => 10,
			'panel'    => 'typography',
		),
		'typo_headings'       => array(
			'title'    => esc_html__( 'Headings', 'penshop' ),
			'priority' => 20,
			'panel'    => 'typography',
		),
		'typo_header'         => array(
			'title'    => esc_html__( 'Header', 'penshop' ),
			'priority' => 30,
			'panel'    => 'typography',
		),
		'typo_page_header'    => array(
			'title'    => esc_html__( 'Page Header', 'penshop' ),
			'priority' => 40,
			'panel'    => 'typography',
		),
		'typo_widgets'        => array(
			'title'    => esc_html__( 'Widgets', 'penshop' ),
			'priority' => 50,
			'panel'    => 'typography',
		),
		'typo_posts'          => array(
			'title'    => esc_html__( 'Blog', 'penshop' ),
			'priority' => 60,
			'panel'    => 'typography',
		),
		'typo_product'        => array(
			'title'    => esc_html__( 'Product', 'penshop' ),
			'priority' => 70,
			'panel'    => 'typography',
		),
		'typo_footer'         => array(
			'title'    => esc_html__( 'Footer', 'penshop' ),
			'priority' => 80,
			'panel'    => 'typography',
		),
		'layout'              => array(
			'title'    => esc_html__( 'Layout', 'penshop' ),
			'priority' => 200,
			'panel'    => 'general',
		),
		'sidebar'             => array(
			'title'    => esc_html__( 'Sidebar', 'penshop' ),
			'priority' => 210,
			'panel'    => 'general',
		),
		'popup'               => array(
			'title'    => esc_html__( 'Popup', 'penshop' ),
			'priority' => 220,
			'panel'    => 'general',
		),
		'colors' => array(
			'title'    => esc_html__( 'Color Scheme', 'penshop' ),
			'priority' => 30,
		),
		'topbar'              => array(
			'title'    => esc_html__( 'Topbar', 'penshop' ),
			'priority' => 10,
			'panel'    => 'header',
		),
		'header'              => array(
			'title'    => esc_html__( 'Header Main', 'penshop' ),
			'priority' => 20,
			'panel'    => 'header',
		),
		'logo'                => array(
			'title'    => esc_html__( 'Logo', 'penshop' ),
			'priority' => 30,
			'panel'    => 'header',
		),
		'menu'                => array(
			'title'    => esc_html__( 'Menu', 'penshop' ),
			'priority' => 40,
			'panel'    => 'header',
		),
		'page_header_default' => array(
			'title'    => esc_html__( 'Default Page Header', 'penshop' ),
			'priority' => 10,
			'panel'    => 'page_header',
		),
		'page_header_shop'    => array(
			'title'    => esc_html__( 'Shop Page Header', 'penshop' ),
			'priority' => 20,
			'panel'    => 'page_header',
		),
		'blog_archive'        => array(
			'title'    => esc_html__( 'Posts Page', 'penshop' ),
			'priority' => 10,
			'panel'    => 'blog',
		),
		'blog_single'         => array(
			'title'    => esc_html__( 'Single Page', 'penshop' ),
			'priority' => 20,
			'panel'    => 'blog',
		),
		'portfolio_archive'   => array(
			'title'    => esc_html__( 'Portfolio', 'penshop' ),
			'priority' => 10,
			'panel'    => 'portfolio',
		),
		'portfolio_single'    => array(
			'title'    => esc_html__( 'Single Portfolio', 'penshop' ),
			'priority' => 20,
			'panel'    => 'portfolio',
		),
		'shop_general'        => array(
			'title'    => esc_html__( 'General', 'penshop' ),
			'priority' => 10,
			'panel'    => 'shop',
		),
		'shop_catalog'        => array(
			'title'    => esc_html__( 'Catalog', 'penshop' ),
			'priority' => 20,
			'panel'    => 'shop',
		),
		'shop_product'        => array(
			'title'    => esc_html__( 'Product', 'penshop' ),
			'priority' => 30,
			'panel'    => 'shop',
		),
		'footer'              => array(
			'title'    => esc_html__( 'Footer', 'penshop' ),
			'priority' => 500,
		),
		'mobile_header'       => array(
			'title'    => esc_html__( 'Header', 'penshop' ),
			'panel'    => 'mobile',
			'priority' => 10,
		),
		'mobile_page_header'  => array(
			'title'    => esc_html__( 'Page Header', 'penshop' ),
			'panel'    => 'mobile',
			'priority' => 30,
		),
	);

	// Register fields
	$fields = array();

	foreach ( $panels as $id => $panel ) {
		$file_name = str_replace( '_', '-', $id ) . '.php';
		$file_path = get_theme_file_path( 'inc/customizer/panels/' . $file_name );

		if ( file_exists( $file_path ) ) {
			$panel_fields = ( include $file_path );
			$fields       = array_merge( $fields, $panel_fields );
		}
	}

	foreach ( $sections as $id => $section ) {
		if ( isset( $section['panel'] ) ) {
			continue;
		}

		$file_name = str_replace( '_', '-', $id ) . '.php';
		$file_path = get_theme_file_path( 'inc/customizer/panels/' . $file_name );

		if ( file_exists( $file_path ) ) {
			$panel_fields = ( include $file_path );
			$fields       = array_merge( $fields, $panel_fields );
		}
	}

	$config['panels']   = apply_filters( 'penshop_customize_panels', $panels );
	$config['sections'] = apply_filters( 'penshop_customize_sections', $sections );
	$config['fields']   = apply_filters( 'penshop_customize_fields', $fields );

	return $config;
}

