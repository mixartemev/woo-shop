<?php
/**
 * Setting fields of Header
 *
 * @package    PenShop
 * @subpackage Customizer
 */

return array(
	// Topbar
	'topbar'                  => array(
		'type'    => 'toggle',
		'label'   => esc_html__( 'Show topbar', 'penshop' ),
		'section' => 'topbar',
		'default' => false,
	),
	'topbar_color_scheme'     => array(
		'type'            => 'select',
		'label'           => esc_html__( 'Topbar Color Scheme', 'penshop' ),
		'section'         => 'topbar',
		'default'         => 'dark',
		'choices'         => array(
			'dark'   => esc_html__( 'Dark', 'penshop' ),
			'light'  => esc_html__( 'Light', 'penshop' ),
			'custom' => esc_html__( 'Custom', 'penshop' ),
		),
		'active_callback' => array(
			array(
				'setting'  => 'topbar',
				'operator' => '==',
				'value'    => true,
			),
		),
	),
	'topbar_color'            => array(
		'type'            => 'color',
		'label'           => esc_html__( 'Topbar Color', 'penshop' ),
		'section'         => 'topbar',
		'default'         => '#000',
		'transport'       => 'postMessage',
		'active_callback' => array(
			array(
				'setting'  => 'topbar',
				'operator' => '==',
				'value'    => true,
			),
			array(
				'setting'  => 'topbar_color_scheme',
				'operator' => '==',
				'value'    => 'custom',
			),
		),
		'js_vars'         => array(
			array(
				'element'  => '.topbar.custom',
				'property' => 'background-color',
			),
		),
	),
	'topbar_text_color'       => array(
		'type'            => 'color',
		'label'           => esc_html__( 'Text Color', 'penshop' ),
		'section'         => 'topbar',
		'default'         => '#fff',
		'transport'       => 'postMessage',
		'active_callback' => array(
			array(
				'setting'  => 'topbar',
				'operator' => '==',
				'value'    => true,
			),
			array(
				'setting'  => 'topbar_color_scheme',
				'operator' => '==',
				'value'    => 'custom',
			),
		),
		'js_vars'         => array(
			array(
				'element'  => '.topbar.custom, .topbar.custom a',
				'property' => 'color',
			),
		),
	),
	'topbar_layout'           => array(
		'type'            => 'radio',
		'label'           => esc_html__( 'Topbar Layout', 'penshop' ),
		'section'         => 'topbar',
		'default'         => '2-columns',
		'choices'         => array(
			'1-column'  => esc_html__( '1 Column', 'penshop' ),
			'2-columns' => esc_html__( '2 Columns', 'penshop' ),
		),
		'active_callback' => array(
			array(
				'setting'  => 'topbar',
				'operator' => '==',
				'value'    => true,
			),
		),
	),
	'topbar_content'          => array(
		'type'            => 'textarea',
		'label'           => esc_html__( 'Topbar Content', 'penshop' ),
		'description'     => esc_html__( 'Allow HTML and Shortcodes', 'penshop' ),
		'section'         => 'topbar',
		'active_callback' => array(
			array(
				'setting'  => 'topbar',
				'operator' => '==',
				'value'    => true,
			),
			array(
				'setting'  => 'topbar_layout',
				'operator' => '==',
				'value'    => '1-column',
			),
		),
	),
	'topbar_closeable'        => array(
		'type'            => 'toggle',
		'label'           => esc_html__( 'Show Close Icon', 'penshop' ),
		'section'         => 'topbar',
		'default'         => 0,
		'active_callback' => array(
			array(
				'setting'  => 'topbar_layout',
				'operator' => '==',
				'value'    => '1-column',
			),
		),
	),
	'topbar_2_columns_notice' => array(
		'type'            => 'custom',
		'label'           => esc_html__( 'Topbar Content', 'penshop' ),
		'section'         => 'topbar',
		'default'         => esc_html__( 'You need to drag widgets to "Topbar Left" and "Topbar Right" sidebar to add content to the topbar', 'penshop' ),
		'active_callback' => array(
			array(
				'setting'  => 'topbar_layout',
				'operator' => '==',
				'value'    => '2-columns',
			),
		),
	),
	// Header layout
	'header_layout'           => array(
		'type'    => 'select',
		'label'   => esc_html__( 'Header Layout', 'penshop' ),
		'section' => 'header',
		'default' => 'v1',
		'choices' => array(
			'v1' => esc_html__( 'Header v1', 'penshop' ),
			'v2' => esc_html__( 'Header v2', 'penshop' ),
			'v3' => esc_html__( 'Header v3', 'penshop' ),
			'v4' => esc_html__( 'Header v4', 'penshop' ),
		),
	),
	'header_color_scheme'     => array(
		'type'    => 'select',
		'label'   => esc_html__( 'Header Color Scheme', 'penshop' ),
		'section' => 'header',
		'default' => 'light',
		'choices' => array(
			'light'       => esc_html__( 'Light', 'penshop' ),
			'dark'        => esc_html__( 'Dark', 'penshop' ),
			'transparent' => esc_html__( 'Transparent', 'penshop' ),
			'custom'      => esc_html__( 'Custom', 'penshop' ),
		),
	),
	'header_color'            => array(
		'type'            => 'color',
		'label'           => esc_html__( 'Header Background Color', 'penshop' ),
		'description'     => esc_html__( 'Pick the background color for site header', 'penshop' ),
		'section'         => 'header',
		'default'         => '#ffffff',
		'transport'       => 'postMessage',
		'active_callback' => array(
			array(
				'setting'  => 'header_color_scheme',
				'operator' => '==',
				'value'    => 'custom',
			),
		),
		'js_vars'         => array(
			array(
				'element'  => '.header-custom .site-header',
				'function' => 'css',
				'property' => 'background-color',
			),
		),
	),
	'header_text_color'       => array(
		'type'            => 'radio',
		'label'           => esc_html__( 'Header Text Color', 'penshop' ),
		'description'     => esc_html__( 'Text light only apply for transparent header', 'penshop' ),
		'section'         => 'header',
		'default'         => 'dark',
		'choices'         => array(
			'light' => esc_html__( 'Light', 'penshop' ),
			'dark'  => esc_html__( 'Dark', 'penshop' ),
		),
		'active_callback' => array(
			array(
				'setting'  => 'header_color_scheme',
				'operator' => 'in',
				'value'    => array( 'custom', 'transparent' ),
			),
		),
	),
	'header_sticky'           => array(
		'type'        => 'select',
		'label'       => esc_html__( 'Sticky Header', 'penshop' ),
		'description' => esc_html__( 'Make header always visible on top of site', 'penshop' ),
		'section'     => 'header',
		'default'     => 'smart',
		'choices'     => array(
			'none'   => esc_html__( 'No sticky', 'penshop' ),
			'normal' => esc_html__( 'Normal sticky', 'penshop' ),
			'smart'  => esc_html__( 'Smart sticky', 'penshop' ),
		),
	),
	'header_right'            => array(
		'type'            => 'select',
		'label'           => esc_html__( 'Header Right', 'penshop' ),
		'description'     => esc_html__( 'Display extra elements on the right side', 'penshop' ),
		'section'         => 'header',
		'default'         => 'search',
		'choices'         => array(
			'none'   => esc_html__( 'None', 'penshop' ),
			'search' => esc_html__( 'Search Form', 'penshop' ),
			'custom' => esc_html__( 'Custom Content', 'penshop' ),
		),
		'active_callback' => array(
			array(
				'setting'  => 'header_layout',
				'operator' => '==',
				'value'    => 'v1',
			),
		),
	),
	'header_right_content'    => array(
		'type'            => 'textarea',
		'label'           => esc_html__( 'Header Right Content', 'penshop' ),
		'description'     => esc_html__( 'Shortcodes and HTML are allowed', 'penshop' ),
		'section'         => 'header',
		'choices'         => array(
			'search' => esc_html__( 'Search form', 'penshop' ),
			'custom' => esc_html__( 'Custom Content', 'penshop' ),
		),
		'active_callback' => array(
			array(
				'setting'  => 'header_layout',
				'operator' => '==',
				'value'    => 'v1',
			),
			array(
				'setting'  => 'header_right',
				'operator' => '==',
				'value'    => 'custom',
			),
		),
	),
	'header_menu_display'     => array(
		'type'            => 'select',
		'label'           => esc_html__( 'Menu Display', 'penshop' ),
		'description'     => esc_html__( 'Select the position of the primary menu', 'penshop' ),
		'section'         => 'header',
		'default'         => 'left',
		'choices'         => array(
			'left'  => esc_html__( 'Align Left', 'penshop' ),
			'right' => esc_html__( 'Align Right', 'penshop' ),
			'none'  => esc_html__( 'Hide Menu', 'penshop' ),
		),
		'active_callback' => array(
			array(
				'setting'  => 'header_layout',
				'operator' => '==',
				'value'    => 'v4',
			),
		),
	),
	// Logo
	'logo_type'               => array(
		'type'    => 'radio',
		'label'   => esc_html__( 'Logo Type', 'penshop' ),
		'section' => 'logo',
		'default' => 'image',
		'choices' => array(
			'image' => esc_html__( 'Image', 'penshop' ),
			'text'  => esc_html__( 'Text', 'penshop' ),
		),
	),
	'logo_text'               => array(
		'type'            => 'text',
		'label'           => esc_html__( 'Logo Text', 'penshop' ),
		'section'         => 'logo',
		'default'         => get_bloginfo( 'name' ),
		'active_callback' => array(
			array(
				'setting'  => 'logo_type',
				'operator' => '==',
				'value'    => 'text',
			),
		),
	),
	'logo_font'               => array(
		'type'            => 'typography',
		'label'           => esc_html__( 'Logo Font', 'penshop' ),
		'section'         => 'logo',
		'default'         => array(
			'font-family'    => 'Poppins',
			'variant'        => '700',
			'font-size'      => '30px',
			'letter-spacing' => '0',
			'subsets'        => array( 'latin-ext' ),
			'text-transform' => 'none',
			'color'          => '#111111',
		),
		'output'          => array(
			array(
				'element' => '.site-branding .logo',
			),
		),
		'active_callback' => array(
			array(
				'setting'  => 'logo_type',
				'operator' => '==',
				'value'    => 'text',
			),
		),
	),
	'logo'                    => array(
		'type'            => 'image',
		'label'           => esc_html__( 'Logo', 'penshop' ),
		'section'         => 'logo',
		'default'         => '',
		'active_callback' => array(
			array(
				'setting'  => 'logo_type',
				'operator' => '==',
				'value'    => 'image',
			),
		),
	),
	'logo_width'              => array(
		'type'            => 'number',
		'label'           => esc_html__( 'Logo Width', 'penshop' ),
		'section'         => 'logo',
		'default'         => '',
		'active_callback' => array(
			array(
				'setting'  => 'logo_type',
				'operator' => '==',
				'value'    => 'image',
			),
		),
	),
	'logo_height'             => array(
		'type'            => 'number',
		'label'           => esc_html__( 'Logo Height', 'penshop' ),
		'section'         => 'logo',
		'default'         => '',
		'active_callback' => array(
			array(
				'setting'  => 'logo_type',
				'operator' => '==',
				'value'    => 'image',
			),
		),
	),
	'logo_margin'             => array(
		'type'    => 'spacing',
		'label'   => esc_html__( 'Logo Margin', 'penshop' ),
		'section' => 'logo',
		'default' => array(
			'top'    => '0',
			'bottom' => '0',
			'left'   => '0',
			'right'  => '0',
		),
	),
	'logo_description'        => array(
		'type'        => 'toggle',
		'label'       => esc_html__( 'Show Description', 'penshop' ),
		'description' => esc_html__( 'Display site description bellow the logo', 'penshop' ),
		'section'     => 'logo',
		'default'     => true,
	),
	'description_font'        => array(
		'type'            => 'typography',
		'label'           => esc_html__( 'Description Font', 'penshop' ),
		'section'         => 'logo',
		'default'         => array(
			'font-family'    => 'Poppins',
			'variant'        => '400',
			'font-size'      => '14px',
			'letter-spacing' => '0',
			'subsets'        => array( 'latin-ext' ),
			'text-transform' => 'none',
			'color'          => '#666666',
		),
		'output'          => array(
			array(
				'element' => '.site-branding .site-description',
			),
		),
		'active_callback' => array(
			array(
				'setting'  => 'logo_description',
				'operator' => '==',
				'value'    => true,
			),
		),
	),
	// Header Icons
	'menu_icons'              => array(
		'type'        => 'sortable',
		'label'       => esc_html__( 'Menu Icons', 'penshop' ),
		'description' => esc_html__( 'Select icons to display on the right side of menu', 'penshop' ),
		'section'     => 'menu',
		'default'     => array( 'wishlist', 'cart' ),
		'choices'     => array(
			'cart'      => esc_html__( 'Cart', 'penshop' ),
			'wishlist'  => esc_html__( 'Wishlist', 'penshop' ),
			'search'    => esc_html__( 'Search', 'penshop' ),
			'hamburger' => esc_html__( 'Menu Hamburger', 'penshop' ),
		),
	),
	'hamburger_menu'          => array(
		'type'            => 'radio',
		'label'           => esc_html__( 'Hamburger Menu', 'penshop' ),
		'section'         => 'menu',
		'default'         => 'menu',
		'choices'         => array(
			'menu'    => esc_html__( 'Primary Menu', 'penshop' ),
			'sidebar' => esc_html__( 'Off-Screen Sidebar', 'penshop' ),
		),
		'active_callback' => array(
			array(
				'setting'  => 'menu_icons',
				'operator' => 'contains',
				'value'    => 'hamburger',
			),
		),
	),
	'search_type'             => array(
		'type'            => 'radio',
		'label'           => esc_html__( 'Search Type', 'penshop' ),
		'section'         => 'menu',
		'default'         => 'all',
		'choices'         => array(
			'all'     => esc_html__( 'All content', 'penshop' ),
			'product' => esc_html__( 'Products only', 'penshop' ),
			'post'    => esc_html__( 'Posts only', 'penshop' ),
		),
		'active_callback' => array(
			array(
				'setting'  => 'menu_icons',
				'operator' => 'contains',
				'value'    => 'search',
			),
		),
	),
	'cart_icon_source'        => array(
		'type'            => 'radio',
		'label'           => esc_html__( 'Shopping Cart Icon Source', 'penshop' ),
		'section'         => 'menu',
		'default'         => 'icon',
		'choices'         => array(
			'icon'  => esc_html__( 'Built-in Icon', 'penshop' ),
			'image' => esc_html__( 'Upload Image', 'penshop' ),
		),
		'active_callback' => array(
			array(
				'setting'  => 'menu_icons',
				'operator' => 'contains',
				'value'    => 'cart',
			),
		),
	),
	'cart_icon'               => array(
		'type'            => 'radio-image',
		'label'           => esc_html__( 'Shopping Cart Icon', 'penshop' ),
		'section'         => 'menu',
		'default'         => 'bag',
		'choices'         => array(
			'bag'    => get_template_directory_uri() . '/assets/images/carts/shopping-bag.png',
			'basket' => get_template_directory_uri() . '/assets/images/carts/shopping-basket.png',
			'cart'   => get_template_directory_uri() . '/assets/images/carts/shopping-cart.png',
		),
		'active_callback' => array(
			array(
				'setting'  => 'menu_icons',
				'operator' => 'contains',
				'value'    => 'cart',
			),
			array(
				'setting'  => 'cart_icon_source',
				'operator' => '==',
				'value'    => 'icon',
			),
		),
	),
	'cart_icon_image'         => array(
		'type'            => 'upload',
		'label'           => esc_html__( 'Shopping Cart Icon', 'penshop' ),
		'section'         => 'menu',
		'active_callback' => array(
			array(
				'setting'  => 'menu_icons',
				'operator' => 'contains',
				'value'    => 'cart',
			),
			array(
				'setting'  => 'cart_icon_source',
				'operator' => '==',
				'value'    => 'image',
			),
		),
	),
	'cart_icon_width'         => array(
		'type'            => 'number',
		'label'           => esc_html__( 'Shopping Cart Icon Width', 'penshop' ),
		'section'         => 'menu',
		'default'         => '16',
		'active_callback' => array(
			array(
				'setting'  => 'menu_icons',
				'operator' => 'contains',
				'value'    => 'cart',
			),
			array(
				'setting'  => 'cart_icon_source',
				'operator' => '==',
				'value'    => 'image',
			),
		),
	),
	'cart_icon_height'        => array(
		'type'            => 'number',
		'label'           => esc_html__( 'Shopping Cart Icon Height', 'penshop' ),
		'section'         => 'menu',
		'default'         => '16',
		'active_callback' => array(
			array(
				'setting'  => 'menu_icons',
				'operator' => 'contains',
				'value'    => 'cart',
			),
			array(
				'setting'  => 'cart_icon_source',
				'operator' => '==',
				'value'    => 'image',
			),
		),
	),
);
