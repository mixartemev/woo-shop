<?php
/**
 * Define shortcodes
 */

/**
 * Class PenShop_Addons_Shortcodes
 */
class PenShop_Addons_Shortcodes {
	/**
	 * The single instance of the class.
	 *
	 * @var object
	 */
	protected static $_instance = null;

	/**
	 * ID number of shortcodes
	 *
	 * @var array
	 */
	protected $ids = array();

	/**
	 * Icon list items
	 *
	 * @var array
	 */
	protected $list;

	/**
	 * Main Instance.
	 * Ensures only one instance of this class is loaded or can be loaded.
	 *
	 * @return PenShop_Addons_Shortcodes - Main instance.
	 */
	public static function init() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	/**
	 * Construction
	 */
	public function __construct() {
		$shortcodes = array(
			'icon_box',
			'banner_grid_3',
			'banner_grid_3_reverse',
			'banner_grid_3_video',
			'banner_grid_4',
			'product_category_grid',
			'button',
			'product_carousel',
			'product_grid',
			'product_tabs',
			'promotion',
			'banner',
			'banner2',
			'banner_promo',
			'post_grid',
			'countdown',
			'map',
			'newsletter',
			'faq',
			'carousel_item',
			'carousel',
			'icon_list',
			'icon_list_item',
		);

		foreach ( $shortcodes as $shortcode ) {
			add_shortcode( "penshop_{$shortcode}", array( $this, $shortcode ) );
		}

		add_action( 'wp_ajax_nopriv_penshop_load_products', array( $this, 'ajax_load_products' ) );
		add_action( 'wp_ajax_penshop_load_products', array( $this, 'ajax_load_products' ) );

		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue' ) );

		add_filter( 'widget_text', 'do_shortcode' );
	}

	/**
	 * Enqueue scripts
	 */
	public function enqueue() {
		wp_register_script( 'jquery-countdown', PENSHOP_ADDONS_URL . 'assets/js/jquery.countdown.js', array( 'jquery' ), '2.0.4', true );
		wp_register_script( 'owl-carousel', PENSHOP_ADDONS_URL . 'assets/js/owl.carousel.min.js', array(), '2.2.1', true );
		wp_register_script( 'lightcase', PENSHOP_ADDONS_URL . 'assets/js/lightcase.js', array(), '2.4.0', true );

		wp_enqueue_script( 'penshop-addons-shortcodes', PENSHOP_ADDONS_URL . 'assets/js/shortcodes.js', array(
			'jquery',
			'owl-carousel',
			'jquery-countdown',
			'lightcase',
			'imagesloaded',
		), '20170629', true );

		wp_localize_script( 'penshop-addons-shortcodes', 'penshop_addons_params', array(
			'ajax_url'   => admin_url( 'admin-ajax.php' ),
			'shop_nonce' => wp_create_nonce( 'penshop_get_products' ),
		) );
	}

	/**
	 * Ajax load products
	 */
	public function ajax_load_products() {
		check_ajax_referer( 'penshop_get_products', 'nonce' );

		if ( ! isset( $_POST['atts'] ) ) {
			wp_send_json_error( esc_html__( 'No query atts', 'penshop-addons' ) );
			exit;
		}

		$atts = $this->parse_query_atts( $_POST['atts'] );

		$data = $this->product_loop( $atts );

		wp_send_json_success( $data );
	}

	/**
	 * Icon box shortcode
	 *
	 * @param  array  $atts
	 * @param  string $content
	 *
	 * @return string
	 */
	public function icon_box( $atts, $content ) {
		$atts = shortcode_atts(
			array(
				'icon_type'        => 'fontawesome',
				'icon_fontawesome' => 'fa fa-adjust',
				'icon_openiconic'  => 'vc-oi vc-oi-dial',
				'icon_typicons'    => 'typcn typcn-adjust-brightness',
				'icon_entypo'      => 'entypo-icon entypo-icon-note',
				'icon_linecons'    => 'vc_li vc_li-heart',
				'icon_monosocial'  => 'vc-mono vc-mono-fivehundredpx',
				'icon_material'    => 'vc-material vc-material-cake',
				'image'            => '',
				'icon_position'    => 'left',
				'title'            => esc_html__( 'I am Icon Box', 'penshop-addons' ),
				'css_animation'    => '',
				'el_class'         => '',
			),
			$atts,
			'penshop_' . __FUNCTION__
		);

		$css_class = array(
			'penshop-icon-box',
			'icon-type-' . $atts['icon_type'],
			'icon-' . $atts['icon_position'],
			$this->get_css_animation( $atts['css_animation'] ),
			$atts['el_class'],
		);

		if ( 'image' == $atts['icon_type'] ) {
			$image = wp_get_attachment_image_src( $atts['image'], 'full' );
			$icon  = $image ? sprintf( '<img alt="%s" src="%s">', esc_attr( $atts['title'] ), esc_url( $image[0] ) ) : '';
		} else {
			vc_icon_element_fonts_enqueue( $atts['icon_type'] );
			$icon = '<i class="' . esc_attr( $atts[ 'icon_' . $atts['icon_type'] ] ) . '"></i>';
		}

		return sprintf(
			'<div class="%s">
				<div class="box-icon">%s</div>
				<h3 class="box-title">%s</h3>
				<div class="box-content">%s</div>
			</div>',
			esc_attr( implode( ' ', $css_class ) ),
			$icon,
			esc_html( $atts['title'] ),
			$content
		);
	}

	/**
	 * Banner grid 3
	 *
	 * @param  array $atts
	 *
	 * @return string
	 */
	public function banner_grid_3( $atts ) {
		$atts = shortcode_atts(
			array(
				'height'                    => 790,
				'css_animation'             => '',
				'el_class'                  => '',
				'image1'                    => '',
				'image_pos_desktop1'        => 'center center',
				'image_pos_mobile1'         => 'center center',
				'image_pos_desktop_custom1' => '50% 50%',
				'image_pos_mobile_custom1'  => '50% 50%',
				'link1'                     => '',
				'text1'                     => '',
				'font_size1'                => '',
				'text_pos1'                 => 'bottom-right',
				'align1'                    => 'left',
				'color_scheme1'             => 'dark',
				'image2'                    => '',
				'image_pos_desktop2'        => 'center center',
				'image_pos_mobile2'         => 'center center',
				'image_pos_desktop_custom2' => '50% 50%',
				'image_pos_mobile_custom2'  => '50% 50%',
				'link2'                     => '',
				'text2'                     => '',
				'font_size2'                => '',
				'text_pos2'                 => 'bottom-left',
				'align2'                    => 'left',
				'color_scheme2'             => 'white',
				'image3'                    => '',
				'image_pos_desktop3'        => 'center center',
				'image_pos_mobile3'         => 'center center',
				'image_pos_desktop_custom3' => '50% 50%',
				'image_pos_mobile_custom3'  => '50% 50%',
				'link3'                     => '',
				'text3'                     => '',
				'font_size3'                => '',
				'text_pos3'                 => 'middle-center',
				'align3'                    => 'center',
				'color_scheme3'             => 'white',
			), $atts, 'penshop_' . __FUNCTION__
		);

		$class_name = 'penshop-banner-grid-3__' . $this->get_id_number( __FUNCTION__ );
		$css_class  = array(
			'penshop-banner-grid-3',
			'penshop-banner-grid',
			$atts['el_class'],
			$class_name,
		);
		$css        = '';

		$animation_class = $this->get_css_animation( $atts['css_animation'] );

		$image1 = wp_get_attachment_image_src( $atts['image1'], 'full' );
		$image2 = wp_get_attachment_image_src( $atts['image2'], 'full' );
		$image3 = wp_get_attachment_image_src( $atts['image3'], 'full' );
		$link1  = vc_build_link( $atts['link1'] );
		$link2  = vc_build_link( $atts['link2'] );
		$link3  = vc_build_link( $atts['link3'] );

		$css_class1 = array(
			'penshop-banner-grid__banner',
			'penshop-banner-grid__banner1',
			'penshop-banner',
			'banner-' . $atts['text_pos1'],
			$atts['color_scheme1'],
			$animation_class,
		);
		$css        .= $this->get_css_background( '.' . $class_name . ' .penshop-banner-grid__banner1 .banner-image', array(
			'image'                  => $image1 ? $image1[0] : '',
			'position'               => $atts['image_pos_desktop1'],
			'position_custom'        => $atts['image_pos_desktop_custom1'],
			'position_mobile'        => $atts['image_pos_mobile1'],
			'position_mobile_custom' => $atts['image_pos_mobile_custom1'],
		) );
		$banner1    = sprintf(
			'<div class="%s">
				<a href="%s" target="%s" rel="%s" title="%s" class="penshop-banner-grid__link">
					<span class="penshop-banner-grid__image banner-image"></span>
					<span class="banner-content">
						<span class="penshop-banner-grid__text penshop-banner-grid__text-%s text-%s banner-title" style="%s">%s</span>
					</span>
				</a>
			</div>',
			esc_attr( implode( ' ', $css_class1 ) ),
			esc_url( $link1['url'] ),
			esc_attr( $link1['target'] ),
			esc_attr( $link1['rel'] ),
			esc_attr( $link1['title'] ),
			$atts['color_scheme1'],
			esc_attr( $atts['align1'] ),
			$this->get_font_size_css( $atts['font_size1'] ),
			$atts['text1']
		);

		$css_class2 = array(
			'penshop-banner-grid__banner',
			'penshop-banner-grid__banner2',
			'penshop-banner',
			'banner-' . $atts['text_pos2'],
			$atts['color_scheme2'],
			$animation_class,
		);
		$css        .= $this->get_css_background( '.' . $class_name . ' .penshop-banner-grid__banner2 .banner-image', array(
			'image'                  => $image2 ? $image2[0] : '',
			'position'               => $atts['image_pos_desktop2'],
			'position_custom'        => $atts['image_pos_desktop_custom2'],
			'position_mobile'        => $atts['image_pos_mobile2'],
			'position_mobile_custom' => $atts['image_pos_mobile_custom2'],
		) );
		$banner2    = sprintf(
			'<div class="%s">
				<a href="%s" target="%s" rel="%s" title="%s" class="penshop-banner-grid__link">
					<span class="penshop-banner-grid__image banner-image"></span>
					<span class="banner-content">
						<span class="penshop-banner-grid__text penshop-banner-grid__text-%s text-%s banner-title" style="%s">%s</span>
					</span>
				</a>
			</div>',
			esc_attr( implode( ' ', $css_class2 ) ),
			esc_url( $link2['url'] ),
			esc_attr( $link2['target'] ),
			esc_attr( $link2['rel'] ),
			esc_attr( $link2['title'] ),
			$atts['color_scheme2'],
			esc_attr( $atts['align2'] ),
			$this->get_font_size_css( $atts['font_size2'] ),
			$atts['text2']
		);

		$css_class3 = array(
			'penshop-banner-grid__banner',
			'penshop-banner-grid__banner3',
			'penshop-banner',
			'banner-' . $atts['text_pos3'],
			$atts['color_scheme3'],
			$animation_class,
		);
		$css        .= $this->get_css_background( '.' . $class_name . ' .penshop-banner-grid__banner3 .banner-image', array(
			'image'                  => $image3 ? $image3[0] : '',
			'position'               => $atts['image_pos_desktop3'],
			'position_custom'        => $atts['image_pos_desktop_custom3'],
			'position_mobile'        => $atts['image_pos_mobile3'],
			'position_mobile_custom' => $atts['image_pos_mobile_custom3'],
		) );
		$banner3    = sprintf(
			'<div class="%s">
				<a href="%s" target="%s" rel="%s" title="%s" class="penshop-banner-grid__link">
					<span class="penshop-banner-grid__image banner-image"></span>
					<span class="banner-content">
						<span class="penshop-banner-grid__text penshop-banner-grid__text-%s text-%s banner-title" style="%s">%s</span>
					</span>
				</a>
			</div>',
			esc_attr( implode( ' ', $css_class3 ) ),
			esc_url( $link3['url'] ),
			esc_attr( $link3['target'] ),
			esc_attr( $link3['rel'] ),
			esc_attr( $link3['title'] ),
			$atts['color_scheme3'],
			esc_attr( $atts['align3'] ),
			$this->get_font_size_css( $atts['font_size3'] ),
			$atts['text3']
		);

		$css .= "
			.$class_name { height: " . floatval( $atts['height'] ) . "px }
			@media (max-width: 991px) { .$class_name { height: " . floatval( $atts['height'] ) * 0.8 . "px } }
			@media (max-width: 767px) { .$class_name { height: " . floatval( $atts['height'] ) * 0.8 * 2 . "px } }
			";

		return sprintf(
			'<style type="text/css">%s</style><div class="%s">%s</div>',
			$css,
			esc_attr( implode( ' ', $css_class ) ),
			$banner1 . $banner2 . $banner3
		);
	}

	/**
	 * Banner grid 3 Reverse
	 *
	 * @param  array $atts
	 *
	 * @return string
	 */
	public function banner_grid_3_reverse( $atts ) {
		$atts = shortcode_atts(
			array(
				'height'                    => 520,
				'gap'                       => '3',
				'css_animation'             => '',
				'el_class'                  => '',
				'image1'                    => '',
				'image_pos_desktop1'        => 'center center',
				'image_pos_mobile1'         => 'center center',
				'image_pos_desktop_custom1' => '50% 50%',
				'image_pos_mobile_custom1'  => '50% 50%',
				'link1'                     => '',
				'title1'                    => '',
				'subtitle1'                 => '',
				'text_pos1'                 => 'middle-center',
				'align1'                    => 'left',
				'color_scheme1'             => 'dark',
				'image2'                    => '',
				'image_pos_desktop2'        => 'center center',
				'image_pos_mobile2'         => 'center center',
				'image_pos_desktop_custom2' => '50% 50%',
				'image_pos_mobile_custom2'  => '50% 50%',
				'link2'                     => '',
				'title2'                    => '',
				'subtitle2'                 => '',
				'text_pos2'                 => 'middle-left',
				'align2'                    => 'left',
				'color_scheme2'             => 'dark',
				'image3'                    => '',
				'image_pos_desktop3'        => 'center center',
				'image_pos_mobile3'         => 'center center',
				'image_pos_desktop_custom3' => '50% 50%',
				'image_pos_mobile_custom3'  => '50% 50%',
				'link3'                     => '',
				'title3'                    => '',
				'subtitle3'                 => '',
				'button3'                   => '',
				'text_pos3'                 => 'middle-center',
				'align3'                    => 'left',
				'color_scheme3'             => 'dark',
			), $atts, 'penshop_' . __FUNCTION__
		);

		$class_name = 'penshop-banner-grid-3-reverse__' . $this->get_id_number( __FUNCTION__ );
		$css_class  = array(
			'penshop-banner-grid-3-reverse',
			'penshop-banner-grid',
			'penshop-banner-grid__gap' . $atts['gap'],
			$atts['el_class'],
			$class_name,
		);
		$css        = '';

		$animation_class = $this->get_css_animation( $atts['css_animation'] );

		$image1 = wp_get_attachment_image_src( $atts['image1'], 'full' );
		$image2 = wp_get_attachment_image_src( $atts['image2'], 'full' );
		$image3 = wp_get_attachment_image_src( $atts['image3'], 'full' );
		$link1  = vc_build_link( $atts['link1'] );
		$link2  = vc_build_link( $atts['link2'] );
		$link3  = vc_build_link( $atts['link3'] );

		$css_class1 = array(
			'penshop-banner-grid__banner',
			'penshop-banner-grid__banner1',
			'penshop-banner',
			'text-' . $atts['align1'],
			'banner-' . $atts['text_pos1'],
			$atts['color_scheme1'],
			$animation_class,
		);
		$css        .= $this->get_css_background( '.' . $class_name . ' .penshop-banner-grid__banner1 .banner-image', array(
			'image'                  => $image1 ? $image1[0] : '',
			'position'               => $atts['image_pos_desktop1'],
			'position_custom'        => $atts['image_pos_desktop_custom1'],
			'position_mobile'        => $atts['image_pos_mobile1'],
			'position_mobile_custom' => $atts['image_pos_mobile_custom1'],
		) );
		$banner1    = sprintf(
			'<div class="%s">
				<a href="%s" target="%s" rel="%s" title="%s" class="penshop-banner-grid__link">
					<span class="penshop-banner-grid__image banner-image"></span>
					<span class="banner-content">
						<span class="penshop-banner-grid__text banner-title">%s</span>
						<span class="penshop-banner-grid__text banner-subtitle">%s</span>
					</span>
				</a>
			</div>',
			esc_attr( implode( ' ', $css_class1 ) ),
			esc_url( $link1['url'] ),
			esc_attr( $link1['target'] ),
			esc_attr( $link1['rel'] ),
			esc_attr( $link1['title'] ),
			$atts['title1'],
			$atts['subtitle1']
		);

		$css_class2 = array(
			'penshop-banner-grid__banner',
			'penshop-banner-grid__banner2',
			'penshop-banner',
			'text-' . $atts['align2'],
			'banner-' . $atts['text_pos2'],
			$atts['color_scheme2'],
			$animation_class,
		);
		$css        .= $this->get_css_background( '.' . $class_name . ' .penshop-banner-grid__banner2 .banner-image', array(
			'image'                  => $image2 ? $image2[0] : '',
			'position'               => $atts['image_pos_desktop2'],
			'position_custom'        => $atts['image_pos_desktop_custom2'],
			'position_mobile'        => $atts['image_pos_mobile2'],
			'position_mobile_custom' => $atts['image_pos_mobile_custom2'],
		) );
		$banner2    = sprintf(
			'<div class="%s">
				<a href="%s" target="%s" rel="%s" title="%s" class="penshop-banner-grid__link">
					<span class="penshop-banner-grid__image banner-image"></span>
					<span class="banner-content">
						<span class="penshop-banner-grid__text banner-title">%s</span>
						<span class="penshop-banner-grid__text banner-subtitle">%s</span>
					</span>
				</a>
			</div>',
			esc_attr( implode( ' ', $css_class2 ) ),
			esc_url( $link2['url'] ),
			esc_attr( $link2['target'] ),
			esc_attr( $link2['rel'] ),
			esc_attr( $link2['title'] ),
			$atts['title2'],
			$atts['subtitle2']
		);

		$css_class3 = array(
			'penshop-banner-grid__banner',
			'penshop-banner-grid__banner3',
			'penshop-banner',
			'text-' . $atts['align3'],
			'banner-' . $atts['text_pos3'],
			$atts['color_scheme3'],
			$animation_class,
		);
		$css        .= $this->get_css_background( '.' . $class_name . ' .penshop-banner-grid__banner3 .banner-image', array(
			'image'                  => $image3 ? $image3[0] : '',
			'position'               => $atts['image_pos_desktop3'],
			'position_custom'        => $atts['image_pos_desktop_custom3'],
			'position_mobile'        => $atts['image_pos_mobile3'],
			'position_mobile_custom' => $atts['image_pos_mobile_custom3'],
		) );
		$button3    = $atts['button3'] ? sprintf(
			'<span class="penshop-button button-type-underline button-size-normal button-color-%s" data-label="%s">%s</span>',
			esc_attr( $atts['color_scheme3'] ),
			esc_attr( $atts['button3'] ),
			$atts['button3']
		) : '';
		$banner3    = sprintf(
			'<div class="%s">
				<a href="%s" target="%s" rel="%s" title="%s" class="penshop-banner-grid__link">
					<span class="penshop-banner-grid__image banner-image"></span>
					<span class="banner-content">
						<span class="penshop-banner-grid__text banner-title">%s</span>
						<span class="penshop-banner-grid__text banner-subtitle">%s</span>
						%s
					</span>
				</a>
			</div>',
			esc_attr( implode( ' ', $css_class3 ) ),
			esc_url( $link3['url'] ),
			esc_attr( $link3['target'] ),
			esc_attr( $link3['rel'] ),
			esc_attr( $link3['title'] ),
			$atts['title3'],
			$atts['subtitle3'],
			$button3
		);

		$css .= "
			.$class_name { height: " . floatval( $atts['height'] ) . "px }
			@media (max-width: 991px) { .$class_name { height: " . floatval( $atts['height'] ) * 0.8 . "px } }
			@media (max-width: 767px) { .$class_name { height: " . floatval( $atts['height'] ) * 0.8 * 2 . "px } }
			";

		return sprintf(
			'<style type="text/css">%s</style><div class="%s">%s</div>',
			$css,
			esc_attr( implode( ' ', $css_class ) ),
			$banner1 . $banner2 . $banner3
		);
	}

	/**
	 * Banner grid 3 video
	 *
	 * @param  array $atts
	 *
	 * @return string
	 */
	public function banner_grid_3_video( $atts ) {
		$atts = shortcode_atts(
			array(
				'height'                    => 520,
				'gap'                       => '3',
				'css_animation'             => '',
				'el_class'                  => '',
				'image1'                    => '',
				'image_pos_desktop1'        => 'center center',
				'image_pos_mobile1'         => 'center center',
				'image_pos_desktop_custom1' => '50% 50%',
				'image_pos_mobile_custom1'  => '50% 50%',
				'link1'                     => '',
				'title1'                    => '',
				'subtitle1'                 => '',
				'button1'                   => '',
				'text_pos1'                 => 'bottom-left',
				'align1'                    => 'left',
				'color_scheme1'             => 'dark',
				'video2'                    => '',
				'image2'                    => '',
				'image_pos_desktop2'        => 'center center',
				'image_pos_mobile2'         => 'center center',
				'image_pos_desktop_custom2' => '50% 50%',
				'image_pos_mobile_custom2'  => '50% 50%',
				'image3'                    => '',
				'image_pos_desktop3'        => 'center center',
				'image_pos_mobile3'         => 'center center',
				'image_pos_desktop_custom3' => '50% 50%',
				'image_pos_mobile_custom3'  => '50% 50%',
				'link3'                     => '',
				'title3'                    => '',
				'subtitle3'                 => '',
				'button3'                   => '',
				'align3'                    => 'left',
				'color_scheme3'             => 'dark',
			), $atts, 'penshop_' . __FUNCTION__
		);

		$class_name = 'penshop-banner-grid-3-video__' . $this->get_id_number( __FUNCTION__ );
		$css_class  = array(
			'penshop-banner-grid-3-video',
			'penshop-banner-grid',
			'penshop-banner-grid__gap' . $atts['gap'],
			$atts['el_class'],
			$class_name,
		);
		$css        = '';

		$animation_class = $this->get_css_animation( $atts['css_animation'] );

		$image1 = wp_get_attachment_image_src( $atts['image1'], 'full' );
		$image2 = wp_get_attachment_image_src( $atts['image2'], 'full' );
		$image3 = wp_get_attachment_image_src( $atts['image3'], 'full' );
		$link1  = vc_build_link( $atts['link1'] );
		$link3  = vc_build_link( $atts['link3'] );

		$css_class1 = array(
			'penshop-banner-grid__banner',
			'penshop-banner-grid__banner1',
			'penshop-banner',
			'text-' . $atts['align1'],
			'banner-' . $atts['text_pos1'],
			$atts['color_scheme1'],
			$animation_class,
		);
		$css        .= $this->get_css_background( '.' . $class_name . ' .penshop-banner-grid__banner1 .banner-image', array(
			'image'                  => $image1 ? $image1[0] : '',
			'position'               => $atts['image_pos_desktop1'],
			'position_custom'        => $atts['image_pos_desktop_custom1'],
			'position_mobile'        => $atts['image_pos_mobile1'],
			'position_mobile_custom' => $atts['image_pos_mobile_custom1'],
		) );
		$button1    = $atts['button1'] ? sprintf(
			'<span class="penshop-button button-type-underline button-size-normal button-color-%s" data-label="%s">%s</span>',
			esc_attr( $atts['color_scheme1'] ),
			esc_attr( $atts['button1'] ),
			$atts['button1']
		) : '';
		$banner1    = sprintf(
			'<div class="%s">
				<a href="%s" target="%s" rel="%s" title="%s" class="penshop-banner-grid__link">
					<span class="penshop-banner-grid__image banner-image"></span>
					<span class="banner-content">
						<span class="penshop-banner-grid__text banner-title">%s</span>
						<span class="penshop-banner-grid__text banner-subtitle">%s</span>
						%s
					</span>
				</a>
			</div>',
			esc_attr( implode( ' ', $css_class1 ) ),
			esc_url( $link1['url'] ),
			esc_attr( $link1['target'] ),
			esc_attr( $link1['rel'] ),
			esc_attr( $link1['title'] ),
			$atts['title1'],
			$atts['subtitle1'],
			$button1
		);

		$css_class2 = array(
			'penshop-banner-grid__banner',
			'penshop-banner-grid__banner2',
			'penshop-banner',
			'penshop-banner-video',
			$animation_class,
		);
		$css        .= $this->get_css_background( '.' . $class_name . ' .penshop-banner-grid__banner2 .banner-image', array(
			'image'                  => $image2 ? $image2[0] : '',
			'position'               => $atts['image_pos_desktop2'],
			'position_custom'        => $atts['image_pos_desktop_custom2'],
			'position_mobile'        => $atts['image_pos_mobile2'],
			'position_mobile_custom' => $atts['image_pos_mobile_custom2'],
		) );
		$video_file = wp_check_filetype( $atts['video2'] );
		if ( strstr( $video_file['type'], 'video/' ) ) {
			$video_url = $atts['video2'];
		} else {
			if ( preg_match( '/(youtube.com|youtu.be)\/(watch)?(\?v=)?(\S+)?/', $atts['video2'], $match ) ) {
				$video_url = preg_replace(
					'/\s*[a-zA-Z\/\/:\.]*youtube.com\/watch\?v=([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i',
					'//www.youtube.com/embed/$1',
					$atts['video2']
				);
			} elseif ( preg_match( "/(https?:\/\/)?(www\.)?(player\.)?vimeo\.com\/([a-z]*\/)*([0-9]{6,11})[?]?.*/", $atts['video2'], $match ) ) {
				$video_url = 'http://player.vimeo.com/video/' . $match[5];
			} else {
				$video_url = $atts['video2'];
			}
		}
		$banner2 = sprintf(
			'<div class="%s">
				<div class="penshop-banner-grid__link">
					<span class="penshop-banner-grid__image banner-image"></span>
					<a href="%s" class="play-video"><i class="fa fa-play-circle"></i></a>
				</div>
			</div>',
			esc_attr( implode( ' ', $css_class2 ) ),
			$video_url
		);

		$css_class3 = array(
			'penshop-banner-grid__banner',
			'penshop-banner-grid__banner3',
			'penshop-banner',
			'text-' . $atts['align3'],
			$atts['color_scheme3'],
			$animation_class,
		);
		$css        .= $this->get_css_background( '.' . $class_name . ' .penshop-banner-grid__banner3 .banner-image', array(
			'image'                  => $image3 ? $image3[0] : '',
			'position'               => $atts['image_pos_desktop3'],
			'position_custom'        => $atts['image_pos_desktop_custom3'],
			'position_mobile'        => $atts['image_pos_mobile3'],
			'position_mobile_custom' => $atts['image_pos_mobile_custom3'],
		) );
		$button3    = $atts['button3'] ? sprintf(
			'<span class="penshop-button button-type-outline button-size-normal button-color-%s">%s</span>',
			esc_attr( $atts['color_scheme3'] ),
			$atts['button3']
		) : '';

		$banner3 = sprintf(
			'<div class="%s">
				<a href="%s" target="%s" rel="%s" title="%s" class="penshop-banner-grid__link">
					<span class="penshop-banner-grid__image banner-image"></span>
					<span class="banner-content">
						<span class="penshop-banner-grid__text banner-title">%s</span>
						<span class="penshop-banner-grid__text banner-subtitle">%s</span>
						%s
					</span>
				</a>
			</div>',
			esc_attr( implode( ' ', $css_class3 ) ),
			esc_url( $link3['url'] ),
			esc_attr( $link3['target'] ),
			esc_attr( $link3['rel'] ),
			esc_attr( $link3['title'] ),
			$atts['title3'],
			$atts['subtitle3'],
			$button3
		);

		$css .= "
			.$class_name { height: " . floatval( $atts['height'] ) . "px }
			@media (max-width: 991px) { .$class_name { height: " . floatval( $atts['height'] ) * 0.8 . "px } }
			@media (max-width: 767px) { .$class_name { height: " . floatval( $atts['height'] ) * 0.8 * 2 . "px } }
			";

		return sprintf(
			'<style type="text/css">%s</style><div class="%s">%s</div>',
			$css,
			esc_attr( implode( ' ', $css_class ) ),
			$banner1 . $banner2 . $banner3
		);
	}

	/**
	 * Banner grid 4
	 *
	 * @param  array $atts
	 *
	 * @return string
	 */
	public function banner_grid_4( $atts ) {
		$atts = shortcode_atts(
			array(
				'height'                    => 780,
				'gap'                       => '3',
				'css_animation'             => '',
				'el_class'                  => '',
				'image1'                    => '',
				'image_pos_desktop1'        => 'center center',
				'image_pos_mobile1'         => 'center center',
				'image_pos_desktop_custom1' => '50% 50%',
				'image_pos_mobile_custom1'  => '50% 50%',
				'link1'                     => '',
				'text1'                     => '',
				'font_size1'                => '',
				'button_text1'              => '',
				'text_pos1'                 => 'middle-center',
				'align1'                    => 'center',
				'color_scheme1'             => 'dark',
				'image2'                    => '',
				'image_pos_desktop2'        => 'center center',
				'image_pos_mobile2'         => 'center center',
				'image_pos_desktop_custom2' => '50% 50%',
				'image_pos_mobile_custom2'  => '50% 50%',
				'link2'                     => '',
				'text2'                     => '',
				'font_size2'                => '',
				'button_text2'              => '',
				'text_pos2'                 => 'bottom-left',
				'align2'                    => 'left',
				'color_scheme2'             => 'dark',
				'image3'                    => '',
				'image_pos_desktop3'        => 'center center',
				'image_pos_mobile3'         => 'center center',
				'image_pos_desktop_custom3' => '50% 50%',
				'image_pos_mobile_custom3'  => '50% 50%',
				'link3'                     => '',
				'text3'                     => '',
				'font_size3'                => '',
				'button_text3'              => '',
				'text_pos3'                 => 'bottom-left',
				'align3'                    => 'left',
				'color_scheme3'             => 'dark',
				'image4'                    => '',
				'image_pos_desktop4'        => 'center center',
				'image_pos_mobile4'         => 'center center',
				'image_pos_desktop_custom4' => '50% 50%',
				'image_pos_mobile_custom4'  => '50% 50%',
				'link4'                     => '',
				'text4'                     => '',
				'font_size4'                => '',
				'button_text4'              => '',
				'text_pos4'                 => 'middle-right',
				'align4'                    => 'left',
				'color_scheme4'             => 'dark',
			), $atts, 'penshop_' . __FUNCTION__
		);

		$class_name = 'penshop-banner-grid-4__' . $this->get_id_number( __FUNCTION__ );
		$css_class  = array(
			'penshop-banner-grid-4',
			'penshop-banner-grid__gap' . $atts['gap'],
			'penshop-banner-grid',
			$atts['el_class'],
			$class_name,
		);
		$css        = '';

		$animation_class = $this->get_css_animation( $atts['css_animation'] );

		$image1 = wp_get_attachment_image_src( $atts['image1'], 'full' );
		$image2 = wp_get_attachment_image_src( $atts['image2'], 'full' );
		$image3 = wp_get_attachment_image_src( $atts['image3'], 'full' );
		$image4 = wp_get_attachment_image_src( $atts['image4'], 'full' );
		$link1  = vc_build_link( $atts['link1'] );
		$link2  = vc_build_link( $atts['link2'] );
		$link3  = vc_build_link( $atts['link3'] );
		$link4  = vc_build_link( $atts['link4'] );

		$css_class1 = array(
			'penshop-banner-grid__banner',
			'penshop-banner-grid__banner1',
			'penshop-banner',
			'banner-' . $atts['text_pos1'],
			'text-' . $atts['align1'],
			$atts['color_scheme1'],
			$animation_class,
		);
		$css        .= $this->get_css_background( '.' . $class_name . ' .penshop-banner-grid__banner1 .banner-image', array(
			'image'                  => $image1 ? $image1[0] : '',
			'position'               => $atts['image_pos_desktop1'],
			'position_custom'        => $atts['image_pos_desktop_custom1'],
			'position_mobile'        => $atts['image_pos_mobile1'],
			'position_mobile_custom' => $atts['image_pos_mobile_custom1'],
		) );
		$button1    = $atts['button_text1'] ? sprintf(
			'<span class="penshop-button button-type-underline button-size-normal button-color-%s" data-label="%s">%s</span>',
			esc_attr( $atts['color_scheme1'] ),
			esc_attr( $atts['button_text1'] ),
			esc_html( $atts['button_text1'] )
		) : '';
		$banner1    = sprintf(
			'<div class="%s">
				<a href="%s" target="%s" rel="%s" title="%s" class="penshop-banner-grid__link">
					<span class="penshop-banner-grid__image banner-image"></span>
					<span class="banner-content">
						<span class="penshop-banner-grid__text penshop-banner-grid__text-%s banner-title" style="%s">%s</span>
						%s
					</span>
				</a>
			</div>',
			esc_attr( implode( ' ', $css_class1 ) ),
			esc_url( $link1['url'] ),
			esc_attr( $link1['target'] ),
			esc_attr( $link1['rel'] ),
			esc_attr( $link1['title'] ),
			$atts['color_scheme1'],
			$this->get_font_size_css( $atts['font_size1'] ),
			$atts['text1'],
			$button1
		);

		$css_class2 = array(
			'penshop-banner-grid__banner',
			'penshop-banner-grid__banner2',
			'penshop-banner',
			'banner-' . $atts['text_pos2'],
			'text-' . $atts['align2'],
			$atts['color_scheme2'],
			$animation_class,
		);
		$css        .= $this->get_css_background( '.' . $class_name . ' .penshop-banner-grid__banner2 .banner-image', array(
			'image'                  => $image2 ? $image2[0] : '',
			'position'               => $atts['image_pos_desktop2'],
			'position_custom'        => $atts['image_pos_desktop_custom2'],
			'position_mobile'        => $atts['image_pos_mobile2'],
			'position_mobile_custom' => $atts['image_pos_mobile_custom2'],
		) );
		$button2    = $atts['button_text2'] ? sprintf(
			'<span class="penshop-button button-type-underline button-size-normal button-color-%s" data-label="%s">%s</span>',
			esc_attr( $atts['color_scheme2'] ),
			esc_attr( $atts['button_text2'] ),
			esc_html( $atts['button_text2'] )
		) : '';
		$banner2    = sprintf(
			'<div class="%s">
				<a href="%s" target="%s" rel="%s" title="%s" class="penshop-banner-grid__link">
					<span class="penshop-banner-grid__image banner-image"></span>
					<span class="banner-content">
						<span class="penshop-banner-grid__text penshop-banner-grid__text-%s banner-title" style="%s">%s</span>
						%s
					</span>
				</a>
			</div>',
			esc_attr( implode( ' ', $css_class2 ) ),
			esc_url( $link2['url'] ),
			esc_attr( $link2['target'] ),
			esc_attr( $link2['rel'] ),
			esc_attr( $link2['title'] ),
			$atts['color_scheme2'],
			$this->get_font_size_css( $atts['font_size2'] ),
			$atts['text2'],
			$button2
		);

		$css_class3 = array(
			'penshop-banner-grid__banner',
			'penshop-banner-grid__banner3',
			'penshop-banner',
			'banner-' . $atts['text_pos3'],
			'text-' . $atts['align3'],
			$atts['color_scheme3'],
			$animation_class,
		);
		$css        .= $this->get_css_background( '.' . $class_name . ' .penshop-banner-grid__banner3 .banner-image', array(
			'image'                  => $image3 ? $image3[0] : '',
			'position'               => $atts['image_pos_desktop3'],
			'position_custom'        => $atts['image_pos_desktop_custom3'],
			'position_mobile'        => $atts['image_pos_mobile3'],
			'position_mobile_custom' => $atts['image_pos_mobile_custom3'],
		) );
		$button3    = $atts['button_text3'] ? sprintf(
			'<span class="penshop-button button-type-underline button-size-normal button-color-%s" data-label="%s">%s</span>',
			esc_attr( $atts['color_scheme3'] ),
			esc_attr( $atts['button_text3'] ),
			esc_html( $atts['button_text3'] )
		) : '';
		$banner3    = sprintf(
			'<div class="%s">
				<a href="%s" target="%s" rel="%s" title="%s" class="penshop-banner-grid__link">
					<span class="penshop-banner-grid__image banner-image"></span>
					<span class="banner-content">
						<span class="penshop-banner-grid__text penshop-banner-grid__text-%s banner-title" style="%s">%s</span>
						%s
					</span>
				</a>
			</div>',
			esc_attr( implode( ' ', $css_class3 ) ),
			esc_url( $link3['url'] ),
			esc_attr( $link3['target'] ),
			esc_attr( $link3['rel'] ),
			esc_attr( $link3['title'] ),
			$atts['color_scheme3'],
			$this->get_font_size_css( $atts['font_size3'] ),
			$atts['text3'],
			$button3
		);

		$css_class4 = array(
			'penshop-banner-grid__banner',
			'penshop-banner-grid__banner4',
			'penshop-banner',
			'banner-' . $atts['text_pos4'],
			'text-' . $atts['align4'],
			$atts['color_scheme4'],
			$animation_class,
		);
		$css        .= $this->get_css_background( '.' . $class_name . ' .penshop-banner-grid__banner4 .banner-image', array(
			'image'                  => $image4 ? $image4[0] : '',
			'position'               => $atts['image_pos_desktop4'],
			'position_custom'        => $atts['image_pos_desktop_custom4'],
			'position_mobile'        => $atts['image_pos_mobile4'],
			'position_mobile_custom' => $atts['image_pos_mobile_custom4'],
		) );
		$button4    = $atts['button_text4'] ? sprintf(
			'<span class="penshop-button button-type-underline button-size-normal button-color-%s" data-label="%s">%s</span>',
			esc_attr( $atts['color_scheme4'] ),
			esc_attr( $atts['button_text4'] ),
			esc_html( $atts['button_text4'] )
		) : '';
		$banner4    = sprintf(
			'<div class="%s">
				<a href="%s" target="%s" rel="%s" title="%s" class="penshop-banner-grid__link">
					<span class="penshop-banner-grid__image banner-image"></span>
					<span class="banner-content">
						<span class="penshop-banner-grid__text penshop-banner-grid__text-%s banner-title" style="%s">%s</span>
						%s
					</span>
				</a>
			</div>',
			esc_attr( implode( ' ', $css_class4 ) ),
			esc_url( $link4['url'] ),
			esc_attr( $link4['target'] ),
			esc_attr( $link4['rel'] ),
			esc_attr( $link4['title'] ),
			$atts['color_scheme4'],
			$this->get_font_size_css( $atts['font_size4'] ),
			$atts['text4'],
			$button4
		);

		$css .= "
			.$class_name { height: " . floatval( $atts['height'] ) . "px }
			@media (max-width: 991px) { .$class_name { height: " . floatval( $atts['height'] ) * 0.8 . "px } }
			@media (max-width: 767px) { .$class_name { height: " . floatval( $atts['height'] ) * 0.8 * 2 . "px } }
			";

		return sprintf(
			'<style type="text/css">%s</style><div class="%s">%s</div>',
			$css,
			esc_attr( implode( ' ', $css_class ) ),
			$banner1 . $banner2 . $banner3 . $banner4
		);
	}

	/**
	 * Display product categories in grid
	 *
	 * @param  array $atts
	 *
	 * @return string
	 */
	public function product_category_grid( $atts ) {
		$atts = shortcode_atts(
			array(
				'present'               => 'default',
				'category'              => '',
				'custom_images'         => false,
				'images'                => '',
				'columns'               => 3,
				'gap'                   => '3',
				'overlay'               => 'yes',
				'overlay_color'         => '#000',
				'overlay_opacity'       => 0.3,
				'overlay_hover_color'   => '#000',
				'overlay_hover_opacity' => 0.4,
				'css_animation'         => '',
				'el_class'              => '',
			),
			$atts,
			'penshop_' . __FUNCTION__
		);

		$columns   = intval( $atts['columns'] );
		$css_class = array(
			'penshop-product-category-grid',
			'style-' . $atts['present'],
			'columns-' . $columns,
			'gap' . $atts['gap'],
			$atts['el_class'],
		);

		$animation_class = $this->get_css_animation( $atts['css_animation'] );

		if ( ! empty( $atts['category'] ) ) {
			$categories = array();
			$cat_slugs  = explode( ',', $atts['category'] );

			foreach ( $cat_slugs as $cat_slug ) {
				$category = get_term_by( 'slug', $cat_slug, 'product_cat' );

				if ( $category && ! is_wp_error( $category ) ) {
					$categories[] = $category;
				}
			}
		} else {
			$categories = get_terms( array(
				'taxonomy'   => 'product_cat',
				'hide_empty' => false,
				'number'     => intval( $atts['columns'] ),
				'orderby'    => 'count',
				'order'      => 'DESC',
			) );
		}

		if ( ! $categories ) {
			return '';
		}

		if ( is_wp_error( $categories ) ) {
			return $categories->get_error_message();
		}

		$images = explode( ',', $atts['images'] );
		$output = array();
		$id     = 'penshop-product-category-grid-' . $this->get_id_number( __FUNCTION__ );

		foreach ( $categories as $index => $category ) {
			if ( $atts['custom_images'] && isset( $images[ $index ] ) ) {
				$image_id  = $images[ $index ];
				$image_url = $image_id ? wp_get_attachment_image_url( $image_id, 'full' ) : false;
			} else {
				$image_id  = get_term_meta( $category->term_id, 'thumbnail_id', true );
				$image_url = wp_get_attachment_image_url( $image_id, 'full' );
			}

			$output[] = sprintf(
				'<div class="penshop-product-category-grid__cat %s %s">
					<a href="%s" class="penshop-product-category-grid__cat-link">
						<span class="penshop-product-category-grid__cat-image" style="%s">%s</span>
						<h3 class="penshop-product-category-grid__cat-name">%s</h3>
					</a>
				</div>',
				$animation_class,
				$image_id ? '' : 'no-image',
				esc_url( get_term_link( $category ) ),
				$image_url ? 'background-image:url(' . $image_url . ')' : '',
				$atts['overlay'] ? '<span class="overlay"></span>' : '',
				$category->name
			);
		}

		if ( $atts['overlay'] ) {
			$output[] = "<style>
			.$id .overlay {
				background-color: {$atts['overlay_color']};
				opacity: {$atts['overlay_opacity']};
			}
			.$id .penshop-product-category-grid__cat:hover .overlay {
				background-color: {$atts['overlay_hover_color']};
				opacity: {$atts['overlay_hover_opacity']};
			}
			</style>";
		}

		return sprintf(
			'<div class="%s %s"><div class="penshop-product-category-grid__cats">%s</div></div>',
			esc_attr( implode( ' ', $css_class ) ),
			$id,
			implode( "\n\t", $output )
		);
	}

	/**
	 * Shortcode to display newsletter
	 *
	 * @param  array  $atts
	 * @param  string $content
	 *
	 * @return string
	 */
	public function newsletter( $atts, $content ) {
		$atts = shortcode_atts(
			array(
				'style'         => 'shadow',
				'form'          => '',
				'css_animation' => '',
				'el_class'      => '',
			),
			$atts,
			'penshop_' . __FUNCTION__
		);

		$css_class = array(
			'penshop-newsletter',
			'style-' . $atts['style'],
			$this->get_css_animation( $atts['css_animation'] ),
			$atts['el_class'],
		);

		return sprintf(
			'<div class="%s">
                <div class="newsletter-box">
	                <div class="newsletter-text">%s</div>
	                <div class="newsletter-form">%s</div>
                </div>
			</div>',
			esc_attr( implode( ' ', $css_class ) ),
			wpb_js_remove_wpautop( $content, true ),
			do_shortcode( '[mc4wp_form id="' . esc_attr( $atts['form'] ) . '"]' )
		);
	}

	/**
	 * FAQ
	 *
	 * @param array  $atts
	 * @param string $content
	 *
	 * @return string
	 */
	public function faq( $atts, $content ) {
		$atts = shortcode_atts(
			array(
				'title'         => esc_html__( 'Question content goes here', 'penshop-addons' ),
				'open'          => 'false',
				'css_animation' => '',
				'el_class'      => '',
			), $atts, 'penshop_' . __FUNCTION__
		);

		$css_class = array(
			'penshop-faq',
			$this->get_css_animation( $atts['css_animation'] ),
			$atts['el_class'],
		);

		if ( 'true' == $atts['open'] ) {
			$css_class[] = 'open';
		}

		return sprintf(
			'<div class="%s">
				<div class="faq">
					<span class="faq-icon"><span class="toggle-icon"></span></span>
					<h3 class="faq-title">%s</h3>
				</div>
				<div class="faq-content">%s</div>
			</div>',
			esc_attr( implode( ' ', $css_class ) ),
			esc_html( $atts['title'] ),
			$content
		);
	}

	/**
	 * Button
	 *
	 * @param array $atts
	 *
	 * @return string
	 */
	public function button( $atts ) {
		$atts = shortcode_atts( array(
			'label'         => esc_html__( 'Button Text', 'penshop-addons' ),
			'link'          => '',
			'type'          => 'outline',
			'size'          => 'normal',
			'align'         => 'inline',
			'color'         => 'dark',
			'css_animation' => '',
			'el_class'      => '',
		), $atts, 'penshop_' . __FUNCTION__ );

		$attributes = array(
			'data-label' => $atts['label'],
		);

		$css_class = array(
			'penshop-button',
			'button-type-' . $atts['type'],
			'button-color-' . $atts['color'],
			'align-' . $atts['align'],
			'button',
			'button-size-' . $atts['size'],
			$this->get_css_animation( $atts['css_animation'] ),
			$atts['el_class'],
		);

		if ( function_exists( 'vc_build_link' ) && ! empty( $atts['link'] ) ) {
			$link = vc_build_link( $atts['link'] );

			if ( ! empty( $link['url'] ) ) {
				$attributes['href'] = $link['url'];
			}

			if ( ! empty( $link['title'] ) ) {
				$attributes['title'] = $link['title'];
			}

			if ( ! empty( $link['target'] ) ) {
				$attributes['target'] = $link['target'];
			}

			if ( ! empty( $link['rel'] ) ) {
				$attributes['rel'] = $link['rel'];
			}
		}

		$attributes['class'] = implode( ' ', $css_class );
		$attr                = array();

		foreach ( $attributes as $name => $value ) {
			$attr[] = $name . '="' . esc_attr( $value ) . '"';
		}

		$button = sprintf(
			'<%1$s %2$s>%3$s</%1$s>',
			empty( $attributes['href'] ) ? 'span' : 'a',
			implode( ' ', $attr ),
			esc_html( $atts['label'] )
		);

		if ( 'center' == $atts['align'] ) {
			return '<div class="penshop-button-wrapper text-center">' . $button . '</div>';
		}

		return $button;
	}

	/**
	 * Product carousel
	 *
	 * @param array $atts
	 *
	 * @return string
	 */
	public function product_carousel( $atts ) {
		$atts = shortcode_atts( array(
			'product_style' => 'default',
			'per_page'      => 10,
			'columns'       => 4,
			'category'      => '',
			'type'          => 'recent',
			'tab'           => false,
			'tab_all'       => true,
			'autoplay'      => 5000,
			'css_animation' => '',
			'el_class'      => '',
		), $atts, 'penshop_' . __FUNCTION__ );


		$css_class = array(
			'penshop-product-carousel',
			'penshop-products',
			'product-' . $atts['product_style'],
			$this->get_css_animation( $atts['css_animation'] ),
			$atts['el_class'],
		);

		// Return soon if tabs is disabled
		if ( ! $atts['tab'] ) {
			return sprintf(
				'<div class="%s" data-columns="%s" data-autoplay="%s">%s</div>',
				esc_attr( implode( ' ', $css_class ) ),
				esc_attr( $atts['columns'] ),
				esc_attr( $atts['autoplay'] ),
				$this->product_loop( $atts )
			);
		}

		$tabs   = array();
		$panels = array();
		$index  = 1;

		if ( $atts['tab_all'] ) {
			$args             = $this->parse_query_atts( $atts );
			$args['category'] = '';

			$tabs['all']   = sprintf( '<li data-target="%s">%s</li>', $index, esc_html__( 'All', 'penshop-addons' ) );
			$panels['all'] = sprintf(
				'<div class="%s panel" data-panel="%s" data-columns="%s" data-autoplay="%s">%s</div>',
				esc_attr( implode( ' ', $css_class ) ),
				$index++,
				esc_attr( $atts['columns'] ),
				esc_attr( $atts['autoplay'] ),
				$this->product_loop( $args )
			);
		}

		if ( $atts['category'] ) {
			$cats = explode( ',', $atts['category'] );

			foreach ( $cats as $cat ) {
				$cat              = trim( $cat );
				$category         = get_term_by( 'slug', $cat, 'product_cat' );
				$args             = $this->parse_query_atts( $atts );
				$args['category'] = $cat;

				$tabs[ $cat ]   = sprintf( '<li data-target="%s">%s</li>', $index, $category->name );
				$panels[ $cat ] = sprintf(
					'<div class="%s panel" data-panel="%s" data-columns="%s" data-autoplay="%s">%s</div>',
					esc_attr( implode( ' ', $css_class ) ),
					$index++,
					esc_attr( $atts['columns'] ),
					esc_attr( $atts['autoplay'] ),
					$this->product_loop( $args )
				);
			}
		}

		if ( count( $tabs ) === 1 ) {
			return array_shift( $panels );
		} else {
			$css_class[] = 'penshop-product-carousel-tab';

			return sprintf(
				'<div class="penshop-product-carousel-tab penshop-tabs">
					<ul class="tabs">%s</ul>
					<div class="panels">%s</div>
				</div>',
				implode( '', $tabs ),
				implode( '', $panels )
			);
		}
	}

	/**
	 * Product grid
	 *
	 * @param array $atts
	 *
	 * @return string
	 */
	public function product_grid( $atts ) {
		$atts = shortcode_atts( array(
			'product_style'  => 'default',
			'per_page'       => 8,
			'columns'        => 4,
			'category'       => '',
			'type'           => 'recent',
			'load_more'      => false,
			'load_more_text' => esc_html__( 'Load more products', 'penshop-addons' ),
			'css_animation'  => '',
			'el_class'       => '',
		), $atts, 'penshop_' . __FUNCTION__ );

		$css_class = array(
			'penshop-product-grid',
			'penshop-products',
			'product-' . $atts['product_style'],
			$this->get_css_animation( $atts['css_animation'] ),
			$atts['el_class'],
		);

		return sprintf(
			'<div class="%s">%s</div>',
			esc_attr( implode( ' ', $css_class ) ),
			$this->product_loop( $atts )
		);
	}

	/**
	 * Product tabs shortcode
	 *
	 * @param array $atts
	 *
	 * @return string
	 */
	public function product_tabs( $atts ) {
		$atts = shortcode_atts( array(
			'product_style'  => 'default',
			'per_page'       => 8,
			'columns'        => 4,
			'tab_type'       => 'product_cat',
			'tab_all'        => false,
			'category'       => '',
			'tag'            => '',
			'groups'         => urlencode( json_encode( array(
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
			'load_more'      => false,
			'load_more_text' => esc_html__( 'Load more products', 'penshop-addons' ),
			'css_animation'  => '',
			'el_class'       => '',
		), $atts, 'penshop_' . __FUNCTION__ );

		$tabs      = array();
		$index     = 1;
		$query     = null;
		$css_class = array(
			'penshop-product-tabs',
			'penshop-product-tabs__' . $atts['tab_type'],
			'penshop-tabs',
			'product-' . $atts['product_style'],
			$this->get_css_animation( $atts['css_animation'] ),
			$atts['el_class'],
		);

		if ( $atts['tab_all'] ) {
			$query             = $this->parse_query_atts( $atts );
			$query['category'] = $query['tag'] = '';

			$tabs['all'] = sprintf( '<li data-target="%s" data-atts="%s" class="active">%s</li>', $index++, esc_attr( json_encode( $query ) ), esc_html__( 'All', 'penshop-addons' ) );
		}

		switch ( $atts['tab_type'] ) {
			case 'product_cat':
			case 'product_tag':
				$taxonomy = $atts['tab_type'];
				$field    = 'product_cat' == $atts['tab_type'] ? 'category' : 'tag';
				$slugs    = explode( ',', $atts[ $field ] );

				foreach ( $slugs as $slug ) {
					$slug = trim( $slug );
					$slug = sanitize_title( $slug );
					$term = get_term_by( 'slug', $slug, $taxonomy );

					if ( ! $term ) {
						continue;
					}

					$args             = $this->parse_query_atts( $atts );
					$args['category'] = $args['tag'] = '';
					$args[ $field ]   = $slug;
					$query            = $query ? $query : $args;

					$tabs[ $slug ] = sprintf( '<li data-target="%s" data-atts="%s">%s</li>', $index++, esc_attr( json_encode( $args ) ), $term->name );
				}
				break;

			case 'groups':
				$groups = json_decode( urldecode( $atts['groups'] ), true );

				if ( empty( $groups ) ) {
					break;
				}

				foreach ( $groups as $i => $group ) {
					$args             = $this->parse_query_atts( $atts );
					$args['category'] = $args['tag'] = '';
					$args['type']     = $group['type'];
					$query            = $query ? $query : $args;

					$tabs[ $group['type'] . $i ] = sprintf( '<li data-target="%s" data-atts="%s">%s</li>', $index++, esc_attr( json_encode( $args ) ), $group['title'] );
				}

				break;
		}

		if ( empty( $tabs ) ) {
			return '';
		}

		$panel_css_class = array(
			'penshop-product-grid',
			'penshop-products',
			'product-' . $atts['product_style'],
		);

		return sprintf(
			'<div class="%s">
				<ul class="tabs">%s</ul>
				<div class="panels">%s</div>
			</div>',
			esc_attr( implode( ' ', $css_class ) ),
			implode( "\n\t", $tabs ),
			sprintf(
				'<div class="%s panel active" data-panel="1">%s</div>',
				esc_attr( implode( ' ', $panel_css_class ) ),
				$this->product_loop( $query )
			)
		);
	}

	/**
	 * Promotion shortcode
	 *
	 * @param  array  $atts
	 * @param  string $content
	 *
	 * @return string
	 */
	public function promotion( $atts, $content ) {
		$atts = shortcode_atts(
			array(
				'image'         => '',
				'type'          => 'default',
				'button_text'   => '',
				'button_link'   => '',
				'css_animation' => '',
				'el_class'      => '',
			),
			$atts,
			'penshop_' . __FUNCTION__
		);

		$css_class = array(
			'penshop-promotion',
			'promotion-type-' . $atts['type'],
			$this->get_css_animation( $atts['css_animation'] ),
			$atts['el_class'],
		);

		$style  = '';
		$button = '';

		if ( $atts['image'] ) {
			$image = wp_get_attachment_image_url( $atts['image'], 'full' );
			$style = 'style="background-image: url(' . esc_attr( $image ) . ')"';
		}

		if ( function_exists( 'vc_build_link' ) && $atts['button_text'] && $atts['button_link'] ) {
			$link       = vc_build_link( $atts['button_link'] );
			$attributes = '';

			foreach ( $link as $attribute => $value ) {
				$attribute = 'url' == $attribute ? 'href' : $attribute;
				$attributes .= $attribute . '="' . $value . '" ';
			}

			$button = sprintf(
				'<a %s class="penshop-button button-type-outline button-size-normal">%s<i class="fa fa-shopping-bag"></i></a>',
				$attributes,
				esc_html( $atts['button_text'] )
			);
		}

		return sprintf(
			'<div class="%s" %s>
				<div class="penshop-promotion__content">%s</div>
				%s
			</div>',
			esc_attr( implode( ' ', $css_class ) ),
			$style,
			wpb_js_remove_wpautop( $content, true ),
			$button
		);
	}

	/**
	 * Banner shortcode
	 * Banner with title, subtitle and button
	 *
	 * @param array $atts
	 *
	 * @return string
	 */
	public function banner( $atts ) {
		$atts = shortcode_atts(
			array(
				'image'           => '',
				'image_size'      => 'full',
				'content_present' => 'default',
				'title'           => '',
				'subtitle'        => '',
				'button_text'     => esc_html__( 'Shop Now', 'penshop-addons' ),
				'button_link'     => '',
				'color_scheme'    => 'dark',
				'text_position'   => 'middle-center',
				'css_animation'   => '',
				'el_class'        => '',
			),
			$atts,
			'penshop_' . __FUNCTION__
		);

		$css_class = array(
			'penshop-banner',
			'penshop-banner-alone',
			'banner-' . $atts['text_position'],
			'content-present-' . $atts['content_present'],
			$atts['color_scheme'],
			self::get_css_animation( $atts['css_animation'] ),
			$atts['el_class'],
		);
		$link      = vc_build_link( $atts['button_link'] );
		$image     = '';

		if ( $atts['image'] ) {
			if ( function_exists( 'wpb_getImageBySize' ) ) {
				$image = wpb_getImageBySize( array(
					'attach_id'  => $atts['image'],
					'thumb_size' => $atts['image_size'],
				) );

				$image = $image['thumbnail'];
			} else {
				$size_array = explode( 'x', $atts['image_size'] );
				$size       = count( $size_array ) == 1 ? $atts['image_size'] : $size_array;

				$image = wp_get_attachment_image( $atts['image'], $size );

				if ( $image ) {
					$image = sprintf( '<img alt="%s" src="%s">',
						esc_attr( $atts['text'] ),
						esc_url( $image[0] )
					);
				}
			}
		}

		return sprintf(
			'<div class="%s">
				<a href="%s" target="%s" rel="%s" title="%s">
					%s
					<span class="banner-content">
						<span class="banner-title">%s</span>
						<span class="banner-subtitle">%s</span>
						<span class="button-wrapper">
							<span class="penshop-button button-type-outline button-size-%s button-color-%s button">%s</span>
						</span>
					</span>
				</a>
			</div>',
			esc_attr( implode( ' ', $css_class ) ),
			esc_url( $link['url'] ),
			esc_attr( $link['target'] ),
			esc_attr( $link['rel'] ),
			esc_attr( $link['title'] ),
			$image,
			esc_html( $atts['title'] ),
			esc_html( $atts['subtitle'] ),
			'default' == $atts['content_present'] ? 'small' : 'normal',
			esc_attr( $atts['color_scheme'] ),
			esc_html( $atts['button_text'] )
		);
	}

	/**
	 * Banner2 shortcode
	 * Simple banner with image and text only
	 *
	 * @param array  $atts
	 * @param string $content
	 *
	 * @return string
	 */
	public function banner2( $atts, $content ) {
		$atts = shortcode_atts(
			array(
				'image'         => '',
				'image_size'    => 'full',
				'link'          => '',
				'color_scheme'  => 'dark',
				'text_align'    => 'center',
				'css_animation' => '',
				'el_class'      => '',
			),
			$atts,
			'penshop_' . __FUNCTION__
		);

		$css_class = array(
			'penshop-banner',
			'penshop-banner2',
			'penshop-banner-alone',
			'banner-' . $atts['text_align'],
			$atts['color_scheme'],
			self::get_css_animation( $atts['css_animation'] ),
			$atts['el_class'],
		);
		$link      = vc_build_link( $atts['link'] );
		$image     = '';

		if ( $atts['image'] ) {
			if ( function_exists( 'wpb_getImageBySize' ) ) {
				$image = wpb_getImageBySize( array(
					'attach_id'  => $atts['image'],
					'thumb_size' => $atts['image_size'],
				) );

				$image = $image['thumbnail'];
			} else {
				$size_array = explode( 'x', $atts['image_size'] );
				$size       = count( $size_array ) == 1 ? $atts['image_size'] : $size_array;

				$image = wp_get_attachment_image( $atts['image'], $size );

				if ( $image ) {
					$image = sprintf( '<img alt="%s" src="%s">',
						esc_attr( $atts['text'] ),
						esc_url( $image[0] )
					);
				}
			}
		}

		$content = function_exists( 'wpb_js_remove_wpautop' ) ? wpb_js_remove_wpautop( $content, true ) : do_shortcode( $content );

		return sprintf(
			'<div class="%s">
				<a href="%s" target="%s" rel="%s" title="%s">
					%s
					<span class="banner-title">%s</span>
				</a>
			</div>',
			esc_attr( implode( ' ', $css_class ) ),
			esc_url( $link['url'] ),
			esc_attr( $link['target'] ),
			esc_attr( $link['rel'] ),
			esc_attr( $link['title'] ),
			$image,
			$content
		);
	}

	/**
	 * Banner shortcode
	 * Simple banner with image and text only
	 *
	 * @param array  $atts
	 * @param string $content
	 *
	 * @return string
	 */
	public function banner_promo( $atts, $content ) {
		$atts = shortcode_atts(
			array(
				'image'         => '',
				'image_size'    => 'full',
				'image_pos'     => 'left',
				'link'          => '',
				'title'         => '',
				'css_animation' => '',
				'el_class'      => '',
			),
			$atts,
			'penshop_' . __FUNCTION__
		);

		$css_class = array(
			'penshop-banner-promo',
			'image-' . $atts['image_pos'],
			self::get_css_animation( $atts['css_animation'] ),
			$atts['el_class'],
		);
		$link      = vc_build_link( $atts['link'] );
		$image     = '';

		if ( $atts['image'] ) {
			if ( function_exists( 'wpb_getImageBySize' ) ) {
				$image = wpb_getImageBySize( array(
					'attach_id'  => $atts['image'],
					'thumb_size' => $atts['image_size'],
				) );

				$image = $image['thumbnail'];
			} else {
				$size_array = explode( 'x', $atts['image_size'] );
				$size       = count( $size_array ) == 1 ? $atts['image_size'] : $size_array;

				$image = wp_get_attachment_image( $atts['image'], $size );

				if ( $image ) {
					$image = sprintf( '<img alt="%s" src="%s">',
						esc_attr( $atts['text'] ),
						esc_url( $image[0] )
					);
				}
			}
		}

		$content = function_exists( 'wpb_js_remove_wpautop' ) ? wpb_js_remove_wpautop( $content, true ) : do_shortcode( $content );

		return sprintf(
			'<div class="%s">
				<div class="banner-image">
					<a href="%s" target="%s" rel="%s" title="%s">
						%s
					</a>
				</div>
				<div class="banner-content">
					%s
					<div class="banner-text">%s</div>
				</div>
			</div>',
			esc_attr( implode( ' ', $css_class ) ),
			esc_url( $link['url'] ),
			esc_attr( $link['target'] ),
			esc_attr( $link['rel'] ),
			esc_attr( $link['title'] ),
			$image,
			$atts['title'] ? '<h2 class="banner-title">' . esc_html( $atts['title'] ) . '</h2>' : '',
			$content
		);
	}

	/**
	 * Shortcode to display carousel
	 *
	 * @param  array  $atts
	 * @param  string $content
	 *
	 * @return string
	 */
	public function carousel( $atts, $content ) {
		$atts = shortcode_atts(
			array(
				'items'         => 3,
				'margin'        => 3,
				'loop'          => false,
				'autowidth'     => true,
				'autoplay'      => false,
				'height'        => '700px',
				'full_height'   => false,
				'offset'        => '',
				'css_animation' => '',
				'el_class'      => '',
			), $atts
		);

		$css_class = array(
			'penshop-carousel',
			$this->get_css_animation( $atts['css_animation'] ),
			$atts['el_class'],
		);

		if ( $atts['full_height'] ) {
			$css_class[] = 'full-height-carousel';
		}

		$data = array(
			'items'           => intval( $atts['items'] ),
			'margin'          => intval( $atts['margin'] ),
			'loop'            => ! ! $atts['loop'],
			'autowidth'       => ! ! $atts['autowidth'],
			'autoplay'        => ! ! $atts['autoplay'],
			'autoplayTimeout' => $atts['autoplay'] ? intval( $atts['autoplay'] ) : 5000,
		);

		return sprintf(
			'<div class="%s" data-carousel_options="%s" data-full_height="%s" data-offset="%s" style="height:%s">%s</div>',
			esc_attr( implode( ' ', $css_class ) ),
			esc_attr( json_encode( $data ) ),
			esc_attr( ! ! $atts['full_height'] ),
			esc_attr( $atts['offset'] ),
			esc_attr( $atts['height'] ),
			do_shortcode( $content )
		);
	}

	/**
	 * Shortcode to display carousel item
	 *
	 * @param  array  $atts
	 * @param  string $content
	 *
	 * @return string
	 */
	public function carousel_item( $atts, $content ) {
		$atts = shortcode_atts(
			array(
				'image'         => '',
				'image_size'    => 'full',
				'text_position' => 'middle-right',
				'text_align'    => 'left',
				'el_class'      => '',
			), $atts
		);

		$css_class = array(
			'penshop-carousel-item',
			'content-' . $atts['text_position'],
			'text-' . $atts['text_align'],
			$atts['el_class'],
		);

		$image = '';

		if ( $atts['image'] ) {
			if ( function_exists( 'wpb_getImageBySize' ) ) {
				$image = wpb_getImageBySize( array(
					'attach_id'  => $atts['image'],
					'thumb_size' => $atts['image_size'],
				) );

				$image = $image['thumbnail'];
			} else {
				$image = wp_get_attachment_image_src( $atts['image'], $atts['image_size'] );

				if ( $image ) {
					$image = sprintf( '<img alt="%s" src="%s">',
						esc_attr( $atts['image'] ),
						esc_url( $image[0] )
					);
				}
			}
		}

		return sprintf(
			'<div class="%s">%s<div class="carousel-item-content">%s</div></div>',
			esc_attr( implode( ' ', $css_class ) ),
			$image,
			wpb_js_remove_wpautop( $content )
		);
	}

	/**
	 * Shortcode icon list
	 *
	 * @param  array  $atts
	 * @param  string $content
	 *
	 * @return string
	 */
	public function icon_list( $atts, $content ) {
		$atts = shortcode_atts(
			array(
				'icon_type'        => 'fontawesome',
				'icon_fontawesome' => 'fa fa-adjust',
				'icon_openiconic'  => 'vc-oi vc-oi-dial',
				'icon_typicons'    => 'typcn typcn-adjust-brightness',
				'icon_entypo'      => 'entypo-icon entypo-icon-note',
				'icon_linecons'    => 'vc_li vc_li-heart',
				'icon_monosocial'  => 'vc-mono vc-mono-fivehundredpx',
				'icon_material'    => 'vc-material vc-material-cake',
				'css_animation'    => '',
				'el_class'         => '',
			),
			$atts,
			'penshop_' . __FUNCTION__
		);

		$css_class = array(
			'penshop-icon-list',
			$atts['el_class'],
		);

		vc_icon_element_fonts_enqueue( $atts['icon_type'] );
		$default_icon = '<i class="' . esc_attr( $atts[ 'icon_' . $atts['icon_type'] ] ) . '"></i>';
		$animation    = $this->get_css_animation( $atts['css_animation'] );

		$this->list = array();
		do_shortcode( $content );

		$list = array();
		foreach ( $this->list as $item ) {
			$item_class = array(
				$item['el_class'],
				$animation,
			);
			$icon       = $item['icon'] ? $item['icon'] : $default_icon;
			$list[]     = sprintf( '<li class="%s">%s%s</li>', implode( ' ', $item_class ), $icon, $item['text'] );
		}

		return sprintf(
			'<ul class="%s" >%s</ul>',
			esc_attr( implode( ' ', $css_class ) ),
			implode( "\n\t", $list )
		);
	}

	/**
	 * Shortcode icon list item
	 *
	 * @param array  $atts
	 * @param string $content
	 *
	 * @return string
	 */
	public function icon_list_item( $atts, $content ) {
		$atts = shortcode_atts(
			array(
				'icon_type'        => 'default',
				'icon_fontawesome' => 'fa fa-adjust',
				'icon_openiconic'  => 'vc-oi vc-oi-dial',
				'icon_typicons'    => 'typcn typcn-adjust-brightness',
				'icon_entypo'      => 'entypo-icon entypo-icon-note',
				'icon_linecons'    => 'vc_li vc_li-heart',
				'icon_monosocial'  => 'vc-mono vc-mono-fivehundredpx',
				'icon_material'    => 'vc-material vc-material-cake',
				'el_class'         => '',
			),
			$atts,
			'penshop_' . __FUNCTION__
		);

		$item = array(
			'el_class' => $atts['el_class'],
			'icon'     => '',
			'text'     => $content,
		);

		if ( 'default' != $atts['icon_type'] ) {
			vc_icon_element_fonts_enqueue( $atts['icon_type'] );
			$item['icon'] = '<i class="' . esc_attr( $atts[ 'icon_' . $atts['icon_type'] ] ) . '"></i>';
		}

		$this->list[] = $item;

		return '';
	}

	/**
	 * Post grid
	 *
	 * @param array $atts
	 *
	 * @return string
	 */
	public function post_grid( $atts ) {
		$atts = shortcode_atts( array(
			'per_page'      => 3,
			'columns'       => 3,
			'category'      => '',
			'css_animation' => '',
			'el_class'      => '',
		), $atts, 'penshop_' . __FUNCTION__ );

		$css_class = array(
			'penshop-post-grid',
			'post-grid',
			'columns-' . $atts['columns'],
			self::get_css_animation( $atts['css_animation'] ),
			$atts['el_class'],
		);

		$output = array();

		$args = array(
			'post_type'              => 'post',
			'posts_per_page'         => $atts['per_page'],
			'ignore_sticky_posts'    => 1,
			'no_found_rows'          => true,
			'update_post_term_cache' => false,
			'update_post_meta_cache' => false,
		);

		if ( $atts['category'] ) {
			$args['category_name'] = trim( $atts['category'] );
		}

		$posts = new WP_Query( $args );

		if ( ! $posts->have_posts() ) {
			return '';
		}

		$column_class = 'penshop-post-grid__post col-sm-6 col-md-' . ( 12 / absint( $atts['columns'] ) );

		while ( $posts->have_posts() ) : $posts->the_post();
			$post_class = get_post_class( $column_class );
			$thumbnail  = '';

			$posted_on = sprintf(
				'<time class="entry-date published updated" datetime="%1$s">%2$s</time>',
				esc_attr( get_the_date( 'c' ) ),
				esc_html( get_the_date( 'd F' ) )
			);

			if ( has_post_thumbnail() ) :
				$thumbnail = sprintf(
					'<div class="post-thumbnail"><a href="%s">%s</a>%s</div>',
					esc_url( get_permalink() ),
					get_the_post_thumbnail( get_the_ID(), 'penshop-blog-thumb' ),
					$posted_on
				);
			endif;

			$comment = '';

			if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
				$comment = sprintf( '<span class="comments-link"><i class="fa fa-comments-o"></i>%s</span>', get_comments_number_text() );
			}

			$output[] = sprintf(
				'<div class="%s">
					%s
					<div class="post-summary">
						<h3 class="entry-title"><a href="%s" rel="bookmark">%s</a></h3>
						<div class="entry-meta">%s</div>
					</div>
				</div>',
				esc_attr( implode( ' ', $post_class ) ),
				$thumbnail,
				esc_url( get_permalink() ),
				get_the_title(),
				$comment
			);
		endwhile;

		wp_reset_postdata();

		return sprintf(
			'<div class="%s">
				<div class="row">%s</div>
			</div>',
			esc_attr( implode( ' ', $css_class ) ),
			implode( '', $output )
		);
	}

	/**
	 * Countdown
	 *
	 * @param array $atts
	 *
	 * @return string
	 */
	public function countdown( $atts ) {
		$atts = shortcode_atts( array(
			'color_scheme'  => 'dark',
			'date'          => '',
			'text_align'    => 'left',
			'css_animation' => '',
			'el_class'      => '',
		), $atts, 'penshop_' . __FUNCTION__ );

		if ( empty( $atts['date'] ) ) {
			return '';
		}

		$css_class = array(
			'penshop-countdown',
			'text-' . $atts['text_align'],
			$atts['color_scheme'],
			self::get_css_animation( $atts['css_animation'] ),
			$atts['el_class'],
		);

		$output   = array();
		$output[] = sprintf( '<div class="timers" data-date="%s">', esc_attr( $atts['date'] ) );
		$output[] = sprintf( '<div class="timer-day box"><span class="time day"></span><span class="title">%s</span></div>', esc_html__( 'Days', 'penshop-addons' ) );
		$output[] = sprintf( '<div class="timer-hour box"><span class="time hour"></span><span class="title">%s</span></div>', esc_html__( 'Hours', 'penshop-addons' ) );
		$output[] = sprintf( '<div class="timer-min box"><span class="time min"></span><span class="title">%s</span></div>', esc_html__( 'Minutes', 'penshop-addons' ) );
		$output[] = sprintf( '<div class="timer-secs box"><span class="time secs"></span><span class="title">%s</span></div>', esc_html__( 'Seconds', 'penshop-addons' ) );
		$output[] = '</div>';

		return sprintf(
			'<div class="%s">%s</div>',
			esc_attr( implode( ' ', $css_class ) ),
			implode( '', $output )
		);
	}

	/**
	 * Google Map
	 *
	 * @param array  $atts
	 * @param string $content
	 *
	 * @return string
	 */
	public function map( $atts, $content ) {
		$atts = shortcode_atts(
			array(
				'api_key'       => '',
				'marker'        => '',
				'address'       => '',
				'lat'           => '',
				'lng'           => '',
				'width'         => '100%',
				'height'        => '512px',
				'zoom'          => 13,
				'css_animation' => '',
				'el_class'      => '',
			), $atts, 'penshop_' . __FUNCTION__
		);

		if ( empty( $atts['api_key'] ) ) {
			return esc_html__( 'Google map requires API Key in order to work.', 'penshop-addons' );
		}

		if ( empty( $atts['address'] ) && empty( $atts['lat'] ) && empty( $atts['lng'] ) ) {
			return esc_html__( 'No address', 'penshop-addons' );
		}

		if ( ! empty( $atts['address'] ) ) {
			$coordinates = self::get_coordinates( $atts['address'], $atts['api_key'] );
		} else {
			$coordinates = array(
				'lat' => $atts['lat'],
				'lng' => $atts['lng'],
			);
		}

		if ( ! empty( $coordinates['error'] ) ) {
			return $coordinates['error'];
		}

		$css_class = array(
			'penshop-map',
			$this->get_css_animation( $atts['css_animation'] ),
			$atts['el_class'],
		);

		$style = array();
		if ( $atts['width'] ) {
			$style[] = 'width: ' . $atts['width'];
		}

		if ( $atts['height'] ) {
			$style[] = 'height: ' . intval( $atts['height'] ) . 'px';
		}

		$marker = '';

		if ( $atts['marker'] ) {
			if ( filter_var( $atts['marker'], FILTER_VALIDATE_URL ) ) {
				$marker = $atts['marker'];
			} else {
				$attachment_image = wp_get_attachment_image_src( intval( $atts['marker'] ), 'full' );
				$marker           = $attachment_image ? $attachment_image[0] : '';
			}
		}

		wp_enqueue_script( 'google-maps', 'https://maps.googleapis.com/maps/api/js?key=' . $atts['api_key'] );

		return sprintf(
			'<div class="%s" style="%s" data-zoom="%s" data-lat="%s" data-lng="%s" data-marker="%s">%s</div>',
			implode( ' ', $css_class ),
			implode( ';', $style ),
			absint( $atts['zoom'] ),
			esc_attr( $coordinates['lat'] ),
			esc_attr( $coordinates['lng'] ),
			esc_attr( $marker ),
			$content
		);
	}

	/**
	 * Get coordinates
	 *
	 * @param string $address
	 * @param bool   $refresh
	 *
	 * @return array
	 */
	public static function get_coordinates( $address, $key = '', $refresh = false ) {
		$address_hash = md5( $address );
		$coordinates  = get_transient( $address_hash );
		$results      = array( 'lat' => '', 'lng' => '' );

		if ( $refresh || $coordinates === false ) {
			$args     = array( 'address' => urlencode( $address ), 'sensor' => 'false', 'key' => $key );
			$url      = add_query_arg( $args, 'https://maps.googleapis.com/maps/api/geocode/json' );
			$response = wp_remote_get( $url );

			if ( is_wp_error( $response ) ) {
				$results['error'] = esc_html__( 'Can not connect to Google Maps APIs', 'penshop-addons' );

				return $results;
			}

			$data = wp_remote_retrieve_body( $response );

			if ( is_wp_error( $data ) ) {
				$results['error'] = esc_html__( 'Can not connect to Google Maps APIs', 'penshop-addons' );

				return $results;
			}

			if ( $response['response']['code'] == 200 ) {
				$data = json_decode( $data );

				if ( $data->status === 'OK' ) {
					$coordinates = $data->results[0]->geometry->location;

					$results['lat']     = $coordinates->lat;
					$results['lng']     = $coordinates->lng;
					$results['address'] = (string) $data->results[0]->formatted_address;

					// cache coordinates for 3 months
					set_transient( $address_hash, $results, 3600 * 24 * 30 * 3 );
				} elseif ( $data->status === 'ZERO_RESULTS' ) {
					$results['error'] = esc_html__( 'No location found for the entered address.', 'penshop-addons' );
				} elseif ( $data->status === 'INVALID_REQUEST' ) {
					$results['error'] = esc_html__( 'Invalid request. Did you enter an address?', 'penshop-addons' );
				} else {
					$results['error'] = esc_html__( 'Something went wrong while retrieving your map, please ensure you have entered the short code correctly.', 'penshop-addons' );
				}
			} else {
				$results['error'] = esc_html__( 'Unable to contact Google API service.', 'penshop-addons' );
			}
		} else {
			$results = $coordinates; // return cached results
		}

		return $results;
	}

	/**
	 * Get CSS classes for animation
	 *
	 * @param string $css_animation
	 *
	 * @return string
	 */
	public function get_css_animation( $css_animation ) {
		$output = '';

		if ( '' !== $css_animation ) {
			wp_enqueue_script( 'waypoints' );
			wp_enqueue_style( 'animate-css' );
			$output = ' wpb_animate_when_almost_visible wpb_' . $css_animation . ' ' . $css_animation;
		}

		return $output;
	}

	/**
	 * Loop over found products.
	 *
	 * @param  array  $atts
	 * @param  string $loop_name
	 *
	 * @return string
	 * @internal param array $columns
	 */
	public function product_loop( $atts, $loop_name = 'product_grid' ) {
		global $woocommerce_loop;

		$atts       = $this->parse_query_atts( $atts );
		$query_args = $this->parse_query_args( $atts );

		if ( isset( $atts['type'] ) && 'top_rated' == $atts['type'] ) {
			add_filter( 'posts_clauses', array( 'WC_Shortcodes', 'order_by_rating_post_clauses' ) );
		}

		$products = new WP_Query( $query_args );

		if ( isset( $atts['type'] ) && 'top_rated' == $atts['type'] ) {
			remove_filter( 'posts_clauses', array( 'WC_Shortcodes', 'order_by_rating_post_clauses' ) );
		}

		$woocommerce_loop['name'] = $loop_name;
		$columns                  = ! empty( $atts['columns'] ) ? absint( $atts['columns'] ) : null;

		if ( isset( $atts['product_style'] ) ) {
			$woocommerce_loop['product_style'] = $atts['product_style'];
		}

		if ( $columns ) {
			$woocommerce_loop['columns'] = $columns;
		}

		ob_start();

		if ( $products->have_posts() ) {
			woocommerce_product_loop_start();

			while ( $products->have_posts() ) : $products->the_post();
				wc_get_template_part( 'content', 'product' );
			endwhile; // end of the loop.

			woocommerce_product_loop_end();
		}

		$return = '<div class="woocommerce columns-' . $columns . '">' . ob_get_clean() . '</div>';

		if ( $atts['load_more'] && $products->max_num_pages > 1 ) {
			$paged = max( 1, $products->get( 'paged' ) );
			$atts['page']++;

			if ( $paged < $products->max_num_pages ) {
				$button = sprintf(
					'<div class="load-more text-center">
						<a href="#" class="penshop-button button-type-underline button-size-normal button ajax-load-products" data-atts="%s" data-label="%s" rel="nofollow">
							<span class="button-text link-text">%s</span>
							<span class="loading-bubbles"><span class="bounce1"></span><span class="bounce2"></span><span class="bounce3"></span></span>
						</a>
					</div>',
					esc_attr( json_encode( $atts ) ),
					esc_attr( $atts['load_more_text'] ),
					esc_html( $atts['load_more_text'] )
				);

				$return .= $button;
			}
		}

		woocommerce_reset_loop();
		wp_reset_postdata();

		return $return;
	}

	/**
	 * Parse query args from shortcode attributes
	 *
	 * @param  array $atts Shortcode's attributes
	 *
	 * @return array
	 */
	protected function parse_query_atts( $atts = array() ) {
		if ( isset( $atts['load_more'] ) ) {
			$atts['load_more'] = filter_var( $atts['load_more'], FILTER_VALIDATE_BOOLEAN );
		}

		return shortcode_atts( array(
			'type'           => 'recent',
			'per_page'       => 10,
			'columns'        => '',
			'product_style'  => 'default',
			'category'       => '',
			'tag'            => '',
			'load_more'      => false,
			'load_more_text' => esc_html__( 'Load more products', 'penshop-addons' ),
			'page'           => 1,
		), $atts );
	}

	/**
	 * Build query args from shortcode attributes
	 *
	 * @param array $atts
	 *
	 * @return array
	 */
	protected function parse_query_args( $atts ) {
		$args = array(
			'post_type'              => 'product',
			'post_status'            => 'publish',
			'ignore_sticky_posts'    => 1,
			'posts_per_page'         => $atts['per_page'],
			'meta_query'             => WC()->query->get_meta_query(),
			'tax_query'              => WC()->query->get_tax_query(),
			'update_post_term_cache' => false,
			'update_post_meta_cache' => false,
		);

		// Improve performance
		if ( ! isset( $atts['load_more'] ) || ! $atts['load_more'] ) {
			$args['no_found_rows'] = true;
		}

		if ( ! empty( $atts['category'] ) ) {
			$args['product_cat'] = $atts['category'];
			unset( $args['update_post_term_cache'] );
		}

		if ( ! empty( $atts['tag'] ) ) {
			$args['product_tag'] = $atts['tag'];
			unset( $args['update_post_term_cache'] );
		}

		if ( ! empty( $atts['page'] ) ) {
			$args['paged'] = absint( $atts['page'] );
		}

		if ( isset( $atts['type'] ) ) {
			switch ( $atts['type'] ) {
				case 'featured':
					$args['tax_query'][] = array(
						'taxonomy' => 'product_visibility',
						'field'    => 'name',
						'terms'    => 'featured',
						'operator' => 'IN',
					);
					unset( $args['update_post_meta_cache'] );
					break;

				case 'sale':
					$args['post__in'] = array_merge( array( 0 ), wc_get_product_ids_on_sale() );
					break;

				case 'best_sellers':
					$args['meta_key'] = 'total_sales';
					$args['orderby']  = 'meta_value_num';
					unset( $args['update_post_meta_cache'] );
					break;

				case 'top_rated':
					unset( $args['product_cat'] );
					$args = self::_maybe_add_category_args( $args, $atts['category'] );
					break;
			}
		}

		return $args;
	}

	/**
	 * Adds a tax_query index to the query to filter by category.
	 *
	 * @param array  $args
	 * @param string $category
	 *
	 * @return array;
	 */
	protected static function _maybe_add_category_args( $args, $category ) {
		if ( ! empty( $category ) ) {
			if ( empty( $args['tax_query'] ) ) {
				$args['tax_query'] = array();
			}
			$args['tax_query'][] = array(
				array(
					'taxonomy' => 'product_cat',
					'terms'    => array_map( 'sanitize_title', explode( ',', $category ) ),
					'field'    => 'slug',
					'operator' => 'IN',
				),
			);
		}

		return $args;
	}

	/**
	 * Get font-size CSS rule
	 *
	 * @param     string /float $font_size
	 * @param int $base
	 *
	 * @return string
	 */
	protected function get_font_size_css( $font_size, $base = 10 ) {
		if ( empty( $font_size ) ) {
			return '';
		}

		$pattern = '/^(\d*(?:\.\d+)?)\s*(px|\%|in|cm|mm|em|rem|ex|pt|pc|vw|vh|vmin|vmax)?$/';
		$regexr  = preg_match( $pattern, $font_size, $matches );
		$value   = isset( $matches[1] ) ? (float) $matches[1] : (float) $font_size;
		$unit    = isset( $matches[2] ) ? $matches[2] : 'px';

		if ( 'px' == $unit ) {
			$value = ( $value / $base ) . 'em';
		} else {
			$value = $value . $unit;
		}

		return 'font-size: ' . $value . ';';
	}

	/**
	 * Get background image and position CSS
	 *
	 * @param string $selector
	 * @param array  $args
	 *
	 * @return string
	 */
	protected function get_css_background( $selector, $args = array() ) {
		$args = wp_parse_args( $args, array(
			'image'                  => '',
			'position'               => 'center center',
			'position_custom'        => 'center center',
			'position_mobile'        => 'center center',
			'position_mobile_custom' => 'center center',
		) );

		$position        = 'custom' == $args['position'] ? $args['position_custom'] : $args['position'];
		$position_mobile = 'custom' == $args['position_mobile'] ? $args['position_mobile_custom'] : $args['position_mobile'];

		$css = $bgimage = '';

		if ( $args['image'] ) {
			$bgimage = 'background-image: url(' . esc_attr( $args['image'] ) . ')';
		}

		$css = "
		$selector {
			$bgimage;
			background-position: $position;
		}
		@media (max-width: 767px) {
			$selector {
				background-position: $position_mobile;
			}
		}
		";

		return $css;
	}

	/**
	 * Get ID number of a shortcode
	 *
	 * @param string $shortcode
	 *
	 * @return int
	 */
	protected function get_id_number( $shortcode ) {
		if ( isset( $this->ids[ $shortcode ] ) ) {
			$this->ids[ $shortcode ]++;
		} else {
			$this->ids[ $shortcode ] = 1;
		}

		return $this->ids[ $shortcode ];
	}
}
