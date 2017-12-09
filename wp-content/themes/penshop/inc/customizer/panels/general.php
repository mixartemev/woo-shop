<?php
/**
 * Setting fields of General panel
 *
 * @package    PenShop
 * @subpackage Customizer
 */

return array(
	'layout_default' => array(
		'type'        => 'radio-image',
		'label'       => esc_html__( 'Default Layout', 'penshop' ),
		'description' => esc_html__( 'Default layout of blog and other pages', 'penshop' ),
		'section'     => 'layout',
		'default'     => 'content-sidebar',
		'choices'     => array(
			'no-sidebar'      => get_template_directory_uri() . '/assets/images/layout/no-sidebar.png',
			'sidebar-content' => get_template_directory_uri() . '/assets/images/layout/sidebar-content.png',
			'content-sidebar' => get_template_directory_uri() . '/assets/images/layout/content-sidebar.png',
		),
	),
	'layout_post'    => array(
		'type'        => 'radio-image',
		'label'       => esc_html__( 'Post Layout', 'penshop' ),
		'description' => esc_html__( 'Default layout of single post', 'penshop' ),
		'section'     => 'layout',
		'default'     => 'content-sidebar',
		'choices'     => array(
			'no-sidebar'      => get_template_directory_uri() . '/assets/images/layout/no-sidebar.png',
			'sidebar-content' => get_template_directory_uri() . '/assets/images/layout/sidebar-content.png',
			'content-sidebar' => get_template_directory_uri() . '/assets/images/layout/content-sidebar.png',
		),
	),
	'layout_page'    => array(
		'type'        => 'radio-image',
		'label'       => esc_html__( 'Page Layout', 'penshop' ),
		'description' => esc_html__( 'Default layout of pages', 'penshop' ),
		'section'     => 'layout',
		'default'     => 'no-sidebar',
		'choices'     => array(
			'no-sidebar'      => get_template_directory_uri() . '/assets/images/layout/no-sidebar.png',
			'sidebar-content' => get_template_directory_uri() . '/assets/images/layout/sidebar-content.png',
			'content-sidebar' => get_template_directory_uri() . '/assets/images/layout/content-sidebar.png',
		),
	),
	'layout_shop'    => array(
		'type'        => 'radio-image',
		'label'       => esc_html__( 'Shop Layout', 'penshop' ),
		'description' => esc_html__( 'Default layout of shop pages', 'penshop' ),
		'section'     => 'layout',
		'default'     => 'no-sidebar',
		'choices'     => array(
			'no-sidebar'      => get_template_directory_uri() . '/assets/images/layout/no-sidebar.png',
			'sidebar-content' => get_template_directory_uri() . '/assets/images/layout/sidebar-content.png',
			'content-sidebar' => get_template_directory_uri() . '/assets/images/layout/content-sidebar.png',
		),
	),
	'layout_product'    => array(
		'type'        => 'radio-image',
		'label'       => esc_html__( 'Product Layout', 'penshop' ),
		'description' => esc_html__( 'Default layout of product page', 'penshop' ),
		'section'     => 'layout',
		'default'     => 'no-sidebar',
		'choices'     => array(
			'no-sidebar'      => get_template_directory_uri() . '/assets/images/layout/no-sidebar.png',
			'sidebar-content' => get_template_directory_uri() . '/assets/images/layout/sidebar-content.png',
			'content-sidebar' => get_template_directory_uri() . '/assets/images/layout/content-sidebar.png',
		),
	),
	'sidebar_sticky'      => array(
		'type'        => 'toggle',
		'label'       => esc_html__( 'Sticky Sidebar', 'penshop' ),
		'description' => esc_html__( 'Make the sidebar always visible when scrolling', 'penshop' ),
		'section'     => 'sidebar',
		'default'     => false,
	),
	'popup'                          => array(
		'type'        => 'toggle',
		'label'       => esc_html__( 'Enable Popup', 'penshop' ),
		'description' => esc_html__( 'Show a popup after website loaded.', 'penshop' ),
		'section'     => 'popup',
		'default'     => false,
	),
	'popup_image'                    => array(
		'type'            => 'image',
		'label'           => esc_html__( 'Banner Image', 'penshop' ),
		'description'     => esc_html__( 'Upload popup banner image', 'penshop' ),
		'section'         => 'popup',
		'active_callback' => array(
			array(
				'setting'  => 'popup',
				'operator' => '==',
				'value'    => true,
			)
		),
	),
	'popup_content'                  => array(
		'type'            => 'textarea',
		'label'           => esc_html__( 'Popup Content', 'penshop' ),
		'description'     => esc_html__( 'Enter popup content. HTML and shortcodes are allowed.', 'penshop' ),
		'section'         => 'popup',
		'active_callback' => array(
			array(
				'setting'  => 'popup',
				'operator' => '==',
				'value'    => true,
			),
		),
	),
	'popup_frequency'                => array(
		'type'            => 'number',
		'label'           => esc_html__( 'Frequency', 'penshop' ),
		'description'     => esc_html__( 'Do NOT show the popup to the same visitor again until this much day has passed.', 'penshop' ),
		'section'         => 'popup',
		'default'         => 1,
		'choices'         => array(
			'min'  => 0,
			'step' => 1,
		),
		'active_callback' => array(
			array(
				'setting'  => 'popup',
				'operator' => '==',
				'value'    => true,
			),
		),
	),
	'popup_visible'                  => array(
		'type'            => 'select',
		'label'           => esc_html__( 'Popup Visible', 'penshop' ),
		'description'     => esc_html__( 'Select when the popup appear', 'penshop' ),
		'section'         => 'popup',
		'default'         => 'loaded',
		'choices'         => array(
			'loaded' => esc_html__( 'Right after page loads', 'penshop' ),
			'delay'  => esc_html__( 'Wait for seconds', 'penshop' ),
		),
		'active_callback' => array(
			array(
				'setting'  => 'popup',
				'operator' => '==',
				'value'    => true,
			),
		),
	),
	'popup_visible_delay'            => array(
		'type'            => 'number',
		'label'           => esc_html__( 'Delay Time', 'penshop' ),
		'description'     => esc_html__( 'Set how many seconds after the page loads before the popup is displayed.', 'penshop' ),
		'section'         => 'popup',
		'default'         => 5,
		'choices'         => array(
			'min'  => 0,
			'step' => 1,
		),
		'active_callback' => array(
			array(
				'setting'  => 'popup',
				'operator' => '==',
				'value'    => true,
			),
			array(
				'setting'  => 'popup_visible',
				'operator' => '==',
				'value'    => 'delay',
			),
		),
	),
);