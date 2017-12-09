<?php
/**
 * Register one-click import demo data
 */

add_filter( 'soo_demo_packages', 'penshop_addons_import_register' );

function penshop_addons_import_register() {
	return array(
		array(
			'name'       => 'Home 1',
			'content'    => 'http://penshop.pencidesign.com/demo-data/home1/demo-content.xml',
			'widgets'    => 'http://penshop.pencidesign.com/demo-data/home1/widgets.wie',
			'preview'    => 'http://penshop.pencidesign.com/demo-data/home1/preview.jpg',
			'customizer' => 'http://penshop.pencidesign.com/demo-data/home1/customizer.dat',
			'pages'      => array(
				'front_page' => 'Home 1',
				'blog'       => 'Blog',
				'shop'       => 'Shop',
				'cart'       => 'Cart',
				'checkout'   => 'Checkout',
				'my_account' => 'My Account',
				'portfolio'  => 'Portfolio',
			),
			'menus'      => array(
				'primary'   => 'primary-menu',
				'secondary' => 'secondary-menu',
				'footer'    => 'footer-menu',
			),
			'options'    => array(
				'shop_catalog_image_size'   => array(
					'width'  => 370,
					'height' => 493,
					'crop'   => 1,
				),
				'shop_single_image_size'    => array(
					'width'  => 480,
					'height' => 653,
					'crop'   => 1,
				),
				'shop_thumbnail_image_size' => array(
					'width'  => 105,
					'height' => 140,
					'crop'   => 1,
				),
			),
		),
		array(
			'name'       => 'Home 2',
			'content'    => 'http://penshop.pencidesign.com/demo-data/home2/demo-content.xml',
			'widgets'    => 'http://penshop.pencidesign.com/demo-data/home2/widgets.wie',
			'preview'    => 'http://penshop.pencidesign.com/demo-data/home2/preview.jpg',
			'customizer' => 'http://penshop.pencidesign.com/demo-data/home2/customizer.dat',
			'pages'      => array(
				'front_page' => 'Home 2',
				'blog'       => 'Blog',
				'shop'       => 'Shop',
				'cart'       => 'Cart',
				'checkout'   => 'Checkout',
				'my_account' => 'My Account',
				'portfolio'  => 'Portfolio',
			),
			'menus'      => array(
				'primary'   => 'primary-menu',
				'secondary' => 'secondary-menu',
				'footer'    => 'footer-menu',
			),
			'options'    => array(
				'shop_catalog_image_size'   => array(
					'width'  => 370,
					'height' => 493,
					'crop'   => 1,
				),
				'shop_single_image_size'    => array(
					'width'  => 480,
					'height' => 653,
					'crop'   => 1,
				),
				'shop_thumbnail_image_size' => array(
					'width'  => 105,
					'height' => 140,
					'crop'   => 1,
				),
			),
		),
		array(
			'name'       => 'Home 3',
			'content'    => 'http://penshop.pencidesign.com/demo-data/home3/demo-content.xml',
			'widgets'    => 'http://penshop.pencidesign.com/demo-data/home3/widgets.wie',
			'preview'    => 'http://penshop.pencidesign.com/demo-data/home3/preview.jpg',
			'customizer' => 'http://penshop.pencidesign.com/demo-data/home3/customizer.dat',
			'pages'      => array(
				'front_page' => 'Home 3',
				'blog'       => 'Blog',
				'shop'       => 'Shop',
				'cart'       => 'Cart',
				'checkout'   => 'Checkout',
				'my_account' => 'My Account',
				'portfolio'  => 'Portfolio',
			),
			'menus'      => array(
				'primary'   => 'primary-menu',
				'secondary' => 'secondary-menu',
				'footer'    => 'footer-menu',
			),
			'options'    => array(
				'shop_catalog_image_size'   => array(
					'width'  => 370,
					'height' => 493,
					'crop'   => 1,
				),
				'shop_single_image_size'    => array(
					'width'  => 480,
					'height' => 653,
					'crop'   => 1,
				),
				'shop_thumbnail_image_size' => array(
					'width'  => 105,
					'height' => 140,
					'crop'   => 1,
				),
			),
		),
		array(
			'name'       => 'Home 4',
			'content'    => 'http://penshop.pencidesign.com/demo-data/home4/demo-content.xml',
			'widgets'    => 'http://penshop.pencidesign.com/demo-data/home4/widgets.wie',
			'preview'    => 'http://penshop.pencidesign.com/demo-data/home4/preview.jpg',
			'customizer' => 'http://penshop.pencidesign.com/demo-data/home4/customizer.dat',
			'pages'      => array(
				'front_page' => 'Home 4',
				'blog'       => 'Blog',
				'shop'       => 'Shop',
				'cart'       => 'Cart',
				'checkout'   => 'Checkout',
				'my_account' => 'My Account',
				'portfolio'  => 'Portfolio',
			),
			'menus'      => array(
				'primary'   => 'primary-menu',
				'secondary' => 'secondary-menu',
				'footer'    => 'footer-menu',
			),
			'options'    => array(
				'shop_catalog_image_size'   => array(
					'width'  => 370,
					'height' => 493,
					'crop'   => 1,
				),
				'shop_single_image_size'    => array(
					'width'  => 480,
					'height' => 653,
					'crop'   => 1,
				),
				'shop_thumbnail_image_size' => array(
					'width'  => 105,
					'height' => 140,
					'crop'   => 1,
				),
			),
		),
		array(
			'name'       => 'Home 5',
			'content'    => 'http://penshop.pencidesign.com/demo-data/home5/demo-content.xml',
			'widgets'    => 'http://penshop.pencidesign.com/demo-data/home5/widgets.wie',
			'preview'    => 'http://penshop.pencidesign.com/demo-data/home5/preview.jpg',
			'customizer' => 'http://penshop.pencidesign.com/demo-data/home5/customizer.dat',
			'sliders'    => 'http://penshop.pencidesign.com/demo-data/home5/sliders.zip',
			'pages'      => array(
				'front_page' => 'Shop',
				'blog'       => 'Blog',
				'shop'       => 'Shop',
				'cart'       => 'Cart',
				'checkout'   => 'Checkout',
				'my_account' => 'My Account',
				'portfolio'  => 'Portfolio',
			),
			'menus'      => array(
				'primary'   => 'primary-menu',
				'secondary' => 'secondary-menu',
				'footer'    => 'footer-menu',
			),
			'options'    => array(
				'shop_catalog_image_size'   => array(
					'width'  => 370,
					'height' => 493,
					'crop'   => 1,
				),
				'shop_single_image_size'    => array(
					'width'  => 480,
					'height' => 653,
					'crop'   => 1,
				),
				'shop_thumbnail_image_size' => array(
					'width'  => 105,
					'height' => 140,
					'crop'   => 1,
				),
			),
		),
		array(
			'name'       => 'Home 6',
			'content'    => 'http://penshop.pencidesign.com/demo-data/home6/demo-content.xml',
			'widgets'    => 'http://penshop.pencidesign.com/demo-data/home6/widgets.wie',
			'preview'    => 'http://penshop.pencidesign.com/demo-data/home6/preview.jpg',
			'customizer' => 'http://penshop.pencidesign.com/demo-data/home6/customizer.dat',
			'sliders'    => 'http://penshop.pencidesign.com/demo-data/home6/sliders.zip',
			'pages'      => array(
				'front_page' => 'Home 6',
				'blog'       => 'Blog',
				'shop'       => 'Shop',
				'cart'       => 'Cart',
				'checkout'   => 'Checkout',
				'my_account' => 'My Account',
				'portfolio'  => 'Portfolio',
			),
			'menus'      => array(
				'primary'   => 'primary-menu',
				'secondary' => 'secondary-menu',
				'footer'    => 'footer-menu',
			),
			'options'    => array(
				'shop_catalog_image_size'   => array(
					'width'  => 370,
					'height' => 493,
					'crop'   => 1,
				),
				'shop_single_image_size'    => array(
					'width'  => 480,
					'height' => 653,
					'crop'   => 1,
				),
				'shop_thumbnail_image_size' => array(
					'width'  => 105,
					'height' => 140,
					'crop'   => 1,
				),
			),
		),
		array(
			'name'       => 'Home 7',
			'content'    => 'http://penshop.pencidesign.com/demo-data/home7/demo-content.xml',
			'widgets'    => 'http://penshop.pencidesign.com/demo-data/home7/widgets.wie',
			'preview'    => 'http://penshop.pencidesign.com/demo-data/home7/preview.jpg',
			'customizer' => 'http://penshop.pencidesign.com/demo-data/home7/customizer.dat',
			'pages'      => array(
				'front_page' => 'Home 7',
				'blog'       => 'Blog',
				'shop'       => 'Shop',
				'cart'       => 'Cart',
				'checkout'   => 'Checkout',
				'my_account' => 'My Account',
				'portfolio'  => 'Portfolio',
			),
			'menus'      => array(
				'primary'   => 'primary-menu',
				'secondary' => 'secondary-menu',
				'footer'    => 'footer-menu',
			),
			'options'    => array(
				'shop_catalog_image_size'   => array(
					'width'  => 370,
					'height' => 493,
					'crop'   => 1,
				),
				'shop_single_image_size'    => array(
					'width'  => 480,
					'height' => 653,
					'crop'   => 1,
				),
				'shop_thumbnail_image_size' => array(
					'width'  => 105,
					'height' => 140,
					'crop'   => 1,
				),
			),
		),
		array(
			'name'       => 'Home 8',
			'content'    => 'http://penshop.pencidesign.com/demo-data/home8/demo-content.xml',
			'widgets'    => 'http://penshop.pencidesign.com/demo-data/home8/widgets.wie',
			'preview'    => 'http://penshop.pencidesign.com/demo-data/home8/preview.jpg',
			'customizer' => 'http://penshop.pencidesign.com/demo-data/home8/customizer.dat',
			'pages'      => array(
				'front_page' => 'Home 8',
				'blog'       => 'Blog',
				'shop'       => 'Shop',
				'cart'       => 'Cart',
				'checkout'   => 'Checkout',
				'my_account' => 'My Account',
				'portfolio'  => 'Portfolio',
			),
			'menus'      => array(
				'primary'   => 'primary-menu',
				'secondary' => 'secondary-menu',
				'footer'    => 'footer-menu',
			),
			'options'    => array(
				'shop_catalog_image_size'   => array(
					'width'  => 370,
					'height' => 493,
					'crop'   => 1,
				),
				'shop_single_image_size'    => array(
					'width'  => 480,
					'height' => 653,
					'crop'   => 1,
				),
				'shop_thumbnail_image_size' => array(
					'width'  => 105,
					'height' => 140,
					'crop'   => 1,
				),
			),
		),
		array(
			'name'       => 'Home 9',
			'content'    => 'http://penshop.pencidesign.com/demo-data/home9/demo-content.xml',
			'widgets'    => 'http://penshop.pencidesign.com/demo-data/home9/widgets.wie',
			'preview'    => 'http://penshop.pencidesign.com/demo-data/home9/preview.jpg',
			'customizer' => 'http://penshop.pencidesign.com/demo-data/home9/customizer.dat',
			'pages'      => array(
				'front_page' => 'Home 9',
				'blog'       => 'Blog',
				'shop'       => 'Shop',
				'cart'       => 'Cart',
				'checkout'   => 'Checkout',
				'my_account' => 'My Account',
				'portfolio'  => 'Portfolio',
			),
			'menus'      => array(
				'primary'   => 'primary-menu',
				'secondary' => 'secondary-menu',
				'footer'    => 'footer-menu',
			),
			'options'    => array(
				'shop_catalog_image_size'   => array(
					'width'  => 370,
					'height' => 493,
					'crop'   => 1,
				),
				'shop_single_image_size'    => array(
					'width'  => 480,
					'height' => 653,
					'crop'   => 1,
				),
				'shop_thumbnail_image_size' => array(
					'width'  => 105,
					'height' => 140,
					'crop'   => 1,
				),
			),
		),
		array(
			'name'       => 'Home 10',
			'content'    => 'http://penshop.pencidesign.com/demo-data/home10/demo-content.xml',
			'widgets'    => 'http://penshop.pencidesign.com/demo-data/home10/widgets.wie',
			'preview'    => 'http://penshop.pencidesign.com/demo-data/home10/preview.jpg',
			'customizer' => 'http://penshop.pencidesign.com/demo-data/home10/customizer.dat',
			'pages'      => array(
				'front_page' => 'Home 10',
				'blog'       => 'Blog',
				'shop'       => 'Shop',
				'cart'       => 'Cart',
				'checkout'   => 'Checkout',
				'my_account' => 'My Account',
				'portfolio'  => 'Portfolio',
			),
			'menus'      => array(
				'primary'   => 'primary-menu',
				'secondary' => 'secondary-menu',
				'footer'    => 'footer-menu',
			),
			'options'    => array(
				'shop_catalog_image_size'   => array(
					'width'  => 370,
					'height' => 493,
					'crop'   => 1,
				),
				'shop_single_image_size'    => array(
					'width'  => 480,
					'height' => 653,
					'crop'   => 1,
				),
				'shop_thumbnail_image_size' => array(
					'width'  => 105,
					'height' => 140,
					'crop'   => 1,
				),
			),
		),
	);
}

add_action( 'soodi_after_setup_pages', 'penshop_addons_import_portfolio_page' );

/**
 * Update more page options
 *
 * @param $pages
 */
function penshop_addons_import_portfolio_page( $pages ) {
	if ( isset( $pages['portfolio'] ) ) {
		$portfolio = get_page_by_title( $pages['portfolio'] );

		if ( $portfolio ) {
			update_option( 'penshop_portfolio_page_id', $portfolio->ID );
		}
	}
}

add_action( 'soodi_before_import_content', 'penshop_addons_import_product_attributes' );

/**
 * Prepare product attributes before import demo content
 *
 * @param $file
 */
function penshop_addons_import_product_attributes( $file ) {
	global $wpdb;

	if ( ! class_exists( 'WXR_Parser' ) ) {
		require_once WP_PLUGIN_DIR . '/penci-demo-importer/includes/parsers.php';
	}

	$parser      = new WXR_Parser();
	$import_data = $parser->parse( $file );

	if ( isset( $import_data['posts'] ) ) {
		$posts = $import_data['posts'];

		if ( $posts && sizeof( $posts ) > 0 ) {
			foreach ( $posts as $post ) {
				if ( 'product' === $post['post_type'] ) {
					if ( ! empty( $post['terms'] ) ) {
						foreach ( $post['terms'] as $term ) {
							if ( strstr( $term['domain'], 'pa_' ) ) {
								if ( ! taxonomy_exists( $term['domain'] ) ) {
									$attribute_name = wc_sanitize_taxonomy_name( str_replace( 'pa_', '', $term['domain'] ) );

									// Create the taxonomy
									if ( ! in_array( $attribute_name, wc_get_attribute_taxonomies() ) ) {
										$attribute = array(
											'attribute_label'   => $attribute_name,
											'attribute_name'    => $attribute_name,
											'attribute_type'    => 'select',
											'attribute_orderby' => 'menu_order',
											'attribute_public'  => 0
										);
										$wpdb->insert( $wpdb->prefix . 'woocommerce_attribute_taxonomies', $attribute );
										delete_transient( 'wc_attribute_taxonomies' );
									}

									// Register the taxonomy now so that the import works!
									register_taxonomy(
										$term['domain'],
										apply_filters( 'woocommerce_taxonomy_objects_' . $term['domain'], array( 'product' ) ),
										apply_filters( 'woocommerce_taxonomy_args_' . $term['domain'], array(
											'hierarchical' => true,
											'show_ui'      => false,
											'query_var'    => true,
											'rewrite'      => false,
										) )
									);
								}
							}
						}
					}
				}
			}
		}
	}
}