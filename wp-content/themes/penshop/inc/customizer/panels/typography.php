<?php
/**
 * Setting fields of Typography
 *
 * @package    PenShop
 * @subpackage Customizer
 */

return array(
	// Typography body
	'typo_body'                      => array(
		'type'        => 'typography',
		'label'       => esc_html__( 'Body', 'penshop' ),
		'description' => esc_html__( 'Customize the body font', 'penshop' ),
		'section'     => 'typo_main',
		'default'     => array(
			'font-family' => 'Roboto',
			'variant'     => '400',
			'font-size'   => '15px',
			'line-height' => '1.7',
			'color'       => '#666666',
			'subsets'     => array( 'latin-ext' ),
		),
	),
	'typo_link'                      => array(
		'type'        => 'typography',
		'label'       => esc_html__( 'Link', 'penshop' ),
		'description' => esc_html__( 'Customize the link color', 'penshop' ),
		'section'     => 'typo_main',
		'default'     => array(
			'color' => '#111111',
		),
	),
	'typo_link_hover'                => array(
		'type'        => 'typography',
		'label'       => esc_html__( 'Link Hover', 'penshop' ),
		'description' => esc_html__( 'Customize the link color when hover, visited', 'penshop' ),
		'section'     => 'typo_main',
		'default'     => array(
			'color' => '#111111',
		),
	),
	// Typography headings
	'typo_h1'                        => array(
		'type'        => 'typography',
		'label'       => esc_html__( 'Heading 1', 'penshop' ),
		'description' => esc_html__( 'Customize the H1 font', 'penshop' ),
		'section'     => 'typo_headings',
		'default'     => array(
			'font-family'    => 'Poppins',
			'variant'        => '600',
			'font-size'      => '30px',
			'line-height'    => '1.7',
			'color'          => '#111111',
			'text-transform' => 'none',
			'subsets'        => array( 'latin-ext' ),
		),
	),
	'typo_h2'                        => array(
		'type'        => 'typography',
		'label'       => esc_html__( 'Heading 2', 'penshop' ),
		'description' => esc_html__( 'Customize the H2 font', 'penshop' ),
		'section'     => 'typo_headings',
		'default'     => array(
			'font-family'    => 'Poppins',
			'variant'        => '600',
			'font-size'      => '24px',
			'line-height'    => '1.7',
			'color'          => '#111111',
			'text-transform' => 'none',
			'subsets'        => array( 'latin-ext' ),
		),
	),
	'typo_h3'                        => array(
		'type'        => 'typography',
		'label'       => esc_html__( 'Heading 3', 'penshop' ),
		'description' => esc_html__( 'Customize the H3 font', 'penshop' ),
		'section'     => 'typo_headings',
		'default'     => array(
			'font-family'    => 'Poppins',
			'variant'        => '600',
			'font-size'      => '18px',
			'line-height'    => '1.7',
			'color'          => '#111111',
			'text-transform' => 'none',
			'subsets'        => array( 'latin-ext' ),
		),
	),
	'typo_h4'                        => array(
		'type'        => 'typography',
		'label'       => esc_html__( 'Heading 4', 'penshop' ),
		'description' => esc_html__( 'Customize the H4 font', 'penshop' ),
		'section'     => 'typo_headings',
		'default'     => array(
			'font-family'    => 'Poppins',
			'variant'        => '600',
			'font-size'      => '15px',
			'line-height'    => '1.7',
			'color'          => '#111111',
			'text-transform' => 'none',
			'subsets'        => array( 'latin-ext' ),
		),
	),
	'typo_h5'                        => array(
		'type'        => 'typography',
		'label'       => esc_html__( 'Heading 5', 'penshop' ),
		'description' => esc_html__( 'Customize the H5 font', 'penshop' ),
		'section'     => 'typo_headings',
		'default'     => array(
			'font-family'    => 'Poppins',
			'variant'        => '600',
			'font-size'      => '12px',
			'line-height'    => '1.7',
			'color'          => '#111111',
			'text-transform' => 'none',
			'subsets'        => array( 'latin-ext' ),
		),
	),
	'typo_h6'                        => array(
		'type'        => 'typography',
		'label'       => esc_html__( 'Heading 6', 'penshop' ),
		'description' => esc_html__( 'Customize the H6 font', 'penshop' ),
		'section'     => 'typo_headings',
		'default'     => array(
			'font-family'    => 'Poppins',
			'variant'        => '600',
			'font-size'      => '10px',
			'line-height'    => '1.7',
			'color'          => '#111111',
			'text-transform' => 'none',
			'subsets'        => array( 'latin-ext' ),
		),
	),
	// Typography header
	'typo_menu'                      => array(
		'type'        => 'typography',
		'label'       => esc_html__( 'Menu', 'penshop' ),
		'description' => esc_html__( 'Customize the menu font', 'penshop' ),
		'section'     => 'typo_header',
		'default'     => array(
			'font-family'    => 'Poppins',
			'variant'        => '600',
			'font-size'      => '16px',
			'color'          => '#111111',
			'text-transform' => 'uppercase',
			'subsets'        => array( 'latin-ext' ),
		),
	),
	'typo_submenu'                   => array(
		'type'        => 'typography',
		'label'       => esc_html__( 'Sub-Menu', 'penshop' ),
		'description' => esc_html__( 'Customize the sub-menu font', 'penshop' ),
		'section'     => 'typo_header',
		'default'     => array(
			'font-family'    => 'Poppins',
			'variant'        => '400',
			'font-size'      => '14px',
			'line-height'    => '2.14',
			'color'          => '#888',
			'text-transform' => 'none',
			'subsets'        => array( 'latin-ext' ),
		),
	),
	// Typography page header
	'typo_page_header_title'         => array(
		'type'            => 'typography',
		'label'           => esc_html__( 'Page Header Title', 'penshop' ),
		'description'     => esc_html__( 'Customize the page header title font', 'penshop' ),
		'section'         => 'typo_page_header',
		'default'         => array(
			'font-family'    => 'Poppins',
			'variant'        => '700',
			'font-size'      => '48px',
			'line-height'    => '1.2',
			'text-transform' => 'uppercase',
			'subsets'        => array( 'latin-ext' ),
		),
	),
	'typo_breadcrumb'                => array(
		'type'        => 'typography',
		'label'       => esc_html__( 'Breadcrumb', 'penshop' ),
		'description' => esc_html__( 'Customize the breadcrumb font', 'penshop' ),
		'section'     => 'typo_page_header',
		'default'     => array(
			'font-family'    => 'Poppins',
			'variant'        => '400',
			'font-size'      => '12px',
			'text-transform' => 'none',
			'subsets'        => array( 'latin-ext' ),
		),
	),
	// Typography widgets
	'type_widget_title'              => array(
		'type'        => 'typography',
		'label'       => esc_html__( 'Widget Title', 'penshop' ),
		'description' => esc_html__( 'Customize the widget title font', 'penshop' ),
		'section'     => 'typo_widgets',
		'default'     => array(
			'font-family'    => 'Poppins',
			'variant'        => '600',
			'font-size'      => '14px',
			'text-transform' => 'uppercase',
			'subsets'        => array( 'latin-ext' ),
		),
	),
	// Typography footer
	'type_footer_info'               => array(
		'type'        => 'typography',
		'label'       => esc_html__( 'Footer Info', 'penshop' ),
		'description' => esc_html__( 'Customize the font of footer menu and text', 'penshop' ),
		'section'     => 'typo_footer',
		'default'     => array(
			'font-family' => 'Poppins',
			'variant'     => '400',
			'font-size'   => '12px',
			'subsets'     => array( 'latin-ext' ),
		),
	),
);