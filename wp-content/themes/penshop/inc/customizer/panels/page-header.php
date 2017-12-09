<?php
/**
 * Setting fields of Page Header
 *
 * @package    PenShop
 * @subpackage Customizer
 */

return array(
	// Page Header Default
	'page_header'                       => array(
		'type'        => 'toggle',
		'label'       => esc_html__( 'Show Page Header', 'penshop' ),
		'description' => esc_html__( 'Display the page header. You can change this on individual pages.', 'penshop' ),
		'section'     => 'page_header_default',
		'default'     => 1,
	),
	'page_header_breadcrumbs'           => array(
		'type'            => 'toggle',
		'label'           => esc_html__( 'Show Breadcrumb', 'penshop' ),
		'description'     => esc_html__( 'Display the breadcrumbs under page title.', 'penshop' ),
		'section'         => 'page_header_default',
		'default'         => 1,
		'active_callback' => array(
			array(
				'setting'  => 'page_header',
				'operator' => '==',
				'value'    => true,
			),
		),
	),
	'page_header_color'                 => array(
		'type'            => 'color',
		'label'           => esc_html__( 'Background Color', 'penshop' ),
		'description'     => esc_html__( 'The default background color for page header', 'penshop' ),
		'section'         => 'page_header_default',
		'default'         => '#eeeeee',
		'transport'       => 'postMessage',
		'active_callback' => array(
			array(
				'setting'  => 'page_header',
				'operator' => '==',
				'value'    => true,
			),
		),
		'js_vars'         => array(
			array(
				'element'  => '.page-header',
				'function' => 'css',
				'property' => 'background-color',
			),
		),
	),
	'page_header_image'                 => array(
		'type'            => 'image',
		'label'           => esc_html__( 'Background Image', 'penshop' ),
		'description'     => esc_html__( 'The default background image for page header', 'penshop' ),
		'section'         => 'page_header_default',
		'active_callback' => array(
			array(
				'setting'  => 'page_header',
				'operator' => '==',
				'value'    => true,
			),
		),
	),
	'page_header_image_position'        => array(
		'type'            => 'select',
		'label'           => esc_html__( 'Image Position', 'penshop' ),
		'description'     => esc_html__( 'Select the position of background image', 'penshop' ),
		'section'         => 'page_header_default',
		'transport'       => 'postMessage',
		'default'         => 'center center',
		'choices'         => array(
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
		'active_callback' => array(
			array(
				'setting'  => 'page_header',
				'operator' => '==',
				'value'    => true,
			),
		),
		'js_vars'         => array(
			array(
				'element'  => '.page-header',
				'function' => 'css',
				'property' => 'background-position',
			),
		),
	),
	'page_header_image_position_x'      => array(
		'type'            => 'slider',
		'label'           => esc_html__( 'Image Vertical Position', 'penshop' ),
		'description'     => esc_html__( 'Select the vertical position of background image', 'penshop' ),
		'section'         => 'page_header_default',
		'transport'       => 'postMessage',
		'default'         => '50',
		'choices'         => array(
			'min'  => '0',
			'max'  => '100',
			'step' => '1',
		),
		'active_callback' => array(
			array(
				'setting'  => 'page_header',
				'operator' => '==',
				'value'    => true,
			),
			array(
				'setting'  => 'page_header_image_position',
				'operator' => '==',
				'value'    => 'custom',
			),
		),
		'js_vars'         => array(
			array(
				'element'  => '.page-header',
				'function' => 'css',
				'units'    => '%',
				'property' => 'background-position-x',
			),
		),
	),
	'page_header_image_position_y'      => array(
		'type'            => 'slider',
		'label'           => esc_html__( 'Image Horizontal Position', 'penshop' ),
		'description'     => esc_html__( 'Select the horizontal position of background image', 'penshop' ),
		'section'         => 'page_header_default',
		'transport'       => 'postMessage',
		'default'         => '50',
		'choices'         => array(
			'min'  => '0',
			'max'  => '100',
			'step' => '1',
		),
		'active_callback' => array(
			array(
				'setting'  => 'page_header',
				'operator' => '==',
				'value'    => true,
			),
			array(
				'setting'  => 'page_header_image_position',
				'operator' => '==',
				'value'    => 'custom',
			),
		),
		'js_vars'         => array(
			array(
				'element'  => '.page-header',
				'function' => 'css',
				'units'    => '%',
				'property' => 'background-position-y',
			),
		),
	),
	'page_header_text_color'            => array(
		'type'            => 'radio',
		'label'           => esc_html__( 'Text Color', 'penshop' ),
		'section'         => 'page_header_default',
		'default'         => 'dark',
		'choices'         => array(
			'dark'  => esc_html__( 'Dark', 'penshop' ),
			'light' => esc_html__( 'Light', 'penshop' ),
		),
		'active_callback' => array(
			array(
				'setting'  => 'page_header',
				'operator' => '==',
				'value'    => true,
			),
		),
	),
	'page_header_spacing'               => array(
		'type'            => 'spacing',
		'label'           => esc_html__( 'Spacing', 'penshop' ),
		'description'     => esc_html__( 'Adjust the top and bottom spacing', 'penshop' ),
		'section'         => 'page_header_default',
		'default'         => array(
			'top'    => '110px',
			'bottom' => '110px',
		),
		'active_callback' => array(
			array(
				'setting'  => 'page_header',
				'operator' => '==',
				'value'    => true,
			),
		),
		'js_vars'         => array(
			array(
				'element'  => '.page-header',
				'function' => 'css',
				'property' => 'padding',
			),
		),
		'transport'       => 'postMessage',
	),
	// Page Header Shop
	'page_header_shop'                  => array(
		'type'        => 'toggle',
		'label'       => esc_html__( 'Show Page Header', 'penshop' ),
		'description' => esc_html__( 'Display the page header. You can change this on individual pages.', 'penshop' ),
		'section'     => 'page_header_shop',
		'default'     => 1,
	),
	'page_header_shop_breadcrumbs'      => array(
		'type'            => 'toggle',
		'label'           => esc_html__( 'Show Breadcrumb', 'penshop' ),
		'description'     => esc_html__( 'Display the breadcrumbs under page title.', 'penshop' ),
		'section'         => 'page_header_shop',
		'default'         => 1,
		'active_callback' => array(
			array(
				'setting'  => 'page_header_shop',
				'operator' => '==',
				'value'    => true,
			),
		),
	),
	'page_header_shop_color'            => array(
		'type'            => 'color',
		'label'           => esc_html__( 'Background Color', 'penshop' ),
		'description'     => esc_html__( 'The default background color for page header', 'penshop' ),
		'section'         => 'page_header_shop',
		'default'         => '#eeeeee',
		'active_callback' => array(
			array(
				'setting'  => 'page_header_shop',
				'operator' => '==',
				'value'    => true,
			),
		),
		'js_vars'         => array(
			array(
				'element'  => '.woocommerce .page-header',
				'function' => 'css',
				'property' => 'background-color',
			),
		),
	),
	'page_header_shop_image'            => array(
		'type'            => 'image',
		'label'           => esc_html__( 'Background Image', 'penshop' ),
		'description'     => esc_html__( 'The default background image for page header', 'penshop' ),
		'section'         => 'page_header_shop',
		'default'         => '',
		'active_callback' => array(
			array(
				'setting'  => 'page_header_shop',
				'operator' => '==',
				'value'    => true,
			),
		),
		'js_vars'         => array(
			array(
				'element'  => '.woocommerce .page-header',
				'function' => 'css',
				'property' => 'background-image',
			),
		),
	),
	'page_header_shop_image_position'   => array(
		'type'            => 'select',
		'label'           => esc_html__( 'Image Position', 'penshop' ),
		'description'     => esc_html__( 'Select the position of background image', 'penshop' ),
		'section'         => 'page_header_shop',
		'transport'       => 'postMessage',
		'default'         => 'center center',
		'choices'         => array(
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
		'active_callback' => array(
			array(
				'setting'  => 'page_header_shop',
				'operator' => '==',
				'value'    => true,
			),
		),
		'js_vars'         => array(
			array(
				'element'  => '.woocommerce .page-header',
				'function' => 'css',
				'property' => 'background-position',
			),
		),
	),
	'page_header_shop_image_position_x' => array(
		'type'            => 'slider',
		'label'           => esc_html__( 'Image Vertical Position', 'penshop' ),
		'description'     => esc_html__( 'Select the vertical position of background image', 'penshop' ),
		'section'         => 'page_header_shop',
		'transport'       => 'postMessage',
		'default'         => '50',
		'choices'         => array(
			'min'  => '0',
			'max'  => '100',
			'step' => '1',
		),
		'active_callback' => array(
			array(
				'setting'  => 'page_header_shop',
				'operator' => '==',
				'value'    => true,
			),
			array(
				'setting'  => 'page_header_shop_image_position',
				'operator' => '==',
				'value'    => 'custom',
			),
		),
		'js_vars'         => array(
			array(
				'element'  => '.woocommerce .page-header',
				'function' => 'css',
				'units'    => '%',
				'property' => 'background-position-x',
			),
		),
	),
	'page_header_shop_image_position_y' => array(
		'type'            => 'slider',
		'label'           => esc_html__( 'Image Horizontal Position', 'penshop' ),
		'description'     => esc_html__( 'Select the horizontal position of background image', 'penshop' ),
		'section'         => 'page_header_shop',
		'transport'       => 'postMessage',
		'default'         => '50',
		'choices'         => array(
			'min'  => '0',
			'max'  => '100',
			'step' => '1',
		),
		'active_callback' => array(
			array(
				'setting'  => 'page_header_shop',
				'operator' => '==',
				'value'    => true,
			),
			array(
				'setting'  => 'page_header_shop_image_position',
				'operator' => '==',
				'value'    => 'custom',
			),
		),
		'js_vars'         => array(
			array(
				'element'  => '.woocommerce .page-header',
				'function' => 'css',
				'units'    => '%',
				'property' => 'background-position-y',
			),
		),
	),
	'page_header_shop_text_color'       => array(
		'type'            => 'radio',
		'label'           => esc_html__( 'Text Color', 'penshop' ),
		'section'         => 'page_header_shop',
		'default'         => 'dark',
		'choices'         => array(
			'dark'  => esc_html__( 'Dark', 'penshop' ),
			'light' => esc_html__( 'Light', 'penshop' ),
		),
		'active_callback' => array(
			array(
				'setting'  => 'page_header_shop',
				'operator' => '==',
				'value'    => true,
			),
		),
	),
	'page_header_shop_spacing'               => array(
		'type'            => 'spacing',
		'label'           => esc_html__( 'Spacing', 'penshop' ),
		'description'     => esc_html__( 'Adjust the top and bottom spacing', 'penshop' ),
		'section'         => 'page_header_shop',
		'default'         => array(
			'top'    => '110px',
			'bottom' => '110px',
		),
		'active_callback' => array(
			array(
				'setting'  => 'page_header',
				'operator' => '==',
				'value'    => true,
			),
		),
		'js_vars'         => array(
			array(
				'element'  => '.page-header',
				'function' => 'css',
				'property' => 'padding',
			),
		),
		'transport'       => 'postMessage',
	),
);