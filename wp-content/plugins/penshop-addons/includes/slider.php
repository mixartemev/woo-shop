<?php

class PenShop_Addons_Slider {
	private $post_type = 'penshop_slider';

	/**
	 * The single instance of the class
	 */
	protected static $instance = null;

	/**
	 * Initialize
	 */
	static function init() {
		if ( null == self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Class constructor.
	 */
	public function __construct() {
		// Make sure the post types are loaded for imports
		add_action( 'import_start', array( $this, 'register_post_type' ) );
		$this->register_post_type();

		// Handle post columns
		add_filter( sprintf( 'manage_%s_posts_columns', $this->post_type ), array( $this, 'edit_admin_columns' ) );
		add_action( sprintf( 'manage_%s_posts_custom_column', $this->post_type ), array(
			$this,
			'manage_custom_columns',
		), 10, 2 );

		// Enqueue style and javascript
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

		// Add meta boxes
		add_filter( 'rwmb_meta_boxes', array( $this, 'register_meta_boxes' ) );

		// Add shortcode
		add_shortcode( 'penshop_slider', array( $this, 'shortcode' ) );
	}

	/**
	 * Register slider post type
	 */
	public function register_post_type() {
		if ( post_type_exists( $this->post_type ) ) {
			return;
		}

		register_post_type( $this->post_type, array(
			'labels'              => array(
				'name'                  => esc_html__( 'Sliders', 'penshop-addons' ),
				'singular_name'         => _x( 'Slider', 'shop_order post type singular name', 'penshop-addons' ),
				'add_new'               => esc_html__( 'Add Slider', 'penshop-addons' ),
				'add_new_item'          => esc_html__( 'Add new slider', 'penshop-addons' ),
				'edit'                  => esc_html__( 'Edit', 'penshop-addons' ),
				'edit_item'             => esc_html__( 'Edit slider', 'penshop-addons' ),
				'new_item'              => esc_html__( 'New slider', 'penshop-addons' ),
				'view'                  => esc_html__( 'View slider', 'penshop-addons' ),
				'view_item'             => esc_html__( 'View slider', 'penshop-addons' ),
				'search_items'          => esc_html__( 'Search sliders', 'penshop-addons' ),
				'not_found'             => esc_html__( 'No sliders found', 'penshop-addons' ),
				'not_found_in_trash'    => esc_html__( 'No sliders found in trash', 'penshop-addons' ),
				'parent'                => esc_html__( 'Parent sliders', 'penshop-addons' ),
				'menu_name'             => _x( 'Sliders', 'Admin menu name', 'penshop-addons' ),
				'all_items'             => esc_html__( 'All Sliders', 'penshop-addons' ),
				'filter_items_list'     => esc_html__( 'Filter sliders', 'penshop-addons' ),
				'items_list_navigation' => esc_html__( 'Sliders navigation', 'penshop-addons' ),
				'items_list'            => esc_html__( 'Sliders list', 'penshop-addons' ),
			),
			'public'              => false,
			'show_ui'             => true,
			'capability_type'     => 'post',
			'map_meta_cap'        => true,
			'publicly_queryable'  => false,
			'exclude_from_search' => true,
			'show_in_menu'        => true,
			'hierarchical'        => false,
			'show_in_nav_menus'   => false,
			'menu_icon'           => 'dashicons-slides',
			'rewrite'             => false,
			'query_var'           => false,
			'supports'            => array( 'title' ),
			'has_archive'         => false,
		) );
	}

	/**
	 * Add custom column to manage portfolio screen
	 * Add Thumbnail column
	 *
	 * @param  array $columns Default columns
	 *
	 * @return array
	 */
	public function edit_admin_columns( $columns ) {
		// add featured image before 'Project'
		$columns = array_slice( $columns, 0, 1, true ) + array( 'thumbnail' => '' ) + array_slice( $columns, 1, null, true );

		return $columns;
	}

	/**
	 * Handle custom column display
	 *
	 * @param  string $column
	 * @param  int    $post_id
	 */
	public function manage_custom_columns( $column, $post_id ) {
		switch ( $column ) {
			case 'thumbnail':
				$slides = get_post_meta( $post_id, 'slides', true );

				if ( $slides && isset( $slides[0]['image'] ) ) {
					echo wp_get_attachment_image( $slides[0]['image'][0], 'full' );
				}

				break;
		}
	}

	/**
	 * Load scripts in the admin
	 */
	public function admin_scripts( $hook ) {
		$screen = get_current_screen();

		if ( in_array( $hook, array(
				'edit.php',
				'post.php',
				'post-new.php',
			) ) && $this->post_type == $screen->post_type ) {
			wp_enqueue_style( 'penshop-addons-animate', PENSHOP_ADDONS_URL . 'assets/css/animate.css', array(), '3.5.2' );
			wp_enqueue_style( 'penshop-addons-slider-admin', PENSHOP_ADDONS_URL . 'assets/css/admin/slider.css' );
			wp_enqueue_script( 'penshop-addons-slider-admin', PENSHOP_ADDONS_URL . 'assets/js/admin/slider.js', array( 'jquery' ), '', true );
		}
	}

	/**
	 * Load scripts on the frontend
	 */
	public function enqueue_scripts() {
		wp_register_style( 'penshop-addons-animate', PENSHOP_ADDONS_URL . 'assets/css/animate.css', array(), '3.5.2' );
		wp_enqueue_style( 'penshop-addons-animate' );
	}

	/**
	 * Registering meta boxes for slider
	 */
	public function register_meta_boxes( $meta_boxes ) {
		$meta_boxes[] = array(
			'id'       => 'pesnhop-slider-slides',
			'title'    => esc_html__( 'Slides', 'penshop-addons' ),
			'pages'    => array( $this->post_type ),
			'context'  => 'advanced',
			'priority' => 'high',
			'fields'   => array(
				array(
					'id'          => 'slides',
					'type'        => 'group',
					'clone'       => true,
					'sort_clone'  => true,
					'collapsible' => true,
					'group_title' => esc_html__( 'Slide {#}', 'penshop-addons' ),
					'add_button'  => esc_html__( 'Add slide', 'penshop-addons' ),
					'fields'      => array(
						array(
							'name'             => esc_html__( 'Slide image', 'penshop-addons' ),
							'id'               => 'image',
							'type'             => 'image_advanced',
							'image_size'       => 'full',
							'max_file_uploads' => 1,
							'max_status'       => false,
							'class'            => 'slider-image-preview',
						),
						array(
							'name'    => esc_html__( 'Content Position', 'penshop' ),
							'id'      => 'content_position',
							'type'    => 'select',
							'std'     => 'center',
							'options' => array(
								'left'   => esc_html__( 'Left', 'penshop-addons' ),
								'center' => esc_html__( 'Center', 'penshop-addons' ),
								'right'  => esc_html__( 'Right', 'penshop-addons' ),
							),
						),
						array(
							'name'    => esc_html__( 'Content alignment', 'penshop' ),
							'id'      => 'content_align',
							'type'    => 'select',
							'std'     => 'center',
							'options' => array(
								'left'   => esc_html__( 'Left', 'penshop-addons' ),
								'center' => esc_html__( 'Center', 'penshop-addons' ),
								'right'  => esc_html__( 'Right', 'penshop-addons' ),
							),
						),
						array(
							'name'        => esc_html__( 'Content layers', 'penshop' ),
							'id'          => 'layers',
							'type'        => 'group',
							'clone'       => true,
							'sort_clone'  => true,
							'collapsible' => true,
							'group_title' => array( 'field' => 'text' ),
							'add_button'  => esc_html__( 'Add layer', 'penshop-addons' ),
							'fields'      => array(
								array(
									'name'    => esc_html__( 'Type', 'penshop' ),
									'id'      => 'type',
									'class'   => 'slide-layer-type',
									'type'    => 'select',
									'std'     => 'h2',
									'options' => array(
										'h1'               => esc_html__( 'Heading 1', 'penshop-addons' ),
										'h2'               => esc_html__( 'Heading 2', 'penshop-addons' ),
										'h3'               => esc_html__( 'Heading 3', 'penshop-addons' ),
										'h4'               => esc_html__( 'Heading 4', 'penshop-addons' ),
										'h5'               => esc_html__( 'Heading 5', 'penshop-addons' ),
										'h6'               => esc_html__( 'Heading 6', 'penshop-addons' ),
										'p'                => esc_html__( 'Paragraph', 'penshop-addons' ),
										'button'           => esc_html__( 'Button', 'penshop-addons' ),
										'button_underline' => esc_html__( 'Button underline', 'penshop-addons' ),
										'div'              => esc_html__( 'Container', 'penshop-addons' ),
									),
								),
								array(
									'name'  => esc_html__( 'Link', 'penshop' ),
									'id'    => 'link',
									'class' => 'slide-layer-link',
									'type'  => 'text',
								),
								array(
									'name' => esc_html__( 'Text', 'penshop' ),
									'id'   => 'text',
									'type' => 'textarea',
								),
								array(
									'name'    => esc_html__( 'Color', 'penshop' ),
									'id'      => 'color_scheme',
									'type'    => 'select',
									'class'   => 'slide-layer-color',
									'std'     => 'dark',
									'options' => array(
										'dark'   => esc_html__( 'Dark', 'penshop-addons' ),
										'white'  => esc_html__( 'White', 'penshop-addons' ),
										'custom' => esc_html__( 'Custom', 'penshop-addons' ),
									),
								),
								array(
									'name'          => "&nbsp;",
									'id'            => 'color',
									'type'          => 'color',
									'std'           => '#fff',
									'class'         => 'slide-layer-custom-color',
									'alpha_channel' => true,
								),
								array(
									'name'    => esc_html__( 'Font', 'penshop' ),
									'id'      => 'font',
									'type'    => 'select',
									'options' => array(
										''                 => esc_html__( 'Default', 'penshop-addons' ),
										'Poppins'          => esc_html__( 'Poppins', 'penshop-addons' ),
										'Roboto'           => esc_html__( 'Roboto', 'penshop-addons' ),
										'Playfair Display' => esc_html__( 'Playfair Display', 'penshop-addons' ),
									),
								),
								array(
									'name'    => esc_html__( 'Weight', 'penshop' ),
									'id'      => 'font_weight',
									'type'    => 'select',
									'options' => array(
										''    => esc_html__( 'Default', 'penshop-addons' ),
										'300' => esc_html__( 'Light', 'penshop-addons' ),
										'400' => esc_html__( 'Normal', 'penshop-addons' ),
										'500' => esc_html__( 'Medium', 'penshop-addons' ),
										'600' => esc_html__( 'Semi Bold', 'penshop-addons' ),
										'700' => esc_html__( 'Bold', 'penshop-addons' ),
									),
								),
								array(
									'name' => '<i>' . esc_html__( 'Italic', 'penshop' ) . '</i>',
									'id'   => 'font_italic',
									'type' => 'checkbox',
									'std'  => false,
								),
								array(
									'name' => esc_html__( 'Letter spacing', 'penshop' ),
									'id'   => 'letter_spacing',
									'type' => 'text',
								),
								array(
									'name'    => esc_html__( 'Animation', 'penshop' ),
									'desc'    => esc_html__( 'The layer animation when become visible', 'penshop' ),
									'id'      => 'animation',
									'class'   => 'slide-layer-animation',
									'type'    => 'select',
									'options' => array(
										''                     => esc_html__( 'No animation', 'penshop-addons' ),
										'bounceIn'             => _x( 'Bounce In', 'animation effect name', 'penshop-addons' ),
										'bounceInUp'           => _x( 'Bounce In Up', 'animation effect name', 'penshop-addons' ),
										'bounceInDown'         => _x( 'Bounce In Down', 'animation effect name', 'penshop-addons' ),
										'bounceInLeft'         => _x( 'Bounce In Left', 'animation effect name', 'penshop-addons' ),
										'bounceInRight'        => _x( 'Bounce In Right', 'animation effect name', 'penshop-addons' ),
										'fadeIn'               => _x( 'Fade In', 'animation effect name', 'penshop-addons' ),
										'penci-fadeInDown'     => _x( 'Fade In Down', 'animation effect name', 'penshop-addons' ),
										'penci-fadeInDownBig'  => _x( 'Fade In Down Big', 'animation effect name', 'penshop-addons' ),
										'penci-fadeInLeft'     => _x( 'Fade In Left', 'animation effect name', 'penshop-addons' ),
										'penci-fadeInLeftBig'  => _x( 'Fade In Left Big', 'animation effect name', 'penshop-addons' ),
										'penci-fadeInRight'    => _x( 'Fade In Right', 'animation effect name', 'penshop-addons' ),
										'penci-fadeInRightBig' => _x( 'Fade In Right Big', 'animation effect name', 'penshop-addons' ),
										'penci-fadeInUp'       => _x( 'Fade In Up', 'animation effect name', 'penshop-addons' ),
										'penci-fadeInUpBig'    => _x( 'Fade In Up Big', 'animation effect name', 'penshop-addons' ),
										'flip'                 => _x( 'Flip', 'animation effect name', 'penshop-addons' ),
										'flipInX'              => _x( 'Flip In X', 'animation effect name', 'penshop-addons' ),
										'flipInY'              => _x( 'Flip In Y', 'animation effect name', 'penshop-addons' ),
										'rotateIn'             => _x( 'Rotate In', 'animation effect name', 'penshop-addons' ),
										'rotateInDownLeft'     => _x( 'Rotate In Down Left', 'animation effect name', 'penshop-addons' ),
										'rotateInDownRight'    => _x( 'Rotate In Down Right', 'animation effect name', 'penshop-addons' ),
										'rotateInUpLeft'       => _x( 'Rotate In Up Left', 'animation effect name', 'penshop-addons' ),
										'rotateInUpRight'      => _x( 'Rotate In Up Right', 'animation effect name', 'penshop-addons' ),
										'slideInUp'            => _x( 'Slide In Up', 'animation effect name', 'penshop-addons' ),
										'slideInDown'          => _x( 'Slide In Down', 'animation effect name', 'penshop-addons' ),
										'slideInLeft'          => _x( 'Slide In Left', 'animation effect name', 'penshop-addons' ),
										'slideInRight'         => _x( 'Slide In Right', 'animation effect name', 'penshop-addons' ),
										'zoomIn'               => _x( 'Zoom In', 'animation effect name', 'penshop-addons' ),
										'zoomInDown'           => _x( 'Zoom In Down', 'animation effect name', 'penshop-addons' ),
										'zoomInLeft'           => _x( 'Zoom In Left', 'animation effect name', 'penshop-addons' ),
										'zoomInRight'          => _x( 'Zoom In Right', 'animation effect name', 'penshop-addons' ),
										'zoomInUp'             => _x( 'Zoom In Up', 'animation effect name', 'penshop-addons' ),
									),
									'after'   => '<div class="rwmb-field animation-preview">
													<div class="rwmb-label">&nbsp;</div>
													<div class="rwmb-input">
														<h3 class="animation-sandbox">' . esc_html__( 'Animation Preview', 'penshop-addons' ) . '</h3>
													</div>
												</div>',
								),
							),
						),
					),
				),
			),
		);

		$meta_boxes[] = array(
			'id'       => 'pesnhop-slider-settings',
			'title'    => esc_html__( 'Slider Settings', 'penshop-addons' ),
			'pages'    => array( $this->post_type ),
			'context'  => 'side',
			'priority' => 'low',
			'fields'   => array(
				array(
					'id'     => 'slider_settings',
					'type'   => 'group',
					'fields' => array(
						array(
							'name'    => esc_html__( 'Slider Width', 'penshop-addons' ),
							'id'      => 'width',
							'type'    => 'select',
							'std'     => 'auto',
							'options' => array(
								'auto'       => esc_html__( 'Auto', 'penshop-addons' ),
								'fullwidth'  => esc_html__( 'Full Width', 'penshop-addons' ),
								'fullscreen' => esc_html__( 'Full Screen', 'penshop-addons' ),
							),
						),
						array(
							'name' => esc_html__( 'Height', 'penshop-addons' ),
							'desc' => esc_html__( 'Note: this option does not work with "Full Screen" slider.', 'penshop-addons' ),
							'id'   => 'height',
							'type' => 'text',
							'std'  => 640,
						),
						array(
							'name'  => esc_html__( 'Auto play', 'penshop-addons' ),
							'id'    => 'autoplay',
							'type'  => 'checkbox',
							'std'   => true,
							'class' => 'inline-checkbox',
						),
						array(
							'name' => esc_html__( 'Slide duration', 'penshop-addons' ),
							'desc' => esc_html__( 'The time one slide stays on the screen in miliseconds', 'penshop-addons' ),
							'id'   => 'duration',
							'type' => 'number',
							'std'  => 10000,
						),
						array(
							'name' => esc_html__( 'Slide Speed', 'penshop-addons' ),
							'desc' => esc_html__( 'Duration of transition between slides in miliseconds', 'penshop-addons' ),
							'id'   => 'speed',
							'type' => 'number',
							'std'  => 800,
						),
						array(
							'name'  => esc_html__( 'Slider navigation', 'penshop-addons' ),
							'id'    => 'nav',
							'type'  => 'checkbox',
							'std'   => true,
							'class' => 'inline-checkbox',
						),
						array(
							'name'  => esc_html__( 'Slider pagination dots', 'penshop-addons' ),
							'id'    => 'dots',
							'type'  => 'checkbox',
							'std'   => false,
							'class' => 'inline-checkbox',
						),
						array(
							'name'    => esc_html__( 'Nav Color', 'penshop' ),
							'id'      => 'nav_color_scheme',
							'type'    => 'select',
							'std'     => 'dark',
							'options' => array(
								'dark'   => esc_html__( 'Dark', 'penshop-addons' ),
								'white'  => esc_html__( 'White', 'penshop-addons' ),
								'custom' => esc_html__( 'Custom', 'penshop-addons' ),
							),
						),
						array(
							'name'          => "&nbsp;",
							'id'            => 'nav_color',
							'type'          => 'color',
							'std'           => '#fff',
							'class'         => 'slider-nav-color',
							'alpha_channel' => true,
						),
					),
				),
			),
		);

		$meta_boxes[] = array(
			'id'       => 'pesnhop-slider-shortcode',
			'title'    => esc_html__( 'Slider Shortcode', 'penshop-addons' ),
			'pages'    => array( $this->post_type ),
			'context'  => 'side',
			'priority' => 'low',
			'fields'   => array(
				array(
					'id'   => 'slider_settings_shortcode',
					'type' => 'custom_html',
					'std'  => isset( $_GET['post'] ) ? '[penshop_slider name="' . get_post_field( 'post_name', $_GET['post'] ) . '"]' : esc_html__( 'You must publish this slider to get the shortcode', 'penshop-addons' ),
				),
			),
		);

		return $meta_boxes;
	}

	/**
	 * Slider shortcode
	 *
	 * @param array $atts
	 *
	 * @return string
	 */
	public function shortcode( $atts ) {
		$atts = shortcode_atts( array(
			'name'     => '',
			'el_class' => '',
		), $atts, 'penshop_slider' );

		if ( empty( $atts['name'] ) ) {
			return esc_html__( 'No slider selected', 'penshop-addons' );
		}

		$slider = get_page_by_path( $atts['name'], OBJECT, 'penshop_slider' );

		$settings = get_post_meta( $slider->ID, 'slider_settings', true );
		$slides   = get_post_meta( $slider->ID, 'slides', true );

		if ( empty( $slides ) ) {
			return '';
		}

		$css     = '';
		$id      = 'penshop-slider-' . $slider->ID;
		$classes = array(
			$id,
			'penshop-slider-' . $settings['width'],
			'nav-color-' . $settings['nav_color_scheme'],
			'penshop-slider',
			$atts['el_class'],
		);
		$attrs   = array(
			'id'            => $id,
			'class'         => implode( ' ', $classes ),
			'data-settings' => json_encode( $settings ),
		);

		$attributes = '';
		foreach ( $attrs as $att => $value ) {
			$attributes .= ' ' . $att . '="' . esc_attr( $value ) . '"';
		}

		if ( 'fullscreen' != $settings['width'] ) {
			$css .= "#$id { height: {$settings['height']}px }";
		}

		if ( 'custom' == $settings['nav_color_scheme'] ) {
			$css .= "#$id .owl-nav div { color: {$settings['nav_color']} }";
			$css .= "#$id .owl-dot span { background-color: {$settings['nav_color']} }";
		}

		$list = array();
		foreach ( $slides as $index => $slide ) {
			$image         = '';
			$slide_class   = 'penshop_slider__slide-' . ( $index + 1 );
			$slide_classes = array(
				$slide_class,
				'slide-content-' . $slide['content_position'],
				'text-' . $slide['content_align'],
				'penshop-slider__slide',
			);

			if ( ! empty( $slide['image'] ) ) {
				$image = wp_get_attachment_image_url( $slide['image'][0], 'full' );
			}

			if ( ! empty( $slide['layers'] ) ) {
				$layers = array();

				foreach ( $slide['layers'] as $layer_index => $layer_data ) {
					$tag         = $layer_data['type'];
					$text        = $layer_data['text'];
					$layer_class = 'slide-layer-' . ( $layer_index + 1 );
					$layer_attrs = array(
						'class' => $layer_class . ' slide-layer',
					);

					if ( 'button_underline' == $layer_data['type'] ) {
						$tag                       = 'a';
						$layer_attrs['href']       = isset( $layer_data['link'] ) ? $layer_data['link'] : '';
						$layer_attrs['data-label'] = $text;
						$layer_attrs['class']      .= ' penshop-button button-type-underline align-center button-size-normal';

						if ( 'custom' != $layer_data['color_scheme'] ) {
							$layer_attrs['class'] .= ' button-color-' . $layer_data['color_scheme'];
						}
					} elseif ( 'button' == $layer_data['type'] ) {
						$tag                  = 'a';
						$layer_attrs['href']  = isset( $layer_data['link'] ) ? $layer_data['link'] : '#';
						$layer_attrs['class'] .= ' penshop-button button-type-outline align-center button-size-normal';

						if ( 'custom' != $layer_data['color_scheme'] ) {
							$layer_attrs['class'] .= ' button-color-' . $layer_data['color_scheme'];
						}
					} else {
						$text = nl2br( $text );
					}

					$layer_css = '';

					if ( 'custom' == $layer_data['color_scheme'] ) {
						$layer_css = "color: {$layer_data['color']};";

						if ( 'button_underline' == $layer_data['type'] ) {
							$css .= "#$id .$slide_class .$layer_class:before { color: {$layer_data['color']}; }";
							$css .= "#$id .$slide_class .$layer_class:after { border-color: {$layer_data['color']}; }";
						} elseif ( 'button' == $layer_data['type'] ) {
							$layer_css .= "border-color: {$layer_data['color']};";
						}
					} elseif ( ! in_array( $layer_data['type'], array( 'button', 'button_underline' ) ) ) {
						$layer_attrs['class'] .= ' layer-color-' . $layer_data['color_scheme'];
					}

					if ( ! empty( $layer_data['font'] ) ) {
						$layer_css .= 'font-family: ' . $layer_data['font'] . ';';
					}

					if ( ! empty( $layer_data['font_weight'] ) ) {
						$layer_css .= 'font-weight: ' . $layer_data['font_weight'] . ';';
					}

					if ( ! empty( $layer_data['font_italic'] ) ) {
						$layer_css .= 'font-style: italic;';
					}

					if ( ! empty( $layer_data['letter_spacing'] ) ) {
						$layer_css .= 'letter-spacing: ' . $layer_data['letter_spacing'] . ';';
					}

					if ( ! empty( $layer_data['animation'] ) ) {
						$layer_attrs['data-animation']       = $layer_data['animation'];
						$layer_attrs['data-animation-delay'] = $layer_index * 0.15;
					}

					$css .= "#$id .$slide_class .$layer_class { $layer_css }";

					$attrs = '';
					foreach ( $layer_attrs as $attr => $value ) {
						$attrs .= $attr . '="' . esc_attr( $value ) . '" ';
					}

					$layers[] = sprintf(
						'<%s %s>%s</%s>',
						$tag,
						$attrs,
						$text,
						$tag
					);
				}
			}

			$list[] = sprintf( '<div class="%s" style="background-image: url(%s)"><div class="container"><div class="slide-content">%s</div></div></div>', esc_attr( implode( ' ', $slide_classes ) ), $image, implode( ' ', $layers ) );
		}

		return sprintf(
			'<style type="text/css">%s</style>
			<div %s>
				<span class="fa-spin fa-fw loading-icon"></span>
				<div class="penshop-slider__container">
					<div class="penshop-slider__slides owl-carousel">%s</div>
				</div>
			</div>',
			$css,
			$attributes,
			implode( '', $list )
		);
	}
}