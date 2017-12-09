<?php
/**
 * Customize and add more fields for mega menu
 *
 * @package PenShop
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Walker_Nav_Menu_Edit' ) ) {
	require_once ABSPATH . 'wp-admin/includes/nav-menu.php';
}

/**
 * Class PenShop_Mega_Menu_Walker_Edit
 *
 * Class for adding more controllers into a menu item
 */
class PenShop_Mega_Menu_Walker_Edit extends Walker_Nav_Menu_Edit {
	/**
	 * Start the element output.
	 *
	 * @see   Walker_Nav_Menu::start_el()
	 * @since 3.0.0
	 *
	 * @global int   $_wp_nav_menu_max_depth
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $item   Menu item data object.
	 * @param int    $depth  Depth of menu item. Used for padding.
	 * @param array  $args   Not used.
	 * @param int    $id     Not used.
	 */
	public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		$mega = get_post_meta( $item->ID, '_menu_item_mega', true );
		$mega = penshop_parse_args( $mega, penshop_get_mega_menu_setting_default() );

		$item_output = '';
		parent::start_el( $item_output, $item, $depth, $args );

		// Allows plugins to add more fields
		$item_output = preg_replace(
			'/(?=<(p|fieldset)[^>]+class="[^"]*field-move)/',
			$this->custom_fields( $item, $depth, $args ),
			$item_output
		);

		$dom = new DOMDocument();

		$dom->validateOnParse = true;
		$dom->loadHTML( mb_convert_encoding( $item_output, 'HTML-ENTITIES', 'UTF-8' ) );
		$xpath = new DOMXPath( $dom );

		// Adds mega menu data holder
		$settings = $xpath->query( "//*[@id='menu-item-settings-" . $item->ID . "']" )->item( 0 );

		if ( $settings ) {
			$node            = $dom->createElement( 'span' );
			$node->nodeValue = $mega['content'];
			unset( $mega['content'] );
			$node->setAttribute( 'data-mega', json_encode( $mega ) );
			$node->setAttribute( 'class', 'hidden mega-data' );
			$settings->appendChild( $node );
		}

		// Add settings link
		$cancel = $xpath->query( "//*[@id='cancel-" . $item->ID . "']" )->item( 0 );

		if ( $cancel ) {
			$link            = $dom->createElement( 'a' );
			$link->nodeValue = esc_html__( 'Settings', 'penshop' );
			$link->setAttribute( 'class', 'item-config-mega opensettings submitcancel hide-if-no-js' );
			$link->setAttribute( 'href', '#' );
			$sep            = $dom->createElement( 'span' );
			$sep->nodeValue = ' | ';
			$sep->setAttribute( 'class', 'meta-sep hide-if-no-js' );
			$cancel->parentNode->insertBefore( $link, $cancel );
			$cancel->parentNode->insertBefore( $sep, $cancel );
		}

		$output .= $dom->saveHTML();
	}

	/**
	 * Get custom fields from plugins
	 *
	 * @param object $item
	 * @param int    $depth
	 * @param array  $args
	 *
	 * @return string
	 */
	protected function custom_fields( $item, $depth, $args = array() ) {
		ob_start();

		/**
		 * Get menu item custom fields from plugins/themes
		 *
		 * @param object $item  Menu item data object.
		 * @param int    $depth Depth of menu item. Used for padding.
		 * @param array  $args  Menu item args.
		 *
		 * @return string
		 */
		do_action( 'wp_nav_menu_item_custom_fields', $item->ID, $item, $depth, $args );

		return ob_get_clean();
	}
}

/**
 * Class PenShop_Mega_Menu_Edit
 *
 * Main class for adding mega setting modal
 */
class PenShop_Mega_Menu_Edit {
	/**
	 * Modal screen of mega menu settings
	 *
	 * @var array
	 */
	public $modals = array();

	/**
	 * Class constructor.
	 */
	public function __construct() {
		$this->modals = apply_filters( 'penshop_mega_menu_modals', array(
			'menus',
			'title',
			'mega',
			'background',
			'icon',
			'content',
			'settings',
		) );

		add_filter( 'wp_edit_nav_menu_walker', array( $this, 'edit_walker' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'scripts' ) );
		add_action( 'admin_footer-nav-menus.php', array( $this, 'modal' ) );
		add_action( 'admin_footer-nav-menus.php', array( $this, 'templates' ) );
		add_action( 'wp_ajax_penshop_save_menu_item_data', array( $this, 'save_menu_item_data' ) );
	}

	/**
	 * Change walker class for editing nav menu
	 *
	 * @return string
	 */
	public function edit_walker() {
		return 'PenShop_Mega_Menu_Walker_Edit';
	}

	/**
	 * Load scripts on Menus page only
	 *
	 * @param string $hook
	 */
	public function scripts( $hook ) {
		if ( 'nav-menus.php' !== $hook ) {
			return;
		}

		wp_register_style( 'font-awesome', get_template_directory_uri() . '/assets/css/font-awesome.min.css', array(), '4.7.0' );
		wp_register_style( 'penshop-mega-menu-admin', get_template_directory_uri() . '/assets/css/admin/nav-menus.css', array(
			'media-views',
			'wp-color-picker',
			'font-awesome',
		) );
		wp_enqueue_style( 'penshop-mega-menu-admin' );

		wp_register_script( 'penshop-mega-menu-admin', get_template_directory_uri() . '/assets/js/admin/nav-menus.js', array(
			'jquery',
			'jquery-ui-resizable',
			'wp-util',
			'wp-color-picker',
		), null, true );
		wp_enqueue_media();
		wp_enqueue_script( 'penshop-mega-menu-admin' );

		wp_localize_script( 'penshop-mega-menu-admin', 'smmModals', $this->modals );
	}

	/**
	 * Prints HTML of modal on footer
	 */
	public function modal() {
		?>
		<div id="smm-settings" tabindex="0" class="smm-settings">
			<div class="smm-modal media-modal wp-core-ui">
				<button type="button" class="button-link media-modal-close smm-modal-close">
					<span class="media-modal-icon"><span class="screen-reader-text"><?php esc_html_e( 'Close', 'penshop' ) ?></span></span>
				</button>
				<div class="media-modal-content">
					<div class="smm-frame-menu media-frame-menu">
						<div class="smm-menu media-menu"></div>
					</div>
					<div class="smm-frame-title media-frame-title"></div>
					<div class="smm-frame-content media-frame-content">
						<div class="smm-content"></div>
					</div>
					<div class="smm-frame-toolbar media-frame-toolbar">
						<div class="smm-toolbar media-toolbar">
							<div class="smm-toolbar-primary media-toolbar-primary search-form">
								<button type="button" class="button smm-button smm-button-save media-button button-primary button-large"><?php esc_html_e( 'Save Changes', 'penshop' ) ?></button>
								<button type="button" class="button smm-button smm-button-cancel media-button button-secondary button-large"><?php esc_html_e( 'Cancel', 'penshop' ) ?></button>
								<span class="spinner"></span>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="media-modal-backdrop smm-modal-backdrop"></div>
		</div>
		<?php
	}

	/**
	 * Prints underscore template on footer
	 */
	public function templates() {
		foreach ( $this->modals as $template ) {
			$file = get_theme_file_path( 'inc/admin/menu-templates/' . $template . '.php' );
			$file = apply_filters( 'penshop_mega_menu_modal_template_file', $file, $template );

			if ( ! file_exists( $file ) ) {
				continue;
			}
			?>
			<script type="text/html" id="tmpl-penshop-<?php echo esc_attr( $template ) ?>">
				<?php include( $file ); ?>
			</script>
			<?php
		}
	}

	/**
	 * Ajax function to save menu item data
	 */
	public function save_menu_item_data() {
		$_POST['data'] = stripslashes_deep( $_POST['data'] );
		parse_str( $_POST['data'], $data );
		$updated = $data;

		// Save menu item data
		foreach ( $data['menu-item-mega'] as $id => $meta ) {
			$old_meta = get_post_meta( $id, '_menu_item_mega', true );
			$old_meta = penshop_parse_args( $old_meta, penshop_get_mega_menu_setting_default() );
			$meta     = penshop_parse_args( $meta, $old_meta );

			$updated['menu-item-mega'][ $id ] = $meta;

			update_post_meta( $id, '_menu_item_mega', $meta );
		}

		wp_send_json_success( $updated );
	}
}

/**
 * Get the default mega menu settings of a menu item
 *
 * @return array
 */
function penshop_get_mega_menu_setting_default() {
	return apply_filters(
		'penshop_mega_menu_setting_default',
		array(
			'mega'         => false,
			'icon'         => '',
			'hide_text'    => false,
			'disable_link' => false,
			'content'      => '',
			'width'        => '',
			'background'   => array(
				'image'      => '',
				'color'      => '',
				'attachment' => 'scroll',
				'size'       => '',
				'repeat'     => 'no-repeat',
				'position'   => array(
					'x'      => 'left',
					'y'      => 'top',
					'custom' => array(
						'x' => '',
						'y' => '',
					),
				),
			),
		)
	);
}

/**
 * Recursive merge user defined arguments into defaults array.
 *
 * @param array $args
 * @param array $default
 *
 * @return array
 */
function penshop_parse_args( $args, $default = array() ) {
	$args   = (array) $args;
	$result = $default;

	foreach ( $args as $key => $value ) {
		if ( is_array( $value ) && isset( $result[ $key ] ) ) {
			$result[ $key ] = penshop_parse_args( $value, $result[ $key ] );
		} else {
			$result[ $key ] = $value;
		}
	}

	return $result;
}