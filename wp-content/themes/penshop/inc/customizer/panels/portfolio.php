<?php
/**
 * Setting fields of Portfolio
 *
 * @package    PenShop
 * @subpackage Customizer
 */
return array(
	'portfolio_filter'        => array(
		'type'        => 'toggle',
		'label'       => esc_html__( 'Portfolio Navigation Filter', 'penshop' ),
		'description' => esc_html__( 'Display portfolio navigation filter', 'penshop' ),
		'section'     => 'portfolio_archive',
		'default'     => true,
	),
	'portfolio_layout'        => array(
		'type'    => 'radio',
		'label'   => esc_html__( 'Portfolio Layout', 'penshop' ),
		'section' => 'portfolio_archive',
		'default' => 'classic',
		'choices' => array(
			'classic'   => esc_html__( 'Classic', 'penshop' ),
			'fullwidth' => esc_html__( 'Full Width', 'penshop' ),
			'masonry'   => esc_html__( 'Masonry', 'penshop' ),
		),
	),
	'portfolio_columns'       => array(
		'type'            => 'radio',
		'label'           => esc_html__( 'Portfolio Columns', 'penshop' ),
		'section'         => 'portfolio_archive',
		'default'         => '2',
		'choices'         => array(
			'2' => esc_html__( '2 Columns', 'penshop' ),
			'3' => esc_html__( '3 Columns', 'penshop' ),
		),
		'active_callback' => array(
			array(
				'setting'  => 'portfolio_layout',
				'operator' => '!=',
				'value'    => 'fullwidth',
			),
		),
	),
	'portfolio_pagination'    => array(
		'type'    => 'radio',
		'label'   => esc_html__( 'Portfolio Pagination', 'penshop' ),
		'section' => 'portfolio_archive',
		'default' => 'loadmore',
		'choices' => array(
			'numeric'  => esc_html__( 'Numeric', 'penshop' ),
			'loadmore' => esc_html__( 'Load More', 'penshop' ),
		),
	),
	'portfolio_navigation'    => array(
		'type'        => 'toggle',
		'label'       => esc_html__( 'Portfolio Navigation', 'penshop' ),
		'description' => esc_html__( 'Display next/previous portfolio navigation', 'penshop' ),
		'section'     => 'portfolio_single',
		'default'     => true,
	),
	'portfolio_nav_text_next' => array(
		'type'            => 'text',
		'label'           => esc_html__( 'Next Link Text', 'penshop' ),
		'section'         => 'portfolio_single',
		'default'         => esc_html__( 'Next Project', 'penshop' ),
		'active_callback' => array(
			array(
				'setting'  => 'portfolio_navigation',
				'operator' => '==',
				'value'    => true,
			),
		),
	),
	'portfolio_nav_text_prev' => array(
		'type'            => 'text',
		'label'           => esc_html__( 'Prev Link Text', 'penshop' ),
		'section'         => 'portfolio_single',
		'default'         => esc_html__( 'Previous Project', 'penshop' ),
		'active_callback' => array(
			array(
				'setting'  => 'portfolio_navigation',
				'operator' => '==',
				'value'    => true,
			),
		),
	),
	'portfolio_share'         => array(
		'type'    => 'multicheck',
		'label'   => esc_html__( 'Portfolio Sharing', 'penshop' ),
		'section' => 'portfolio_single',
		'default' => array( 'facebook', 'twitter', 'googleplus', 'pinterest' ),
		'choices' => array(
			'facebook'   => esc_html__( 'Facebook', 'penshop' ),
			'twitter'    => esc_html__( 'Twitter', 'penshop' ),
			'googleplus' => esc_html__( 'Google Plus', 'penshop' ),
			'pinterest'  => esc_html__( 'Pinterest', 'penshop' ),
		),
	),
);