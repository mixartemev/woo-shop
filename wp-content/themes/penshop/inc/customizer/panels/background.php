<?php
/**
 * Setting fields of 404
 *
 * @package    PenShop
 * @subpackage Customizer
 */

return array(
	'404_bg'                         => array(
		'type'        => 'image',
		'label'       => esc_html__( '404 Page', 'penshop' ),
		'description' => esc_html__( 'Background image for not found page', 'penshop' ),
		'section'     => 'background',
		'default'     => '',
	),
);
