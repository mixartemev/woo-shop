<?php
/**
 * Setting fields of Mobile
 *
 * @package    PenShop
 * @subpackage Customizer
 */

return array(
	// Mobile Header
	'mobile_header_topbar'                     => array(
		'type'        => 'toggle',
		'label'       => esc_html__( 'Show Topbar', 'penshop' ),
		'description' => esc_html__( 'Keep displaying the topbar on mobile', 'penshop' ),
		'section'     => 'mobile_header',
		'default'     => false,
	),
	'mobile_header_icon'                       => array(
		'type'        => 'select',
		'label'       => esc_html__( 'Header Icon', 'penshop' ),
		'description' => esc_html__( 'Select the icon to be displayed on the mobile header', 'penshop' ),
		'section'     => 'mobile_header',
		'default'     => 'cart',
		'choices'     => array(
			'cart'     => esc_html__( 'Cart', 'penshop' ),
			'wishlist' => esc_html__( 'Wishlist', 'penshop' ),
			'search'   => esc_html__( 'Search', 'penshop' ),
		),
	),
	// Mobile Page Header
	'mobile_page_header_custom'                => array(
		'type'    => 'custom',
		'section' => 'mobile_page_header',
		'default' => '<h2>' . esc_html__( 'Default Page Header', 'penshop' ) . '</h2>',
	),
	'page_header_spacing_mobile'               => array(
		'type'        => 'spacing',
		'label'       => esc_html__( 'Spacing', 'penshop' ),
		'description' => esc_html__( 'Adjust the top and bottom spacing. Leave empty to use the value of desktop version.', 'penshop' ),
		'section'     => 'mobile_page_header',
		'default'     => array(
			'top'    => '60px',
			'bottom' => '60px',
		),
		'js_vars'     => array(
			array(
				'element'     => '.page-header',
				'function'    => 'css',
				'media_query' => '@media (max-width: 767px)',
				'property'    => 'padding',
			),
		),
		'transport'   => 'postMessage',
	),
	'mobile_page_header_image_position'        => array(
		'type'        => 'select',
		'label'       => esc_html__( 'Image Position', 'penshop' ),
		'description' => esc_html__( 'Select the position of background image', 'penshop' ),
		'section'     => 'mobile_page_header',
		'transport'   => 'postMessage',
		'default'     => 'center center',
		'choices'     => array(
			'left top'      => esc_html__( 'Top Left', 'penshop' ),
			'center top'    => esc_html__( 'Top', 'penshop' ),
			'right top'     => esc_html__( 'Top Right', 'penshop' ),
			'left center'   => esc_html__( 'Left', 'penshop' ),
			'center center' => esc_html__( 'Center', 'penshop' ),
			'right center'  => esc_html__( 'Right', 'penshop' ),
			'left bottom'   => esc_html__( 'Bottom Left', 'penshop' ),
			'center bottom' => esc_html__( 'Bottom', 'penshop' ),
			'right bottom'  => esc_html__( 'Bottom Right', 'penshop' ),
			'custom'        => esc_html__( 'Custom Position', 'penshop' ),
		),
		'js_vars'     => array(
			array(
				'element'     => '.page-header',
				'function'    => 'css',
				'media_query' => '@media (max-width: 767px)',
				'property'    => 'background-position',
			),
		),
	),
	'mobile_page_header_image_position_x'      => array(
		'type'            => 'slider',
		'label'           => esc_html__( 'Image Vertical Position', 'penshop' ),
		'description'     => esc_html__( 'Select the vertical position of background image', 'penshop' ),
		'section'         => 'mobile_page_header',
		'transport'       => 'postMessage',
		'default'         => '50',
		'choices'         => array(
			'min'  => '0',
			'max'  => '100',
			'step' => '1',
		),
		'active_callback' => array(
			array(
				'setting'  => 'mobile_page_header_image_position',
				'operator' => '==',
				'value'    => 'custom',
			),
		),
		'js_vars'         => array(
			array(
				'element'     => '.page-header',
				'function'    => 'css',
				'units'       => '%',
				'media_query' => '@media (max-width: 767px)',
				'property'    => 'background-position-x',
			),
		),
	),
	'mobile_page_header_image_position_y'      => array(
		'type'            => 'slider',
		'label'           => esc_html__( 'Image Horizontal Position', 'penshop' ),
		'description'     => esc_html__( 'Select the horizontal position of background image', 'penshop' ),
		'section'         => 'mobile_page_header',
		'transport'       => 'postMessage',
		'default'         => '50',
		'choices'         => array(
			'min'  => '0',
			'max'  => '100',
			'step' => '1',
		),
		'active_callback' => array(
			array(
				'setting'  => 'mobile_page_header_image_position',
				'operator' => '==',
				'value'    => 'custom',
			),
		),
		'js_vars'         => array(
			array(
				'element'     => '.page-header',
				'function'    => 'css',
				'units'       => '%',
				'media_query' => '@media (max-width: 767px)',
				'property'    => 'background-position-y',
			),
		),
	),
	'mobile_page_header_custom2'               => array(
		'type'    => 'custom',
		'section' => 'mobile_page_header',
		'default' => '<hr>',
	),
	'mobile_page_header_shop_custom'           => array(
		'type'    => 'custom',
		'section' => 'mobile_page_header',
		'default' => '<h2>' . esc_html__( 'Shop Page Header', 'penshop' ) . '</h2>',
	),
	'page_header_shop_spacing_mobile'               => array(
		'type'        => 'spacing',
		'label'       => esc_html__( 'Spacing', 'penshop' ),
		'description' => esc_html__( 'Adjust the top and bottom spacing. Leave empty to use the value of desktop version.', 'penshop' ),
		'section'     => 'mobile_page_header',
		'default'     => array(
			'top'    => '60px',
			'bottom' => '60px',
		),
		'js_vars'     => array(
			array(
				'element'     => '.woocommerce .page-header',
				'function'    => 'css',
				'media_query' => '@media (max-width: 767px)',
				'property'    => 'padding',
			),
		),
		'transport'   => 'postMessage',
	),
	'mobile_page_header_shop_image_position'   => array(
		'type'        => 'select',
		'label'       => esc_html__( 'Image Position', 'penshop' ),
		'description' => esc_html__( 'Select the position of background image', 'penshop' ),
		'section'     => 'mobile_page_header',
		'transport'   => 'postMessage',
		'default'     => 'center center',
		'choices'     => array(
			'left top'      => esc_html__( 'Top Left', 'penshop' ),
			'center top'    => esc_html__( 'Top', 'penshop' ),
			'right top'     => esc_html__( 'Top Right', 'penshop' ),
			'left center'   => esc_html__( 'Left', 'penshop' ),
			'center center' => esc_html__( 'Center', 'penshop' ),
			'right center'  => esc_html__( 'Right', 'penshop' ),
			'left bottom'   => esc_html__( 'Bottom Left', 'penshop' ),
			'center bottom' => esc_html__( 'Bottom', 'penshop' ),
			'right bottom'  => esc_html__( 'Bottom Right', 'penshop' ),
			'custom'        => esc_html__( 'Custom Position', 'penshop' ),
		),
		'js_vars'     => array(
			array(
				'element'     => '.woocommerce .page-header',
				'function'    => 'css',
				'media_query' => '@media (max-width: 767px)',
				'property'    => 'background-position',
			),
		),
	),
	'mobile_page_header_shop_image_position_x' => array(
		'type'            => 'slider',
		'label'           => esc_html__( 'Image Vertical Position', 'penshop' ),
		'description'     => esc_html__( 'Select the vertical position of background image', 'penshop' ),
		'section'         => 'mobile_page_header',
		'transport'       => 'postMessage',
		'default'         => '50',
		'choices'         => array(
			'min'  => '0',
			'max'  => '100',
			'step' => '1',
		),
		'active_callback' => array(
			array(
				'setting'  => 'mobile_page_header_shop_image_position',
				'operator' => '==',
				'value'    => 'custom',
			),
		),
		'js_vars'         => array(
			array(
				'element'     => '.woocommerce .page-header',
				'function'    => 'css',
				'units'       => '%',
				'media_query' => '@media (max-width: 767px)',
				'property'    => 'background-position-x',
			),
		),
	),
	'mobile_page_header_shop_image_position_y' => array(
		'type'            => 'slider',
		'label'           => esc_html__( 'Image Horizontal Position', 'penshop' ),
		'description'     => esc_html__( 'Select the horizontal position of background image', 'penshop' ),
		'section'         => 'mobile_page_header',
		'transport'       => 'postMessage',
		'default'         => '50',
		'choices'         => array(
			'min'  => '0',
			'max'  => '100',
			'step' => '1',
		),
		'active_callback' => array(
			array(
				'setting'  => 'mobile_page_header_shop_image_position',
				'operator' => '==',
				'value'    => 'custom',
			),
		),
		'js_vars'         => array(
			array(
				'element'     => '.woocommerce .page-header',
				'function'    => 'css',
				'units'       => '%',
				'media_query' => '@media (max-width: 767px)',
				'property'    => 'background-position-y',
			),
		),
	),
);