<?php
/**
 * Registering meta boxes
 *
 * All the definitions of meta boxes are listed below with comments.
 *
 * For more information, please visit:
 * @link    http://www.deluxeblogtips.com/meta-box/
 *
 * @package PenShop
 */


/**
 * Registering meta boxes
 *
 * Using Meta Box plugin: http://www.deluxeblogtips.com/meta-box/
 *
 * @see http://www.deluxeblogtips.com/meta-box/docs/define-meta-boxes
 *
 * @param array $meta_boxes Default meta boxes. By default, there are no meta boxes.
 *
 * @return array All registered meta boxes
 */
function penshop_register_meta_boxes( $meta_boxes ) {
	// Display Settings
	$meta_boxes[] = array(
		'id'       => 'display-settings',
		'title'    => esc_html__( 'Display Settings', 'penshop' ),
		'pages'    => array( 'page' ),
		'context'  => 'normal',
		'priority' => 'high',
		'fields'   => array(
			array(
				'name' => esc_html__( 'Site Header', 'penshop' ),
				'id'   => 'heading_site_header',
				'type' => 'heading',
			),
			array(
				'name'    => esc_html__( 'Header Background', 'penshop' ),
				'id'      => 'header_color_scheme',
				'type'    => 'select',
				'options' => array(
					''            => esc_html__( 'Default', 'penshop' ),
					'dark'        => esc_html__( 'Dark', 'penshop' ),
					'light'       => esc_html__( 'Light', 'penshop' ),
					'transparent' => esc_html__( 'Transparent', 'penshop' ),
				),
			),
			array(
				'name'    => esc_html__( 'Header Text Color', 'penshop' ),
				'desc'    => esc_html__( 'This option only works if the header background is transparent', 'penshop' ),
				'id'      => 'header_text_color',
				'class'   => 'header_text_color',
				'type'    => 'select',
				'options' => array(
					''      => esc_html__( 'Default', 'penshop' ),
					'dark'  => esc_html__( 'Dark', 'penshop' ),
					'light' => esc_html__( 'Light', 'penshop' ),
				),
			),
			array(
				'name' => esc_html__( 'Page Header', 'penshop' ),
				'id'   => 'heading_page_header',
				'type' => 'heading',
			),
			array(
				'name' => esc_html__( 'Hide Page Header', 'penshop' ),
				'id'   => 'hide_page_header',
				'type' => 'checkbox',
				'std'  => false,
			),
			array(
				'name'             => esc_html__( 'Page Header Image', 'penshop' ),
				'id'               => 'page_header_image',
				'class'            => 'page-header-field',
				'type'             => 'image_advanced',
				'max_file_uploads' => 1,
			),
			array(
				'name'    => esc_html__( 'Image Position', 'penshop' ),
				'id'      => 'page_header_image_position',
				'class'   => 'page-header-field page-header-position',
				'type'    => 'select',
				'options' => array(
					''              => esc_html__( 'Default', 'penshop' ),
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
			),
			array(
				'name'    => esc_html__( 'Image Position Vertical', 'penshop' ),
				'id'      => 'page_header_image_position_x',
				'class'   => 'page-header-field page-header-position page-header-position-desktop',
				'type'    => 'slider',
				'std'     => 50,
				'options' => array(
					'min'  => 0,
					'max'  => 100,
					'step' => 1,
				),
			),
			array(
				'name'    => esc_html__( 'Image Position Horizontal', 'penshop' ),
				'id'      => 'page_header_image_position_y',
				'class'   => 'page-header-field page-header-position page-header-position-desktop',
				'type'    => 'slider',
				'std'     => 50,
				'options' => array(
					'min'  => 0,
					'max'  => 100,
					'step' => 1,
				),
			),
			array(
				'name'    => esc_html__( 'Image Position (Mobile)', 'penshop' ),
				'id'      => 'page_header_image_mobile_position',
				'class'   => 'page-header-field page-header-position',
				'type'    => 'select',
				'options' => array(
					''              => esc_html__( 'Default', 'penshop' ),
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
			),
			array(
				'name'    => esc_html__( 'Image Position Vertical (Mobile)', 'penshop' ),
				'id'      => 'page_header_image_mobile_position_x',
				'class'   => 'page-header-field page-header-position page-header-position-mobile',
				'type'    => 'slider',
				'std'     => 50,
				'options' => array(
					'min'  => 0,
					'max'  => 100,
					'step' => 1,
				),
			),
			array(
				'name'    => esc_html__( 'Image Position Horizontal (Mobile)', 'penshop' ),
				'id'      => 'page_header_image_mobile_position_y',
				'class'   => 'page-header-field page-header-position page-header-position-mobile',
				'type'    => 'slider',
				'std'     => 50,
				'options' => array(
					'min'  => 0,
					'max'  => 100,
					'step' => 1,
				),
			),
			array(
				'name'    => esc_html__( 'Page Header Text Color', 'penshop' ),
				'id'      => 'page_header_text_color',
				'class'   => 'page-header-field',
				'type'    => 'select',
				'options' => array(
					''      => esc_html__( 'Default', 'penshop' ),
					'dark'  => esc_html__( 'Dark', 'penshop' ),
					'light' => esc_html__( 'Light', 'penshop' ),
				),
			),
			array(
				'name'  => esc_html__( 'Hide Breadcrumb', 'penshop' ),
				'desc'  => esc_html__( 'Remove the breadcrumb from page header', 'penshop' ),
				'id'    => 'hide_breadcrumbs',
				'class' => 'page-header-field',
				'type'  => 'checkbox',
				'std'   => false,
			),
			array(
				'name'  => esc_html__( 'Hide Page Title', 'penshop' ),
				'id'    => 'hide_page_title',
				'class' => 'hide-page-title',
				'type'  => 'checkbox',
				'std'   => false,
			),
			array(
				'name'  => esc_html__( 'Custom Spacing', 'penshop' ),
				'desc'  => esc_html__( 'Edit the top and bottom spacing of page header', 'penshop' ),
				'id'    => 'page_header_custom_spacing',
				'class' => 'page-header-field',
				'type'  => 'checkbox',
				'std'   => false,
			),
			array(
				'name'  => esc_html__( 'Spacing', 'penshop' ),
				'desc'  => esc_html__( 'The value must includes unit. For example 100px or 10em. Allowed units are px, em, rem, %.', 'penshop' ),
				'id'    => 'page_header_spacing',
				'class' => 'page-header-spacing page-header-field',
				'type'  => 'group',
				'fields'   => array(
					array(
						'before'  => esc_html__( 'Top', 'penshop' ),
						'id'    => 'top',
						'type'  => 'text',
					),
					array(
						'before'  => esc_html__( 'Bottom', 'penshop' ),
						'id'    => 'bottom',
						'type'  => 'text',
					),
				),
			),
			array(
				'name'  => esc_html__( 'Spacing (Mobile)', 'penshop' ),
				'desc'  => esc_html__( 'The value must includes unit. For example 100px or 10em. Allowed units are px, em, rem, %.', 'penshop' ),
				'id'    => 'page_header_spacing_mobile',
				'class' => 'page-header-spacing page-header-field',
				'type'  => 'group',
				'fields'   => array(
					array(
						'before'  => esc_html__( 'Top', 'penshop' ),
						'id'    => 'top',
						'type'  => 'text',
					),
					array(
						'before'  => esc_html__( 'Bottom', 'penshop' ),
						'id'    => 'bottom',
						'type'  => 'text',
					),
				),
			),
			array(
				'name' => esc_html__( 'Site Content', 'penshop' ),
				'id'   => 'heading_site_content',
				'type' => 'heading',
			),
			array(
				'name' => esc_html__( 'Remove Top Spacing', 'penshop' ),
				'desc' => esc_html__( 'Remove the top spacing (padding) of site content', 'penshop' ),
				'id'   => 'remove_top_padding',
				'type' => 'checkbox',
				'std'  => false,
			),
			array(
				'name' => esc_html__( 'Remove Bottom Spacing', 'penshop' ),
				'desc' => esc_html__( 'Remove the bottom spacing (padding) of site content', 'penshop' ),
				'id'   => 'remove_bottom_padding',
				'type' => 'checkbox',
				'std'  => false,
			),
			array(
				'name' => esc_html__( 'Layout', 'penshop' ),
				'id'   => 'heading_layout',
				'type' => 'heading',
			),
			array(
				'name' => esc_html__( 'Custom Layout', 'penshop' ),
				'id'   => 'custom_layout',
				'type' => 'checkbox',
				'std'  => false,
			),
			array(
				'name'    => esc_html__( 'Layout', 'penshop' ),
				'id'      => 'layout',
				'type'    => 'image_select',
				'class'   => 'custom-layout',
				'options' => array(
					'no-sidebar'      => get_template_directory_uri() . '/assets/images/layout/no-sidebar.png',
					'sidebar-content' => get_template_directory_uri() . '/assets/images/layout/sidebar-content.png',
					'content-sidebar' => get_template_directory_uri() . '/assets/images/layout/content-sidebar.png',
				),
			),
		),
	);

	return $meta_boxes;
}

add_filter( 'rwmb_meta_boxes', 'penshop_register_meta_boxes' );

/**
 * Enqueue scripts for admin
 */
function penshop_meta_boxes_scripts( $hook ) {

	if ( in_array( $hook, array( 'post.php', 'post-new.php' ) ) ) {
		wp_enqueue_script( 'penshop-meta-boxes', get_template_directory_uri() . '/assets/js/admin/meta-boxes.js', array( 'jquery' ), '20170623', true );
	}
}

add_action( 'admin_enqueue_scripts', 'penshop_meta_boxes_scripts' );