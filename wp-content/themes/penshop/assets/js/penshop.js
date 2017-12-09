;(function( $ ) {
	'use strict';

	var penshop = window.penshop || {};

	/**
	 * Init theme scripts
	 */
	penshop.init = function() {
		this.$window = $( window );
		this.$body = $( document.body );
		this.data = penShopData || {};

		this.toggleOffCanvas();
		this.toggleModal();
		this.togglePanel();
		this.instanceSearch();
		this.sideSubMenu();
		this.stickyHeader();
		this.stickySidebar();
		this.changeProductQuantity();
		this.productGallery();
		this.productQuickView();
		this.ajaxLoadProducts();
		this.ajaxLoadPortfolio();
		this.ajaxProductFilter();
		this.autoOpenCart();
		this.portfolioFilter();
		this.tooltip();
		this.prettyDropdown();
		this.goTop();
		this.wishlistCounter();
		this.addToWishlist();
		this.toggleLoginForms();
		this.popup();

		this.$body.trigger( 'penshop_initialized', [penshop] );
	};

	/**
	 * Toggle off canvas panels
	 */
	penshop.toggleOffCanvas = function() {
		var $backdrop = $( '.off-canvas-backdrop' );

		penshop.$body.on( 'click', '[data-toggle="off-canvas"]', function( event ) {
			event.preventDefault();

			var $el = $( event.currentTarget ),
				$target = $( $el.data( 'target' ) );

			$target.toggleClass( 'opened' );

			penshop.$body.toggleClass( 'canvas-opened' );

			$backdrop.fadeToggle();
		} );

		penshop.$body.on( 'click', '.off-canvas-backdrop, .off-canvas .close-btn', function( event ) {
			event.preventDefault();

			$( '.off-canvas' ).removeClass( 'opened' );
			penshop.$body.removeClass( 'canvas-opened' ).trigger( 'penshop_canvas_off' );
			$backdrop.fadeOut();
		} );
	};

	/**
	 * Toggle modals
	 */
	penshop.toggleModal = function() {
		penshop.$body.on( 'click', '[data-toggle="modal"]', function( event ) {
			event.preventDefault();

			var $el = $( event.currentTarget ),
				$target = $( $el.data( 'target' ) );

			$target.fadeToggle( function() {
				$target.toggleClass( 'opened' );
			} );

			penshop.$body.toggleClass( 'modal-opened' );
		} );

		penshop.$body.on( 'click', '.modal .close-btn, .modal .close-trigger', function( event ) {
			event.preventDefault();

			$( event.currentTarget ).closest( '.modal' ).removeClass( 'opened' ).fadeOut();
			penshop.$body.removeClass( 'modal-opened' ).trigger( 'penshop_modal_close' );
		} );
	};

	/**
	 * Toggle panels
	 */
	penshop.togglePanel = function() {
		penshop.$body.on( 'click', '[data-toggle="panel"]', function( event ) {
			event.preventDefault();

			var $el = $( event.currentTarget ),
				target = $el.data( 'target' ) ? $el.data( 'target' ) : $el.attr( 'href' ),
				$target = $( target );

			if ( !$target.length ) {
				return;
			}

			$el.parents( 'ul' ).find( '.active[data-toggle="panel"]' ).not( $el ).removeClass( 'active' );

			$target.siblings( '.panel' ).stop( true, true ).slideUp( 'normal', function() {
				$( this ).removeClass( 'active' );

				$target.slideToggle( 'normal', function() {
					$target.toggleClass( 'active' );
					$el.toggleClass( 'active' );
				} );
			} );
		} );
	};

	/**
	 * Autocomplete for search modal
	 */
	penshop.instanceSearch = function() {
		if ( $().autocomplete ) {
			/*
			 * Search field inside modal
			 */
			var cache = {},
				$modal = $( '#modal-search' ),
				$type = $modal.find( '.type-field' );

			$( '.search-field', $modal ).autocomplete( {
				minLength: 2,
				source   : function( request, response ) {
					var term = request.term,
						type = $type.length ? $type.val() : '',
						key = term + '|' + type;

					if ( key in cache ) {
						response( cache[key] );
						return;
					}

					$.post(
						penshop.data.ajax_url,
						{
							action: 'penshop_search',
							term  : term,
							type  : type
						},
						function( data ) {
							cache[key] = data.data;
							response( data.data );
						}
					);
				},
				select   : function( event, ui ) {
					event.preventDefault();
					if ( ui.item.value !== '#' ) {
						location.href = ui.item.value;
					}
				},
				search   : function( event ) {
					$( event.target ).closest( 'form' ).addClass( 'ajax-loading' );
				},
				response : function( event ) {
					$( event.target ).closest( 'form' ).removeClass( 'ajax-loading' );
				},
				create   : function() {
					$( this ).data( 'ui-autocomplete' )._renderItem = function( ul, item ) {
						return $( '<li class="woocommerce"></li>' )
							.append( '<a href="' + item.url + '">' + item.thumb + '<span class="title">' + item.value + '</span><span class="price">' + item.price + '</span></a>' )
							.appendTo( ul );
					};
				}
			} );

			/*
			 * Search field on header v1
			 */
			var productSearchCache = {},
				$form = $( '.product-search-form' ),
				$cat = $( 'select[name=product_cat]', $form );

			$( '.search-field.search-text', $form ).autocomplete( {
				minLength: 2,
				source   : function( request, response ) {
					var term = request.term,
						cat = $cat.length ? $cat.val() : '',
						key = term + '|' + cat;

					if ( key in productSearchCache ) {
						response( productSearchCache[key] );
						return;
					}

					$.post(
						penshop.data.ajax_url,
						{
							action: 'penshop_search',
							term  : term,
							type  : 'product',
							cat   : cat
						},
						function( data ) {
							productSearchCache[key] = data.data;
							response( data.data );
						}
					);
				},
				select   : function( event, ui ) {
					event.preventDefault();

					if ( ui.item.url !== '#' ) {
						location.href = ui.item.url;
					}
				},
				search   : function( event ) {
					$( event.target ).closest( 'form' ).addClass( 'ajax-loading' );
				},
				response : function( event ) {
					$( event.target ).closest( 'form' ).removeClass( 'ajax-loading' );
				},
				create   : function() {
					$( this ).data( 'ui-autocomplete' )._renderItem = function( ul, item ) {
						return $( '<li class="woocommerce"></li>' )
							.append( '<a href="' + item.url + '">' + item.thumb + '<span class="title">' + item.value + '</span><span class="price">' + item.price + '</span></a>' )
							.appendTo( ul );
					};
				}
			} );
		}

		/*
		 * Shop toolbar product search
		 */
		var xhr = null,
			searchCache = {},
			$grid = $( '#primary ul.products' ),
			$nav = $grid.next( '.woocommerce-pagination' );

		$( '.search-field', '#search-panel' ).on( 'keyup', function( e ) {
			var valid = false,
				$input = $( this ),
				$form = $( this ).closest( 'form' ),
				keyword = $input.val();

			if ( typeof e.which === 'undefined' ) {
				valid = true;
			} else if ( typeof e.which === 'number' && e.which > 0 ) {
				valid = !e.ctrlKey && !e.metaKey && !e.altKey;
			}

			if ( !valid ) {
				return;
			}

			if ( xhr ) {
				xhr.abort();
			}

			var url = $form.attr( 'action' ) + '?' + $form.serialize();

			$grid.append( '<li class="products-ajax-loading"><i class="fa fa-circle-o-notch fa-spin fa-fw"></i></li>' );

			if ( keyword in searchCache ) {
				var result = searchCache[keyword];

				updateSearchResult( result );
			} else {
				xhr = $.get( url, function( response ) {
					var $html = $( response ),
						$_grid = $( '#primary ul.products', $html ),
						$_info = $( '#primary .woocommerce-info', $html ),
						result = null;

					if ( $_grid.length ) {
						result = {
							found   : true,
							url     : url,
							products: $_grid.children(),
							nav     : $_grid.next( '.woocommerce-pagination' )
						};
					} else {
						result = {
							found: false,
							url  : url,
							info : $( '#primary .woocommerce-info', $html )
						};
					}

					searchCache[keyword] = result;
					updateSearchResult( result );
				}, 'html' );
			}
		} );

		var updateSearchResult = function( result ) {
			if ( result.found ) {
				var $_products = result.products,
					$_pagination = result.nav;

				$_products.css( 'opacity', 0 );
				$grid.html( $_products );

				setTimeout( function() {
					$_products.css( 'opacity', 1 );
				}, 100 );

				if ( $_pagination.length ) {
					$nav.html( $_pagination.html() );
				} else {
					$nav.html( '' );
				}
			} else {
				var $_info = result.info,
					$li = $( '<li class="col-sm-12" />' ).append( $_info );

				$grid.html( $li );
				$nav.html( '' );
			}

			window.history.pushState( null, '', result.url );
		};
	};

	/**
	 * Toggle side sub menu
	 */
	penshop.sideSubMenu = function() {
		$( '.side-menu > .menu-item-has-children' ).each( function() {
			var $item = $( this );

			if ( $item.hasClass( 'current-menu-item' ) || $item.hasClass( 'current-menu-ancestor' ) ) {
				$item.addClass( 'open' );
			}

			$item.children( 'a' ).append( '<i class="fa fa-angle-right toggle-sub" />' );
		} );

		this.$body.on( 'click', '.side-menu .toggle-sub', function( event ) {
			event.preventDefault();

			var $item = $( this ).closest( 'li' );

			if ( $item.hasClass( 'open' ) ) {
				$item.children( 'ul' ).slideUp( function() {
					$item.removeClass( 'open' );
				} );
			} else {
				$item.children( 'ul' ).slideDown();
				$item.addClass( 'open' );
			}
		} );
	};

	/**
	 * Sticky header
	 */
	penshop.stickyHeader = function() {
		if ( !penshop.data.sticky_header || 'none' === penshop.data.sticky_header ) {
			return;
		}

		var $header = $( '#masthead' ),
			$sticker = $( '.header-main', $header ),
			$topbar = $( '#topbar' ),
			$adminbar = $( '#wpadminbar' ),
			offset = 1;

		if ( $topbar.length ) {
			offset += $topbar.outerHeight();
		}

		if ( $adminbar.length ) {
			offset += $adminbar.outerHeight();
		}

		if ( penshop.$body.hasClass( 'header-layout-v1' ) ) {
			offset += $( '.header-main', $sticker ).outerHeight();
			$sticker = $( '#site-navigation' );
		}

		offset += $sticker.outerHeight();

		if ( 'smart' === penshop.data.sticky_header ) {
			var $stickyHolder = $( '<div class="sticky-holder" />' ).height( $sticker.outerHeight() );

			$sticker.after( $stickyHolder );

			var stickyHeader = new Headroom( $sticker.get( 0 ), {
				offset  : offset,
				onTop   : function() {
					$sticker.removeClass( 'headroom--animation' );
					$header.removeClass( 'is-sticky' );
					$stickyHolder.hide();
				},
				onNotTop: function() {
					setTimeout( function() {
						$sticker.addClass( 'headroom--animation' );
					}, 10 );
					$header.addClass( 'is-sticky' );
					$stickyHolder.show();
				}
			} );

			stickyHeader.init();
		} else {
			$sticker.sticky( {
				topSpacing: $adminbar.length ? $adminbar.outerHeight() : 0,
				zIndex    : 999
			} );
		}
	};

	/**
	 * Sticky sidebar
	 */
	penshop.stickySidebar = function() {
		if ( !penshop.data.sticky_sidebar ) {
			return;
		}

		if ( penshop.$body.hasClass( 'no-sidebar' ) ) {
			return;
		}

		$( '.content-area, .primary-sidebar' ).theiaStickySidebar();
	};

	/**
	 * Change quantity number
	 */
	penshop.changeProductQuantity = function() {
		penshop.$body.on( 'click', '.quantity button', function( event ) {
			event.preventDefault();

			var $button = $( this ),
				$qty = $button.siblings( '.qty' ),
				current = parseInt( $qty.val(), 10 ),
				min = parseInt( $qty.attr( 'min' ), 10 ),
				max = parseInt( $qty.attr( 'max' ), 10 );

			min = min ? min : 1;
			max = max ? max : current + 1;

			if ( $button.hasClass( 'decrease' ) && current > min ) {
				$qty.val( current - 1 );
				$qty.trigger( 'change' );
			}

			if ( $button.hasClass( 'increase' ) && current < max ) {
				$qty.val( current + 1 );
				$qty.trigger( 'change' );
			}
		} );
	};

	/**
	 * Modify the default product images gallery
	 */
	penshop.productGallery = function() {
		$( '.woocommerce-product-gallery' ).on( 'click', '.woocommerce-product-gallery__image .zoomImg', function() {
			$( this ).prev( 'a' ).trigger( 'click' );
		} );

		setTimeout( function() {
			var height = $( '.woocommerce-product-gallery .flex-viewport' ).height() - 50;
			$( '.woocommerce-product-gallery__trigger' ).css( 'top', height );
		}, 100 );
	};

	/**
	 * Display quick view modal
	 */
	penshop.productQuickView = function() {
		penshop.$body.on( 'click', '.quick-view-button', function( event ) {
			if ( penshop.$window.width() <= 768 ) {
				return;
			}

			event.preventDefault();

			var url = $( this ).attr( 'href' ),
				$modal = $( '#modal-quick-view' ),
				$container = $( '.container', $modal ),
				$button = $modal.children( '.close-btn' ).clone();

			$container.html( '' );
			$modal.removeClass( 'loaded' );

			// Start ajax
			$.get( url, function( response ) {
				var $html = $( response ),
					$_product = $( 'div.product', $html ),
					$gallery = $( '.woocommerce-product-gallery', $_product ),
					$variations = $( '.variations_form', $_product );

				$_product.find( '.breadcrumb, .woocommerce-tabs, .related, .upsells' ).remove();
				$_product.find( 'h1.product_title' ).wrapInner( '<a href="' + url + '"></a>' );
				$_product.prepend( $button );

				$container.append( $_product );

				if ( $.fn.wc_product_gallery ) {
					$gallery.wc_product_gallery( {
						flexslider_enabled: true,
						zoom_enabled      : true,
						photoswipe_enabled: false
					} );
				}

				$( '.social-share a', $_product ).penTip();

				$gallery.on( 'click', 'a', function( e ) {
					e.preventDefault();
				} );

				$variations.wc_variation_form().find( '.variations select:eq(0)' ).change();

				// Show up
				$modal.addClass( 'loaded' );

				penshop.$body.trigger( 'penshop_quick_view_opened', [$modal, $html, penshop] );

				console.log($modal);
			} );
		} );
	};

	/**
	 * Use ajax to load more products
	 */
	penshop.ajaxLoadProducts = function() {
		if ( 'ajax' === penshop.data.shop_nav_type || 'infinite' === penshop.data.shop_nav_type ) {
			penshop.$body.on( 'click', '.woocommerce-pagination .next', function( e ) {
				e.preventDefault();

				var $button = $( this ),
					$nav = $button.closest( '.woocommerce-pagination' ),
					$products = $nav.prev( 'ul.products' ),
					url = $button.attr( 'href' );

				if ( $button.hasClass( 'loading' ) ) {
					return;
				}

				$button.addClass( 'loading' );

				loadProducts( url, $products, function( response ) {
					var $pagination = $( response ).find( '.woocommerce-pagination' );

					if ( $pagination.length ) {
						$nav.html( $pagination.html() );
					} else {
						$nav.html( '' );
					}
				} );
			} );
		}

		// Infinite Shop
		if ( 'infinite' === penshop.data.shop_nav_type ) {
			var $nav = $( '.woocommerce-pagination' ),
				$button = $nav.find( '.next' ),
				$products = $( 'ul.products' );

			if ( $button.length ) {
				// Use this variable to control scroll event handle for better performance
				var waiting = false,
					endScrollHandle;

				penshop.$window.on( 'scroll', function() {
					if ( waiting ) {
						return;
					}

					waiting = true;

					// clear previous scheduled endScrollHandle
					clearTimeout( endScrollHandle );

					infiniteScoll();

					setTimeout( function() {
						waiting = false;
					}, 100 );

					// schedule an extra execution of infiniteScoll() after 200ms
					// in case the scrolling stops in next 100ms
					endScrollHandle = setTimeout( function() {
						infiniteScoll();
					}, 200 );
				} );
			}

			var infiniteScoll = function() {
				// When almost reach to nav and new next button is exists
				if ( penshop.isVisible( $nav ) && $button.length ) {
					if ( $button.hasClass( 'loading' ) ) {
						return;
					}

					$button.addClass( 'loading' );

					loadProducts( $button.attr( 'href' ), $products, function( response ) {
						var $pagination = $( response ).find( '.woocommerce-pagination' );

						if ( $pagination.length ) {
							$nav.html( $pagination.html() );

							// Re-select because DOM has been changed
							$button = $nav.find( '.next' );
						} else {
							$nav.html( '' );
							$button.length = 0;
						}
					} );
				}
			}
		}

		/**
		 * Private function for ajax loading products
		 *
		 * @param url
		 * @param $holder
		 * @param callback
		 */
		function loadProducts( url, $holder, callback ) {
			$.get(
				url,
				function( response ) {
					var $_products = $( response ).find( '#primary ul.products li.product' );

					$_products.each( function( index, product ) {
						$( product ).css( 'animation-delay', (0.15 * index) + 's' );
					} );

					$_products.addClass( 'penci-fadeInUp animated' );
					$holder.append( $_products );

					if ( $holder.hasClass( 'product-style-hidden_buttons' ) ) {
						$( '.buttons a', $_products ).penTip();
					}


					if ( 'function' === typeof callback ) {
						setTimeout( callback( response ), 500 );
					}

					window.history.pushState( null, '', url );
				}
			);
		}
	};

	/**
	 * Ajax load portfolio
	 */
	penshop.ajaxLoadPortfolio = function() {
		if ( ! penshop.$body.hasClass( 'post-type-archive-portfolio' ) && ! penshop.$body.hasClass( 'tax-portfolio_type' ) ) {
			return;
		}

		var $portfolios = $( '.portfolio-items' ),
			$navigation =  $portfolios.next( '.navigation' );

		penshop.$body.on( 'click', '.posts-navigation .nav-previous a', function( event ) {
			event.preventDefault();

			var $link = $( this ),
				url = $link.attr( 'href' );

			$link.addClass( 'loading' );

			$.get( url, function( response ) {
				var $content = $( response ).find( '#primary' ),
					$items = $( '.portfolio-items .portfolio', $content ),
					$nav = $( '.navigation', $content );

				$portfolios.append( $items ).isotope( 'appended', $items );
				$items.imagesLoaded().progress( function () {
					$portfolios.isotope( 'layout' );
				} );

				if ( $nav.length ) {
					$navigation.replaceWith( $nav );
				} else {
					$navigation.fadeOut();
				}

				window.history.pushState( null, '', url );
			} );
		} );
	};

	/**
	 * Check if an element is in view-port
	 *
	 * @param el
	 * @returns {boolean}
	 */
	penshop.isVisible = function( el ) {
		if ( el instanceof jQuery ) {
			el = el[0];
		}

		var rect = el.getBoundingClientRect();

		return rect.bottom > 0 &&
			rect.right > 0 &&
			rect.left < ( window.innerWidth || document.documentElement.clientWidth ) &&
			rect.top < ( window.innerHeight || document.documentElement.clientHeight );
	};

	/**
	 * Filtering products
	 */
	penshop.ajaxProductFilter = function() {
		var $toolbar = $( '#shop-toolbar' ),
			$panel = $( '#filter-panel', $toolbar );

		$toolbar.on(
			'click',
			'.widget-products-order a, .widget-price-ranges a, .widget_layered_nav a, .widget_product_categories a, .widget_product_tag_cloud a',
			function( event ) {
				event.preventDefault();

				var $link = $( this ),
					url = $link.attr( 'href' ),
					$grid = $toolbar.next( 'ul.products' ),
					$nav = $grid.next( '.woocommerce-pagination' );

				$grid.append( '<li class="products-ajax-loading"><span class="fa-spin loading-icon"></span></li>' );

				$.get( url, function( response ) {
					var $page = $( response ),
						$_grid = $( '#primary ul.products', $page ),
						$filter = $( '#filter-panel', $page );

					if ( $_grid.length ) {
						var $products = $_grid.children(),
							$pagination = $_grid.next( '.woocommerce-pagination' );

						$products.css( 'opacity', 0 );
						$grid.html( $products );

						setTimeout( function() {
							$products.css( 'opacity', 1 );
						}, 100 );

						if ( $pagination.length ) {
							$nav.html( $pagination.html() );
						} else {
							$nav.html( '' );
						}
					} else {
						var $info = $( '#primary .woocommerce-info', $page ),
							$li = $( '<li class="col-sm-12" />' ).append( $info );

						$grid.html( $li );
						$nav.html( '' );
					}

					$panel.html( $filter.html() );
					window.history.pushState( null, '', url );
				} );
			}
		);
	};

	/*
	 * Automatically open the cart panel after successful addition
	 */
	penshop.autoOpenCart = function() {
		if ( !penshop.data.auto_open_cart ) {
			return;
		}

		penshop.$body.on( 'added_to_cart', function() {
			// Close modal
			$( '.modal.opened' ).fadeOut( function() {
				$( this ).removeClass( 'opened' );
			} );
			penshop.$body.removeClass( 'modal-opened' );

			// Close other panels
			$( '.off-canvas.opened' ).removeClass( 'opened' );

			// Open cart
			$( '#off-canvas-cart' ).addClass( 'opened' );
			penshop.$body.addClass( 'canvas-opened' );
			$( '.off-canvas-backdrop' ).fadeIn();
		} );
	};

	/**
	 * Initialize isotope for portfolio items
	 */
	penshop.portfolioFilter = function() {
		var $items = $( '.portfolio-items' );

		if ( !$items.length ) {
			return;
		}

		var options = {
			itemSelector      : '.portfolio',
			transitionDuration: '0.7s',
			isOriginLeft      : !(penshop.data.isRTL === '1')
		};

		if ( $items.hasClass( 'layout-fullwidth' ) ) {
			options.percentPosition = true;
			options.masonry = {
				columnWidth: '.portfolio-normal'
			};
		} else if ( $items.hasClass( 'layout-classic' ) ) {
			options.layoutMode = 'fitRows';
		}

		$items.imagesLoaded( function() {
			$( this.elements ).isotope( options );
		} );

		var $filter = $( '.portfolio-filter' );

		$filter.on( 'click', 'li', function( e ) {
			e.preventDefault();

			var $this = $( this ),
				selector = $this.attr( 'data-filter' );

			if ( $this.hasClass( 'active' ) ) {
				return;
			}

			$this.addClass( 'active' ).siblings( '.active' ).removeClass( 'active' );
			$this.closest( '.portfolio-filter' ).next( '.portfolio-items' ).isotope( {
				filter: selector
			} );
		} )
	};

	/**
	 * Init tooltip
	 */
	penshop.tooltip = function() {
		$( 'ul.product-style-hidden_buttons .buttons a, .social-share a' ).penTip();
	};

	/**
	 * Use list for select dropdown
	 */
	penshop.prettyDropdown = function() {
		$( '.search-by-cat select' ).select2( {
			minimumResultsForSearch: -1,
			dropdownCssClass       : 'product-cat-search'
		} );
	};

	/**
	 * Handle the button gotop events and visibility
	 */
	penshop.goTop = function() {
		var $button = $( '.gotop' ),
			offset = penshop.$window.height();

		if ( !$button.length ) {
			return;
		}

		penshop.$window.on( 'scroll load', function() {
			if ( penshop.$window.scrollTop() > offset ) {
				$button.addClass( 'active' );
			} else {
				$button.removeClass( 'active' );
			}
		} );

		$button.on( 'click', function( event ) {
			event.preventDefault();

			$( 'html, body' ).animate( {
				scrollTop: 0
			}, 1000 );
		} );
	};

	/**
	 * Update wishlist counter value
	 */
	penshop.wishlistCounter = function() {
		var $counter = $( '.wishlist-counter' );

		if ( !$counter.length ) {
			return;
		}

		penshop.$body.on( 'added_to_wishlist', function() {
			$counter.text( parseInt( $counter.text() ) + 1 );
		} ).on( 'removed_from_wishlist', function() {
			$counter.text( parseInt( $counter.text() ) - 1 );
		} );
	};

	/**
	 * Add "loading" class to add-to-wishlist button
	 */
	penshop.addToWishlist = function() {
		penshop.$body.on( 'click', '.add_to_wishlist', function( event ) {
			event.preventDefault();

			$( this ).addClass( 'loading' );
		} );
	};

	/**
	 * Toggle login/register form of the login modal
	 */
	penshop.toggleLoginForms = function() {
		penshop.$body.on( 'click', '#modal-login .toggle-register-form', function( event ) {
			event.preventDefault();

			$( this ).closest( '.col2-set' ).addClass( 'register' );
		} ).on( 'click', '#modal-login .toggle-login-form', function( event ) {
			event.preventDefault();

			$( this ).closest( '.col2-set' ).removeClass( 'register' );
		} );

		$( '#modal-login' ).on( 'click', '.modal-backdrop', function() {
			$( this ).next( '.woocommerce' ).find( '.col2-set' ).removeClass( 'register' );
		} );
	};

	/**
	 * Open popup
	 */
	penshop.popup = function() {
		var days = parseInt( penshop.data.popup_frequency ),
			delay = parseInt( penshop.data.popup_delay ),
			$popup = $( '#popup' );

		if ( !$popup.length ) {
			return;
		}

		if ( days > 0 && document.cookie.match( /^(.*;)?\s*penshop_popup\s*=\s*[^;]+(.*)?$/ ) ) {
			return;
		}

		delay = Math.max( delay, 0 );
		delay = 'delay' === penshop.data.popup_visible ? delay : 0;

		penshop.$window.on( 'load', function() {
			setTimeout( function() {
				$popup.fadeToggle( function() {
					$popup.toggleClass( 'opened' );
				} );

				penshop.$body.toggleClass( 'modal-opened' );
			}, delay * 1000 );
		} );

		$popup.on( 'click', '.close-trigger', function() {
			var date = new Date(),
				value = date.getTime();

			date.setTime( date.getTime() + (days * 24 * 60 * 60 * 1000) );

			document.cookie = 'penshop_popup=' + value + ';expires=' + date.toGMTString() + ';path=/';
		} );
	};

	/**
	 * Document ready
	 */
	$( function() {
		penshop.init();
	} );
})( jQuery );
