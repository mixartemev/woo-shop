<?php
/**
 * Setting fields of Footer
 *
 * @package    PenShop
 * @subpackage Customizer
 */

return array(
	'footer_widgets'         => array(
		'type'        => 'toggle',
		'label'       => esc_html__( 'Enable Footer Widgets', 'penshop' ),
		'description' => esc_html__( 'Display widgets on footer', 'penshop' ),
		'section'     => 'footer',
		'default'     => true,
	),
	'footer_widgets_columns' => array(
		'type'            => 'select',
		'label'           => esc_html__( 'Footer Widgets Layout', 'penshop' ),
		'description'     => esc_html__( 'Select number of columns for displaying widgets', 'penshop' ),
		'section'         => 'footer',
		'default'         => '4',
		'choices'         => array(
			'1' => esc_html__( '1 Column', 'penshop' ),
			'2' => esc_html__( '2 Columns', 'penshop' ),
			'3' => esc_html__( '3 Columns', 'penshop' ),
			'4' => esc_html__( '4 Columns', 'penshop' ),
		),
		'active_callback' => array(
			array(
				'setting'  => 'footer_widgets',
				'operator' => '==',
				'value'    => true,
			),
		),
	),
	'footer_custom_field'    => array(
		'type'    => 'custom',
		'section' => 'footer',
		'default' => '<hr/>',
	),
	'footer_layout'          => array(
		'type'        => 'select',
		'label'       => esc_html__( 'Footer Layout', 'penshop' ),
		'description' => esc_html__( 'Select number of columns for displaying widgets', 'penshop' ),
		'section'     => 'footer',
		'default'     => '2-columns',
		'choices'     => array(
			'1-column'  => esc_html__( '1 Column', 'penshop' ),
			'2-columns' => esc_html__( '2 Columns', 'penshop' ),
		),
	),
	'footer_background'      => array(
		'type'        => 'select',
		'label'       => esc_html__( 'Footer Background', 'penshop' ),
		'description' => esc_html__( 'Select footer background color scheme', 'penshop' ),
		'section'     => 'footer',
		'default'     => 'dark',
		'choices'     => array(
			'dark'  => esc_html__( 'Dark', 'penshop' ),
			'light' => esc_html__( 'Light', 'penshop' ),
		),
	),
	'footer_copyright'       => array(
		'type'        => 'textarea',
		'label'       => esc_html__( 'Footer Copyright', 'penshop' ),
		'description' => esc_html__( 'Display copyright info on the left side of footer', 'penshop' ),
		'section'     => 'footer',
		'default'     => sprintf( esc_html__( 'Copyright %s %s', 'penshop' ), "&copy;", date( 'Y' ) ),
	),
	'footer_right'      => array(
		'type'        => 'select',
		'label'       => esc_html__( 'Footer Right', 'penshop' ),
		'description' => esc_html__( 'Select footer right content', 'penshop' ),
		'section'     => 'footer',
		'default'     => 'menu',
		'choices'     => array(
			'menu'    => esc_html__( 'Footer Menu', 'penshop' ),
			'content' => esc_html__( 'Custom Content', 'penshop' ),
		),
		'active_callback' => array(
			array(
				'setting'  => 'footer_layout',
				'operator' => '==',
				'value'    => '2-columns',
			),
		),
	),
	'footer_right_content'   => array(
		'type'            => 'textarea',
		'label'           => esc_html__( 'Footer Right Content', 'penshop' ),
		'description'     => esc_html__( 'Display extra information on the right side of footer', 'penshop' ),
		'section'         => 'footer',
		'active_callback' => array(
			array(
				'setting'  => 'footer_layout',
				'operator' => '==',
				'value'    => '2-columns',
			),
			array(
				'setting'  => 'footer_right',
				'operator' => '==',
				'value'    => 'content',
			),
		),
	),
);