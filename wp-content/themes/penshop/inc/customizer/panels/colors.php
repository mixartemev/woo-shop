<?php
return array(
	'color_scheme'        => array(
		'type'    => 'palette',
		'label'   => esc_html__( 'Color Shemes', 'penshop' ),
		'section' => 'colors',
		'default' => 'default',
		'choices' => array(
			'default'  => array( '#e53935' ),
			'cerulean' => array( '#00ADB5' ),
			'berry'    => array( '#B83B5E' ),
			'pink'     => array( '#FF2E63' ),
			'orange'   => array( '#F07B3F' ),
			'purple'   => array( '#B61AAE' ),
			'custom'   => array( esc_html__( 'Custom', 'duko' ) ),
		),
	),
	'color_scheme_custom' => array(
		'type'            => 'color',
		'label'           => esc_html__( 'Custom Color', 'penshop' ),
		'section'         => 'colors',
		'default'         => '#e53935',
		'active_callback' => array(
			array(
				'setting'  => 'color_scheme',
				'operator' => '==',
				'value'    => 'custom',
			),
		),
	),
);