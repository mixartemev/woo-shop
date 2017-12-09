<?php
/**
 * Mapping shortcodes into Visual Composer
 */

if ( ! function_exists( 'is_plugin_active' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
}

/**
 * Class PenShop_Addons_VC
 */
class PenShop_Addons_VC {
	/**
	 * The single instance of the class.
	 *
	 * @var object
	 */
	protected static $_instance = null;

	/**
	 * Temporary cached terms variable
	 *
	 * @var array
	 */
	protected $terms = array();

	/**
	 * Main Instance.
	 * Ensures only one instance of this class is loaded or can be loaded.
	 *
	 * @return PenShop_Addons_VC - Main instance.
	 */
	public static function init() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	/**
	 * Constructor
	 */
	function __construct() {
		// Stop if VC is not installed
		if ( ! is_plugin_active( 'js_composer/js_composer.php' ) ) {
			return false;
		}

		vc_set_as_theme();
		remove_action( 'admin_bar_menu', array( vc_frontend_editor(), 'adminBarEditLink' ), 1000 );

		$this->map_shortcodes();
	}

	/**
	 * Register custom shortcodes within Visual Composer interface
	 *
	 * @see http://kb.wpbakery.com/index.php?title=Vc_map
	 */
	public function map_shortcodes() {
		// Icon Box
		vc_map( array(
			'name'        => esc_html__( 'Icon Box', 'penshop-addons' ),
			'description' => esc_html__( 'Information box with icon', 'penshop-addons' ),
			'base'        => 'penshop_icon_box',
			'icon'        => $this->get_icon( 'icon-box.png' ),
			'class'       => '',
			'category'    => esc_html__( 'PenShop', 'penshop-addons' ),
			'params'      => array(
				array(
					'heading'     => esc_html__( 'Icon library', 'penshop-addons' ),
					'description' => esc_html__( 'Select icon library.', 'penshop-addons' ),
					'param_name'  => 'icon_type',
					'type'        => 'dropdown',
					'value'       => array(
						esc_html__( 'Font Awesome', 'penshop-addons' ) => 'fontawesome',
						esc_html__( 'Open Iconic', 'penshop-addons' )  => 'openiconic',
						esc_html__( 'Typicons', 'penshop-addons' )     => 'typicons',
						esc_html__( 'Entypo', 'penshop-addons' )       => 'entypo',
						esc_html__( 'Linecons', 'penshop-addons' )     => 'linecons',
						esc_html__( 'Mono Social', 'penshop-addons' )  => 'monosocial',
						esc_html__( 'Material', 'penshop-addons' )     => 'material',
						esc_html__( 'Custom Image', 'penshop-addons' ) => 'image',
					),
				),
				array(
					'heading'     => esc_html__( 'Icon', 'penshop-addons' ),
					'description' => esc_html__( 'Pick an icon from library.', 'penshop-addons' ),
					'type'        => 'iconpicker',
					'param_name'  => 'icon_fontawesome',
					'value'       => 'fa fa-adjust',
					'settings'    => array(
						'emptyIcon'    => false,
						'iconsPerPage' => 4000,
					),
					'dependency'  => array(
						'element' => 'icon_type',
						'value'   => 'fontawesome',
					),
				),
				array(
					'heading'     => esc_html__( 'Icon', 'penshop-addons' ),
					'description' => esc_html__( 'Pick icon from library.', 'penshop-addons' ),
					'type'        => 'iconpicker',
					'param_name'  => 'icon_openiconic',
					'value'       => 'vc-oi vc-oi-dial',
					'settings'    => array(
						'emptyIcon'    => false,
						'type'         => 'openiconic',
						'iconsPerPage' => 4000,
					),
					'dependency'  => array(
						'element' => 'icon_type',
						'value'   => 'openiconic',
					),
				),
				array(
					'heading'     => esc_html__( 'Icon', 'penshop-addons' ),
					'description' => esc_html__( 'Pick icon from library.', 'penshop-addons' ),
					'type'        => 'iconpicker',
					'param_name'  => 'icon_typicons',
					'value'       => 'typcn typcn-adjust-brightness',
					'settings'    => array(
						'emptyIcon'    => false,
						'type'         => 'typicons',
						'iconsPerPage' => 4000,
					),
					'dependency'  => array(
						'element' => 'icon_type',
						'value'   => 'typicons',
					),
				),
				array(
					'heading'     => esc_html__( 'Icon', 'penshop-addons' ),
					'description' => esc_html__( 'Pick icon from library.', 'penshop-addons' ),
					'type'        => 'iconpicker',
					'param_name'  => 'icon_entypo',
					'value'       => 'entypo-icon entypo-icon-note',
					'settings'    => array(
						'emptyIcon'    => false,
						'type'         => 'entypo',
						'iconsPerPage' => 4000,
					),
					'dependency'  => array(
						'element' => 'icon_type',
						'value'   => 'entypo',
					),
				),
				array(
					'heading'     => esc_html__( 'Icon', 'penshop-addons' ),
					'description' => esc_html__( 'Pick icon from library.', 'penshop-addons' ),
					'type'        => 'iconpicker',
					'param_name'  => 'icon_linecons',
					'value'       => 'vc_li vc_li-heart',
					'settings'    => array(
						'emptyIcon'    => false,
						'type'         => 'linecons',
						'iconsPerPage' => 4000,
					),
					'dependency'  => array(
						'element' => 'icon_type',
						'value'   => 'linecons',
					),
				),
				array(
					'heading'     => esc_html__( 'Icon', 'penshop-addons' ),
					'description' => esc_html__( 'Pick icon from library.', 'penshop-addons' ),
					'type'        => 'iconpicker',
					'param_name'  => 'icon_monosocial',
					'value'       => 'vc-mono vc-mono-fivehundredpx',
					'settings'    => array(
						'emptyIcon'    => false,
						'type'         => 'monosocial',
						'iconsPerPage' => 4000,
					),
					'dependency'  => array(
						'element' => 'icon_type',
						'value'   => 'monosocial',
					),
				),
				array(
					'heading'     => esc_html__( 'Icon', 'penshop-addons' ),
					'description' => esc_html__( 'Pick icon from library.', 'penshop-addons' ),
					'type'        => 'iconpicker',
					'param_name'  => 'icon_material',
					'value'       => 'vc-material vc-material-cake',
					'settings'    => array(
						'emptyIcon'    => false,
						'type'         => 'material',
						'iconsPerPage' => 4000,
					),
					'dependency'  => array(
						'element' => 'icon_type',
						'value'   => 'material',
					),
				),
				array(
					'heading'     => esc_html__( 'Icon Image', 'penshop-addons' ),
					'description' => esc_html__( 'Upload icon image', 'penshop-addons' ),
					'type'        => 'attach_image',
					'param_name'  => 'image',
					'value'       => '',
					'dependency'  => array(
						'element' => 'icon_type',
						'value'   => 'image',
					),
				),
				array(
					'type'       => 'dropdown',
					'heading'    => __( 'Icon Position', 'penshop-addons' ),
					'param_name' => 'icon_position',
					'value'      => array(
						esc_html__( 'Left', 'penshop-addons' ) => 'left',
						esc_html__( 'Top', 'penshop-addons' )  => 'top',
					),
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Title', 'penshop-addons' ),
					'admin_label' => true,
					'param_name'  => 'title',
					'value'       => esc_html__( 'I am Icon Box', 'penshop-addons' ),
				),
				array(
					'type'        => 'textarea_html',
					'heading'     => esc_html__( 'Content', 'penshop-addons' ),
					'param_name'  => 'content',
					'value'       => '',
					'description' => __( 'Enter the content of this box', 'penshop-addons' ),
				),
				vc_map_add_css_animation(),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Extra class name', 'penshop-addons' ),
					'param_name'  => 'el_class',
					'value'       => '',
					'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'penshop-addons' ),
				),
			),
		) );

		// Banner grid 3
		vc_map( array(
			'name'        => esc_html__( 'Banner Grid 3', 'penshop-addons' ),
			'description' => esc_html__( 'Grid of 3 banners', 'penshop-addons' ),
			'base'        => 'penshop_banner_grid_3',
			'icon'        => $this->get_icon( 'banner-grid-3.png' ),
			'class'       => '',
			'category'    => esc_html__( 'PenShop', 'penshop-addons' ),
			'params'      => array(
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Height', 'penshop-addons' ),
					'description' => esc_html__( 'Enter height of the grid', 'penshop-addons' ),
					'param_name'  => 'height',
					'value'       => 790,
				),
				vc_map_add_css_animation(),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Extra class name', 'penshop-addons' ),
					'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'penshop-addons' ),
					'param_name'  => 'el_class',
					'value'       => '',
				),
				// Banner1
				array(
					'heading'     => esc_html__( 'Image', 'penshop-addons' ),
					'description' => esc_html__( 'Banner Image', 'penshop-addons' ),
					'param_name'  => 'image1',
					'type'        => 'attach_image',
					'group'       => esc_html__( 'Banner 1', 'penshop-addons' ),
				),
				array(
					'heading'          => esc_html__( 'Image Position (Desktop)', 'penshop-addons' ),
					'param_name'       => 'image_pos_desktop1',
					'edit_field_class' => 'vc_col-xs-6',
					'type'             => 'dropdown',
					'std'              => 'center center',
					'group'            => esc_html__( 'Banner 1', 'penshop-addons' ),
					'value'            => array(
						esc_html__( 'Top Left', 'penshop' )        => 'left top',
						esc_html__( 'Top', 'penshop' )             => 'center top',
						esc_html__( 'Top Right', 'penshop' )       => 'right top',
						esc_html__( 'Left', 'penshop' )            => 'left center',
						esc_html__( 'Center', 'penshop' )          => 'center center',
						esc_html__( 'Right', 'penshop' )           => 'right center',
						esc_html__( 'Bottom Left', 'penshop' )     => 'left bottom',
						esc_html__( 'Bottom', 'penshop' )          => 'center bottom',
						esc_html__( 'Bottom Right', 'penshop' )    => 'right bottom',
						esc_html__( 'Custom Position', 'penshop' ) => 'custom',
					),
				),
				array(
					'heading'          => esc_html__( 'Image Position (Mobile)', 'penshop-addons' ),
					'param_name'       => 'image_pos_mobile1',
					'edit_field_class' => 'vc_col-xs-6',
					'type'             => 'dropdown',
					'std'              => 'center center',
					'group'            => esc_html__( 'Banner 1', 'penshop-addons' ),
					'value'            => array(
						esc_html__( 'Top Left', 'penshop' )        => 'left top',
						esc_html__( 'Top', 'penshop' )             => 'center top',
						esc_html__( 'Top Right', 'penshop' )       => 'right top',
						esc_html__( 'Left', 'penshop' )            => 'left center',
						esc_html__( 'Center', 'penshop' )          => 'center center',
						esc_html__( 'Right', 'penshop' )           => 'right center',
						esc_html__( 'Bottom Left', 'penshop' )     => 'left bottom',
						esc_html__( 'Bottom', 'penshop' )          => 'center bottom',
						esc_html__( 'Bottom Right', 'penshop' )    => 'right bottom',
						esc_html__( 'Custom Position', 'penshop' ) => 'custom',
					),
				),
				array(
					'heading'          => esc_html__( 'Custom Image Position (Desktop)', 'penshop-addons' ),
					'description'      => esc_html__( 'Enter custom image position in format "vertical horizontal". Example: "10px 40px" or "30% 50%"', 'penshop-addons' ),
					'param_name'       => 'image_pos_desktop_custom1',
					'edit_field_class' => 'vc_col-xs-6',
					'type'             => 'textfield',
					'std'              => '50% 50%',
					'group'            => esc_html__( 'Banner 1', 'penshop-addons' ),
					'dependency'       => array(
						'element' => 'image_pos_desktop1',
						'value'   => 'custom',
					),
				),
				array(
					'heading'          => esc_html__( 'Custom Image Position (Mobile)', 'penshop-addons' ),
					'description'      => esc_html__( 'Enter custom image position in format "vertical horizontal". Example: "10px 40px" or "30% 50%"', 'penshop-addons' ),
					'param_name'       => 'image_pos_mobile_custom1',
					'edit_field_class' => 'vc_col-xs-6 vc_pull-right',
					'type'             => 'textfield',
					'std'              => '50% 50%',
					'group'            => esc_html__( 'Banner 1', 'penshop-addons' ),
					'dependency'       => array(
						'element' => 'image_pos_mobile1',
						'value'   => 'custom',
					),
				),
				array(
					'heading'     => esc_html__( 'Link', 'penshop-addons' ),
					'description' => esc_html__( 'Banner URL', 'penshop-addons' ),
					'param_name'  => 'link1',
					'type'        => 'vc_link',
					'group'       => esc_html__( 'Banner 1', 'penshop-addons' ),
				),
				array(
					'heading'     => esc_html__( 'Text', 'penshop-addons' ),
					'description' => esc_html__( 'Banner text', 'penshop-addons' ),
					'param_name'  => 'text1',
					'type'        => 'textarea_safe',
					'group'       => esc_html__( 'Banner 1', 'penshop-addons' ),
				),
				array(
					'heading'     => esc_html__( 'Font size', 'penshop-addons' ),
					'description' => esc_html__( 'Banner text size. Leave it empty to use the default size.', 'penshop-addons' ),
					'param_name'  => 'font_size1',
					'type'        => 'textfield',
					'group'       => esc_html__( 'Banner 1', 'penshop-addons' ),
				),
				array(
					'heading'     => esc_html__( 'Text Position', 'penshop-addons' ),
					'description' => esc_html__( 'Banner text position', 'penshop-addons' ),
					'param_name'  => 'text_pos1',
					'type'        => 'dropdown',
					'value'       => array(
						esc_html__( 'Top Left', 'penshop-addons' )      => 'top-left',
						esc_html__( 'Top Center', 'penshop-addons' )    => 'top-center',
						esc_html__( 'Top Right', 'penshop-addons' )     => 'top-right',
						esc_html__( 'Middle Left', 'penshop-addons' )   => 'middle-left',
						esc_html__( 'Middle Center', 'penshop-addons' ) => 'middle-center',
						esc_html__( 'Middle Right', 'penshop-addons' )  => 'middle-right',
						esc_html__( 'Bottom Left', 'penshop-addons' )   => 'bottom-left',
						esc_html__( 'Bottom Center', 'penshop-addons' ) => 'bottom-center',
						esc_html__( 'Bottom Right', 'penshop-addons' )  => 'bottom-right',
					),
					'std'         => 'bottom-right',
					'group'       => esc_html__( 'Banner 1', 'penshop-addons' ),
				),
				array(
					'heading'     => esc_html__( 'Text Align', 'penshop-addons' ),
					'description' => esc_html__( 'Banner text alignment', 'penshop-addons' ),
					'param_name'  => 'align1',
					'type'        => 'dropdown',
					'value'       => array(
						esc_html__( 'Left', 'penshop-addons' )   => 'left',
						esc_html__( 'Center', 'penshop-addons' ) => 'center',
						esc_html__( 'Right', 'penshop-addons' )  => 'right',
					),
					'std'         => 'left',
					'group'       => esc_html__( 'Banner 1', 'penshop-addons' ),
				),
				array(
					'heading'     => esc_html__( 'Color scheme', 'penshop-addons' ),
					'description' => esc_html__( 'Banner text color scheme', 'penshop-addons' ),
					'param_name'  => 'color_scheme1',
					'type'        => 'dropdown',
					'value'       => array(
						esc_html__( 'White', 'penshop-addons' ) => 'white',
						esc_html__( 'Dark', 'penshop-addons' )  => 'dark',
					),
					'std'         => 'dark',
					'group'       => esc_html__( 'Banner 1', 'penshop-addons' ),
				),
				// Banner 2
				array(
					'heading'     => esc_html__( 'Image', 'penshop-addons' ),
					'description' => esc_html__( 'The first banner image. It will be used for the tall banner.', 'penshop-addons' ),
					'param_name'  => 'image2',
					'type'        => 'attach_image',
					'group'       => esc_html__( 'Banner 2', 'penshop-addons' ),
				),
				array(
					'heading'          => esc_html__( 'Image Position (Desktop)', 'penshop-addons' ),
					'param_name'       => 'image_pos_desktop2',
					'edit_field_class' => 'vc_col-xs-6',
					'type'             => 'dropdown',
					'std'              => 'center center',
					'group'            => esc_html__( 'Banner 2', 'penshop-addons' ),
					'value'            => array(
						esc_html__( 'Top Left', 'penshop' )        => 'left top',
						esc_html__( 'Top', 'penshop' )             => 'center top',
						esc_html__( 'Top Right', 'penshop' )       => 'right top',
						esc_html__( 'Left', 'penshop' )            => 'left center',
						esc_html__( 'Center', 'penshop' )          => 'center center',
						esc_html__( 'Right', 'penshop' )           => 'right center',
						esc_html__( 'Bottom Left', 'penshop' )     => 'left bottom',
						esc_html__( 'Bottom', 'penshop' )          => 'center bottom',
						esc_html__( 'Bottom Right', 'penshop' )    => 'right bottom',
						esc_html__( 'Custom Position', 'penshop' ) => 'custom',
					),
				),
				array(
					'heading'          => esc_html__( 'Image Position (Mobile)', 'penshop-addons' ),
					'param_name'       => 'image_pos_mobile2',
					'edit_field_class' => 'vc_col-xs-6',
					'type'             => 'dropdown',
					'std'              => 'center center',
					'group'            => esc_html__( 'Banner 2', 'penshop-addons' ),
					'value'            => array(
						esc_html__( 'Top Left', 'penshop' )        => 'left top',
						esc_html__( 'Top', 'penshop' )             => 'center top',
						esc_html__( 'Top Right', 'penshop' )       => 'right top',
						esc_html__( 'Left', 'penshop' )            => 'left center',
						esc_html__( 'Center', 'penshop' )          => 'center center',
						esc_html__( 'Right', 'penshop' )           => 'right center',
						esc_html__( 'Bottom Left', 'penshop' )     => 'left bottom',
						esc_html__( 'Bottom', 'penshop' )          => 'center bottom',
						esc_html__( 'Bottom Right', 'penshop' )    => 'right bottom',
						esc_html__( 'Custom Position', 'penshop' ) => 'custom',
					),
				),
				array(
					'heading'          => esc_html__( 'Custom Image Position (Desktop)', 'penshop-addons' ),
					'description'      => esc_html__( 'Enter custom image position in format "vertical horizontal". Example: "10px 40px" or "30% 50%"', 'penshop-addons' ),
					'param_name'       => 'image_pos_desktop_custom2',
					'edit_field_class' => 'vc_col-xs-6',
					'type'             => 'textfield',
					'std'              => '50% 50%',
					'group'            => esc_html__( 'Banner 2', 'penshop-addons' ),
					'dependency'       => array(
						'element' => 'image_pos_desktop2',
						'value'   => 'custom',
					),
				),
				array(
					'heading'          => esc_html__( 'Custom Image Position (Mobile)', 'penshop-addons' ),
					'description'      => esc_html__( 'Enter custom image position in format "vertical horizontal". Example: "10px 40px" or "30% 50%"', 'penshop-addons' ),
					'param_name'       => 'image_pos_mobile_custom2',
					'edit_field_class' => 'vc_col-xs-6 vc_pull-right',
					'type'             => 'textfield',
					'std'              => '50% 50%',
					'group'            => esc_html__( 'Banner 2', 'penshop-addons' ),
					'dependency'       => array(
						'element' => 'image_pos_mobile2',
						'value'   => 'custom',
					),
				),
				array(
					'heading'     => esc_html__( 'Link', 'penshop-addons' ),
					'description' => esc_html__( 'Banner URL', 'penshop-addons' ),
					'param_name'  => 'link2',
					'type'        => 'vc_link',
					'group'       => esc_html__( 'Banner 2', 'penshop-addons' ),
				),
				array(
					'heading'     => esc_html__( 'Text', 'penshop-addons' ),
					'description' => esc_html__( 'Banner text', 'penshop-addons' ),
					'param_name'  => 'text2',
					'type'        => 'textarea_safe',
					'group'       => esc_html__( 'Banner 2', 'penshop-addons' ),
				),
				array(
					'heading'     => esc_html__( 'Font size', 'penshop-addons' ),
					'description' => esc_html__( 'Banner text size. Leave it empty to use the default size.', 'penshop-addons' ),
					'param_name'  => 'font_size2',
					'type'        => 'textfield',
					'group'       => esc_html__( 'Banner 2', 'penshop-addons' ),
				),
				array(
					'heading'     => esc_html__( 'Text Position', 'penshop-addons' ),
					'description' => esc_html__( 'Banner text position', 'penshop-addons' ),
					'param_name'  => 'text_pos2',
					'type'        => 'dropdown',
					'value'       => array(
						esc_html__( 'Top Left', 'penshop-addons' )      => 'top-left',
						esc_html__( 'Top Center', 'penshop-addons' )    => 'top-center',
						esc_html__( 'Top Right', 'penshop-addons' )     => 'top-right',
						esc_html__( 'Middle Left', 'penshop-addons' )   => 'middle-left',
						esc_html__( 'Middle Center', 'penshop-addons' ) => 'middle-center',
						esc_html__( 'Middle Right', 'penshop-addons' )  => 'middle-right',
						esc_html__( 'Bottom Left', 'penshop-addons' )   => 'bottom-left',
						esc_html__( 'Bottom Center', 'penshop-addons' ) => 'bottom-center',
						esc_html__( 'Bottom Right', 'penshop-addons' )  => 'bottom-right',
					),
					'std'         => 'bottom-left',
					'group'       => esc_html__( 'Banner 2', 'penshop-addons' ),
				),
				array(
					'heading'     => esc_html__( 'Text Align', 'penshop-addons' ),
					'description' => esc_html__( 'Banner text alignment', 'penshop-addons' ),
					'param_name'  => 'align2',
					'type'        => 'dropdown',
					'value'       => array(
						esc_html__( 'Left', 'penshop-addons' )   => 'left',
						esc_html__( 'Center', 'penshop-addons' ) => 'center',
						esc_html__( 'Right', 'penshop-addons' )  => 'right',
					),
					'std'         => 'left',
					'group'       => esc_html__( 'Banner 2', 'penshop-addons' ),
				),
				array(
					'heading'     => esc_html__( 'Color scheme', 'penshop-addons' ),
					'description' => esc_html__( 'Banner text color scheme', 'penshop-addons' ),
					'param_name'  => 'color_scheme2',
					'type'        => 'dropdown',
					'value'       => array(
						esc_html__( 'White', 'penshop-addons' ) => 'white',
						esc_html__( 'Dark', 'penshop-addons' )  => 'dark',
					),
					'std'         => 'white',
					'group'       => esc_html__( 'Banner 2', 'penshop-addons' ),
				),
				// Banner 3
				array(
					'heading'     => esc_html__( 'Image', 'penshop-addons' ),
					'description' => esc_html__( 'The first banner image. It will be used for the tall banner.', 'penshop-addons' ),
					'param_name'  => 'image3',
					'type'        => 'attach_image',
					'group'       => esc_html__( 'Banner 3', 'penshop-addons' ),
				),
				array(
					'heading'          => esc_html__( 'Image Position (Desktop)', 'penshop-addons' ),
					'param_name'       => 'image_pos_desktop3',
					'edit_field_class' => 'vc_col-xs-6',
					'type'             => 'dropdown',
					'std'              => 'center center',
					'group'            => esc_html__( 'Banner 3', 'penshop-addons' ),
					'value'            => array(
						esc_html__( 'Top Left', 'penshop' )        => 'left top',
						esc_html__( 'Top', 'penshop' )             => 'center top',
						esc_html__( 'Top Right', 'penshop' )       => 'right top',
						esc_html__( 'Left', 'penshop' )            => 'left center',
						esc_html__( 'Center', 'penshop' )          => 'center center',
						esc_html__( 'Right', 'penshop' )           => 'right center',
						esc_html__( 'Bottom Left', 'penshop' )     => 'left bottom',
						esc_html__( 'Bottom', 'penshop' )          => 'center bottom',
						esc_html__( 'Bottom Right', 'penshop' )    => 'right bottom',
						esc_html__( 'Custom Position', 'penshop' ) => 'custom',
					),
				),
				array(
					'heading'          => esc_html__( 'Image Position (Mobile)', 'penshop-addons' ),
					'param_name'       => 'image_pos_mobile3',
					'edit_field_class' => 'vc_col-xs-6',
					'type'             => 'dropdown',
					'std'              => 'center center',
					'group'            => esc_html__( 'Banner 3', 'penshop-addons' ),
					'value'            => array(
						esc_html__( 'Top Left', 'penshop' )        => 'left top',
						esc_html__( 'Top', 'penshop' )             => 'center top',
						esc_html__( 'Top Right', 'penshop' )       => 'right top',
						esc_html__( 'Left', 'penshop' )            => 'left center',
						esc_html__( 'Center', 'penshop' )          => 'center center',
						esc_html__( 'Right', 'penshop' )           => 'right center',
						esc_html__( 'Bottom Left', 'penshop' )     => 'left bottom',
						esc_html__( 'Bottom', 'penshop' )          => 'center bottom',
						esc_html__( 'Bottom Right', 'penshop' )    => 'right bottom',
						esc_html__( 'Custom Position', 'penshop' ) => 'custom',
					),
				),
				array(
					'heading'          => esc_html__( 'Custom Image Position (Desktop)', 'penshop-addons' ),
					'description'      => esc_html__( 'Enter custom image position in format "vertical horizontal". Example: "10px 40px" or "30% 50%"', 'penshop-addons' ),
					'param_name'       => 'image_pos_desktop_custom3',
					'edit_field_class' => 'vc_col-xs-6',
					'type'             => 'textfield',
					'std'              => '50% 50%',
					'group'            => esc_html__( 'Banner 3', 'penshop-addons' ),
					'dependency'       => array(
						'element' => 'image_pos_desktop3',
						'value'   => 'custom',
					),
				),
				array(
					'heading'          => esc_html__( 'Custom Image Position (Mobile)', 'penshop-addons' ),
					'description'      => esc_html__( 'Enter custom image position in format "vertical horizontal". Example: "10px 40px" or "30% 50%"', 'penshop-addons' ),
					'param_name'       => 'image_pos_mobile_custom3',
					'edit_field_class' => 'vc_col-xs-6 vc_pull-right',
					'type'             => 'textfield',
					'std'              => '50% 50%',
					'group'            => esc_html__( 'Banner 3', 'penshop-addons' ),
					'dependency'       => array(
						'element' => 'image_pos_mobile3',
						'value'   => 'custom',
					),
				),
				array(
					'heading'     => esc_html__( 'Link', 'penshop-addons' ),
					'description' => esc_html__( 'Banner URL', 'penshop-addons' ),
					'param_name'  => 'link3',
					'type'        => 'vc_link',
					'group'       => esc_html__( 'Banner 3', 'penshop-addons' ),
				),
				array(
					'heading'     => esc_html__( 'Text', 'penshop-addons' ),
					'description' => esc_html__( 'Banner text', 'penshop-addons' ),
					'param_name'  => 'text3',
					'type'        => 'textarea_safe',
					'group'       => esc_html__( 'Banner 3', 'penshop-addons' ),
				),
				array(
					'heading'     => esc_html__( 'Font size', 'penshop-addons' ),
					'description' => esc_html__( 'Banner text size. Leave it empty to use the default size.', 'penshop-addons' ),
					'param_name'  => 'font_size3',
					'type'        => 'textfield',
					'group'       => esc_html__( 'Banner 3', 'penshop-addons' ),
				),
				array(
					'heading'     => esc_html__( 'Text Position', 'penshop-addons' ),
					'description' => esc_html__( 'Banner text position', 'penshop-addons' ),
					'param_name'  => 'text_pos3',
					'type'        => 'dropdown',
					'value'       => array(
						esc_html__( 'Top Left', 'penshop-addons' )      => 'top-left',
						esc_html__( 'Top Center', 'penshop-addons' )    => 'top-center',
						esc_html__( 'Top Right', 'penshop-addons' )     => 'top-right',
						esc_html__( 'Middle Left', 'penshop-addons' )   => 'middle-left',
						esc_html__( 'Middle Center', 'penshop-addons' ) => 'middle-center',
						esc_html__( 'Middle Right', 'penshop-addons' )  => 'middle-right',
						esc_html__( 'Bottom Left', 'penshop-addons' )   => 'bottom-left',
						esc_html__( 'Bottom Center', 'penshop-addons' ) => 'bottom-center',
						esc_html__( 'Bottom Right', 'penshop-addons' )  => 'bottom-right',
					),
					'std'         => 'middle-center',
					'group'       => esc_html__( 'Banner 3', 'penshop-addons' ),
				),
				array(
					'heading'     => esc_html__( 'Text Align', 'penshop-addons' ),
					'description' => esc_html__( 'Banner text alignment', 'penshop-addons' ),
					'param_name'  => 'align3',
					'type'        => 'dropdown',
					'value'       => array(
						esc_html__( 'Left', 'penshop-addons' )   => 'left',
						esc_html__( 'Center', 'penshop-addons' ) => 'center',
						esc_html__( 'Right', 'penshop-addons' )  => 'right',
					),
					'std'         => 'center',
					'group'       => esc_html__( 'Banner 3', 'penshop-addons' ),
				),
				array(
					'heading'     => esc_html__( 'Color scheme', 'penshop-addons' ),
					'description' => esc_html__( 'Banner text color scheme', 'penshop-addons' ),
					'param_name'  => 'color_scheme3',
					'type'        => 'dropdown',
					'value'       => array(
						esc_html__( 'White', 'penshop-addons' ) => 'white',
						esc_html__( 'Dark', 'penshop-addons' )  => 'dark',
					),
					'std'         => 'white',
					'group'       => esc_html__( 'Banner 3', 'penshop-addons' ),
				),
			),
		) );

		// Banner grid 3 Reverse
		vc_map( array(
			'name'        => esc_html__( 'Banner Grid 3 Reverse', 'penshop-addons' ),
			'description' => esc_html__( 'Grid of 3 banners in reverse order', 'penshop-addons' ),
			'base'        => 'penshop_banner_grid_3_reverse',
			'icon'        => $this->get_icon( 'banner-grid-3-reverse.png' ),
			'category'    => esc_html__( 'PenShop', 'penshop-addons' ),
			'params'      => array(
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Height', 'penshop-addons' ),
					'description' => esc_html__( 'Enter height of the grid', 'penshop-addons' ),
					'param_name'  => 'height',
					'value'       => 520,
				),
				array(
					'heading'     => esc_html__( 'Banner gap', 'penshop-addons' ),
					'description' => esc_html__( 'Select gap between banners in grid.', 'penshop-addons' ),
					'param_name'  => 'gap',
					'type'        => 'dropdown',
					'value'       => array(
						esc_html__( '0px', 'penshop-addons' )  => '0',
						esc_html__( '1px', 'penshop-addons' )  => '1',
						esc_html__( '2px', 'penshop-addons' )  => '2',
						esc_html__( '3px', 'penshop-addons' )  => '3',
						esc_html__( '4px', 'penshop-addons' )  => '4',
						esc_html__( '5px', 'penshop-addons' )  => '5',
						esc_html__( '10px', 'penshop-addons' ) => '10',
						esc_html__( '15px', 'penshop-addons' ) => '15',
						esc_html__( '20px', 'penshop-addons' ) => '20',
						esc_html__( '25px', 'penshop-addons' ) => '25',
						esc_html__( '30px', 'penshop-addons' ) => '30',
					),
					'std'         => '3',
				),
				vc_map_add_css_animation(),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Extra class name', 'penshop-addons' ),
					'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'penshop-addons' ),
					'param_name'  => 'el_class',
					'value'       => '',
				),

				array(
					'heading'     => esc_html__( 'Image', 'penshop-addons' ),
					'description' => esc_html__( 'Banner Image', 'penshop-addons' ),
					'param_name'  => 'image1',
					'type'        => 'attach_image',
					'group'       => esc_html__( 'Banner 1', 'penshop-addons' ),
				),
				array(
					'heading'          => esc_html__( 'Image Position (Desktop)', 'penshop-addons' ),
					'param_name'       => 'image_pos_desktop1',
					'edit_field_class' => 'vc_col-xs-6',
					'type'             => 'dropdown',
					'std'              => 'center center',
					'group'            => esc_html__( 'Banner 1', 'penshop-addons' ),
					'value'            => array(
						esc_html__( 'Top Left', 'penshop' )        => 'left top',
						esc_html__( 'Top', 'penshop' )             => 'center top',
						esc_html__( 'Top Right', 'penshop' )       => 'right top',
						esc_html__( 'Left', 'penshop' )            => 'left center',
						esc_html__( 'Center', 'penshop' )          => 'center center',
						esc_html__( 'Right', 'penshop' )           => 'right center',
						esc_html__( 'Bottom Left', 'penshop' )     => 'left bottom',
						esc_html__( 'Bottom', 'penshop' )          => 'center bottom',
						esc_html__( 'Bottom Right', 'penshop' )    => 'right bottom',
						esc_html__( 'Custom Position', 'penshop' ) => 'custom',
					),
				),
				array(
					'heading'          => esc_html__( 'Image Position (Mobile)', 'penshop-addons' ),
					'param_name'       => 'image_pos_mobile1',
					'edit_field_class' => 'vc_col-xs-6',
					'type'             => 'dropdown',
					'std'              => 'center center',
					'group'            => esc_html__( 'Banner 1', 'penshop-addons' ),
					'value'            => array(
						esc_html__( 'Top Left', 'penshop' )        => 'left top',
						esc_html__( 'Top', 'penshop' )             => 'center top',
						esc_html__( 'Top Right', 'penshop' )       => 'right top',
						esc_html__( 'Left', 'penshop' )            => 'left center',
						esc_html__( 'Center', 'penshop' )          => 'center center',
						esc_html__( 'Right', 'penshop' )           => 'right center',
						esc_html__( 'Bottom Left', 'penshop' )     => 'left bottom',
						esc_html__( 'Bottom', 'penshop' )          => 'center bottom',
						esc_html__( 'Bottom Right', 'penshop' )    => 'right bottom',
						esc_html__( 'Custom Position', 'penshop' ) => 'custom',
					),
				),
				array(
					'heading'          => esc_html__( 'Custom Image Position (Desktop)', 'penshop-addons' ),
					'description'      => esc_html__( 'Enter custom image position in format "vertical horizontal". Example: "10px 40px" or "30% 50%"', 'penshop-addons' ),
					'param_name'       => 'image_pos_desktop_custom1',
					'edit_field_class' => 'vc_col-xs-6',
					'type'             => 'textfield',
					'std'              => '50% 50%',
					'group'            => esc_html__( 'Banner 1', 'penshop-addons' ),
					'dependency'       => array(
						'element' => 'image_pos_desktop1',
						'value'   => 'custom',
					),
				),
				array(
					'heading'          => esc_html__( 'Custom Image Position (Mobile)', 'penshop-addons' ),
					'description'      => esc_html__( 'Enter custom image position in format "vertical horizontal". Example: "10px 40px" or "30% 50%"', 'penshop-addons' ),
					'param_name'       => 'image_pos_mobile_custom1',
					'edit_field_class' => 'vc_col-xs-6 vc_pull-right',
					'type'             => 'textfield',
					'std'              => '50% 50%',
					'group'            => esc_html__( 'Banner 1', 'penshop-addons' ),
					'dependency'       => array(
						'element' => 'image_pos_mobile1',
						'value'   => 'custom',
					),
				),
				array(
					'heading'     => esc_html__( 'Link', 'penshop-addons' ),
					'description' => esc_html__( 'Banner URL', 'penshop-addons' ),
					'param_name'  => 'link1',
					'type'        => 'vc_link',
					'group'       => esc_html__( 'Banner 1', 'penshop-addons' ),
				),
				array(
					'heading'     => esc_html__( 'Title', 'penshop-addons' ),
					'description' => esc_html__( 'Banner title', 'penshop-addons' ),
					'param_name'  => 'title1',
					'type'        => 'textarea_safe',
					'group'       => esc_html__( 'Banner 1', 'penshop-addons' ),
				),
				array(
					'heading'     => esc_html__( 'Subtitle', 'penshop-addons' ),
					'description' => esc_html__( 'Banner subtitle', 'penshop-addons' ),
					'param_name'  => 'subtitle1',
					'type'        => 'textarea_safe',
					'group'       => esc_html__( 'Banner 1', 'penshop-addons' ),
				),
				array(
					'heading'     => esc_html__( 'Text Position', 'penshop-addons' ),
					'description' => esc_html__( 'Banner text position', 'penshop-addons' ),
					'param_name'  => 'text_pos1',
					'type'        => 'dropdown',
					'value'       => array(
						esc_html__( 'Top Left', 'penshop-addons' )      => 'top-left',
						esc_html__( 'Top Center', 'penshop-addons' )    => 'top-center',
						esc_html__( 'Top Right', 'penshop-addons' )     => 'top-right',
						esc_html__( 'Middle Left', 'penshop-addons' )   => 'middle-left',
						esc_html__( 'Middle Center', 'penshop-addons' ) => 'middle-center',
						esc_html__( 'Middle Right', 'penshop-addons' )  => 'middle-right',
						esc_html__( 'Bottom Left', 'penshop-addons' )   => 'bottom-left',
						esc_html__( 'Bottom Center', 'penshop-addons' ) => 'bottom-center',
						esc_html__( 'Bottom Right', 'penshop-addons' )  => 'bottom-right',
					),
					'std'         => 'middle-center',
					'group'       => esc_html__( 'Banner 1', 'penshop-addons' ),
				),
				array(
					'heading'     => esc_html__( 'Text Align', 'penshop-addons' ),
					'description' => esc_html__( 'Banner text alignment', 'penshop-addons' ),
					'param_name'  => 'align1',
					'type'        => 'dropdown',
					'value'       => array(
						esc_html__( 'Left', 'penshop-addons' )   => 'left',
						esc_html__( 'Center', 'penshop-addons' ) => 'center',
						esc_html__( 'Right', 'penshop-addons' )  => 'right',
					),
					'std'         => 'left',
					'group'       => esc_html__( 'Banner 1', 'penshop-addons' ),
				),
				array(
					'heading'     => esc_html__( 'Color scheme', 'penshop-addons' ),
					'description' => esc_html__( 'Banner text color scheme', 'penshop-addons' ),
					'param_name'  => 'color_scheme1',
					'type'        => 'dropdown',
					'value'       => array(
						esc_html__( 'White', 'penshop-addons' ) => 'white',
						esc_html__( 'Dark', 'penshop-addons' )  => 'dark',
					),
					'std'         => 'dark',
					'group'       => esc_html__( 'Banner 1', 'penshop-addons' ),
				),

				array(
					'heading'     => esc_html__( 'Image', 'penshop-addons' ),
					'description' => esc_html__( 'The first banner image. It will be used for the tall banner.', 'penshop-addons' ),
					'param_name'  => 'image2',
					'type'        => 'attach_image',
					'group'       => esc_html__( 'Banner 2', 'penshop-addons' ),
				),
				array(
					'heading'          => esc_html__( 'Image Position (Desktop)', 'penshop-addons' ),
					'param_name'       => 'image_pos_desktop2',
					'edit_field_class' => 'vc_col-xs-6',
					'type'             => 'dropdown',
					'std'              => 'center center',
					'group'            => esc_html__( 'Banner 2', 'penshop-addons' ),
					'value'            => array(
						esc_html__( 'Top Left', 'penshop' )        => 'left top',
						esc_html__( 'Top', 'penshop' )             => 'center top',
						esc_html__( 'Top Right', 'penshop' )       => 'right top',
						esc_html__( 'Left', 'penshop' )            => 'left center',
						esc_html__( 'Center', 'penshop' )          => 'center center',
						esc_html__( 'Right', 'penshop' )           => 'right center',
						esc_html__( 'Bottom Left', 'penshop' )     => 'left bottom',
						esc_html__( 'Bottom', 'penshop' )          => 'center bottom',
						esc_html__( 'Bottom Right', 'penshop' )    => 'right bottom',
						esc_html__( 'Custom Position', 'penshop' ) => 'custom',
					),
				),
				array(
					'heading'          => esc_html__( 'Image Position (Mobile)', 'penshop-addons' ),
					'param_name'       => 'image_pos_mobile2',
					'edit_field_class' => 'vc_col-xs-6',
					'type'             => 'dropdown',
					'std'              => 'center center',
					'group'            => esc_html__( 'Banner 2', 'penshop-addons' ),
					'value'            => array(
						esc_html__( 'Top Left', 'penshop' )        => 'left top',
						esc_html__( 'Top', 'penshop' )             => 'center top',
						esc_html__( 'Top Right', 'penshop' )       => 'right top',
						esc_html__( 'Left', 'penshop' )            => 'left center',
						esc_html__( 'Center', 'penshop' )          => 'center center',
						esc_html__( 'Right', 'penshop' )           => 'right center',
						esc_html__( 'Bottom Left', 'penshop' )     => 'left bottom',
						esc_html__( 'Bottom', 'penshop' )          => 'center bottom',
						esc_html__( 'Bottom Right', 'penshop' )    => 'right bottom',
						esc_html__( 'Custom Position', 'penshop' ) => 'custom',
					),
				),
				array(
					'heading'          => esc_html__( 'Custom Image Position (Desktop)', 'penshop-addons' ),
					'description'      => esc_html__( 'Enter custom image position in format "vertical horizontal". Example: "10px 40px" or "30% 50%"', 'penshop-addons' ),
					'param_name'       => 'image_pos_desktop_custom2',
					'edit_field_class' => 'vc_col-xs-6',
					'type'             => 'textfield',
					'std'              => '50% 50%',
					'group'            => esc_html__( 'Banner 2', 'penshop-addons' ),
					'dependency'       => array(
						'element' => 'image_pos_desktop2',
						'value'   => 'custom',
					),
				),
				array(
					'heading'          => esc_html__( 'Custom Image Position (Mobile)', 'penshop-addons' ),
					'description'      => esc_html__( 'Enter custom image position in format "vertical horizontal". Example: "10px 40px" or "30% 50%"', 'penshop-addons' ),
					'param_name'       => 'image_pos_mobile_custom2',
					'edit_field_class' => 'vc_col-xs-6 vc_pull-right',
					'type'             => 'textfield',
					'std'              => '50% 50%',
					'group'            => esc_html__( 'Banner 2', 'penshop-addons' ),
					'dependency'       => array(
						'element' => 'image_pos_mobile2',
						'value'   => 'custom',
					),
				),
				array(
					'heading'     => esc_html__( 'Link', 'penshop-addons' ),
					'description' => esc_html__( 'Banner URL', 'penshop-addons' ),
					'param_name'  => 'link2',
					'type'        => 'vc_link',
					'group'       => esc_html__( 'Banner 2', 'penshop-addons' ),
				),
				array(
					'heading'     => esc_html__( 'Title', 'penshop-addons' ),
					'description' => esc_html__( 'Banner title', 'penshop-addons' ),
					'param_name'  => 'title2',
					'type'        => 'textarea_safe',
					'group'       => esc_html__( 'Banner 2', 'penshop-addons' ),
				),
				array(
					'heading'     => esc_html__( 'Subtitle', 'penshop-addons' ),
					'description' => esc_html__( 'Banner subtitle', 'penshop-addons' ),
					'param_name'  => 'subtitle2',
					'type'        => 'textarea_safe',
					'group'       => esc_html__( 'Banner 2', 'penshop-addons' ),
				),
				array(
					'heading'     => esc_html__( 'Text Position', 'penshop-addons' ),
					'description' => esc_html__( 'Banner text position', 'penshop-addons' ),
					'param_name'  => 'text_pos2',
					'type'        => 'dropdown',
					'value'       => array(
						esc_html__( 'Top Left', 'penshop-addons' )      => 'top-left',
						esc_html__( 'Top Center', 'penshop-addons' )    => 'top-center',
						esc_html__( 'Top Right', 'penshop-addons' )     => 'top-right',
						esc_html__( 'Middle Left', 'penshop-addons' )   => 'middle-left',
						esc_html__( 'Middle Center', 'penshop-addons' ) => 'middle-center',
						esc_html__( 'Middle Right', 'penshop-addons' )  => 'middle-right',
						esc_html__( 'Bottom Left', 'penshop-addons' )   => 'bottom-left',
						esc_html__( 'Bottom Center', 'penshop-addons' ) => 'bottom-center',
						esc_html__( 'Bottom Right', 'penshop-addons' )  => 'bottom-right',
					),
					'std'         => 'middle-left',
					'group'       => esc_html__( 'Banner 2', 'penshop-addons' ),
				),
				array(
					'heading'     => esc_html__( 'Text Align', 'penshop-addons' ),
					'description' => esc_html__( 'Banner text alignment', 'penshop-addons' ),
					'param_name'  => 'align2',
					'type'        => 'dropdown',
					'value'       => array(
						esc_html__( 'Left', 'penshop-addons' )   => 'left',
						esc_html__( 'Center', 'penshop-addons' ) => 'center',
						esc_html__( 'Right', 'penshop-addons' )  => 'right',
					),
					'std'         => 'left',
					'group'       => esc_html__( 'Banner 2', 'penshop-addons' ),
				),
				array(
					'heading'     => esc_html__( 'Color scheme', 'penshop-addons' ),
					'description' => esc_html__( 'Banner text color scheme', 'penshop-addons' ),
					'param_name'  => 'color_scheme2',
					'type'        => 'dropdown',
					'value'       => array(
						esc_html__( 'White', 'penshop-addons' ) => 'white',
						esc_html__( 'Dark', 'penshop-addons' )  => 'dark',
					),
					'std'         => 'dark',
					'group'       => esc_html__( 'Banner 2', 'penshop-addons' ),
				),

				array(
					'heading'     => esc_html__( 'Image', 'penshop-addons' ),
					'description' => esc_html__( 'The first banner image. It will be used for the tall banner.', 'penshop-addons' ),
					'param_name'  => 'image3',
					'type'        => 'attach_image',
					'group'       => esc_html__( 'Banner 3', 'penshop-addons' ),
				),
				array(
					'heading'          => esc_html__( 'Image Position (Desktop)', 'penshop-addons' ),
					'param_name'       => 'image_pos_desktop3',
					'edit_field_class' => 'vc_col-xs-6',
					'type'             => 'dropdown',
					'std'              => 'center center',
					'group'            => esc_html__( 'Banner 3', 'penshop-addons' ),
					'value'            => array(
						esc_html__( 'Top Left', 'penshop' )        => 'left top',
						esc_html__( 'Top', 'penshop' )             => 'center top',
						esc_html__( 'Top Right', 'penshop' )       => 'right top',
						esc_html__( 'Left', 'penshop' )            => 'left center',
						esc_html__( 'Center', 'penshop' )          => 'center center',
						esc_html__( 'Right', 'penshop' )           => 'right center',
						esc_html__( 'Bottom Left', 'penshop' )     => 'left bottom',
						esc_html__( 'Bottom', 'penshop' )          => 'center bottom',
						esc_html__( 'Bottom Right', 'penshop' )    => 'right bottom',
						esc_html__( 'Custom Position', 'penshop' ) => 'custom',
					),
				),
				array(
					'heading'          => esc_html__( 'Image Position (Mobile)', 'penshop-addons' ),
					'param_name'       => 'image_pos_mobile3',
					'edit_field_class' => 'vc_col-xs-6',
					'type'             => 'dropdown',
					'std'              => 'center center',
					'group'            => esc_html__( 'Banner 3', 'penshop-addons' ),
					'value'            => array(
						esc_html__( 'Top Left', 'penshop' )        => 'left top',
						esc_html__( 'Top', 'penshop' )             => 'center top',
						esc_html__( 'Top Right', 'penshop' )       => 'right top',
						esc_html__( 'Left', 'penshop' )            => 'left center',
						esc_html__( 'Center', 'penshop' )          => 'center center',
						esc_html__( 'Right', 'penshop' )           => 'right center',
						esc_html__( 'Bottom Left', 'penshop' )     => 'left bottom',
						esc_html__( 'Bottom', 'penshop' )          => 'center bottom',
						esc_html__( 'Bottom Right', 'penshop' )    => 'right bottom',
						esc_html__( 'Custom Position', 'penshop' ) => 'custom',
					),
				),
				array(
					'heading'          => esc_html__( 'Custom Image Position (Desktop)', 'penshop-addons' ),
					'description'      => esc_html__( 'Enter custom image position in format "vertical horizontal". Example: "10px 40px" or "30% 50%"', 'penshop-addons' ),
					'param_name'       => 'image_pos_desktop_custom3',
					'edit_field_class' => 'vc_col-xs-6',
					'type'             => 'textfield',
					'std'              => '50% 50%',
					'group'            => esc_html__( 'Banner 3', 'penshop-addons' ),
					'dependency'       => array(
						'element' => 'image_pos_desktop3',
						'value'   => 'custom',
					),
				),
				array(
					'heading'          => esc_html__( 'Custom Image Position (Mobile)', 'penshop-addons' ),
					'description'      => esc_html__( 'Enter custom image position in format "vertical horizontal". Example: "10px 40px" or "30% 50%"', 'penshop-addons' ),
					'param_name'       => 'image_pos_mobile_custom3',
					'edit_field_class' => 'vc_col-xs-6 vc_pull-right',
					'type'             => 'textfield',
					'std'              => '50% 50%',
					'group'            => esc_html__( 'Banner 3', 'penshop-addons' ),
					'dependency'       => array(
						'element' => 'image_pos_mobile3',
						'value'   => 'custom',
					),
				),
				array(
					'heading'     => esc_html__( 'Link', 'penshop-addons' ),
					'description' => esc_html__( 'Banner URL', 'penshop-addons' ),
					'param_name'  => 'link3',
					'type'        => 'vc_link',
					'group'       => esc_html__( 'Banner 3', 'penshop-addons' ),
				),
				array(
					'heading'     => esc_html__( 'Title', 'penshop-addons' ),
					'description' => esc_html__( 'Banner title', 'penshop-addons' ),
					'param_name'  => 'title3',
					'type'        => 'textarea_safe',
					'group'       => esc_html__( 'Banner 3', 'penshop-addons' ),
				),
				array(
					'heading'     => esc_html__( 'Subtitle', 'penshop-addons' ),
					'description' => esc_html__( 'Banner subtitle', 'penshop-addons' ),
					'param_name'  => 'subtitle3',
					'type'        => 'textarea_safe',
					'group'       => esc_html__( 'Banner 3', 'penshop-addons' ),
				),
				array(
					'heading'     => esc_html__( 'Button Text', 'penshop-addons' ),
					'description' => esc_html__( 'Enter button text', 'penshop-addons' ),
					'param_name'  => 'button3',
					'type'        => 'textfield',
					'group'       => esc_html__( 'Banner 3', 'penshop-addons' ),
				),
				array(
					'heading'     => esc_html__( 'Text Position', 'penshop-addons' ),
					'description' => esc_html__( 'Banner text position', 'penshop-addons' ),
					'param_name'  => 'text_pos3',
					'type'        => 'dropdown',
					'value'       => array(
						esc_html__( 'Top Left', 'penshop-addons' )      => 'top-left',
						esc_html__( 'Top Center', 'penshop-addons' )    => 'top-center',
						esc_html__( 'Top Right', 'penshop-addons' )     => 'top-right',
						esc_html__( 'Middle Left', 'penshop-addons' )   => 'middle-left',
						esc_html__( 'Middle Center', 'penshop-addons' ) => 'middle-center',
						esc_html__( 'Middle Right', 'penshop-addons' )  => 'middle-right',
						esc_html__( 'Bottom Left', 'penshop-addons' )   => 'bottom-left',
						esc_html__( 'Bottom Center', 'penshop-addons' ) => 'bottom-center',
						esc_html__( 'Bottom Right', 'penshop-addons' )  => 'bottom-right',
					),
					'std'         => 'middle-center',
					'group'       => esc_html__( 'Banner 3', 'penshop-addons' ),
				),
				array(
					'heading'     => esc_html__( 'Text Align', 'penshop-addons' ),
					'description' => esc_html__( 'Banner text alignment', 'penshop-addons' ),
					'param_name'  => 'align3',
					'type'        => 'dropdown',
					'value'       => array(
						esc_html__( 'Left', 'penshop-addons' )   => 'left',
						esc_html__( 'Center', 'penshop-addons' ) => 'center',
						esc_html__( 'Right', 'penshop-addons' )  => 'right',
					),
					'std'         => 'left',
					'group'       => esc_html__( 'Banner 3', 'penshop-addons' ),
				),
				array(
					'heading'     => esc_html__( 'Color scheme', 'penshop-addons' ),
					'description' => esc_html__( 'Banner text color scheme', 'penshop-addons' ),
					'param_name'  => 'color_scheme3',
					'type'        => 'dropdown',
					'value'       => array(
						esc_html__( 'White', 'penshop-addons' ) => 'white',
						esc_html__( 'Dark', 'penshop-addons' )  => 'dark',
					),
					'std'         => 'dark',
					'group'       => esc_html__( 'Banner 3', 'penshop-addons' ),
				),
			),
		) );

		// Banner grid 3 Video
		vc_map( array(
			'name'        => esc_html__( 'Banner Grid 3 Video', 'penshop-addons' ),
			'description' => esc_html__( 'Grid of 3 banners including one video', 'penshop-addons' ),
			'base'        => 'penshop_banner_grid_3_video',
			'icon'        => $this->get_icon( 'banner-grid-3-video.png' ),
			'category'    => esc_html__( 'PenShop', 'penshop-addons' ),
			'params'      => array(
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Height', 'penshop-addons' ),
					'description' => esc_html__( 'Enter height of the grid', 'penshop-addons' ),
					'param_name'  => 'height',
					'value'       => 620,
				),
				array(
					'heading'     => esc_html__( 'Banner gap', 'penshop-addons' ),
					'description' => esc_html__( 'Select gap between banners in grid.', 'penshop-addons' ),
					'param_name'  => 'gap',
					'type'        => 'dropdown',
					'value'       => array(
						esc_html__( '0px', 'penshop-addons' )  => '0',
						esc_html__( '1px', 'penshop-addons' )  => '1',
						esc_html__( '2px', 'penshop-addons' )  => '2',
						esc_html__( '3px', 'penshop-addons' )  => '3',
						esc_html__( '4px', 'penshop-addons' )  => '4',
						esc_html__( '5px', 'penshop-addons' )  => '5',
						esc_html__( '10px', 'penshop-addons' ) => '10',
						esc_html__( '15px', 'penshop-addons' ) => '15',
						esc_html__( '20px', 'penshop-addons' ) => '20',
						esc_html__( '25px', 'penshop-addons' ) => '25',
						esc_html__( '30px', 'penshop-addons' ) => '30',
					),
					'std'         => '3',
				),
				vc_map_add_css_animation(),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Extra class name', 'penshop-addons' ),
					'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'penshop-addons' ),
					'param_name'  => 'el_class',
					'value'       => '',
				),

				array(
					'heading'     => esc_html__( 'Image', 'penshop-addons' ),
					'description' => esc_html__( 'Upload a large image for the large banner.', 'penshop-addons' ),
					'param_name'  => 'image1',
					'type'        => 'attach_image',
					'group'       => esc_html__( 'Large Banner', 'penshop-addons' ),
				),
				array(
					'heading'          => esc_html__( 'Image Position (Desktop)', 'penshop-addons' ),
					'param_name'       => 'image_pos_desktop1',
					'edit_field_class' => 'vc_col-xs-6',
					'type'             => 'dropdown',
					'std'              => 'center center',
					'group'            => esc_html__( 'Banner 1', 'penshop-addons' ),
					'value'            => array(
						esc_html__( 'Top Left', 'penshop' )        => 'left top',
						esc_html__( 'Top', 'penshop' )             => 'center top',
						esc_html__( 'Top Right', 'penshop' )       => 'right top',
						esc_html__( 'Left', 'penshop' )            => 'left center',
						esc_html__( 'Center', 'penshop' )          => 'center center',
						esc_html__( 'Right', 'penshop' )           => 'right center',
						esc_html__( 'Bottom Left', 'penshop' )     => 'left bottom',
						esc_html__( 'Bottom', 'penshop' )          => 'center bottom',
						esc_html__( 'Bottom Right', 'penshop' )    => 'right bottom',
						esc_html__( 'Custom Position', 'penshop' ) => 'custom',
					),
				),
				array(
					'heading'          => esc_html__( 'Image Position (Mobile)', 'penshop-addons' ),
					'param_name'       => 'image_pos_mobile1',
					'edit_field_class' => 'vc_col-xs-6',
					'type'             => 'dropdown',
					'std'              => 'center center',
					'group'            => esc_html__( 'Banner 1', 'penshop-addons' ),
					'value'            => array(
						esc_html__( 'Top Left', 'penshop' )        => 'left top',
						esc_html__( 'Top', 'penshop' )             => 'center top',
						esc_html__( 'Top Right', 'penshop' )       => 'right top',
						esc_html__( 'Left', 'penshop' )            => 'left center',
						esc_html__( 'Center', 'penshop' )          => 'center center',
						esc_html__( 'Right', 'penshop' )           => 'right center',
						esc_html__( 'Bottom Left', 'penshop' )     => 'left bottom',
						esc_html__( 'Bottom', 'penshop' )          => 'center bottom',
						esc_html__( 'Bottom Right', 'penshop' )    => 'right bottom',
						esc_html__( 'Custom Position', 'penshop' ) => 'custom',
					),
				),
				array(
					'heading'          => esc_html__( 'Custom Image Position (Desktop)', 'penshop-addons' ),
					'description'      => esc_html__( 'Enter custom image position in format "vertical horizontal". Example: "10px 40px" or "30% 50%"', 'penshop-addons' ),
					'param_name'       => 'image_pos_desktop_custom1',
					'edit_field_class' => 'vc_col-xs-6',
					'type'             => 'textfield',
					'std'              => '50% 50%',
					'group'            => esc_html__( 'Banner 1', 'penshop-addons' ),
					'dependency'       => array(
						'element' => 'image_pos_desktop1',
						'value'   => 'custom',
					),
				),
				array(
					'heading'          => esc_html__( 'Custom Image Position (Mobile)', 'penshop-addons' ),
					'description'      => esc_html__( 'Enter custom image position in format "vertical horizontal". Example: "10px 40px" or "30% 50%"', 'penshop-addons' ),
					'param_name'       => 'image_pos_mobile_custom1',
					'edit_field_class' => 'vc_col-xs-6 vc_pull-right',
					'type'             => 'textfield',
					'std'              => '50% 50%',
					'group'            => esc_html__( 'Banner 1', 'penshop-addons' ),
					'dependency'       => array(
						'element' => 'image_pos_mobile1',
						'value'   => 'custom',
					),
				),
				array(
					'heading'     => esc_html__( 'Link', 'penshop-addons' ),
					'description' => esc_html__( 'Banner URL', 'penshop-addons' ),
					'param_name'  => 'link1',
					'type'        => 'vc_link',
					'group'       => esc_html__( 'Large Banner', 'penshop-addons' ),
				),
				array(
					'heading'     => esc_html__( 'Title', 'penshop-addons' ),
					'description' => esc_html__( 'Banner title', 'penshop-addons' ),
					'param_name'  => 'title1',
					'type'        => 'textarea_safe',
					'group'       => esc_html__( 'Large Banner', 'penshop-addons' ),
				),
				array(
					'heading'     => esc_html__( 'Subtitle', 'penshop-addons' ),
					'description' => esc_html__( 'Banner subtitle', 'penshop-addons' ),
					'param_name'  => 'subtitle1',
					'type'        => 'textarea_safe',
					'group'       => esc_html__( 'Large Banner', 'penshop-addons' ),
				),
				array(
					'heading'    => esc_html__( 'Button Text', 'penshop-addons' ),
					'param_name' => 'button1',
					'type'       => 'textfield',
					'group'      => esc_html__( 'Large Banner', 'penshop-addons' ),
				),
				array(
					'heading'     => esc_html__( 'Text Position', 'penshop-addons' ),
					'description' => esc_html__( 'Banner text position', 'penshop-addons' ),
					'param_name'  => 'text_pos1',
					'type'        => 'dropdown',
					'value'       => array(
						esc_html__( 'Top Left', 'penshop-addons' )      => 'top-left',
						esc_html__( 'Top Center', 'penshop-addons' )    => 'top-center',
						esc_html__( 'Top Right', 'penshop-addons' )     => 'top-right',
						esc_html__( 'Middle Left', 'penshop-addons' )   => 'middle-left',
						esc_html__( 'Middle Center', 'penshop-addons' ) => 'middle-center',
						esc_html__( 'Middle Right', 'penshop-addons' )  => 'middle-right',
						esc_html__( 'Bottom Left', 'penshop-addons' )   => 'bottom-left',
						esc_html__( 'Bottom Center', 'penshop-addons' ) => 'bottom-center',
						esc_html__( 'Bottom Right', 'penshop-addons' )  => 'bottom-right',
					),
					'std'         => 'bottom-left',
					'group'       => esc_html__( 'Large Banner', 'penshop-addons' ),
				),
				array(
					'heading'     => esc_html__( 'Text Align', 'penshop-addons' ),
					'description' => esc_html__( 'Banner text alignment', 'penshop-addons' ),
					'param_name'  => 'align1',
					'type'        => 'dropdown',
					'value'       => array(
						esc_html__( 'Left', 'penshop-addons' )   => 'left',
						esc_html__( 'Center', 'penshop-addons' ) => 'center',
						esc_html__( 'Right', 'penshop-addons' )  => 'right',
					),
					'std'         => 'left',
					'group'       => esc_html__( 'Large Banner', 'penshop-addons' ),
				),
				array(
					'heading'     => esc_html__( 'Color scheme', 'penshop-addons' ),
					'description' => esc_html__( 'Banner text color scheme', 'penshop-addons' ),
					'param_name'  => 'color_scheme1',
					'type'        => 'dropdown',
					'value'       => array(
						esc_html__( 'White', 'penshop-addons' ) => 'white',
						esc_html__( 'Dark', 'penshop-addons' )  => 'dark',
					),
					'std'         => 'dark',
					'group'       => esc_html__( 'Large Banner', 'penshop-addons' ),
				),

				array(
					'heading'     => esc_html__( 'Video URL', 'penshop-addons' ),
					'description' => esc_html__( 'Enter video URL. It could be a direct url or Youtube URL.', 'penshop-addons' ),
					'param_name'  => 'video2',
					'type'        => 'textfield',
					'group'       => esc_html__( 'Video', 'penshop-addons' ),
				),
				array(
					'heading'     => esc_html__( 'Cover Image', 'penshop-addons' ),
					'description' => esc_html__( 'Cover image will be used as placeholder for the video', 'penshop-addons' ),
					'param_name'  => 'image2',
					'type'        => 'attach_image',
					'group'       => esc_html__( 'Video', 'penshop-addons' ),
				),
				array(
					'heading'          => esc_html__( 'Image Position (Desktop)', 'penshop-addons' ),
					'param_name'       => 'image_pos_desktop2',
					'edit_field_class' => 'vc_col-xs-6',
					'type'             => 'dropdown',
					'std'              => 'center center',
					'group'            => esc_html__( 'Video', 'penshop-addons' ),
					'value'            => array(
						esc_html__( 'Top Left', 'penshop' )        => 'left top',
						esc_html__( 'Top', 'penshop' )             => 'center top',
						esc_html__( 'Top Right', 'penshop' )       => 'right top',
						esc_html__( 'Left', 'penshop' )            => 'left center',
						esc_html__( 'Center', 'penshop' )          => 'center center',
						esc_html__( 'Right', 'penshop' )           => 'right center',
						esc_html__( 'Bottom Left', 'penshop' )     => 'left bottom',
						esc_html__( 'Bottom', 'penshop' )          => 'center bottom',
						esc_html__( 'Bottom Right', 'penshop' )    => 'right bottom',
						esc_html__( 'Custom Position', 'penshop' ) => 'custom',
					),
				),
				array(
					'heading'          => esc_html__( 'Image Position (Mobile)', 'penshop-addons' ),
					'param_name'       => 'image_pos_mobile2',
					'edit_field_class' => 'vc_col-xs-6',
					'type'             => 'dropdown',
					'std'              => 'center center',
					'group'            => esc_html__( 'Video', 'penshop-addons' ),
					'value'            => array(
						esc_html__( 'Top Left', 'penshop' )        => 'left top',
						esc_html__( 'Top', 'penshop' )             => 'center top',
						esc_html__( 'Top Right', 'penshop' )       => 'right top',
						esc_html__( 'Left', 'penshop' )            => 'left center',
						esc_html__( 'Center', 'penshop' )          => 'center center',
						esc_html__( 'Right', 'penshop' )           => 'right center',
						esc_html__( 'Bottom Left', 'penshop' )     => 'left bottom',
						esc_html__( 'Bottom', 'penshop' )          => 'center bottom',
						esc_html__( 'Bottom Right', 'penshop' )    => 'right bottom',
						esc_html__( 'Custom Position', 'penshop' ) => 'custom',
					),
				),
				array(
					'heading'          => esc_html__( 'Custom Image Position (Desktop)', 'penshop-addons' ),
					'description'      => esc_html__( 'Enter custom image position in format "vertical horizontal". Example: "10px 40px" or "30% 50%"', 'penshop-addons' ),
					'param_name'       => 'image_pos_desktop_custom2',
					'edit_field_class' => 'vc_col-xs-6',
					'type'             => 'textfield',
					'std'              => '50% 50%',
					'group'            => esc_html__( 'Video', 'penshop-addons' ),
					'dependency'       => array(
						'element' => 'image_pos_desktop2',
						'value'   => 'custom',
					),
				),
				array(
					'heading'          => esc_html__( 'Custom Image Position (Mobile)', 'penshop-addons' ),
					'description'      => esc_html__( 'Enter custom image position in format "vertical horizontal". Example: "10px 40px" or "30% 50%"', 'penshop-addons' ),
					'param_name'       => 'image_pos_mobile_custom2',
					'edit_field_class' => 'vc_col-xs-6 vc_pull-right',
					'type'             => 'textfield',
					'std'              => '50% 50%',
					'group'            => esc_html__( 'Video', 'penshop-addons' ),
					'dependency'       => array(
						'element' => 'image_pos_mobile2',
						'value'   => 'custom',
					),
				),

				array(
					'heading'     => esc_html__( 'Image', 'penshop-addons' ),
					'description' => esc_html__( 'Banner image', 'penshop-addons' ),
					'param_name'  => 'image3',
					'type'        => 'attach_image',
					'group'       => esc_html__( 'Small Banner', 'penshop-addons' ),
				),
				array(
					'heading'          => esc_html__( 'Image Position (Desktop)', 'penshop-addons' ),
					'param_name'       => 'image_pos_desktop3',
					'edit_field_class' => 'vc_col-xs-6',
					'type'             => 'dropdown',
					'std'              => 'center center',
					'group'            => esc_html__( 'Small Banner', 'penshop-addons' ),
					'value'            => array(
						esc_html__( 'Top Left', 'penshop' )        => 'left top',
						esc_html__( 'Top', 'penshop' )             => 'center top',
						esc_html__( 'Top Right', 'penshop' )       => 'right top',
						esc_html__( 'Left', 'penshop' )            => 'left center',
						esc_html__( 'Center', 'penshop' )          => 'center center',
						esc_html__( 'Right', 'penshop' )           => 'right center',
						esc_html__( 'Bottom Left', 'penshop' )     => 'left bottom',
						esc_html__( 'Bottom', 'penshop' )          => 'center bottom',
						esc_html__( 'Bottom Right', 'penshop' )    => 'right bottom',
						esc_html__( 'Custom Position', 'penshop' ) => 'custom',
					),
				),
				array(
					'heading'          => esc_html__( 'Image Position (Mobile)', 'penshop-addons' ),
					'param_name'       => 'image_pos_mobile3',
					'edit_field_class' => 'vc_col-xs-6',
					'type'             => 'dropdown',
					'std'              => 'center center',
					'group'            => esc_html__( 'Small Banner', 'penshop-addons' ),
					'value'            => array(
						esc_html__( 'Top Left', 'penshop' )        => 'left top',
						esc_html__( 'Top', 'penshop' )             => 'center top',
						esc_html__( 'Top Right', 'penshop' )       => 'right top',
						esc_html__( 'Left', 'penshop' )            => 'left center',
						esc_html__( 'Center', 'penshop' )          => 'center center',
						esc_html__( 'Right', 'penshop' )           => 'right center',
						esc_html__( 'Bottom Left', 'penshop' )     => 'left bottom',
						esc_html__( 'Bottom', 'penshop' )          => 'center bottom',
						esc_html__( 'Bottom Right', 'penshop' )    => 'right bottom',
						esc_html__( 'Custom Position', 'penshop' ) => 'custom',
					),
				),
				array(
					'heading'          => esc_html__( 'Custom Image Position (Desktop)', 'penshop-addons' ),
					'description'      => esc_html__( 'Enter custom image position in format "vertical horizontal". Example: "10px 40px" or "30% 50%"', 'penshop-addons' ),
					'param_name'       => 'image_pos_desktop_custom3',
					'edit_field_class' => 'vc_col-xs-6',
					'type'             => 'textfield',
					'std'              => '50% 50%',
					'group'            => esc_html__( 'Small Banner', 'penshop-addons' ),
					'dependency'       => array(
						'element' => 'image_pos_desktop3',
						'value'   => 'custom',
					),
				),
				array(
					'heading'          => esc_html__( 'Custom Image Position (Mobile)', 'penshop-addons' ),
					'description'      => esc_html__( 'Enter custom image position in format "vertical horizontal". Example: "10px 40px" or "30% 50%"', 'penshop-addons' ),
					'param_name'       => 'image_pos_mobile_custom3',
					'edit_field_class' => 'vc_col-xs-6 vc_pull-right',
					'type'             => 'textfield',
					'std'              => '50% 50%',
					'group'            => esc_html__( 'Small Banner', 'penshop-addons' ),
					'dependency'       => array(
						'element' => 'image_pos_mobile3',
						'value'   => 'custom',
					),
				),
				array(
					'heading'     => esc_html__( 'Link', 'penshop-addons' ),
					'description' => esc_html__( 'Banner URL', 'penshop-addons' ),
					'param_name'  => 'link3',
					'type'        => 'vc_link',
					'group'       => esc_html__( 'Small Banner', 'penshop-addons' ),
				),
				array(
					'heading'     => esc_html__( 'Title', 'penshop-addons' ),
					'description' => esc_html__( 'Banner title', 'penshop-addons' ),
					'param_name'  => 'title3',
					'type'        => 'textarea_safe',
					'group'       => esc_html__( 'Small Banner', 'penshop-addons' ),
				),
				array(
					'heading'     => esc_html__( 'Subtitle', 'penshop-addons' ),
					'description' => esc_html__( 'Banner subtitle', 'penshop-addons' ),
					'param_name'  => 'subtitle3',
					'type'        => 'textarea_safe',
					'group'       => esc_html__( 'Small Banner', 'penshop-addons' ),
				),
				array(
					'heading'     => esc_html__( 'Button Text', 'penshop-addons' ),
					'description' => esc_html__( 'Enter button text', 'penshop-addons' ),
					'param_name'  => 'button3',
					'type'        => 'textfield',
					'group'       => esc_html__( 'Small Banner', 'penshop-addons' ),
				),
				array(
					'heading'     => esc_html__( 'Text Align', 'penshop-addons' ),
					'description' => esc_html__( 'Banner text alignment', 'penshop-addons' ),
					'param_name'  => 'align3',
					'type'        => 'dropdown',
					'value'       => array(
						esc_html__( 'Left', 'penshop-addons' )   => 'left',
						esc_html__( 'Center', 'penshop-addons' ) => 'center',
						esc_html__( 'Right', 'penshop-addons' )  => 'right',
					),
					'std'         => 'left',
					'group'       => esc_html__( 'Small Banner', 'penshop-addons' ),
				),
				array(
					'heading'     => esc_html__( 'Color scheme', 'penshop-addons' ),
					'description' => esc_html__( 'Banner text color scheme', 'penshop-addons' ),
					'param_name'  => 'color_scheme3',
					'type'        => 'dropdown',
					'value'       => array(
						esc_html__( 'White', 'penshop-addons' ) => 'white',
						esc_html__( 'Dark', 'penshop-addons' )  => 'dark',
					),
					'std'         => 'dark',
					'group'       => esc_html__( 'Small Banner', 'penshop-addons' ),
				),
			),
		) );

		// Banner grid 4
		vc_map( array(
			'name'        => esc_html__( 'Banner Grid 4', 'penshop-addons' ),
			'description' => esc_html__( 'Grid of 4 banners', 'penshop-addons' ),
			'base'        => 'penshop_banner_grid_4',
			'icon'        => $this->get_icon( 'banner-grid-4.png' ),
			'class'       => '',
			'category'    => esc_html__( 'PenShop', 'penshop-addons' ),
			'params'      => array(
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Height', 'penshop-addons' ),
					'description' => esc_html__( 'Enter height of the grid', 'penshop-addons' ),
					'param_name'  => 'height',
					'value'       => 780,
				),
				array(
					'heading'     => esc_html__( 'Banner gap', 'penshop-addons' ),
					'description' => esc_html__( 'Select gap between banners in grid.', 'penshop-addons' ),
					'param_name'  => 'gap',
					'type'        => 'dropdown',
					'value'       => array(
						esc_html__( '0px', 'penshop-addons' )  => '0',
						esc_html__( '1px', 'penshop-addons' )  => '1',
						esc_html__( '2px', 'penshop-addons' )  => '2',
						esc_html__( '3px', 'penshop-addons' )  => '3',
						esc_html__( '4px', 'penshop-addons' )  => '4',
						esc_html__( '5px', 'penshop-addons' )  => '5',
						esc_html__( '10px', 'penshop-addons' ) => '10',
						esc_html__( '15px', 'penshop-addons' ) => '15',
						esc_html__( '20px', 'penshop-addons' ) => '20',
						esc_html__( '25px', 'penshop-addons' ) => '25',
						esc_html__( '30px', 'penshop-addons' ) => '30',
					),
					'std'         => '3',
				),
				vc_map_add_css_animation(),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Extra class name', 'penshop-addons' ),
					'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'penshop-addons' ),
					'param_name'  => 'el_class',
					'value'       => '',
				),

				array(
					'heading'     => esc_html__( 'Image', 'penshop-addons' ),
					'description' => esc_html__( 'Banner Image', 'penshop-addons' ),
					'param_name'  => 'image1',
					'type'        => 'attach_image',
					'group'       => esc_html__( 'Banner 1', 'penshop-addons' ),
				),
				array(
					'heading'          => esc_html__( 'Image Position (Desktop)', 'penshop-addons' ),
					'param_name'       => 'image_pos_desktop1',
					'edit_field_class' => 'vc_col-xs-6',
					'type'             => 'dropdown',
					'std'              => 'center center',
					'group'            => esc_html__( 'Banner 1', 'penshop-addons' ),
					'value'            => array(
						esc_html__( 'Top Left', 'penshop' )        => 'left top',
						esc_html__( 'Top', 'penshop' )             => 'center top',
						esc_html__( 'Top Right', 'penshop' )       => 'right top',
						esc_html__( 'Left', 'penshop' )            => 'left center',
						esc_html__( 'Center', 'penshop' )          => 'center center',
						esc_html__( 'Right', 'penshop' )           => 'right center',
						esc_html__( 'Bottom Left', 'penshop' )     => 'left bottom',
						esc_html__( 'Bottom', 'penshop' )          => 'center bottom',
						esc_html__( 'Bottom Right', 'penshop' )    => 'right bottom',
						esc_html__( 'Custom Position', 'penshop' ) => 'custom',
					),
				),
				array(
					'heading'          => esc_html__( 'Image Position (Mobile)', 'penshop-addons' ),
					'param_name'       => 'image_pos_mobile1',
					'edit_field_class' => 'vc_col-xs-6',
					'type'             => 'dropdown',
					'std'              => 'center center',
					'group'            => esc_html__( 'Banner 1', 'penshop-addons' ),
					'value'            => array(
						esc_html__( 'Top Left', 'penshop' )        => 'left top',
						esc_html__( 'Top', 'penshop' )             => 'center top',
						esc_html__( 'Top Right', 'penshop' )       => 'right top',
						esc_html__( 'Left', 'penshop' )            => 'left center',
						esc_html__( 'Center', 'penshop' )          => 'center center',
						esc_html__( 'Right', 'penshop' )           => 'right center',
						esc_html__( 'Bottom Left', 'penshop' )     => 'left bottom',
						esc_html__( 'Bottom', 'penshop' )          => 'center bottom',
						esc_html__( 'Bottom Right', 'penshop' )    => 'right bottom',
						esc_html__( 'Custom Position', 'penshop' ) => 'custom',
					),
				),
				array(
					'heading'          => esc_html__( 'Custom Image Position (Desktop)', 'penshop-addons' ),
					'description'      => esc_html__( 'Enter custom image position in format "vertical horizontal". Example: "10px 40px" or "30% 50%"', 'penshop-addons' ),
					'param_name'       => 'image_pos_desktop_custom1',
					'edit_field_class' => 'vc_col-xs-6',
					'type'             => 'textfield',
					'std'              => '50% 50%',
					'group'            => esc_html__( 'Banner 1', 'penshop-addons' ),
					'dependency'       => array(
						'element' => 'image_pos_desktop1',
						'value'   => 'custom',
					),
				),
				array(
					'heading'          => esc_html__( 'Custom Image Position (Mobile)', 'penshop-addons' ),
					'description'      => esc_html__( 'Enter custom image position in format "vertical horizontal". Example: "10px 40px" or "30% 50%"', 'penshop-addons' ),
					'param_name'       => 'image_pos_mobile_custom1',
					'edit_field_class' => 'vc_col-xs-6 vc_pull-right',
					'type'             => 'textfield',
					'std'              => '50% 50%',
					'group'            => esc_html__( 'Banner 1', 'penshop-addons' ),
					'dependency'       => array(
						'element' => 'image_pos_mobile1',
						'value'   => 'custom',
					),
				),
				array(
					'heading'     => esc_html__( 'Link', 'penshop-addons' ),
					'description' => esc_html__( 'Banner URL', 'penshop-addons' ),
					'param_name'  => 'link1',
					'type'        => 'vc_link',
					'group'       => esc_html__( 'Banner 1', 'penshop-addons' ),
				),
				array(
					'heading'     => esc_html__( 'Text', 'penshop-addons' ),
					'description' => esc_html__( 'Banner text', 'penshop-addons' ),
					'param_name'  => 'text1',
					'type'        => 'textarea_safe',
					'group'       => esc_html__( 'Banner 1', 'penshop-addons' ),
				),
				array(
					'heading'     => esc_html__( 'Font size', 'penshop-addons' ),
					'description' => esc_html__( 'Banner text size. Leave it empty to use the default size.', 'penshop-addons' ),
					'param_name'  => 'font_size1',
					'type'        => 'textfield',
					'group'       => esc_html__( 'Banner 1', 'penshop-addons' ),
				),
				array(
					'heading'     => esc_html__( 'Button Text', 'penshop-addons' ),
					'description' => esc_html__( 'Enter button text if you want to show a button on this banner.', 'penshop-addons' ),
					'param_name'  => 'button_text1',
					'type'        => 'textfield',
					'group'       => esc_html__( 'Banner 1', 'penshop-addons' ),
				),
				array(
					'heading'     => esc_html__( 'Text Position', 'penshop-addons' ),
					'description' => esc_html__( 'Banner text position', 'penshop-addons' ),
					'param_name'  => 'text_pos1',
					'type'        => 'dropdown',
					'value'       => array(
						esc_html__( 'Top Left', 'penshop-addons' )      => 'top-left',
						esc_html__( 'Top Center', 'penshop-addons' )    => 'top-center',
						esc_html__( 'Top Right', 'penshop-addons' )     => 'top-right',
						esc_html__( 'Middle Left', 'penshop-addons' )   => 'middle-left',
						esc_html__( 'Middle Center', 'penshop-addons' ) => 'middle-center',
						esc_html__( 'Middle Right', 'penshop-addons' )  => 'middle-right',
						esc_html__( 'Bottom Left', 'penshop-addons' )   => 'bottom-left',
						esc_html__( 'Bottom Center', 'penshop-addons' ) => 'bottom-center',
						esc_html__( 'Bottom Right', 'penshop-addons' )  => 'bottom-right',
					),
					'std'         => 'middle-center',
					'group'       => esc_html__( 'Banner 1', 'penshop-addons' ),
				),
				array(
					'heading'     => esc_html__( 'Text Align', 'penshop-addons' ),
					'description' => esc_html__( 'Banner text alignment', 'penshop-addons' ),
					'param_name'  => 'align1',
					'type'        => 'dropdown',
					'value'       => array(
						esc_html__( 'Left', 'penshop-addons' )   => 'left',
						esc_html__( 'Center', 'penshop-addons' ) => 'center',
						esc_html__( 'Right', 'penshop-addons' )  => 'right',
					),
					'std'         => 'center',
					'group'       => esc_html__( 'Banner 1', 'penshop-addons' ),
				),
				array(
					'heading'     => esc_html__( 'Color scheme', 'penshop-addons' ),
					'description' => esc_html__( 'Banner text color scheme', 'penshop-addons' ),
					'param_name'  => 'color_scheme1',
					'type'        => 'dropdown',
					'value'       => array(
						esc_html__( 'White', 'penshop-addons' ) => 'white',
						esc_html__( 'Dark', 'penshop-addons' )  => 'dark',
					),
					'std'         => 'dark',
					'group'       => esc_html__( 'Banner 1', 'penshop-addons' ),
				),

				array(
					'heading'     => esc_html__( 'Image', 'penshop-addons' ),
					'description' => esc_html__( 'The first banner image. It will be used for the tall banner.', 'penshop-addons' ),
					'param_name'  => 'image2',
					'type'        => 'attach_image',
					'group'       => esc_html__( 'Banner 2', 'penshop-addons' ),
				),
				array(
					'heading'          => esc_html__( 'Image Position (Desktop)', 'penshop-addons' ),
					'param_name'       => 'image_pos_desktop2',
					'edit_field_class' => 'vc_col-xs-6',
					'type'             => 'dropdown',
					'std'              => 'center center',
					'group'            => esc_html__( 'Banner 2', 'penshop-addons' ),
					'value'            => array(
						esc_html__( 'Top Left', 'penshop' )        => 'left top',
						esc_html__( 'Top', 'penshop' )             => 'center top',
						esc_html__( 'Top Right', 'penshop' )       => 'right top',
						esc_html__( 'Left', 'penshop' )            => 'left center',
						esc_html__( 'Center', 'penshop' )          => 'center center',
						esc_html__( 'Right', 'penshop' )           => 'right center',
						esc_html__( 'Bottom Left', 'penshop' )     => 'left bottom',
						esc_html__( 'Bottom', 'penshop' )          => 'center bottom',
						esc_html__( 'Bottom Right', 'penshop' )    => 'right bottom',
						esc_html__( 'Custom Position', 'penshop' ) => 'custom',
					),
				),
				array(
					'heading'          => esc_html__( 'Image Position (Mobile)', 'penshop-addons' ),
					'param_name'       => 'image_pos_mobile2',
					'edit_field_class' => 'vc_col-xs-6',
					'type'             => 'dropdown',
					'std'              => 'center center',
					'group'            => esc_html__( 'Banner 2', 'penshop-addons' ),
					'value'            => array(
						esc_html__( 'Top Left', 'penshop' )        => 'left top',
						esc_html__( 'Top', 'penshop' )             => 'center top',
						esc_html__( 'Top Right', 'penshop' )       => 'right top',
						esc_html__( 'Left', 'penshop' )            => 'left center',
						esc_html__( 'Center', 'penshop' )          => 'center center',
						esc_html__( 'Right', 'penshop' )           => 'right center',
						esc_html__( 'Bottom Left', 'penshop' )     => 'left bottom',
						esc_html__( 'Bottom', 'penshop' )          => 'center bottom',
						esc_html__( 'Bottom Right', 'penshop' )    => 'right bottom',
						esc_html__( 'Custom Position', 'penshop' ) => 'custom',
					),
				),
				array(
					'heading'          => esc_html__( 'Custom Image Position (Desktop)', 'penshop-addons' ),
					'description'      => esc_html__( 'Enter custom image position in format "vertical horizontal". Example: "10px 40px" or "30% 50%"', 'penshop-addons' ),
					'param_name'       => 'image_pos_desktop_custom2',
					'edit_field_class' => 'vc_col-xs-6',
					'type'             => 'textfield',
					'std'              => '50% 50%',
					'group'            => esc_html__( 'Banner 2', 'penshop-addons' ),
					'dependency'       => array(
						'element' => 'image_pos_desktop2',
						'value'   => 'custom',
					),
				),
				array(
					'heading'          => esc_html__( 'Custom Image Position (Mobile)', 'penshop-addons' ),
					'description'      => esc_html__( 'Enter custom image position in format "vertical horizontal". Example: "10px 40px" or "30% 50%"', 'penshop-addons' ),
					'param_name'       => 'image_pos_mobile_custom2',
					'edit_field_class' => 'vc_col-xs-6 vc_pull-right',
					'type'             => 'textfield',
					'std'              => '50% 50%',
					'group'            => esc_html__( 'Banner 2', 'penshop-addons' ),
					'dependency'       => array(
						'element' => 'image_pos_mobile2',
						'value'   => 'custom',
					),
				),
				array(
					'heading'     => esc_html__( 'Link', 'penshop-addons' ),
					'description' => esc_html__( 'Banner URL', 'penshop-addons' ),
					'param_name'  => 'link2',
					'type'        => 'vc_link',
					'group'       => esc_html__( 'Banner 2', 'penshop-addons' ),
				),
				array(
					'heading'     => esc_html__( 'Text', 'penshop-addons' ),
					'description' => esc_html__( 'Banner text', 'penshop-addons' ),
					'param_name'  => 'text2',
					'type'        => 'textarea_safe',
					'group'       => esc_html__( 'Banner 2', 'penshop-addons' ),
				),
				array(
					'heading'     => esc_html__( 'Font size', 'penshop-addons' ),
					'description' => esc_html__( 'Banner text size. Leave it empty to use the default size.', 'penshop-addons' ),
					'param_name'  => 'font_size2',
					'type'        => 'textfield',
					'group'       => esc_html__( 'Banner 2', 'penshop-addons' ),
				),
				array(
					'heading'     => esc_html__( 'Button Text', 'penshop-addons' ),
					'description' => esc_html__( 'Enter button text if you want to show a button on this banner.', 'penshop-addons' ),
					'param_name'  => 'button_text2',
					'type'        => 'textfield',
					'group'       => esc_html__( 'Banner 2', 'penshop-addons' ),
				),
				array(
					'heading'     => esc_html__( 'Text Position', 'penshop-addons' ),
					'description' => esc_html__( 'Banner text position', 'penshop-addons' ),
					'param_name'  => 'text_pos2',
					'type'        => 'dropdown',
					'value'       => array(
						esc_html__( 'Top Left', 'penshop-addons' )      => 'top-left',
						esc_html__( 'Top Center', 'penshop-addons' )    => 'top-center',
						esc_html__( 'Top Right', 'penshop-addons' )     => 'top-right',
						esc_html__( 'Middle Left', 'penshop-addons' )   => 'middle-left',
						esc_html__( 'Middle Center', 'penshop-addons' ) => 'middle-center',
						esc_html__( 'Middle Right', 'penshop-addons' )  => 'middle-right',
						esc_html__( 'Bottom Left', 'penshop-addons' )   => 'bottom-left',
						esc_html__( 'Bottom Center', 'penshop-addons' ) => 'bottom-center',
						esc_html__( 'Bottom Right', 'penshop-addons' )  => 'bottom-right',
					),
					'std'         => 'bottom-left',
					'group'       => esc_html__( 'Banner 2', 'penshop-addons' ),
				),
				array(
					'heading'     => esc_html__( 'Text Align', 'penshop-addons' ),
					'description' => esc_html__( 'Banner text alignment', 'penshop-addons' ),
					'param_name'  => 'align2',
					'type'        => 'dropdown',
					'value'       => array(
						esc_html__( 'Left', 'penshop-addons' )   => 'left',
						esc_html__( 'Center', 'penshop-addons' ) => 'center',
						esc_html__( 'Right', 'penshop-addons' )  => 'right',
					),
					'std'         => 'left',
					'group'       => esc_html__( 'Banner 2', 'penshop-addons' ),
				),
				array(
					'heading'     => esc_html__( 'Color scheme', 'penshop-addons' ),
					'description' => esc_html__( 'Banner text color scheme', 'penshop-addons' ),
					'param_name'  => 'color_scheme2',
					'type'        => 'dropdown',
					'value'       => array(
						esc_html__( 'White', 'penshop-addons' ) => 'white',
						esc_html__( 'Dark', 'penshop-addons' )  => 'dark',
					),
					'std'         => 'dark',
					'group'       => esc_html__( 'Banner 2', 'penshop-addons' ),
				),

				array(
					'heading'     => esc_html__( 'Image', 'penshop-addons' ),
					'description' => esc_html__( 'The first banner image. It will be used for the tall banner.', 'penshop-addons' ),
					'param_name'  => 'image3',
					'type'        => 'attach_image',
					'group'       => esc_html__( 'Banner 3', 'penshop-addons' ),
				),
				array(
					'heading'          => esc_html__( 'Image Position (Desktop)', 'penshop-addons' ),
					'param_name'       => 'image_pos_desktop3',
					'edit_field_class' => 'vc_col-xs-6',
					'type'             => 'dropdown',
					'std'              => 'center center',
					'group'            => esc_html__( 'Banner 3', 'penshop-addons' ),
					'value'            => array(
						esc_html__( 'Top Left', 'penshop' )        => 'left top',
						esc_html__( 'Top', 'penshop' )             => 'center top',
						esc_html__( 'Top Right', 'penshop' )       => 'right top',
						esc_html__( 'Left', 'penshop' )            => 'left center',
						esc_html__( 'Center', 'penshop' )          => 'center center',
						esc_html__( 'Right', 'penshop' )           => 'right center',
						esc_html__( 'Bottom Left', 'penshop' )     => 'left bottom',
						esc_html__( 'Bottom', 'penshop' )          => 'center bottom',
						esc_html__( 'Bottom Right', 'penshop' )    => 'right bottom',
						esc_html__( 'Custom Position', 'penshop' ) => 'custom',
					),
				),
				array(
					'heading'          => esc_html__( 'Image Position (Mobile)', 'penshop-addons' ),
					'param_name'       => 'image_pos_mobile3',
					'edit_field_class' => 'vc_col-xs-6',
					'type'             => 'dropdown',
					'std'              => 'center center',
					'group'            => esc_html__( 'Banner 3', 'penshop-addons' ),
					'value'            => array(
						esc_html__( 'Top Left', 'penshop' )        => 'left top',
						esc_html__( 'Top', 'penshop' )             => 'center top',
						esc_html__( 'Top Right', 'penshop' )       => 'right top',
						esc_html__( 'Left', 'penshop' )            => 'left center',
						esc_html__( 'Center', 'penshop' )          => 'center center',
						esc_html__( 'Right', 'penshop' )           => 'right center',
						esc_html__( 'Bottom Left', 'penshop' )     => 'left bottom',
						esc_html__( 'Bottom', 'penshop' )          => 'center bottom',
						esc_html__( 'Bottom Right', 'penshop' )    => 'right bottom',
						esc_html__( 'Custom Position', 'penshop' ) => 'custom',
					),
				),
				array(
					'heading'          => esc_html__( 'Custom Image Position (Desktop)', 'penshop-addons' ),
					'description'      => esc_html__( 'Enter custom image position in format "vertical horizontal". Example: "10px 40px" or "30% 50%"', 'penshop-addons' ),
					'param_name'       => 'image_pos_desktop_custom3',
					'edit_field_class' => 'vc_col-xs-6',
					'type'             => 'textfield',
					'std'              => '50% 50%',
					'group'            => esc_html__( 'Banner 3', 'penshop-addons' ),
					'dependency'       => array(
						'element' => 'image_pos_desktop3',
						'value'   => 'custom',
					),
				),
				array(
					'heading'          => esc_html__( 'Custom Image Position (Mobile)', 'penshop-addons' ),
					'description'      => esc_html__( 'Enter custom image position in format "vertical horizontal". Example: "10px 40px" or "30% 50%"', 'penshop-addons' ),
					'param_name'       => 'image_pos_mobile_custom3',
					'edit_field_class' => 'vc_col-xs-6 vc_pull-right',
					'type'             => 'textfield',
					'std'              => '50% 50%',
					'group'            => esc_html__( 'Banner 3', 'penshop-addons' ),
					'dependency'       => array(
						'element' => 'image_pos_mobile3',
						'value'   => 'custom',
					),
				),
				array(
					'heading'     => esc_html__( 'Link', 'penshop-addons' ),
					'description' => esc_html__( 'Banner URL', 'penshop-addons' ),
					'param_name'  => 'link3',
					'type'        => 'vc_link',
					'group'       => esc_html__( 'Banner 3', 'penshop-addons' ),
				),
				array(
					'heading'     => esc_html__( 'Text', 'penshop-addons' ),
					'description' => esc_html__( 'Banner text', 'penshop-addons' ),
					'param_name'  => 'text3',
					'type'        => 'textarea_safe',
					'group'       => esc_html__( 'Banner 3', 'penshop-addons' ),
				),
				array(
					'heading'     => esc_html__( 'Font size', 'penshop-addons' ),
					'description' => esc_html__( 'Banner text size. Leave it empty to use the default size.', 'penshop-addons' ),
					'param_name'  => 'font_size3',
					'type'        => 'textfield',
					'group'       => esc_html__( 'Banner 3', 'penshop-addons' ),
				),
				array(
					'heading'     => esc_html__( 'Button Text', 'penshop-addons' ),
					'description' => esc_html__( 'Enter button text if you want to show a button on this banner.', 'penshop-addons' ),
					'param_name'  => 'button_text3',
					'type'        => 'textfield',
					'group'       => esc_html__( 'Banner 3', 'penshop-addons' ),
				),
				array(
					'heading'     => esc_html__( 'Text Position', 'penshop-addons' ),
					'description' => esc_html__( 'Banner text position', 'penshop-addons' ),
					'param_name'  => 'text_pos3',
					'type'        => 'dropdown',
					'value'       => array(
						esc_html__( 'Top Left', 'penshop-addons' )      => 'top-left',
						esc_html__( 'Top Center', 'penshop-addons' )    => 'top-center',
						esc_html__( 'Top Right', 'penshop-addons' )     => 'top-right',
						esc_html__( 'Middle Left', 'penshop-addons' )   => 'middle-left',
						esc_html__( 'Middle Center', 'penshop-addons' ) => 'middle-center',
						esc_html__( 'Middle Right', 'penshop-addons' )  => 'middle-right',
						esc_html__( 'Bottom Left', 'penshop-addons' )   => 'bottom-left',
						esc_html__( 'Bottom Center', 'penshop-addons' ) => 'bottom-center',
						esc_html__( 'Bottom Right', 'penshop-addons' )  => 'bottom-right',
					),
					'std'         => 'bottom-left',
					'group'       => esc_html__( 'Banner 3', 'penshop-addons' ),
				),
				array(
					'heading'     => esc_html__( 'Text Align', 'penshop-addons' ),
					'description' => esc_html__( 'Banner text alignment', 'penshop-addons' ),
					'param_name'  => 'align3',
					'type'        => 'dropdown',
					'value'       => array(
						esc_html__( 'Left', 'penshop-addons' )   => 'left',
						esc_html__( 'Center', 'penshop-addons' ) => 'center',
						esc_html__( 'Right', 'penshop-addons' )  => 'right',
					),
					'std'         => 'left',
					'group'       => esc_html__( 'Banner 3', 'penshop-addons' ),
				),
				array(
					'heading'     => esc_html__( 'Color scheme', 'penshop-addons' ),
					'description' => esc_html__( 'Banner text color scheme', 'penshop-addons' ),
					'param_name'  => 'color_scheme3',
					'type'        => 'dropdown',
					'value'       => array(
						esc_html__( 'White', 'penshop-addons' ) => 'white',
						esc_html__( 'Dark', 'penshop-addons' )  => 'dark',
					),
					'std'         => 'dark',
					'group'       => esc_html__( 'Banner 3', 'penshop-addons' ),
				),

				array(
					'heading'     => esc_html__( 'Image', 'penshop-addons' ),
					'description' => esc_html__( 'The first banner image. It will be used for the tall banner.', 'penshop-addons' ),
					'param_name'  => 'image4',
					'type'        => 'attach_image',
					'group'       => esc_html__( 'Banner 4', 'penshop-addons' ),
				),
				array(
					'heading'          => esc_html__( 'Image Position (Desktop)', 'penshop-addons' ),
					'param_name'       => 'image_pos_desktop4',
					'edit_field_class' => 'vc_col-xs-6',
					'type'             => 'dropdown',
					'std'              => 'center center',
					'group'            => esc_html__( 'Banner 4', 'penshop-addons' ),
					'value'            => array(
						esc_html__( 'Top Left', 'penshop' )        => 'left top',
						esc_html__( 'Top', 'penshop' )             => 'center top',
						esc_html__( 'Top Right', 'penshop' )       => 'right top',
						esc_html__( 'Left', 'penshop' )            => 'left center',
						esc_html__( 'Center', 'penshop' )          => 'center center',
						esc_html__( 'Right', 'penshop' )           => 'right center',
						esc_html__( 'Bottom Left', 'penshop' )     => 'left bottom',
						esc_html__( 'Bottom', 'penshop' )          => 'center bottom',
						esc_html__( 'Bottom Right', 'penshop' )    => 'right bottom',
						esc_html__( 'Custom Position', 'penshop' ) => 'custom',
					),
				),
				array(
					'heading'          => esc_html__( 'Image Position (Mobile)', 'penshop-addons' ),
					'param_name'       => 'image_pos_mobile4',
					'edit_field_class' => 'vc_col-xs-6',
					'type'             => 'dropdown',
					'std'              => 'center center',
					'group'            => esc_html__( 'Banner 4', 'penshop-addons' ),
					'value'            => array(
						esc_html__( 'Top Left', 'penshop' )        => 'left top',
						esc_html__( 'Top', 'penshop' )             => 'center top',
						esc_html__( 'Top Right', 'penshop' )       => 'right top',
						esc_html__( 'Left', 'penshop' )            => 'left center',
						esc_html__( 'Center', 'penshop' )          => 'center center',
						esc_html__( 'Right', 'penshop' )           => 'right center',
						esc_html__( 'Bottom Left', 'penshop' )     => 'left bottom',
						esc_html__( 'Bottom', 'penshop' )          => 'center bottom',
						esc_html__( 'Bottom Right', 'penshop' )    => 'right bottom',
						esc_html__( 'Custom Position', 'penshop' ) => 'custom',
					),
				),
				array(
					'heading'          => esc_html__( 'Custom Image Position (Desktop)', 'penshop-addons' ),
					'description'      => esc_html__( 'Enter custom image position in format "vertical horizontal". Example: "10px 40px" or "30% 50%"', 'penshop-addons' ),
					'param_name'       => 'image_pos_desktop_custom4',
					'edit_field_class' => 'vc_col-xs-6',
					'type'             => 'textfield',
					'std'              => '50% 50%',
					'group'            => esc_html__( 'Banner 4', 'penshop-addons' ),
					'dependency'       => array(
						'element' => 'image_pos_desktop4',
						'value'   => 'custom',
					),
				),
				array(
					'heading'          => esc_html__( 'Custom Image Position (Mobile)', 'penshop-addons' ),
					'description'      => esc_html__( 'Enter custom image position in format "vertical horizontal". Example: "10px 40px" or "30% 50%"', 'penshop-addons' ),
					'param_name'       => 'image_pos_mobile_custom4',
					'edit_field_class' => 'vc_col-xs-6 vc_pull-right',
					'type'             => 'textfield',
					'std'              => '50% 50%',
					'group'            => esc_html__( 'Banner 4', 'penshop-addons' ),
					'dependency'       => array(
						'element' => 'image_pos_mobile4',
						'value'   => 'custom',
					),
				),
				array(
					'heading'     => esc_html__( 'Link', 'penshop-addons' ),
					'description' => esc_html__( 'Banner URL', 'penshop-addons' ),
					'param_name'  => 'link4',
					'type'        => 'vc_link',
					'group'       => esc_html__( 'Banner 4', 'penshop-addons' ),
				),
				array(
					'heading'     => esc_html__( 'Text', 'penshop-addons' ),
					'description' => esc_html__( 'Banner text', 'penshop-addons' ),
					'param_name'  => 'text4',
					'type'        => 'textarea_safe',
					'group'       => esc_html__( 'Banner 4', 'penshop-addons' ),
				),
				array(
					'heading'     => esc_html__( 'Font size', 'penshop-addons' ),
					'description' => esc_html__( 'Banner text size. Leave it empty to use the default size.', 'penshop-addons' ),
					'param_name'  => 'font_size4',
					'type'        => 'textfield',
					'group'       => esc_html__( 'Banner 4', 'penshop-addons' ),
				),
				array(
					'heading'     => esc_html__( 'Button Text', 'penshop-addons' ),
					'description' => esc_html__( 'Enter button text if you want to show a button on this banner.', 'penshop-addons' ),
					'param_name'  => 'button_text4',
					'type'        => 'textfield',
					'group'       => esc_html__( 'Banner 4', 'penshop-addons' ),
				),
				array(
					'heading'     => esc_html__( 'Text Position', 'penshop-addons' ),
					'description' => esc_html__( 'Banner text position', 'penshop-addons' ),
					'param_name'  => 'text_pos4',
					'type'        => 'dropdown',
					'value'       => array(
						esc_html__( 'Top Left', 'penshop-addons' )      => 'top-left',
						esc_html__( 'Top Center', 'penshop-addons' )    => 'top-center',
						esc_html__( 'Top Right', 'penshop-addons' )     => 'top-right',
						esc_html__( 'Middle Left', 'penshop-addons' )   => 'middle-left',
						esc_html__( 'Middle Center', 'penshop-addons' ) => 'middle-center',
						esc_html__( 'Middle Right', 'penshop-addons' )  => 'middle-right',
						esc_html__( 'Bottom Left', 'penshop-addons' )   => 'bottom-left',
						esc_html__( 'Bottom Center', 'penshop-addons' ) => 'bottom-center',
						esc_html__( 'Bottom Right', 'penshop-addons' )  => 'bottom-right',
					),
					'std'         => 'middle-right',
					'group'       => esc_html__( 'Banner 4', 'penshop-addons' ),
				),
				array(
					'heading'     => esc_html__( 'Text Align', 'penshop-addons' ),
					'description' => esc_html__( 'Banner text alignment', 'penshop-addons' ),
					'param_name'  => 'align4',
					'type'        => 'dropdown',
					'value'       => array(
						esc_html__( 'Left', 'penshop-addons' )   => 'left',
						esc_html__( 'Center', 'penshop-addons' ) => 'center',
						esc_html__( 'Right', 'penshop-addons' )  => 'right',
					),
					'std'         => 'left',
					'group'       => esc_html__( 'Banner 4', 'penshop-addons' ),
				),
				array(
					'heading'     => esc_html__( 'Color scheme', 'penshop-addons' ),
					'description' => esc_html__( 'Banner text color scheme', 'penshop-addons' ),
					'param_name'  => 'color_scheme4',
					'type'        => 'dropdown',
					'value'       => array(
						esc_html__( 'White', 'penshop-addons' ) => 'white',
						esc_html__( 'Dark', 'penshop-addons' )  => 'dark',
					),
					'std'         => 'dark',
					'group'       => esc_html__( 'Banner 4', 'penshop-addons' ),
				),
			),
		) );

		// Product Carousel
		vc_map( array(
			'name'        => esc_html__( 'Product Carousel', 'penshop-addons' ),
			'description' => esc_html__( 'Product carousel slider', 'penshop-addons' ),
			'base'        => 'penshop_product_carousel',
			'icon'        => $this->get_icon( 'product-carousel.png' ),
			'category'    => esc_html__( 'PenShop', 'penshop-addons' ),
			'params'      => array(
				array(
					'heading'     => esc_html__( 'Product Style', 'penshop-addons' ),
					'description' => esc_html__( 'Select product layout style', 'penshop-addons' ),
					'param_name'  => 'product_style',
					'type'        => 'dropdown',
					'std'         => 'default',
					'value'       => array(
						esc_html__( 'Default', 'penshop-addons' )        => 'default',
						esc_html__( 'Hidden Buttons', 'penshop-addons' ) => 'hidden_buttons',
						esc_html__( 'Dark Name Bar', 'penshop-addons' )  => 'dark_name',
					),
				),
				array(
					'heading'     => esc_html__( 'Category', 'penshop-addons' ),
					'description' => esc_html__( 'Select what categories you want to use. Leave it empty to use all categories.', 'penshop-addons' ),
					'param_name'  => 'category',
					'type'        => 'autocomplete',
					'value'       => '',
					'settings'    => array(
						'multiple' => true,
						'sortable' => true,
						'values'   => $this->get_terms(),
					),
				),
				array(
					'heading'     => esc_html__( 'Use Categories as Tabs', 'penshop-addons' ),
					'description' => esc_html__( 'Use selected categories as tabs. Each tab will be a single carousel.', 'penshop-addons' ),
					'param_name'  => 'tab',
					'type'        => 'checkbox',
					'value'       => array( esc_html__( 'Yes', 'penshop-addons' ) => 'yes' ),
				),
				array(
					'heading'     => esc_html__( 'Adds "All" tab', 'penshop-addons' ),
					'description' => esc_html__( 'Adds "All" tab as the default tab.', 'penshop-addons' ),
					'param_name'  => 'tab_all',
					'type'        => 'checkbox',
					'value'       => array( esc_html__( 'Yes', 'penshop-addons' ) => 'yes' ),
					'std'         => 'yes',
					'dependency'  => array(
						'element' => 'tab',
						'value'   => 'yes',
					),
				),
				array(
					'heading'     => esc_html__( 'Product Type', 'penshop-addons' ),
					'description' => esc_html__( 'Select product type you want to show', 'penshop-addons' ),
					'param_name'  => 'type',
					'type'        => 'dropdown',
					'value'       => array(
						esc_html__( 'Recent Products', 'penshop-addons' )       => 'recent',
						esc_html__( 'Featured Products', 'penshop-addons' )     => 'featured',
						esc_html__( 'Sale Products', 'penshop-addons' )         => 'sale',
						esc_html__( 'Best Selling Products', 'penshop-addons' ) => 'best_sellers',
						esc_html__( 'Top Rated Products', 'penshop-addons' )    => 'top_rated',
					),
					'std'         => 'recent',
				),
				array(
					'heading'     => esc_html__( 'Number Of Products', 'penshop-addons' ),
					'description' => esc_html__( 'Total number of products you want to show. Set -1 to show all products', 'penshop-addons' ),
					'param_name'  => 'per_page',
					'type'        => 'textfield',
					'value'       => 10,
				),
				array(
					'heading'     => esc_html__( 'Columns', 'penshop-addons' ),
					'description' => esc_html__( 'Display products in how many columns', 'penshop-addons' ),
					'param_name'  => 'columns',
					'type'        => 'dropdown',
					'std'         => 4,
					'value'       => array(
						esc_html__( '3 Columns', 'penshop-addons' ) => 3,
						esc_html__( '4 Columns', 'penshop-addons' ) => 4,
						esc_html__( '5 Columns', 'penshop-addons' ) => 5,
					),
				),
				array(
					'heading'     => esc_html__( 'Auto Play', 'penshop-addons' ),
					'description' => esc_html__( 'Auto play speed in miliseconds. Enter "0" to disable auto play.', 'penshop-addons' ),
					'type'        => 'textfield',
					'param_name'  => 'autoplay',
					'value'       => 5000,
				),
				vc_map_add_css_animation(),
				array(
					'heading'     => esc_html__( 'Extra class name', 'penshop-addons' ),
					'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'penshop-addons' ),
					'param_name'  => 'el_class',
					'type'        => 'textfield',
					'value'       => '',
				),
			),
		) );

		// Product Grid
		vc_map( array(
			'name'        => esc_html__( 'Product Grid', 'penshop-addons' ),
			'description' => esc_html__( 'Grid of products', 'penshop-addons' ),
			'base'        => 'penshop_product_grid',
			'icon'        => $this->get_icon( 'product-grid.png' ),
			'category'    => esc_html__( 'PenShop', 'penshop-addons' ),
			'params'      => array(
				array(
					'heading'     => esc_html__( 'Product Style', 'penshop-addons' ),
					'description' => esc_html__( 'Select style', 'penshop-addons' ),
					'param_name'  => 'product_style',
					'type'        => 'dropdown',
					'value'       => array(
						esc_html__( 'Default', 'penshop-addons' )        => 'default',
						esc_html__( 'Hidden Buttons', 'penshop-addons' ) => 'hidden_buttons',
						esc_html__( 'Dark Name Bar', 'penshop-addons' )  => 'dark_name',
					),
				),
				array(
					'heading'     => esc_html__( 'Number Of Products', 'penshop-addons' ),
					'description' => esc_html__( 'Total number of products you want to show. Set -1 to show all products', 'penshop-addons' ),
					'param_name'  => 'per_page',
					'type'        => 'textfield',
					'value'       => 8,
				),
				array(
					'heading'     => esc_html__( 'Columns', 'penshop-addons' ),
					'description' => esc_html__( 'Display products in how many columns', 'penshop-addons' ),
					'param_name'  => 'columns',
					'type'        => 'dropdown',
					'std'         => 4,
					'value'       => array(
						esc_html__( '3 Columns', 'penshop-addons' ) => 3,
						esc_html__( '4 Columns', 'penshop-addons' ) => 4,
						esc_html__( '5 Columns', 'penshop-addons' ) => 5,
					),
				),
				array(
					'heading'     => esc_html__( 'Category', 'penshop-addons' ),
					'description' => esc_html__( 'Select what categories you want to use. Leave it empty to use all categories.', 'penshop-addons' ),
					'param_name'  => 'category',
					'type'        => 'autocomplete',
					'value'       => '',
					'settings'    => array(
						'multiple' => true,
						'sortable' => true,
						'values'   => $this->get_terms(),
					),
				),
				array(
					'heading'     => esc_html__( 'Product Type', 'penshop-addons' ),
					'description' => esc_html__( 'Select product type you want to show', 'penshop-addons' ),
					'param_name'  => 'type',
					'type'        => 'dropdown',
					'value'       => array(
						esc_html__( 'Recent Products', 'penshop-addons' )       => 'recent',
						esc_html__( 'Featured Products', 'penshop-addons' )     => 'featured',
						esc_html__( 'Sale Products', 'penshop-addons' )         => 'sale',
						esc_html__( 'Best Selling Products', 'penshop-addons' ) => 'best_sellers',
						esc_html__( 'Top Rated Products', 'penshop-addons' )    => 'top_rated',
					),
				),
				array(
					'heading'     => esc_html__( 'Load More Button', 'penshop-addons' ),
					'description' => esc_html__( 'Show a ajax load more button at the end of grid', 'penshop-addons' ),
					'param_name'  => 'load_more',
					'type'        => 'checkbox',
					'value'       => array(
						esc_html__( 'Yes', 'penshop-addons' ) => 'yes',
					),
				),
				array(
					'heading'     => esc_html__( 'Load More Text', 'penshop-addons' ),
					'description' => esc_html__( 'Load more button text', 'penshop-addons' ),
					'param_name'  => 'load_more_text',
					'type'        => 'textfield',
					'value'       => esc_html__( 'Load more products', 'penshop-addons' ),
					'dependency'  => array(
						'element' => 'load_more',
						'value'   => 'yes',
					),
				),
				vc_map_add_css_animation(),
				array(
					'heading'     => esc_html__( 'Extra class name', 'penshop-addons' ),
					'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'penshop-addons' ),
					'param_name'  => 'el_class',
					'type'        => 'textfield',
					'value'       => '',
				),
			),
		) );

		// Product Tabs
		vc_map( array(
			'name'        => esc_html__( 'Product Tabs', 'penshop-addons' ),
			'description' => esc_html__( 'Display product grids in tabs', 'penshop-addons' ),
			'base'        => 'penshop_product_tabs',
			'icon'        => $this->get_icon( 'product-tabs.png' ),
			'category'    => esc_html__( 'PenShop', 'penshop-addons' ),
			'params'      => array(
				array(
					'heading'     => esc_html__( 'Product Style', 'penshop-addons' ),
					'description' => esc_html__( 'Select style', 'penshop-addons' ),
					'param_name'  => 'product_style',
					'type'        => 'dropdown',
					'value'       => array(
						esc_html__( 'Default', 'penshop-addons' )        => 'default',
						esc_html__( 'Hidden Buttons', 'penshop-addons' ) => 'hidden_buttons',
						esc_html__( 'Dark Name Bar', 'penshop-addons' )  => 'dark_name',
					),
				),
				array(
					'heading'     => esc_html__( 'Number Of Products', 'penshop-addons' ),
					'description' => esc_html__( 'Total number of products you want to show. Set -1 to show all products', 'penshop-addons' ),
					'param_name'  => 'per_page',
					'type'        => 'textfield',
					'value'       => 8,
				),
				array(
					'heading'     => esc_html__( 'Columns', 'penshop-addons' ),
					'description' => esc_html__( 'Display products in how many columns', 'penshop-addons' ),
					'param_name'  => 'columns',
					'type'        => 'dropdown',
					'std'         => 4,
					'value'       => array(
						esc_html__( '3 Columns', 'penshop-addons' ) => 3,
						esc_html__( '4 Columns', 'penshop-addons' ) => 4,
						esc_html__( '5 Columns', 'penshop-addons' ) => 5,
					),
				),
				array(
					'heading'     => esc_html__( 'Tab Type', 'penshop-addons' ),
					'description' => esc_html__( 'Select what tab type do you want to use', 'penshop-addons' ),
					'param_name'  => 'tab_type',
					'admin_label' => true,
					'type'        => 'dropdown',
					'std'         => 'product_cat',
					'value'       => array(
						esc_html__( 'Categories', 'penshop-addons' ) => 'product_cat',
						esc_html__( 'Tags', 'penshop-addons' )       => 'product_tag',
						esc_html__( 'Groups', 'penshop-addons' )     => 'groups',
					),
				),
				array(
					'heading'     => esc_html__( 'Adds "All" tab', 'penshop-addons' ),
					'description' => esc_html__( 'Adds "All" tab as the default tab.', 'penshop-addons' ),
					'param_name'  => 'tab_all',
					'type'        => 'checkbox',
					'value'       => array( esc_html__( 'Yes', 'penshop-addons' ) => 'yes' ),
				),
				array(
					'heading'     => esc_html__( 'Category', 'penshop-addons' ),
					'description' => esc_html__( 'Select what categories you want to use.', 'penshop-addons' ),
					'param_name'  => 'category',
					'type'        => 'autocomplete',
					'value'       => '',
					'settings'    => array(
						'multiple' => true,
						'sortable' => true,
						'values'   => $this->get_terms(),
					),
					'dependency'  => array(
						'element' => 'tab_type',
						'value'   => 'product_cat',
					),
				),
				array(
					'heading'     => esc_html__( 'Tags', 'penshop-addons' ),
					'description' => esc_html__( 'Enter tag slugs. Separates by comma.', 'penshop-addons' ),
					'param_name'  => 'tag',
					'type'        => 'textfield',
					'value'       => '',
					'dependency'  => array(
						'element' => 'tab_type',
						'value'   => 'product_tag',
					),
				),
				array(
					'heading'     => esc_html__( 'Groups', 'penshop-addons' ),
					'description' => esc_html__( 'Select product types as groups.', 'penshop-addons' ),
					'param_name'  => 'groups',
					'type'        => 'param_group',
					'value'       => urlencode( json_encode( array(
						array(
							'type'  => 'best_sellers',
							'title' => esc_html__( 'Best Sellers', 'penshop-addons' ),
						),
						array(
							'type'  => 'recent',
							'title' => esc_html__( 'New Arrivals', 'penshop-addons' ),
						),
						array(
							'type'  => 'sale',
							'title' => esc_html__( 'Hot Sales', 'penshop-addons' ),
						),
					) ) ),
					'params'      => array(
						array(
							'heading'     => esc_html__( 'Type', 'penshop-addons' ),
							'description' => esc_html__( 'Select product type for this tab', 'penshop-addons' ),
							'param_name'  => 'type',
							'type'        => 'dropdown',
							'value'       => array(
								esc_html__( 'Recent Products', 'penshop-addons' )       => 'recent',
								esc_html__( 'Featured Products', 'penshop-addons' )     => 'featured',
								esc_html__( 'Sale Products', 'penshop-addons' )         => 'sale',
								esc_html__( 'Best Selling Products', 'penshop-addons' ) => 'best_sellers',
								esc_html__( 'Top Rated Products', 'penshop-addons' )    => 'top_rated',
							),
						),
						array(
							'heading'     => esc_html__( 'Title', 'penshop-addons' ),
							'description' => esc_html__( 'Enter title for this tab.', 'penshop-addons' ),
							'param_name'  => 'title',
							'type'        => 'textfield',
						),
					),
					'dependency'  => array(
						'element' => 'tab_type',
						'value'   => 'groups',
					),
				),
				array(
					'heading'     => esc_html__( 'Load More Button', 'penshop-addons' ),
					'description' => esc_html__( 'Show a ajax load more button at the end of grid', 'penshop-addons' ),
					'param_name'  => 'load_more',
					'type'        => 'checkbox',
					'value'       => array(
						esc_html__( 'Yes', 'penshop-addons' ) => 'yes',
					),
				),
				array(
					'heading'     => esc_html__( 'Load More Text', 'penshop-addons' ),
					'description' => esc_html__( 'Load more button text', 'penshop-addons' ),
					'param_name'  => 'load_more_text',
					'type'        => 'textfield',
					'value'       => esc_html__( 'Load more products', 'penshop-addons' ),
					'dependency'  => array(
						'element' => 'load_more',
						'value'   => 'yes',
					),
				),
				vc_map_add_css_animation(),
				array(
					'heading'     => esc_html__( 'Extra class name', 'penshop-addons' ),
					'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'penshop-addons' ),
					'param_name'  => 'el_class',
					'type'        => 'textfield',
					'value'       => '',
				),
			),
		) );

		// Product Category Grid
		vc_map( array(
			'name'        => esc_html__( 'Product Categories', 'penshop-addons' ),
			'description' => esc_html__( 'Product category grid', 'penshop-addons' ),
			'base'        => 'penshop_product_category_grid',
			'icon'        => $this->get_icon( 'product-categories.png' ),
			'category'    => esc_html__( 'PenShop', 'penshop-addons' ),
			'params'      => array(
				array(
					'heading'     => esc_html__( 'Present', 'penshop-addons' ),
					'description' => esc_html__( 'Select style of category item in grid', 'penshop-addons' ),
					'param_name'  => 'present',
					'type'        => 'dropdown',
					'std'         => 'default',
					'value'       => array(
						esc_html__( 'Default (Square)', 'penshop-addons' )   => 'default',
						esc_html__( 'Simple (Rectangle)', 'penshop-addons' ) => 'simple',
						esc_html__( 'Dark name bar', 'penshop-addons' )      => 'dark_name',
					),
				),
				array(
					'heading'     => esc_html__( 'Category', 'penshop-addons' ),
					'description' => esc_html__( 'Select what categories you want to show', 'penshop-addons' ),
					'admin_label' => true,
					'param_name'  => 'category',
					'type'        => 'autocomplete',
					'value'       => '',
					'settings'    => array(
						'multiple' => true,
						'sortable' => true,
						'values'   => $this->get_terms(),
					),
				),
				array(
					'heading'     => esc_html__( 'Use custom thumbnail', 'penshop-addons' ),
					'description' => esc_html__( 'Using custom images as category thumbnails instead of default thumbnails', 'penshop-addons' ),
					'param_name'  => 'custom_images',
					'type'        => 'checkbox',
					'value'       => array(
						esc_html__( 'Yes', 'penshop-addons' ) => 'yes',
					),
				),
				array(
					'heading'     => esc_html__( 'Custom Thumbnails', 'penshop-addons' ),
					'description' => esc_html__( 'Upload images for categories thumbnails. Place them in the same order as the order of categories', 'penshop-addons' ),
					'param_name'  => 'images',
					'type'        => 'attach_images',
					'dependency'  => array(
						'element' => 'custom_images',
						'value'   => 'yes',
					),
				),
				array(
					'heading'     => esc_html__( 'Columns', 'penshop-addons' ),
					'description' => esc_html__( 'Select number of columns for the grid', 'penshop-addons' ),
					'param_name'  => 'columns',
					'type'        => 'dropdown',
					'value'       => array(
						esc_html__( '2 Columns', 'penshop-addons' ) => 2,
						esc_html__( '3 Columns', 'penshop-addons' ) => 3,
						esc_html__( '4 Columns', 'penshop-addons' ) => 4,
					),
					'std'         => 3,
				),
				array(
					'heading'     => esc_html__( 'Category Gap', 'penshop-addons' ),
					'description' => esc_html__( 'Select gap between categories in grid', 'penshop-addons' ),
					'param_name'  => 'gap',
					'type'        => 'dropdown',
					'std'         => '3',
					'value'       => array(
						esc_html__( '0px', 'penshop-addons' )  => '0',
						esc_html__( '1px', 'penshop-addons' )  => '1',
						esc_html__( '2px', 'penshop-addons' )  => '2',
						esc_html__( '3px', 'penshop-addons' )  => '3',
						esc_html__( '4px', 'penshop-addons' )  => '4',
						esc_html__( '5px', 'penshop-addons' )  => '5',
						esc_html__( '10px', 'penshop-addons' ) => '10',
						esc_html__( '15px', 'penshop-addons' ) => '15',
						esc_html__( '20px', 'penshop-addons' ) => '20',
						esc_html__( '25px', 'penshop-addons' ) => '25',
						esc_html__( '30px', 'penshop-addons' ) => '30',
					),
				),
				vc_map_add_css_animation(),
				array(
					'heading'     => esc_html__( 'Extra class name', 'penshop-addons' ),
					'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'penshop-addons' ),
					'param_name'  => 'el_class',
					'type'        => 'textfield',
					'value'       => '',
				),
				array(
					'heading'    => esc_html__( 'Overlay', 'penshop-addons' ),
					'param_name' => 'overlay',
					'type'       => 'checkbox',
					'value'      => array( esc_html__( 'Yes', 'penshop-addons' ) => 'yes' ),
					'std'        => 'yes',
					'group'      => esc_html__( 'Overlay', 'penshop-addons' ),
				),
				array(
					'heading'    => esc_html__( 'Overlay Color', 'penshop-addons' ),
					'param_name' => 'overlay_color',
					'type'       => 'colorpicker',
					'value'      => '#000000',
					'group'      => esc_html__( 'Overlay', 'penshop-addons' ),
					'dependency' => array(
						'element' => 'overlay',
						'value'   => 'yes',
					),
				),
				array(
					'heading'     => esc_html__( 'Overlay Opacity', 'penshop-addons' ),
					'description' => esc_html__( 'Enter overlay opacity. Min 0, max 1.', 'penshop-addons' ),
					'param_name'  => 'overlay_opacity',
					'type'        => 'textfield',
					'value'       => '0.3',
					'group'       => esc_html__( 'Overlay', 'penshop-addons' ),
					'dependency'  => array(
						'element' => 'overlay',
						'value'   => 'yes',
					),
				),
				array(
					'heading'    => esc_html__( 'Overlay Hover Color', 'penshop-addons' ),
					'param_name' => 'overlay_hover_color',
					'type'       => 'colorpicker',
					'value'      => '#000000',
					'group'      => esc_html__( 'Overlay', 'penshop-addons' ),
					'dependency' => array(
						'element' => 'overlay',
						'value'   => 'yes',
					),
				),
				array(
					'heading'     => esc_html__( 'Overlay Hover Opacity', 'penshop-addons' ),
					'description' => esc_html__( 'Enter overlay hover opacity. Min 0, max 1.', 'penshop-addons' ),
					'param_name'  => 'overlay_hover_opacity',
					'type'        => 'textfield',
					'value'       => '0.3',
					'group'       => esc_html__( 'Overlay', 'penshop-addons' ),
					'dependency'  => array(
						'element' => 'overlay',
						'value'   => 'yes',
					),
				),
			),
		) );

		// Button
		vc_map( array(
			'name'        => esc_html__( 'Button', 'penshop-addons' ),
			'description' => esc_html__( 'Button in style', 'penshop-addons' ),
			'base'        => 'penshop_button',
			'icon'        => $this->get_icon( 'button.png' ),
			'category'    => esc_html__( 'PenShop', 'penshop-addons' ),
			'params'      => array(
				array(
					'heading'     => esc_html__( 'Text', 'penshop-addons' ),
					'description' => esc_html__( 'Enter button text', 'penshop-addons' ),
					'admin_label' => true,
					'type'        => 'textfield',
					'param_name'  => 'label',
					'value'       => esc_html__( 'Button Text', 'penshop-addons' ),
				),
				array(
					'heading'    => esc_html__( 'URL (Link)', 'penshop-addons' ),
					'type'       => 'vc_link',
					'param_name' => 'link',
				),
				array(
					'heading'     => esc_html__( 'Style', 'penshop-addons' ),
					'description' => esc_html__( 'Select button style', 'penshop-addons' ),
					'param_name'  => 'type',
					'type'        => 'dropdown',
					'value'       => array(
						esc_html__( 'Normal', 'penshop-addons' )                => 'normal',
						esc_html__( 'Outline', 'penshop-addons' )               => 'outline',
						esc_html__( 'Underline', 'penshop-addons' )             => 'underline',
						esc_html__( 'Plain with Arrow Icon', 'penshop-addons' ) => 'arrow',
					),
					'std'         => 'outline',
				),
				array(
					'heading'     => esc_html__( 'Size', 'penshop-addons' ),
					'description' => esc_html__( 'Select button size', 'penshop-addons' ),
					'param_name'  => 'size',
					'type'        => 'dropdown',
					'value'       => array(
						esc_html__( 'Small', 'penshop-addons' )   => 'small',
						esc_html__( 'Normal', 'penshop-addons' )  => 'normal',
						esc_html__( 'Large', 'penshop-addons' )   => 'large',
						esc_html__( 'X Large', 'penshop-addons' ) => 'xlarge',
					),
					'std'         => 'normal',
				),
				array(
					'heading'     => esc_html__( 'Color', 'penshop-addons' ),
					'description' => esc_html__( 'Select button color', 'penshop-addons' ),
					'param_name'  => 'color',
					'type'        => 'dropdown',
					'value'       => array(
						esc_html__( 'Dark', 'penshop-addons' )  => 'dark',
						esc_html__( 'White', 'penshop-addons' ) => 'white',
					),
				),
				array(
					'heading'     => esc_html__( 'Alignment', 'penshop-addons' ),
					'description' => esc_html__( 'Select button alignment', 'penshop-addons' ),
					'param_name'  => 'align',
					'type'        => 'dropdown',
					'value'       => array(
						esc_html__( 'Inline', 'penshop-addons' ) => 'inline',
						esc_html__( 'Left', 'penshop-addons' )   => 'left',
						esc_html__( 'Center', 'penshop-addons' ) => 'center',
						esc_html__( 'Right', 'penshop-addons' )  => 'right',
					),
				),
				vc_map_add_css_animation(),
				array(
					'heading'     => esc_html__( 'Extra class name', 'penshop-addons' ),
					'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'penshop-addons' ),
					'param_name'  => 'el_class',
					'type'        => 'textfield',
					'value'       => '',
				),
			),
		) );

		// Promotion
		vc_map( array(
			'name'        => esc_html__( 'Promotion', 'penshop-addons' ),
			'description' => esc_html__( 'Promotion banner with button', 'penshop-addons' ),
			'base'        => 'penshop_promotion',
			'icon'        => $this->get_icon( 'promotion.png' ),
			'category'    => esc_html__( 'PenShop', 'penshop-addons' ),
			'params'      => array(
				array(
					'heading'     => esc_html__( 'Image', 'penshop-addons' ),
					'description' => esc_html__( 'Background Image', 'penshop-addons' ),
					'param_name'  => 'image',
					'type'        => 'attach_image',
				),
				array(
					'heading'     => esc_html__( 'Style', 'penshop-addons' ),
					'description' => esc_html__( 'Select promotion style', 'penshop-addons' ),
					'param_name'  => 'type',
					'type'        => 'dropdown',
					'value'       => array(
						esc_html__( 'Default', 'penshop-addons' )  => 'default',
						esc_html__( 'Bordered', 'penshop-addons' ) => 'bordered',
					),
				),
				array(
					'heading'     => esc_html__( 'Promotion Text', 'penshop-addons' ),
					'description' => esc_html__( 'Enter the banner text content', 'penshop-addons' ),
					'type'        => 'textarea_html',
					'param_name'  => 'content',
					'admin_label' => true,
				),
				array(
					'heading'    => esc_html__( 'Button Text', 'penshop-addons' ),
					'param_name' => 'button_text',
					'type'       => 'textfield',
					'value'      => '',
				),
				array(
					'heading'    => esc_html__( 'Button Link', 'penshop-addons' ),
					'param_name' => 'button_link',
					'type'       => 'vc_link',
					'value'      => '',
				),
				vc_map_add_css_animation(),
				array(
					'heading'     => esc_html__( 'Extra class name', 'penshop-addons' ),
					'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'penshop-addons' ),
					'param_name'  => 'el_class',
					'type'        => 'textfield',
					'value'       => '',
				),
			),
		) );

		// Banner
		vc_map( array(
			'name'        => esc_html__( 'Banner', 'penshop-addons' ),
			'description' => esc_html__( 'Banner image with text and button', 'penshop-addons' ),
			'base'        => 'penshop_banner',
			'icon'        => $this->get_icon( 'banner.png' ),
			'category'    => esc_html__( 'PenShop', 'penshop-addons' ),
			'params'      => array(
				array(
					'heading'     => esc_html__( 'Image', 'penshop-addons' ),
					'description' => esc_html__( 'Banner Image', 'penshop-addons' ),
					'param_name'  => 'image',
					'type'        => 'attach_image',
				),
				array(
					'heading'     => esc_html__( 'Image size', 'penshop-addons' ),
					'description' => esc_html__( 'Enter image size. Example: "thumbnail", "medium", "large", "full" or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use "thumbnail" size.', 'penshop-addons' ),
					'type'        => 'textfield',
					'param_name'  => 'image_size',
					'value'       => 'full',
				),
				array(
					'heading'     => esc_html__( 'Content Present', 'penshop-addons' ),
					'description' => esc_html__( 'Select style of banner text.', 'penshop-addons' ),
					'param_name'  => 'content_present',
					'type'        => 'dropdown',
					'std'         => 'dark',
					'value'       => array(
						esc_html__( 'Two lines', 'penshop-addons' ) => 'default',
						esc_html__( 'Inline', 'penshop-addons' )    => 'inline',
					),
				),
				array(
					'heading'     => esc_html__( 'Title', 'penshop-addons' ),
					'description' => esc_html__( 'Banner title', 'penshop-addons' ),
					'param_name'  => 'title',
					'type'        => 'textfield',
					'admin_label' => true,
				),
				array(
					'heading'     => esc_html__( 'Subtitle', 'penshop-addons' ),
					'description' => esc_html__( 'Banner subtitle', 'penshop-addons' ),
					'param_name'  => 'subtitle',
					'type'        => 'textfield',
					'admin_label' => true,
				),
				array(
					'heading'    => esc_html__( 'Button Text', 'penshop-addons' ),
					'param_name' => 'button_text',
					'type'       => 'textfield',
					'value'      => esc_html__( 'Shop Now', 'penshop-addons' ),
				),
				array(
					'heading'    => esc_html__( 'Button Link', 'penshop-addons' ),
					'param_name' => 'button_link',
					'type'       => 'vc_link',
				),
				array(
					'heading'     => esc_html__( 'Color Scheme', 'penshop-addons' ),
					'description' => esc_html__( 'Select position for your banner content.', 'penshop-addons' ),
					'param_name'  => 'color_scheme',
					'type'        => 'dropdown',
					'std'         => 'dark',
					'value'       => array(
						esc_html__( 'Dark', 'penshop-addons' )  => 'dark',
						esc_html__( 'White', 'penshop-addons' ) => 'white',
					),
				),
				array(
					'heading'     => esc_html__( 'Banner Text Position', 'penshop-addons' ),
					'description' => esc_html__( 'Select position for your banner content.', 'penshop-addons' ),
					'param_name'  => 'text_position',
					'type'        => 'dropdown',
					'std'         => 'middle-center',
					'value'       => array(
						esc_html__( 'Top Left', 'penshop-addons' )      => 'top-left',
						esc_html__( 'Top Center', 'penshop-addons' )    => 'top-center',
						esc_html__( 'Top Right', 'penshop-addons' )     => 'top-right',
						esc_html__( 'Middle Left', 'penshop-addons' )   => 'middle-left',
						esc_html__( 'Middle Center', 'penshop-addons' ) => 'middle-center',
						esc_html__( 'Middle Right', 'penshop-addons' )  => 'middle-right',
						esc_html__( 'Bottom Left', 'penshop-addons' )   => 'bottom-left',
						esc_html__( 'Bottom Center', 'penshop-addons' ) => 'bottom-center',
						esc_html__( 'Bottom Right', 'penshop-addons' )  => 'bottom-right',
					),
				),
				vc_map_add_css_animation(),
				array(
					'heading'     => esc_html__( 'Extra class name', 'penshop-addons' ),
					'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'penshop-addons' ),
					'param_name'  => 'el_class',
					'type'        => 'textfield',
					'value'       => '',
				),
			),
		) );

		// Banner2
		vc_map( array(
			'name'        => esc_html__( 'Banner 2', 'penshop-addons' ),
			'description' => esc_html__( 'Simple banner with image and text', 'penshop-addons' ),
			'base'        => 'penshop_banner2',
			'icon'        => $this->get_icon( 'banner2.png' ),
			'category'    => esc_html__( 'PenShop', 'penshop-addons' ),
			'params'      => array(
				array(
					'heading'     => esc_html__( 'Image', 'penshop-addons' ),
					'description' => esc_html__( 'Banner Image', 'penshop-addons' ),
					'param_name'  => 'image',
					'type'        => 'attach_image',
				),
				array(
					'heading'     => esc_html__( 'Image size', 'penshop-addons' ),
					'description' => esc_html__( 'Enter image size. Example: "thumbnail", "medium", "large", "full" or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use "thumbnail" size.', 'penshop-addons' ),
					'type'        => 'textfield',
					'param_name'  => 'image_size',
					'value'       => 'full',
				),
				array(
					'heading'     => esc_html__( 'Link', 'penshop-addons' ),
					'description' => esc_html__( 'Banner URL', 'penshop-addons' ),
					'param_name'  => 'link',
					'type'        => 'vc_link',
				),
				array(
					'heading'     => esc_html__( 'Banner Text', 'penshop-addons' ),
					'param_name'  => 'content',
					'type'        => 'textarea',
					'admin_label' => true,
				),
				array(
					'heading'     => esc_html__( 'Text Alignment', 'penshop-addons' ),
					'description' => esc_html__( 'Select banner text alignment', 'penshop-addons' ),
					'param_name'  => 'text_align',
					'type'        => 'dropdown',
					'std'         => 'center',
					'value'       => array(
						esc_html__( 'Left', 'penshop-addons' )   => 'left',
						esc_html__( 'Center', 'penshop-addons' ) => 'center',
						esc_html__( 'Right', 'penshop-addons' )  => 'right',
					),
				),
				array(
					'heading'     => esc_html__( 'Color Scheme', 'penshop-addons' ),
					'description' => esc_html__( 'Select position for your banner content.', 'penshop-addons' ),
					'param_name'  => 'color_scheme',
					'type'        => 'dropdown',
					'std'         => 'dark',
					'value'       => array(
						esc_html__( 'Dark', 'penshop-addons' )  => 'dark',
						esc_html__( 'White', 'penshop-addons' ) => 'white',
					),
				),
				vc_map_add_css_animation(),
				array(
					'heading'     => esc_html__( 'Extra class name', 'penshop-addons' ),
					'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'penshop-addons' ),
					'param_name'  => 'el_class',
					'type'        => 'textfield',
					'value'       => '',
				),
			),
		) );

		// Banner Promotion
		vc_map( array(
			'name'        => esc_html__( 'Banner Promotion', 'penshop-addons' ),
			'description' => esc_html__( 'Simple banner with image and text', 'penshop-addons' ),
			'base'        => 'penshop_banner_promo',
			'icon'        => $this->get_icon( 'banner-promotion.png' ),
			'category'    => esc_html__( 'PenShop', 'penshop-addons' ),
			'params'      => array(
				array(
					'heading'     => esc_html__( 'Image', 'penshop-addons' ),
					'description' => esc_html__( 'Banner Image', 'penshop-addons' ),
					'param_name'  => 'image',
					'type'        => 'attach_image',
				),
				array(
					'heading'     => esc_html__( 'Image size', 'penshop-addons' ),
					'description' => esc_html__( 'Enter image size. Example: "thumbnail", "medium", "large", "full" or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use "thumbnail" size.', 'penshop-addons' ),
					'type'        => 'textfield',
					'param_name'  => 'image_size',
					'value'       => 'full',
				),
				array(
					'heading'     => esc_html__( 'Image position', 'penshop-addons' ),
					'description' => esc_html__( 'Select image position', 'penshop-addons' ),
					'param_name'  => 'image_pos',
					'type'        => 'dropdown',
					'value'       => array(
						esc_html__( 'Left', 'penshop-addons' )  => 'left',
						esc_html__( 'Right', 'penshop-addons' ) => 'right',
					),
				),
				array(
					'heading'     => esc_html__( 'Link', 'penshop-addons' ),
					'description' => esc_html__( 'Banner URL', 'penshop-addons' ),
					'param_name'  => 'link',
					'type'        => 'vc_link',
				),
				array(
					'heading'     => esc_html__( 'Banner Title', 'penshop-addons' ),
					'param_name'  => 'title',
					'type'        => 'textfield',
					'admin_label' => true,
				),
				array(
					'heading'    => esc_html__( 'Banner Content', 'penshop-addons' ),
					'param_name' => 'content',
					'type'       => 'textarea',
				),
				vc_map_add_css_animation(),
				array(
					'heading'     => esc_html__( 'Extra class name', 'penshop-addons' ),
					'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'penshop-addons' ),
					'param_name'  => 'el_class',
					'type'        => 'textfield',
					'value'       => '',
				),
			),
		) );

		// Carousel
		vc_map( array(
			'name'            => esc_html__( 'Carousel', 'penshop-addons' ),
			'description'     => esc_html__( 'Image carousel', 'penshop-addons' ),
			'base'            => 'penshop_carousel',
			'as_parent'       => array( 'only' => 'penshop_carousel_item' ),
			'content_element' => true,
			'icon'            => $this->get_icon( 'carousel.png' ),
			'category'        => esc_html__( 'PenShop', 'penshop-addons' ),
			'js_view'         => 'VcColumnView',
			'params'          => array(
				array(
					'heading'     => esc_html__( 'Items', 'penshop-addons' ),
					'description' => esc_html__( 'Number of visible items', 'penshop-addons' ),
					'param_name'  => 'items',
					'type'        => 'textfield',
					'value'       => 3,
				),
				array(
					'heading'     => esc_html__( 'Items Gap', 'penshop-addons' ),
					'description' => esc_html__( 'Gap between items in pixel', 'penshop-addons' ),
					'param_name'  => 'margin',
					'type'        => 'textfield',
					'value'       => 3,
				),
				array(
					'heading'     => esc_html__( 'Loop', 'penshop-addons' ),
					'description' => esc_html__( 'Infinity loop', 'penshop-addons' ),
					'param_name'  => 'loop',
					'type'        => 'checkbox',
					'value'       => array( esc_html__( 'Yes', 'penshop-addons' ) => 'yes' ),
				),
				array(
					'heading'     => esc_html__( 'Auto-width', 'penshop-addons' ),
					'description' => esc_html__( 'Do not use equal width items', 'penshop-addons' ),
					'param_name'  => 'autowidth',
					'type'        => 'checkbox',
					'std'         => 'yes',
					'value'       => array( esc_html__( 'Yes', 'penshop-addons' ) => 'yes' ),
				),
				array(
					'heading'     => esc_html__( 'Height', 'penshop-addons' ),
					'description' => esc_html__( 'Carousel height', 'penshop-addons' ),
					'param_name'  => 'height',
					'type'        => 'textfield',
					'value'       => '700px',
				),
				array(
					'heading'     => esc_html__( 'Full Height', 'penshop-addons' ),
					'description' => esc_html__( 'Force the height to fit with viewport. Ignore the option Height above.', 'penshop-addons' ),
					'param_name'  => 'full_height',
					'type'        => 'checkbox',
					'value'       => array( esc_html__( 'Yes', 'penshop-addons' ) => 'yes' ),
				),
				array(
					'heading'     => esc_html__( 'Decrease Full Height', 'penshop-addons' ),
					'description' => esc_html__( 'Enter element ID or a number. Example: #masthead, #colophon, #somecontainer or 100px | Height of Slider will be decreased with the height of these Containers to fit perfect in the screen.', 'penshop-addons' ),
					'param_name'  => 'offset',
					'type'        => 'textfield',
					'dependency'  => array(
						'element' => 'full_height',
						'value'   => 'yes',
					),
				),
				array(
					'heading'     => esc_html__( 'Auto Play', 'penshop-addons' ),
					'description' => esc_html__( 'Auto play speed in miliseconds. Enter "0" to disable auto play.', 'penshop-addons' ),
					'type'        => 'textfield',
					'param_name'  => 'autoplay',
					'value'       => 5000,
				),
				vc_map_add_css_animation(),
				array(
					'heading'     => esc_html__( 'Extra class name', 'penshop-addons' ),
					'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'penshop-addons' ),
					'param_name'  => 'el_class',
					'type'        => 'textfield',
					'value'       => '',
				),
			),
		) );

		// Carousel Item
		vc_map( array(
			'name'     => esc_html__( 'Carousel Item', 'penshop-addons' ),
			'base'     => 'penshop_carousel_item',
			'as_child' => array( 'only' => 'penshop_carousel' ),
			'icon'     => $this->get_icon( 'carousel-item.png' ),
			'category' => esc_html__( 'PenShop', 'penshop-addons' ),
			'params'   => array(
				array(
					'heading'     => esc_html__( 'Image', 'penshop-addons' ),
					'description' => esc_html__( 'Slide Image', 'penshop-addons' ),
					'param_name'  => 'image',
					'type'        => 'attach_image',
				),
				array(
					'heading'     => esc_html__( 'Image size', 'penshop-addons' ),
					'description' => esc_html__( 'Enter image size. Example: "thumbnail", "medium", "large", "full" or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use "thumbnail" size.', 'penshop-addons' ),
					'type'        => 'textfield',
					'param_name'  => 'image_size',
					'value'       => 'full',
				),
				array(
					'heading'     => esc_html__( 'Content Position', 'penshop-addons' ),
					'description' => esc_html__( 'Slide text position', 'penshop-addons' ),
					'param_name'  => 'text_position',
					'type'        => 'dropdown',
					'value'       => array(
						esc_html__( 'Top Left', 'penshop-addons' )      => 'top-left',
						esc_html__( 'Top Center', 'penshop-addons' )    => 'top-center',
						esc_html__( 'Top Right', 'penshop-addons' )     => 'top-right',
						esc_html__( 'Middle Left', 'penshop-addons' )   => 'middle-left',
						esc_html__( 'Middle Center', 'penshop-addons' ) => 'middle-center',
						esc_html__( 'Middle Right', 'penshop-addons' )  => 'middle-right',
						esc_html__( 'Bottom Left', 'penshop-addons' )   => 'bottom-left',
						esc_html__( 'Bottom Center', 'penshop-addons' ) => 'bottom-center',
						esc_html__( 'Bottom Right', 'penshop-addons' )  => 'bottom-right',
					),
				),
				array(
					'heading'     => esc_html__( 'Text Align', 'penshop-addons' ),
					'description' => esc_html__( 'Slide text align', 'penshop-addons' ),
					'param_name'  => 'text_align',
					'type'        => 'dropdown',
					'value'       => array(
						esc_html__( 'Left', 'penshop-addons' )   => 'left',
						esc_html__( 'Center', 'penshop-addons' ) => 'center',
						esc_html__( 'Right', 'penshop-addons' )  => 'right',
					),
				),
				array(
					'heading'     => esc_html__( 'Content', 'penshop-addons' ),
					'description' => esc_html__( 'Enter content of carousel item.', 'penshop-addons' ),
					'type'        => 'textarea_html',
					'param_name'  => 'content',
					'admin_label' => true,
				),
				array(
					'heading'     => esc_html__( 'Extra class name', 'penshop-addons' ),
					'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'penshop-addons' ),
					'param_name'  => 'el_class',
					'type'        => 'textfield',
					'value'       => '',
				),
			),
		) );

		// Icon List
		vc_map( array(
			'name'            => esc_html__( 'Icon List', 'penshop-addons' ),
			'description'     => esc_html__( 'List with custom bullet icon', 'penshop-addons' ),
			'base'            => 'penshop_icon_list',
			'as_parent'       => array( 'only' => 'penshop_icon_list_item' ),
			'content_element' => true,
			'icon'            => $this->get_icon( 'icon-list.png' ),
			'category'        => esc_html__( 'PenShop', 'penshop-addons' ),
			'js_view'         => 'VcColumnView',
			'params'          => array(
				array(
					'heading'     => esc_html__( 'Icon library', 'penshop-addons' ),
					'description' => esc_html__( 'Select icon library.', 'penshop-addons' ),
					'param_name'  => 'icon_type',
					'type'        => 'dropdown',
					'value'       => array(
						esc_html__( 'Font Awesome', 'penshop-addons' ) => 'fontawesome',
						esc_html__( 'Open Iconic', 'penshop-addons' )  => 'openiconic',
						esc_html__( 'Typicons', 'penshop-addons' )     => 'typicons',
						esc_html__( 'Entypo', 'penshop-addons' )       => 'entypo',
						esc_html__( 'Linecons', 'penshop-addons' )     => 'linecons',
						esc_html__( 'Mono Social', 'penshop-addons' )  => 'monosocial',
						esc_html__( 'Material', 'penshop-addons' )     => 'material',
					),
				),
				array(
					'heading'     => esc_html__( 'Icon', 'penshop-addons' ),
					'description' => esc_html__( 'Pick an icon from library.', 'penshop-addons' ),
					'type'        => 'iconpicker',
					'param_name'  => 'icon_fontawesome',
					'value'       => 'fa fa-adjust',
					'settings'    => array(
						'emptyIcon'    => false,
						'iconsPerPage' => 4000,
					),
					'dependency'  => array(
						'element' => 'icon_type',
						'value'   => 'fontawesome',
					),
				),
				array(
					'heading'     => esc_html__( 'Icon', 'penshop-addons' ),
					'description' => esc_html__( 'Pick icon from library.', 'penshop-addons' ),
					'type'        => 'iconpicker',
					'param_name'  => 'icon_openiconic',
					'value'       => 'vc-oi vc-oi-dial',
					'settings'    => array(
						'emptyIcon'    => false,
						'type'         => 'openiconic',
						'iconsPerPage' => 4000,
					),
					'dependency'  => array(
						'element' => 'icon_type',
						'value'   => 'openiconic',
					),
				),
				array(
					'heading'     => esc_html__( 'Icon', 'penshop-addons' ),
					'description' => esc_html__( 'Pick icon from library.', 'penshop-addons' ),
					'type'        => 'iconpicker',
					'param_name'  => 'icon_typicons',
					'value'       => 'typcn typcn-adjust-brightness',
					'settings'    => array(
						'emptyIcon'    => false,
						'type'         => 'typicons',
						'iconsPerPage' => 4000,
					),
					'dependency'  => array(
						'element' => 'icon_type',
						'value'   => 'typicons',
					),
				),
				array(
					'heading'     => esc_html__( 'Icon', 'penshop-addons' ),
					'description' => esc_html__( 'Pick icon from library.', 'penshop-addons' ),
					'type'        => 'iconpicker',
					'param_name'  => 'icon_entypo',
					'value'       => 'entypo-icon entypo-icon-note',
					'settings'    => array(
						'emptyIcon'    => false,
						'type'         => 'entypo',
						'iconsPerPage' => 4000,
					),
					'dependency'  => array(
						'element' => 'icon_type',
						'value'   => 'entypo',
					),
				),
				array(
					'heading'     => esc_html__( 'Icon', 'penshop-addons' ),
					'description' => esc_html__( 'Pick icon from library.', 'penshop-addons' ),
					'type'        => 'iconpicker',
					'param_name'  => 'icon_linecons',
					'value'       => 'vc_li vc_li-heart',
					'settings'    => array(
						'emptyIcon'    => false,
						'type'         => 'linecons',
						'iconsPerPage' => 4000,
					),
					'dependency'  => array(
						'element' => 'icon_type',
						'value'   => 'linecons',
					),
				),
				array(
					'heading'     => esc_html__( 'Icon', 'penshop-addons' ),
					'description' => esc_html__( 'Pick icon from library.', 'penshop-addons' ),
					'type'        => 'iconpicker',
					'param_name'  => 'icon_monosocial',
					'value'       => 'vc-mono vc-mono-fivehundredpx',
					'settings'    => array(
						'emptyIcon'    => false,
						'type'         => 'monosocial',
						'iconsPerPage' => 4000,
					),
					'dependency'  => array(
						'element' => 'icon_type',
						'value'   => 'monosocial',
					),
				),
				array(
					'heading'     => esc_html__( 'Icon', 'penshop-addons' ),
					'description' => esc_html__( 'Pick icon from library.', 'penshop-addons' ),
					'type'        => 'iconpicker',
					'param_name'  => 'icon_material',
					'value'       => 'vc-material vc-material-cake',
					'settings'    => array(
						'emptyIcon'    => false,
						'type'         => 'material',
						'iconsPerPage' => 4000,
					),
					'dependency'  => array(
						'element' => 'icon_type',
						'value'   => 'material',
					),
				),
				vc_map_add_css_animation( false ),
				array(
					'heading'     => esc_html__( 'Extra class name', 'penshop-addons' ),
					'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'penshop-addons' ),
					'param_name'  => 'el_class',
					'type'        => 'textfield',
					'value'       => '',
				),
			),
		) );

		// Icon List Item
		vc_map( array(
			'name'     => esc_html__( 'Icon List Item', 'penshop-addons' ),
			'base'     => 'penshop_icon_list_item',
			'as_child' => array( 'only' => 'penshop_icon_list' ),
			'icon'     => $this->get_icon( 'icon-list-item.png' ),
			'category' => esc_html__( 'PenShop', 'penshop-addons' ),
			'params'   => array(
				array(
					'heading'     => esc_html__( 'Text', 'penshop-addons' ),
					'param_name'  => 'content',
					'type'        => 'textfield',
					'admin_label' => true,
				),
				array(
					'heading'     => esc_html__( 'Icon library', 'penshop-addons' ),
					'description' => esc_html__( 'Use default icon or custom icon for this item.', 'penshop-addons' ),
					'param_name'  => 'icon_type',
					'type'        => 'dropdown',
					'value'       => array(
						esc_html__( 'Default Icon', 'penshop-addons' ) => 'default',
						esc_html__( 'Font Awesome', 'penshop-addons' ) => 'fontawesome',
						esc_html__( 'Open Iconic', 'penshop-addons' )  => 'openiconic',
						esc_html__( 'Typicons', 'penshop-addons' )     => 'typicons',
						esc_html__( 'Entypo', 'penshop-addons' )       => 'entypo',
						esc_html__( 'Linecons', 'penshop-addons' )     => 'linecons',
						esc_html__( 'Mono Social', 'penshop-addons' )  => 'monosocial',
						esc_html__( 'Material', 'penshop-addons' )     => 'material',
					),
				),
				array(
					'heading'     => esc_html__( 'Icon', 'penshop-addons' ),
					'description' => esc_html__( 'Pick an icon from library.', 'penshop-addons' ),
					'type'        => 'iconpicker',
					'param_name'  => 'icon_fontawesome',
					'value'       => 'fa fa-adjust',
					'settings'    => array(
						'emptyIcon'    => false,
						'iconsPerPage' => 4000,
					),
					'dependency'  => array(
						'element' => 'icon_type',
						'value'   => 'fontawesome',
					),
				),
				array(
					'heading'     => esc_html__( 'Icon', 'penshop-addons' ),
					'description' => esc_html__( 'Pick icon from library.', 'penshop-addons' ),
					'type'        => 'iconpicker',
					'param_name'  => 'icon_openiconic',
					'value'       => 'vc-oi vc-oi-dial',
					'settings'    => array(
						'emptyIcon'    => false,
						'type'         => 'openiconic',
						'iconsPerPage' => 4000,
					),
					'dependency'  => array(
						'element' => 'icon_type',
						'value'   => 'openiconic',
					),
				),
				array(
					'heading'     => esc_html__( 'Icon', 'penshop-addons' ),
					'description' => esc_html__( 'Pick icon from library.', 'penshop-addons' ),
					'type'        => 'iconpicker',
					'param_name'  => 'icon_typicons',
					'value'       => 'typcn typcn-adjust-brightness',
					'settings'    => array(
						'emptyIcon'    => false,
						'type'         => 'typicons',
						'iconsPerPage' => 4000,
					),
					'dependency'  => array(
						'element' => 'icon_type',
						'value'   => 'typicons',
					),
				),
				array(
					'heading'     => esc_html__( 'Icon', 'penshop-addons' ),
					'description' => esc_html__( 'Pick icon from library.', 'penshop-addons' ),
					'type'        => 'iconpicker',
					'param_name'  => 'icon_entypo',
					'value'       => 'entypo-icon entypo-icon-note',
					'settings'    => array(
						'emptyIcon'    => false,
						'type'         => 'entypo',
						'iconsPerPage' => 4000,
					),
					'dependency'  => array(
						'element' => 'icon_type',
						'value'   => 'entypo',
					),
				),
				array(
					'heading'     => esc_html__( 'Icon', 'penshop-addons' ),
					'description' => esc_html__( 'Pick icon from library.', 'penshop-addons' ),
					'type'        => 'iconpicker',
					'param_name'  => 'icon_linecons',
					'value'       => 'vc_li vc_li-heart',
					'settings'    => array(
						'emptyIcon'    => false,
						'type'         => 'linecons',
						'iconsPerPage' => 4000,
					),
					'dependency'  => array(
						'element' => 'icon_type',
						'value'   => 'linecons',
					),
				),
				array(
					'heading'     => esc_html__( 'Icon', 'penshop-addons' ),
					'description' => esc_html__( 'Pick icon from library.', 'penshop-addons' ),
					'type'        => 'iconpicker',
					'param_name'  => 'icon_monosocial',
					'value'       => 'vc-mono vc-mono-fivehundredpx',
					'settings'    => array(
						'emptyIcon'    => false,
						'type'         => 'monosocial',
						'iconsPerPage' => 4000,
					),
					'dependency'  => array(
						'element' => 'icon_type',
						'value'   => 'monosocial',
					),
				),
				array(
					'heading'     => esc_html__( 'Icon', 'penshop-addons' ),
					'description' => esc_html__( 'Pick icon from library.', 'penshop-addons' ),
					'type'        => 'iconpicker',
					'param_name'  => 'icon_material',
					'value'       => 'vc-material vc-material-cake',
					'settings'    => array(
						'emptyIcon'    => false,
						'type'         => 'material',
						'iconsPerPage' => 4000,
					),
					'dependency'  => array(
						'element' => 'icon_type',
						'value'   => 'material',
					),
				),
				array(
					'heading'     => esc_html__( 'Extra class name', 'penshop-addons' ),
					'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'penshop-addons' ),
					'param_name'  => 'el_class',
					'type'        => 'textfield',
					'value'       => '',
				),
			),
		) );

		// Post Grid
		vc_map( array(
			'name'        => esc_html__( 'Post Grid', 'penshop-addons' ),
			'description' => esc_html__( 'Display posts in grid', 'penshop-addons' ),
			'base'        => 'penshop_post_grid',
			'icon'        => $this->get_icon( 'post-grid.png' ),
			'category'    => esc_html__( 'PenShop', 'penshop-addons' ),
			'params'      => array(
				array(
					'description' => esc_html__( 'Number of posts you want to show', 'penshop-addons' ),
					'heading'     => esc_html__( 'Number of posts', 'penshop-addons' ),
					'param_name'  => 'per_page',
					'type'        => 'textfield',
					'value'       => 3,
				),
				array(
					'heading'     => esc_html__( 'Columns', 'penshop-addons' ),
					'description' => esc_html__( 'Display posts in how many columns', 'penshop-addons' ),
					'param_name'  => 'columns',
					'type'        => 'dropdown',
					'value'       => array(
						esc_html__( '3 Columns', 'penshop-addons' ) => 3,
						esc_html__( '4 Columns', 'penshop-addons' ) => 4,
					),
				),
				array(
					'heading'     => esc_html__( 'Category', 'penshop-addons' ),
					'description' => esc_html__( 'Enter categories name', 'penshop-addons' ),
					'param_name'  => 'category',
					'type'        => 'autocomplete',
					'settings'    => array(
						'multiple' => true,
						'sortable' => true,
						'values'   => $this->get_terms( 'category' ),
					),
				),
				vc_map_add_css_animation(),
				array(
					'heading'     => esc_html__( 'Extra class name', 'penshop-addons' ),
					'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'penshop-addons' ),
					'param_name'  => 'el_class',
					'type'        => 'textfield',
					'value'       => '',
				),
			),
		) );

		// Countdown
		vc_map( array(
			'name'        => esc_html__( 'Countdown', 'penshop-addons' ),
			'description' => esc_html__( 'Countdown digital clock', 'penshop-addons' ),
			'base'        => 'penshop_countdown',
			'icon'        => $this->get_icon( 'countdown.png' ),
			'category'    => esc_html__( 'PenShop', 'penshop-addons' ),
			'params'      => array(
				array(
					'heading'     => esc_html__( 'Date', 'penshop-addons' ),
					'description' => esc_html__( 'Enter the date in format: YYYY/MM/DD', 'penshop-addons' ),
					'admin_label' => true,
					'type'        => 'textfield',
					'param_name'  => 'date',
				),
				array(
					'heading'     => esc_html__( 'Color Scheme', 'penshop-addons' ),
					'description' => esc_html__( 'Select color', 'penshop-addons' ),
					'param_name'  => 'color_scheme',
					'type'        => 'dropdown',
					'value'       => array(
						esc_html__( 'Dark', 'penshop-addons' )  => 'dark',
						esc_html__( 'White', 'penshop-addons' ) => 'white',
					),
				),
				array(
					'heading'     => esc_html__( 'Text Align', 'penshop-addons' ),
					'description' => esc_html__( 'Select text alignment', 'penshop-addons' ),
					'param_name'  => 'text_align',
					'type'        => 'dropdown',
					'value'       => array(
						esc_html__( 'Left', 'penshop-addons' )   => 'left',
						esc_html__( 'Center', 'penshop-addons' ) => 'center',
						esc_html__( 'Right', 'penshop-addons' )  => 'right',
					),
				),
				vc_map_add_css_animation(),
				array(
					'heading'     => esc_html__( 'Extra class name', 'penshop-addons' ),
					'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'penshop-addons' ),
					'param_name'  => 'el_class',
					'type'        => 'textfield',
					'value'       => '',
				),
			),
		) );

		// Google Map
		vc_map( array(
			'name'        => esc_html__( 'Google Maps', 'penshop-addons' ),
			'description' => esc_html__( 'Google maps in style', 'penshop-addons' ),
			'base'        => 'penshop_map',
			'icon'        => $this->get_icon( 'map.png' ),
			'category'    => esc_html__( 'PenShop', 'penshop-addons' ),
			'params'      => array(
				array(
					'heading'     => esc_html__( 'API Key', 'penshop-addons' ),
					'description' => esc_html__( 'Google requires an API key to work.', 'penshop-addons' ),
					'type'        => 'textfield',
					'param_name'  => 'api_key',
				),
				array(
					'heading'     => esc_html__( 'Address', 'penshop-addons' ),
					'description' => esc_html__( 'Enter address for map marker. If this option does not work, use the Latitude and Longitude options bellow.', 'penshop-addons' ),
					'type'        => 'textfield',
					'param_name'  => 'address',
					'admin_label' => true,
				),
				array(
					'heading'          => esc_html__( 'Latitude', 'sober' ),
					'type'             => 'textfield',
					'edit_field_class' => 'vc_col-xs-6',
					'param_name'       => 'lat',
					'admin_label'      => true,
				),
				array(
					'heading'          => esc_html__( 'Longitude', 'sober' ),
					'type'             => 'textfield',
					'param_name'       => 'lng',
					'edit_field_class' => 'vc_col-xs-6',
					'admin_label'      => true,
				),
				array(
					'heading'     => esc_html__( 'Marker', 'penshop-addons' ),
					'description' => esc_html__( 'Upload custom marker icon or leave this to use default marker.', 'penshop-addons' ),
					'param_name'  => 'marker',
					'type'        => 'attach_image',
				),
				array(
					'heading'     => esc_html__( 'Width', 'penshop-addons' ),
					'description' => esc_html__( 'Map width in pixel or percentage.', 'penshop-addons' ),
					'param_name'  => 'width',
					'type'        => 'textfield',
					'value'       => '100%',
				),
				array(
					'heading'     => esc_html__( 'Height', 'penshop-addons' ),
					'description' => esc_html__( 'Map height in pixel.', 'penshop-addons' ),
					'type'        => 'textfield',
					'param_name'  => 'height',
					'value'       => '512px',
				),
				array(
					'heading'     => esc_html__( 'Zoom', 'penshop-addons' ),
					'description' => esc_html__( 'Enter zoom level. The value is between 1 and 20.', 'penshop-addons' ),
					'param_name'  => 'zoom',
					'type'        => 'textfield',
					'value'       => '13',
				),
				array(
					'heading'     => esc_html__( 'Content', 'penshop-addons' ),
					'description' => esc_html__( 'Enter content of info window.', 'penshop-addons' ),
					'type'        => 'textarea_html',
					'param_name'  => 'content',
				),
				vc_map_add_css_animation(),
				array(
					'heading'     => esc_html__( 'Extra class name', 'penshop-addons' ),
					'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'penshop-addons' ),
					'type'        => 'textfield',
					'param_name'  => 'el_class',
				),
			),
		) );

		// FAQ
		vc_map( array(
			'name'        => esc_html__( 'FAQ', 'penshop-addons' ),
			'description' => esc_html__( 'Question and answer toggle', 'penshop-addons' ),
			'base'        => 'penshop_faq',
			'icon'        => $this->get_icon( 'faq.png' ),
			'category'    => esc_html__( 'PenShop', 'penshop-addons' ),
			'js_view'     => 'VcToggleView',
			'params'      => array(
				array(
					'heading'     => esc_html__( 'Question', 'penshop-addons' ),
					'description' => esc_html__( 'Enter title of toggle block.', 'penshop-addons' ),
					'type'        => 'textfield',
					'class'       => 'vc_toggle_title wpb_element_title',
					'param_name'  => 'title',
					'value'       => esc_html__( 'Question content goes here', 'penshop-addons' ),
				),
				array(
					'heading'     => esc_html__( 'Answer', 'penshop-addons' ),
					'description' => esc_html__( 'Toggle block content.', 'penshop-addons' ),
					'type'        => 'textarea_html',
					'class'       => 'vc_toggle_content',
					'param_name'  => 'content',
					'value'       => esc_html__( 'Answer content goes here, click edit button to change this text.', 'penshop-addons' ),
				),
				array(
					'heading'     => esc_html__( 'Default state', 'penshop-addons' ),
					'description' => esc_html__( 'Select "Open" if you want toggle to be open by default.', 'penshop-addons' ),
					'type'        => 'dropdown',
					'param_name'  => 'open',
					'value'       => array(
						esc_html__( 'Closed', 'penshop-addons' ) => 'false',
						esc_html__( 'Open', 'penshop-addons' )   => 'true',
					),
				),
				vc_map_add_css_animation(),
				array(
					'heading'     => esc_html__( 'Extra class name', 'penshop-addons' ),
					'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'penshop-addons' ),
					'param_name'  => 'el_class',
					'type'        => 'textfield',
				),
			),
		) );

		// Newsletter
		if ( defined( 'MC4WP_VERSION' ) ) {
			$mail_forms    = get_posts( 'post_type=mc4wp-form&number=-1' );
			$mail_form_ids = array();

			foreach ( $mail_forms as $form ) {
				$title                   = $form->post_title ? $form->post_title : 'Form #' . $form->ID;
				$mail_form_ids[ $title ] = $form->ID;
			}

			vc_map( array(
				'name'        => esc_html__( 'MailChimp Newsletter', 'penshop-addons' ),
				'description' => esc_html__( 'Subscribe form of MailChimp for WP', 'penshop-addons' ),
				'base'        => 'penshop_newsletter',
				'icon'        => $this->get_icon( 'mailchimp.png' ),
				'category'    => esc_html__( 'PenShop', 'penshop-addons' ),
				'params'      => array(
					array(
						'heading'     => esc_html__( 'Style', 'penshop-addons' ),
						'description' => esc_html__( 'Select style', 'penshop-addons' ),
						'param_name'  => 'style',
						'type'        => 'dropdown',
						'value'       => array(
							esc_html__( 'Shadow Box', 'penshop-addons' )   => 'shadow',
							esc_html__( 'Bordered Box', 'penshop-addons' ) => 'border',
							esc_html__( 'Flat', 'penshop-addons' )         => 'flat',
						),
					),
					array(
						'type'        => 'textarea_html',
						'heading'     => esc_html__( 'Description', 'penshop-addons' ),
						'param_name'  => 'content',
						'description' => esc_html__( 'Enter a short description for your subscribe form', 'penshop-addons' ),
					),
					array(
						'type'        => 'dropdown',
						'heading'     => esc_html__( 'Mailchimp Form', 'penshop-addons' ),
						'param_name'  => 'form',
						'admin_label' => true,
						'value'       => $mail_form_ids,
					),
					vc_map_add_css_animation(),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Extra class name', 'penshop-addons' ),
						'param_name'  => 'el_class',
						'value'       => '',
						'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'penshop-addons' ),
					),
				),
			) );
		}

		if ( post_type_exists( 'penshop_slider' ) ) {
			$sliders = get_posts( array(
				'posts_per_page' => -1,
				'post_type'      => 'penshop_slider',
			) );

			$options = array(
				'' => esc_html__( 'Select a slider', 'penshop-addons' )
			);

			foreach ( $sliders as $slider ) {
				$options[ $slider->post_title ] = $slider->post_name;
			}

			vc_map( array(
				'name'        => esc_html__( 'PenShop Slider', 'penshop-addons' ),
				'description' => esc_html__( 'PenShop image slider', 'penshop-addons' ),
				'base'        => 'penshop_slider',
				'icon'        => $this->get_icon( 'slider.png' ),
				'category'    => esc_html__( 'PenShop', 'penshop-addons' ),
				'params'      => array(
					array(
						'heading'     => esc_html__( 'Slider', 'penshop-addons' ),
						'description' => esc_html__( 'Select slider', 'penshop-addons' ),
						'param_name'  => 'name',
						'admin_label' => true,
						'type'        => 'dropdown',
						'value'       => $options,
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Extra class name', 'penshop-addons' ),
						'param_name'  => 'el_class',
						'value'       => '',
						'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'penshop-addons' ),
					),
				),
			) );
		}
	}

	/**
	 * Get category for auto complete field
	 *
	 * @param string $taxonomy
	 *
	 * @return array
	 */
	protected function get_terms( $taxonomy = 'product_cat' ) {
		// We don't want to query all terms again
		if ( isset( $this->terms[ $taxonomy ] ) ) {
			return $this->terms[ $taxonomy ];
		}

		$cats = get_terms( array( 'taxonomy' => $taxonomy, 'hide_empty' => false ) );
		if ( ! $cats || is_wp_error( $cats ) ) {
			return array();
		}

		$categories = array();
		foreach ( $cats as $cat ) {
			$categories[] = array(
				'label' => $cat->name,
				'value' => $cat->slug,
				'group' => 'category',
			);
		}

		// Store this in order to avoid double query this
		$this->terms[ $taxonomy ] = $categories;

		return $categories;
	}

	/**
	 * Get Icon URL
	 *
	 * @param string $file_name The icon file name with extension
	 *
	 * @return string Full URL of icon image
	 */
	protected function get_icon( $file_name ) {
		if ( file_exists( PENSHOP_ADDONS_DIR . 'assets/icons/' . $file_name ) ) {
			$url = PENSHOP_ADDONS_URL . 'assets/images/' . $file_name;
		} else {
			$url = PENSHOP_ADDONS_URL . 'assets/images/default.png';
		}

		return $url;
	}
}

if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
	class WPBakeryShortCode_Penshop_Carousel extends WPBakeryShortCodesContainer {
	}

	class WPBakeryShortCode_Penshop_Icon_list extends WPBakeryShortCodesContainer {
	}
}

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_Penshop_Carousel_Item extends WPBakeryShortCode {
	}

	class WPBakeryShortCode_Penshop_Icon_List_Item extends WPBakeryShortCode {
	}
}
