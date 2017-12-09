<?php
/**
 * Customize WooCommerce through actions and filters
 *
 * @package PenShop
 */

/**
 * Class PenShop_WooCommerce
 */
class PenShop_WooCommerce {
	/**
	 * The single instance of the class
	 */
	protected static $instance = null;

	/**
	 * Main instance
	 */
	public static function instance() {
		if ( null == self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Construction function
	 */
	public function __construct() {
		// Check if WooCommerce plugin is activated
		if ( ! in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
			return;
		}

		$this->hooks();
	}

	/**
	 * Hooks to WooCommerce actions, filters
	 *
	 * @since  1.0
	 * @return void
	 */
	public function hooks() {
		/*
		 * General hooks
		 */
		add_filter( 'woocommerce_add_to_cart_fragments', array( $this, 'add_to_cart_fragments' ) );
		add_filter( 'woocommerce_enqueue_styles', array( $this, 'wc_styles' ) );

		// Disable redirect to product page while having only one search result
		add_filter( 'woocommerce_redirect_single_search_result', '__return_false' );

		// Remove breadcrumb
		add_filter( 'woocommerce_breadcrumb_defaults', array( $this, 'breadcrumb_args' ) );
		remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );

		// Add badges
		remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash' );
		remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash' );
		add_action( 'woocommerce_before_shop_loop_item_title', array( $this, 'product_badges' ), 5 );
		add_action( 'woocommerce_before_single_product_summary', array( $this, 'product_badges' ), 5 );

		/*
		 * Hooks for single product page
		 */
		// Add breadcrumb into top of product summary
		add_action( 'woocommerce_single_product_summary', 'woocommerce_breadcrumb', 2 );
		add_action( 'woocommerce_after_add_to_cart_button', array( $this, 'add_wishlist_button' ) );

		// Show gallery carousel nav
		add_filter( 'woocommerce_single_product_carousel_options', array( $this, 'product_carousel_options' ) );

		// Product tabs
		add_filter( 'woocommerce_product_reviews_tab_title', array( $this, 'product_reviews_tab_title' ) );
		add_filter( 'woocommerce_review_gravatar_size', array( $this, 'product_review_gravatar_size' ) );
		remove_action( 'woocommerce_review_before_comment_meta', 'woocommerce_review_display_rating' );

		add_filter( 'woocommerce_output_related_products_args', array( $this, 'related_products_args' ) );
		add_filter( 'woocommerce_upsell_display_args', array( $this, 'related_products_args' ) );

		/*
		 * Hooks for catalog
		 */
		// Remove page title and result count
		add_filter( 'woocommerce_show_page_title', '__return_false' );
		remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
		remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

		// Shop toolbar
		add_action( 'woocommerce_before_shop_loop', array( $this, 'shop_toolbar' ) );

		// Add Bootstrap classes
		add_filter( 'post_class', array( $this, 'product_class' ), 50, 3 );
		add_filter( 'product_cat_class', array( $this, 'product_cat_class' ), 50 );

		// Change shop columns
		add_filter( 'loop_shop_columns', array( $this, 'shop_columns' ), 20 );
		add_filter( 'loop_shop_per_page', array( $this, 'products_per_page' ), 20 );

		// Change product link wrapper
		remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
		add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_link_close', 20 );

		// Wrap product thumbnail
		add_action( 'woocommerce_before_shop_loop_item', array( $this, 'loop_product_header_open' ), 1 );
		add_action( 'woocommerce_before_shop_loop_item_title', array( $this, 'loop_product_header_close' ), 40 );

		// Wrap product title, price, buttons
		add_action( 'woocommerce_before_shop_loop_item_title', array( $this, 'loop_product_summary_open' ), 50 );
		add_action( 'woocommerce_after_shop_loop_item', array( $this, 'loop_product_summary_close' ), 50 );

		// Adds hovered thumbnail to loop product
		add_action( 'woocommerce_before_shop_loop_item_title', array( $this, 'product_secondary_thumbnail' ) );

		// Add quick view button
		add_action( 'woocommerce_before_shop_loop_item_title', array( $this, 'loop_product_header_buttons' ), 30 );

		// Change the product title markup
		remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title' );
		add_action( 'woocommerce_shop_loop_item_title', array( $this, 'loop_product_title' ) );

		// Remove star rating
		if ( ! penshop_get_option( 'shop_star_rating' ) ) {
			remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
		}

		// Add short description
		add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_single_excerpt', 20 );

		// Add add-to-wishlist button
		add_action( 'woocommerce_after_shop_loop_item', array( $this, 'loop_wishlist_button' ) );

		// Shop pagination
		add_filter( 'woocommerce_pagination_args', array( $this, 'shop_pagination_args' ) );

		// Add "current" class to product tag cloud
		add_filter( 'wp_generate_tag_cloud_data', array( $this, 'tag_cloud_data' ) );

		add_filter( 'yith_wcwl_wishlist_title', '__return_null' );
	}

	/**
	 * Remove default woocommerce styles
	 *
	 * @param  array $styles
	 *
	 * @return array
	 */
	public function wc_styles( $styles ) {
		// unset( $styles['woocommerce-general'] );
		unset( $styles['woocommerce-layout'] );
		unset( $styles['woocommerce-smallscreen'] );

		return $styles;
	}

	/**
	 * Ajax update cart viewer
	 *
	 * @param array $fragments
	 *
	 * @return array
	 */
	public function add_to_cart_fragments( $fragments ) {
		$fragments['span.cart-counter'] = '<span class="cart-counter counter">' . WC()->cart->get_cart_contents_count() . '</span>';

		return $fragments;
	}

	/**
	 * Add wishlist button
	 */
	public function add_wishlist_button() {
		global $product;

		if ( ! shortcode_exists( 'yith_wcwl_add_to_wishlist' ) || $product->is_type( 'variable' ) || $product->is_type( 'external' ) ) {
			return;
		}

		echo do_shortcode( '[yith_wcwl_add_to_wishlist]' );
	}

	/**
	 * Allow to use direction nav for gallery carousel
	 *
	 * @param array $options
	 *
	 * @return array
	 */
	public function product_carousel_options( $options ) {
		$options['directionNav'] = true;

		return $options;
	}

	/**
	 * Swap the counter in reviews tab title with <span> tag
	 *
	 * @param string $title
	 *
	 * @return string
	 */
	public function product_reviews_tab_title( $title ) {
		$title = str_replace( array( '(', ')' ), array( '<span class="count">(', ')</span>' ), $title );

		return $title;
	}

	/**
	 * Change the avatar size
	 *
	 * @param int
	 *
	 * @return int
	 */
	public function product_review_gravatar_size( $size ) {
		$size = 90;

		return $size;
	}

	/**
	 * Change related/up-sells product args
	 *
	 * @param array $args
	 *
	 * @return array
	 */
	public function related_products_args( $args ) {
		if ( 'no-sidebar' != penshop_get_option( 'layout_product' ) ) {
			$args['posts_per_page'] = 3;
			$args['columns'] = 3;
		}

		return $args;
	}

	/**
	 * Display the shop toolbar before shop loop
	 */
	public function shop_toolbar() {
		if ( ! penshop_get_option( 'shop_toolbar' ) ) {
			return;
		}

		?>

		<div id="shop-toolbar" class="shop-toolbar products-toolbar">
			<div class="row">
				<div class="col-xs-12 col-sm-7 shop-quick-access">
					<?php
					if ( penshop_get_option( 'shop_quick_access' ) ) {
						$this->shop_quick_access();
					} else {
						woocommerce_result_count();
					}
					?>
				</div>

				<div class="col-xs-12 col-sm-5 shop-tools">
					<?php
					$links = array();
					if ( penshop_get_option( 'shop_toolbar_filter' ) ) {
						$links['filter'] = sprintf( '<li class="filter-toggle"><a href="#filter-panel" data-toggle="panel" data-target="#filter-panel">%s<i class="fa fa-angle-down"></i></a></li>', esc_html__( 'Filter', 'penshop' ) );
					}

					if ( penshop_get_option( 'shop_toolbar_search' ) ) {
						$links['search'] = sprintf( '<li class="search-toggle"><a href="#search-panel" data-toggle="panel" data-target="#search-panel">%s<i class="fa fa-search"></i></a></li>', esc_html__( 'Search', 'penshop' ) );
					}

					if ( penshop_get_option( 'shop_toolbar_sort' ) ) {
						ob_start();
						woocommerce_catalog_ordering();
						$links['ordering'] = '<li class="products-ordering">' . ob_get_clean() . '</li>';
					}

					if ( $links ) {
						echo '<ul>';
						echo implode( "\n\t", $links );
						echo '</ul>';
					}
					?>
				</div>
			</div>

			<?php if ( array_key_exists( 'filter', $links ) ) : ?>
				<div id="filter-panel" class="filter-panel penshop-panel panel clearfix">
					<?php if ( is_active_sidebar( 'filter-sidebar' ) ) : ?>
						<div class="widget-area filter-sidebar"><?php dynamic_sidebar( 'filter-sidebar' ) ?></div>
					<?php endif; ?>
				</div>
			<?php endif; ?>

			<?php if ( array_key_exists( 'search', $links ) ) : ?>
				<div id="search-panel" class="search-panel penshop-panel panel"><?php get_product_search_form() ?></div>
			<?php endif; ?>
		</div>

		<?php
	}

	/**
	 * Shop quick access links
	 */
	protected function shop_quick_access() {
		switch ( penshop_get_option( 'shop_quick_access_type' ) ) {
			case 'category':
				$cat_ids = array_filter( (array) penshop_get_option( 'shop_quick_access_cats' ) );

				if ( empty( $cat_ids ) ) {
					break;
				}

				$cats = get_terms( array(
					'taxonomy' => 'product_cat',
					'include' => $cat_ids
				) );

				if ( is_wp_error( $cats ) ) {
					break;
				}

				echo '<ul class="quick-access-links">';
				printf(
					'<li class="all %s"><a href="%s">%s</a></li>',
					is_shop() ? 'current' : '',
					wc_get_page_permalink( 'shop' ),
					esc_html__( 'All', 'penshop' )
				);
				foreach ( $cats as $cat ) {
					printf(
						'<li class="product_cat-%s product_cat-%s %s"><a href="%s">%s</a></li>',
						esc_attr( $cat->term_id ),
						esc_attr( $cat->slug ),
						is_product_category( $cat ) ? 'current' : '',
						get_term_link( $cat ),
						esc_html( $cat->name )
					);
				}
				echo '</ul>';
				break;

			case 'tag';
				$tags = trim( strtolower( penshop_get_option( 'shop_quick_access_tags' ) ) );
				$tags = array_filter( explode( ',', $tags ) );

				if ( empty( $tags ) ) {
					break;
				}

				echo '<ul class="quick-access-links">';
				printf(
					'<li class="all %s"><a href="%s">%s</a></li>',
					is_shop() ? 'current' : '',
					wc_get_page_permalink( 'shop' ),
					esc_html__( 'All', 'penshop' )
				);

				foreach ( $tags as $tag ) {
					$tag = trim( $tag );
					$tag = str_replace( array( ' ', '_' ), '-', strtolower( $tag ) );
					$tag = get_term_by( 'slug', $tag, 'product_tag' );

					if ( ! $tag || is_wp_error( $tag ) ) {
						continue;
					}

					printf(
						'<li class="product_tag-%s product_tag-%s %s"><a href="%s">%s</a></li>',
						esc_attr( $tag->term_id ),
						esc_attr( $tag->slug ),
						is_product_tag( $tag ) ? 'current' : '',
						get_term_link( $tag ),
						esc_html( $tag->name )
					);
				}
				break;
		}
	}

	/**
	 * Add Bootstrap's column classes for product
	 *
	 * @since 1.0
	 *
	 * @param array  $classes
	 * @param string $class
	 * @param string $post_id
	 *
	 * @return array
	 */
	public function product_class( $classes, $class = '', $post_id = '' ) {
		if ( is_admin() && ! defined( 'DOING_AJAX' ) ) {
			return $classes;
		}

		// Add classes for products in archive page only
		if ( ! $post_id || ! in_array( get_post_type( $post_id ), array( 'product', 'product_variation' ) ) || is_single( $post_id ) ) {
			return $classes;
		}

		global $woocommerce_loop, $product;

		$layout = penshop_get_layout();

		$classes[] = 'col-xs-6 col-sm-4';
		$classes[] = 'no-sidebar' == $layout ? 'col-md-3' : 'col-md-4';

		if ( $woocommerce_loop['columns'] == 5 ) {
			$classes[] = 'col-lg-1-5';
		} elseif ( isset( $woocommerce_loop['columns'] ) ) {
			$classes[] = 'col-lg-' . ( 12 / $woocommerce_loop['columns'] );
		}

		$gallery_image_ids = $product->get_gallery_image_ids();
		if ( ! empty( $gallery_image_ids ) ) {
			$classes[] = 'product-has-gallery';
		}

		return $classes;
	}

	/**
	 * Add class for product category item
	 *
	 * @param $classes
	 *
	 * @return array
	 */
	public function product_cat_class( $classes ) {
		global $woocommerce_loop;

		$layout = penshop_get_layout();

		$classes[] = 'col-xs-6 col-sm-4';
		$classes[] = 'no-sidebar' == $layout ? 'col-md-3' : 'col-md-4';

		if ( ! isset( $woocommerce_loop['columns'] ) ) {
			$classes[] = 'col-lg-1-5';

			return $classes;
		}

		if ( $woocommerce_loop['columns'] == 5 ) {
			$classes[] = 'col-lg-1-5';
		} else {
			$classes[] = 'col-lg-' . ( 12 / $woocommerce_loop['columns'] );
		}

		return $classes;
	}

	/**
	 * Change breadcrumb's separator
	 *
	 * @param array $args
	 *
	 * @return array
	 */
	public function breadcrumb_args( $args ) {
		$args['delimiter']   = '<i class="fa fa-angle-right" aria-hidden="true"></i>';
		$args['wrap_before'] = '<nav class="woocommerce-breadcrumb breadcrumb" ' . ( is_single() ? 'itemprop="breadcrumb"' : '' ) . '>';

		return $args;
	}

	/**
	 * Dispay product badge
	 */
	public function product_badges() {
		global $product;

		$output = array();

		if ( $product->is_on_sale() ) {
			$percentage = 0;

			if ( $product->get_type() == 'variable' ) {
				$available_variations = $product->get_available_variations();
				$max_percentage       = 0;

				for ( $i = 0; $i < count( $available_variations ); $i ++ ) {
					$variation_id        = $available_variations[ $i ]['variation_id'];
					$variable_product    = new WC_Product_Variation( $variation_id );
					$regular_price       = $variable_product->get_regular_price();
					$sales_price         = $variable_product->get_sale_price();
					$variable_percentage = $regular_price && $sales_price ? round( ( ( ( $regular_price - $sales_price ) / $regular_price ) * 100 ) ) : 0;

					if ( $variable_percentage > $max_percentage ) {
						$max_percentage = $variable_percentage;
					}
				}

				$percentage = $max_percentage ? $max_percentage : $percentage;
			} elseif ( $product->get_regular_price() != 0 ) {
				$percentage = round( ( ( $product->get_regular_price() - $product->get_sale_price() ) / $product->get_regular_price() ) * 100 );
			}

			if ( $percentage ) {
				$output[] = '<span class="onsale badge">-' . $percentage . '%' . '</span>';
			}
		}

		if ( $product->is_featured() ) {
			$output[] = '<span class="featured badge">' . esc_html__( 'Hot', 'penshop' ) . '</span>';
		}

		if ( get_post_meta( $product->get_id(), '_is_new', true ) ) {
			$output[] = '<span class="newness badge">' . esc_html__( 'New', 'penshop' ) . '</span>';
		}

		if ( ! $product->is_in_stock() && penshop_get_option( 'wc_sold_out_badge' ) ) {
			$output[] = '<span class="sold-out badge">' . esc_html__( 'Sold Out', 'penshop' ) . '</span>';
		}

		if ( $output ) {
			printf( '<span class="badges">%s</span>', implode( '', $output ) );
		}
	}

	/**
	 * Change the shop columns
	 *
	 * @since  1.0.0
	 *
	 * @param  int $columns The default columns
	 *
	 * @return int
	 */
	public function shop_columns( $columns ) {
		$columns = intval( penshop_get_option( 'shop_columns' ) );

		return $columns;
	}

	/**
	 * Change number of products per page
	 *
	 * @param int $limit
	 *
	 * @return int
	 */
	public function products_per_page( $limit ) {
		$limit = intval( penshop_get_option( 'shop_products_per_page' ) );

		return $limit;
	}

	/**
	 * Open product header wrapper
	 */
	public function loop_product_header_open() {
		echo '<div class="product-header">';
	}

	/**
	 * Close product header wrapper
	 */
	public function loop_product_header_close() {
		echo '</div>';
	}

	/**
	 * Open product summary wrapper
	 */
	public function loop_product_summary_open() {
		echo '<div class="product-summary">';
	}

	/**
	 * Close product summary wrapper
	 */
	public function loop_product_summary_close() {
		echo '</div>';
	}

	/**
	 * Adds secondary product thumbnail
	 * Get the first image from gallery
	 */
	public function product_secondary_thumbnail() {
		global $product;

		if ( ! penshop_get_option( 'shop_thumbnail_hover' ) ) {
			return;
		}

		$image_ids = method_exists( $product, 'get_gallery_image_ids' ) ? $product->get_gallery_image_ids() : $product->get_gallery_attachment_ids();

		if ( empty( $image_ids ) ) {
			return;
		}

		echo wp_get_attachment_image( $image_ids[0], 'shop_catalog', false, array( 'class' => 'attachment-shop_catalog size-shop_catalog product-hover-image' ) );
	}

	/**
	 * Display the quick view button
	 */
	public function loop_product_header_buttons() {
		global $woocommerce_loop;

		if ( ! isset( $woocommerce_loop['product_style'] ) ) {
			$woocommerce_loop['product_style'] = penshop_get_option( 'shop_product_style' );
		}

		echo '<div class="buttons">';

		if ( 'default' != $woocommerce_loop['product_style'] ) {
			woocommerce_template_loop_add_to_cart();
			$this->loop_wishlist_button();
		}

		if ( penshop_get_option( 'shop_quick_view_button' ) ) {
			printf(
				'<a href="%s" class="button button-full quick-view-button" data-toggle="modal" data-target="#modal-quick-view" data-tip="%s"><i class="fa fa-eye"></i>%s</a>',
				esc_url( get_permalink() ),
				esc_attr__( 'Quick View', 'penshop' ),
				esc_html__( 'Quick View', 'penshop' )
			);
		}

		echo '</div>';
	}

	/**
	 * Display product title with link
	 */
	public function loop_product_title() {
		printf(
			'<h2 class="woocommerce-loop-product__title"><a href="%s" rel="bookmark">%s</a></h2>',
			esc_url( get_permalink() ),
			get_the_title()
		);
	}

	/**
	 * Display add-to-wishlist button
	 */
	public function loop_wishlist_button() {
		if ( shortcode_exists( 'yith_wcwl_add_to_wishlist' ) ) {
			echo do_shortcode( '[yith_wcwl_add_to_wishlist]' );
		}
	}

	/**
	 * Change the pagination args.
	 * Edit next & previous text
	 *
	 * @param array $args
	 *
	 * @return array
	 */
	public function shop_pagination_args( $args ) {
		$args['prev_text'] = '<i class="fa fa-angle-left"></i>';
		$args['next_text'] = '<i class="fa fa-angle-right"></i>';

		if ( penshop_get_option( 'shop_nav_type' ) != 'links' ) {
			$args['prev_text'] = '';
			$args['next_text'] = '<span class="link-text">' . esc_html__( 'Load More Products', 'penshop' ) . '</span><span class="loading-bubbles"><span class="bounce1"></span><span class="bounce2"></span><span class="bounce3"></span></span>';
		}

		return $args;
	}

	/**
	 * Add class "current" to product tag
	 *
	 * @param array $tags_data
	 *
	 * @return array
	 */
	public function tag_cloud_data( $tags_data ) {
		if ( is_tax() ) {
			$term = get_queried_object();

			if ( $term->taxonomy != 'product_tag' ) {
				return $tags_data;
			}

			foreach ( $tags_data as $index => $tag_data ) {
				if ( $term->term_id == $tag_data['id'] ) {
					$tags_data[$index]['class'] .= ' current';
				}
			}
		}

		return $tags_data;
	}
}
