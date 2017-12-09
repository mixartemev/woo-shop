<?php
/**
 * Setting fields of Blog
 *
 * @package    PenShop
 * @subpackage Customizer
 */

return array(
	'post_navigation'    => array(
		'type'        => 'toggle',
		'label'       => esc_html__( 'Post Navigation', 'penshop' ),
		'description' => esc_html__( 'Display next/previous post navigation', 'penshop' ),
		'section'     => 'blog_single',
		'default'     => true,
	),
	'post_related_posts' => array(
		'type'        => 'toggle',
		'label'       => esc_html__( 'Related Posts', 'penshop' ),
		'description' => esc_html__( 'Display related posts at the end of single post', 'penshop' ),
		'section'     => 'blog_single',
		'default'     => true,
	),
	'post_share'         => array(
		'type'    => 'multicheck',
		'label'   => esc_html__( 'Post Sharing', 'penshop' ),
		'section' => 'blog_single',
		'default' => array( 'facebook', 'twitter', 'googleplus', 'pinterest' ),
		'choices' => array(
			'facebook'   => esc_html__( 'Facebook', 'penshop' ),
			'twitter'    => esc_html__( 'Twitter', 'penshop' ),
			'googleplus' => esc_html__( 'Google Plus', 'penshop' ),
			'pinterest'  => esc_html__( 'Pinterest', 'penshop' ),
		),
	),
	'blog_layout'        => array(
		'type'    => 'radio',
		'label'   => esc_html__( 'Blog Layout', 'penshop' ),
		'section' => 'blog_archive',
		'default' => 'classic',
		'choices' => array(
			'classic' => esc_html__( 'Classic', 'penshop' ),
			'grid'    => esc_html__( 'Grid', 'penshop' ),
			'list'    => esc_html__( 'List', 'penshop' ),
		),
	),
	'excerpt_length'     => array(
		'type'    => 'number',
		'label'   => esc_html__( 'Excerpt Length', 'penshop' ),
		'section' => 'blog_archive',
		'default' => 30,
	),
);