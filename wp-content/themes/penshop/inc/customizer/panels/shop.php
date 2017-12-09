<?php
/**
 * Setting fields of Shop
 *
 * @package    PenShop
 * @subpackage Customizer
 */

return array(
	// Shop General
	'wc_auto_open_cart'      => array(
		'type'        => 'toggle',
		'label'       => esc_html__( 'Auto Open Cart Panel', 'penshop' ),
		'description' => esc_html__( 'Open the cart modal after successful addition', 'penshop' ),
		'section'     => 'shop_general',
		'default'     => false,
	),
	'wc_sold_out_badge'      => array(
		'type'        => 'toggle',
		'label'       => esc_html__( 'Sold Out Ribbon', 'penshop' ),
		'description' => esc_html__( 'Display the "Sold Out" badge for out of stock products', 'penshop' ),
		'section'     => 'shop_general',
		'default'     => false,
	),

	// Shop catalog
	'shop_layout'            => array(
		'type'    => 'radio',
		'label'   => esc_html__( 'Shop Layout', 'penshop' ),
		'section' => 'shop_catalog',
		'default' => 'grid',
		'choices' => array(
			'grid' => esc_html__( 'Grid', 'penshop' ),
			'list' => esc_html__( 'List', 'penshop' ),
		),
	),
	'shop_container'         => array(
		'type'            => 'select',
		'label'           => esc_html__( 'Shop Container', 'penshop' ),
		'description'     => esc_html__( 'Select the products container width', 'penshop' ),
		'section'         => 'shop_catalog',
		'default'         => 'wrapped',
		'choices'         => array(
			'wrapped'    => esc_html__( 'Wrapped', 'penshop' ),
			'full-width' => esc_html__( 'Full Width', 'penshop' ),
		),
		'active_callback' => array(
			array(
				'setting'  => 'shop_layout',
				'operator' => '==',
				'value'    => 'grid',
			),
		),
	),
	'shop_columns'           => array(
		'type'            => 'select',
		'label'           => esc_html__( 'Shop Columns', 'penshop' ),
		'section'         => 'shop_catalog',
		'default'         => '4',
		'choices'         => array(
			'3' => esc_html__( '3 Columns', 'penshop' ),
			'4' => esc_html__( '4 Columns', 'penshop' ),
			'5' => esc_html__( '5 Columns', 'penshop' ),
			'6' => esc_html__( '6 Columns', 'penshop' ),
		),
		'active_callback' => array(
			array(
				'setting'  => 'shop_layout',
				'operator' => '==',
				'value'    => 'grid',
			),
		),
	),
	'shop_products_per_page' => array(
		'type'    => 'number',
		'label'   => esc_html__( 'Products Per Page', 'penshop' ),
		'section' => 'shop_catalog',
		'default' => 12,
	),
	'shop_custom_field_1'    => array(
		'type'    => 'custom',
		'section' => 'shop_catalog',
		'default' => '<hr/>',
	),
	'shop_toolbar'           => array(
		'type'        => 'toggle',
		'label'       => esc_html__( 'Shop Toolbar', 'penshop' ),
		'description' => esc_html__( 'Enable shop toolbar on the top of catalog pages', 'penshop' ),
		'section'     => 'shop_catalog',
		'default'     => true,
	),
	'shop_quick_access'      => array(
		'type'            => 'toggle',
		'label'           => esc_html__( 'Quick Access', 'penshop' ),
		'description'     => esc_html__( 'Display quick access links in Shop Toolbar', 'penshop' ),
		'section'         => 'shop_catalog',
		'default'         => true,
		'active_callback' => array(
			array(
				'setting'  => 'shop_toolbar',
				'operator' => '==',
				'value'    => true,
			),
		),
	),
	'shop_quick_access_type' => array(
		'type'            => 'select',
		'label'           => esc_html__( 'Quick Access Type', 'penshop' ),
		'description'     => esc_html__( 'Select what type to display as quick access', 'penshop' ),
		'section'         => 'shop_catalog',
		'default'         => 'category',
		'choices'         => array(
			'category' => esc_html__( 'Categories', 'penshop' ),
			'tag'      => esc_html__( 'Tags', 'penshop' ),
		),
		'active_callback' => array(
			array(
				'setting'  => 'shop_toolbar',
				'operator' => '==',
				'value'    => true,
			),
			array(
				'setting'  => 'shop_quick_access',
				'operator' => '==',
				'value'    => true,
			),
		),
	),
	'shop_quick_access_cats' => array(
		'type'            => 'select',
		'label'           => esc_html__( 'Quick Access Categories', 'penshop' ),
		'description'     => esc_html__( 'Select categories for quick access', 'penshop' ),
		'section'         => 'shop_catalog',
		'multiple'        => 6,
		'choices'         => get_terms( array(
			'taxonomy'   => 'product_cat',
			'fields'     => 'id=>name',
			'hide_empty' => false,
		) ),
		'active_callback' => array(
			array(
				'setting'  => 'shop_toolbar',
				'operator' => '==',
				'value'    => true,
			),
			array(
				'setting'  => 'shop_quick_access',
				'operator' => '==',
				'value'    => true,
			),
			array(
				'setting'  => 'shop_quick_access_type',
				'operator' => '==',
				'value'    => 'category',
			),
		),
	),
	'shop_quick_access_tags' => array(
		'type'            => 'text',
		'label'           => esc_html__( 'Tags', 'penshop' ),
		'description'     => esc_html__( 'Enter tags for filter tabs. Separate by commas.', 'penshop' ),
		'section'         => 'shop_catalog',
		'default'         => '',
		'active_callback' => array(
			array(
				'setting'  => 'shop_toolbar',
				'operator' => '==',
				'value'    => true,
			),
			array(
				'setting'  => 'shop_quick_access',
				'operator' => '==',
				'value'    => true,
			),
			array(
				'setting'  => 'shop_quick_access_type',
				'operator' => '==',
				'value'    => 'tag',
			),
		),
	),
	'shop_toolbar_filter'    => array(
		'type'            => 'toggle',
		'label'           => esc_html__( 'Products Filter', 'penshop' ),
		'description'     => esc_html__( 'Show filter icon on the Shop Toolbar', 'penshop' ),
		'tooltip'         => esc_html__( 'This requires Shop Filter sidebar must has at least one widget.', 'penshop' ),
		'section'         => 'shop_catalog',
		'default'         => true,
		'active_callback' => array(
			array(
				'setting'  => 'shop_toolbar',
				'operator' => '==',
				'value'    => true,
			),
		),
	),
	'shop_toolbar_search'    => array(
		'type'            => 'toggle',
		'label'           => esc_html__( 'Products Search', 'penshop' ),
		'description'     => esc_html__( 'Show the search icon on the Shop Toolbar', 'penshop' ),
		'section'         => 'shop_catalog',
		'default'         => true,
		'active_callback' => array(
			array(
				'setting'  => 'shop_toolbar',
				'operator' => '==',
				'value'    => true,
			),
		),
	),
	'shop_toolbar_sort'      => array(
		'type'            => 'toggle',
		'label'           => esc_html__( 'Products Ordering', 'penshop' ),
		'description'     => esc_html__( 'Show the product ordering dropdown', 'penshop' ),
		'section'         => 'shop_catalog',
		'default'         => false,
		'active_callback' => array(
			array(
				'setting'  => 'shop_toolbar',
				'operator' => '==',
				'value'    => true,
			),
		),
	),
	'shop_custom_field_2'    => array(
		'type'    => 'custom',
		'section' => 'shop_catalog',
		'default' => '<hr/>',
	),
	'shop_product_style'     => array(
		'type'        => 'radio',
		'label'       => esc_html__( 'Product Style', 'penshop' ),
		'description' => esc_html__( 'Select a style for product item in grid', 'penshop' ),
		'section'     => 'shop_catalog',
		'default'     => 'default',
		'choices'     => array(
			'default'        => esc_html__( 'Default', 'penshop' ),
			'hidden_buttons' => esc_html__( 'Hidden Buttons', 'penshop' ),
			'dark_name'      => esc_html__( 'Dark Name Bar', 'penshop' ),
		),
		'active_callback' => array(
			array(
				'setting'  => 'shop_layout',
				'operator' => '==',
				'value'    => 'grid',
			),
		),
	),
	'shop_thumbnail_hover'   => array(
		'type'        => 'toggle',
		'label'       => esc_html__( 'Secondary Thumbnail', 'penshop' ),
		'description' => esc_html__( 'Show different product thumbnail when hover', 'penshop' ),
		'section'     => 'shop_catalog',
		'default'     => true,
	),
	'shop_quick_view_button' => array(
		'type'        => 'toggle',
		'label'       => esc_html__( 'Quick View Button', 'penshop' ),
		'description' => esc_html__( 'Show the quick view button when hover', 'penshop' ),
		'section'     => 'shop_catalog',
		'default'     => true,
		'active_callback' => array(
			array(
				'setting'  => 'shop_product_style',
				'operator' => '!=',
				'value'    => 'dark_name',
			),
		),
	),
	'shop_star_rating'       => array(
		'type'        => 'toggle',
		'label'       => esc_html__( 'Show Star Rating', 'penshop' ),
		'description' => esc_html__( 'Show the star rating on the catalog pages', 'penshop' ),
		'section'     => 'shop_catalog',
		'default'     => false,
	),
	'shop_custom_field_3'    => array(
		'type'    => 'custom',
		'section' => 'shop_catalog',
		'default' => '<hr/>',
	),
	'shop_nav_type'          => array(
		'type'    => 'radio',
		'label'   => esc_html__( 'Navigation Type', 'penshop' ),
		'section' => 'shop_catalog',
		'default' => 'links',
		'choices' => array(
			'links'    => esc_html__( 'Numeric', 'penshop' ),
			'ajax'     => esc_html__( 'Load more button', 'penshop' ),
			'infinite' => esc_html__( 'Infinite Loading', 'penshop' ),
		),
	),
	// Product
	'product_share'          => array(
		'type'        => 'multicheck',
		'label'       => esc_html__( 'Product Share', 'penshop' ),
		'description' => esc_html__( 'Select social media for sharing products', 'penshop' ),
		'section'     => 'shop_product',
		'default'     => array( 'facebook', 'twitter', 'pinterest', 'googleplus', 'tumblr', 'email' ),
		'choices'     => array(
			'facebook'   => esc_html__( 'Facebook', 'penshop' ),
			'twitter'    => esc_html__( 'Twitter', 'penshop' ),
			'pinterest'  => esc_html__( 'Pinterest', 'penshop' ),
			'googleplus' => esc_html__( 'Google Plus', 'penshop' ),
			'tumblr'     => esc_html__( 'Tumblr', 'penshop' ),
			'email'      => esc_html__( 'Email', 'penshop' ),
		),
	),
);