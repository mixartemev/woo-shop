/* global penshop_addons_params */
jQuery( document ).ready( function( $ ) {
	'use strict';

	var $window = $( window ),
		params = penshop_addons_params || {};

	/**
	 * Ajax load more products
	 */
	$( document.body ).on( 'click', '.ajax-load-products', function( event ) {
		event.preventDefault();

		var $el = $( this ),
			atts = $el.data( 'atts' );

		if ( $el.hasClass( 'loading' ) ) {
			return;
		}

		$el.removeClass( 'failed' ).addClass( 'loading' );

		$.post( params.ajax_url, {
			action: 'penshop_load_products',
			nonce : params.shop_nonce,
			atts  : atts
		}, function( response ) {
			if ( !response.success ) {
				console.log( response.data );
				$el.removeClass( 'loading' ).addClass( 'failed' );
				return;
			}

			var $data = $( response.data ),
				$products = $( 'ul.products > li', $data ),
				$button = $( '.ajax-load-products', $data ),
				$grid = $el.closest( '.penshop-products' ).find( 'ul.products' );

			// Add classes before append products to grid
			$products.addClass( 'product' );

			// If has products
			if ( $products.length ) {
				$products.each( function( index, product ) {
					$( product ).css( 'animation-delay', (0.15 * index) + 's' );
				} );

				$products.addClass( 'penci-fadeInUp animated' );

				$grid.append( $products );

				if ( $grid.hasClass( 'product-style-hidden_buttons' ) && $.fn.penTip ) {
					$( '.buttons a', $products ).penTip();
				}

				if ( $button.length ) {
					$el.replaceWith( $button );
				} else {
					$el.slideUp();
				}
			}
		} );
	} );

	/**
	 * FAQ
	 */
	$( '.penshop-faq' ).on( 'click', '.faq', function( e ) {
		e.preventDefault();

		var $faq = $( this ).closest( '.penshop-faq' );

		if ( $faq.hasClass( 'open' ) ) {
			$faq.find( '.faq-content' ).stop( true, true ).slideUp( function() {
				$faq.removeClass( 'open' );
			} );
		} else {
			$faq.find( '.faq-content' ).stop( true, true ).slideDown( function() {
				$faq.addClass( 'open' );
			} );
		}
	} );

	$window.on( 'resize', function() {
		var $container = $( '.container' ).width(),
			$w = $window.width();
		$( '.penshop-contact-form' ).css( {'padding-right': ($w - $container) / 2} )
	} ).trigger( 'resize' );

	/**
	 *  Countdown
	 */
	$( '.penshop-countdown' ).each( function() {
		var $el = $( this ),
			$timers = $el.find( '.timers' ),
			output = '';

		$timers.countdown( $timers.data( 'date' ), function( event ) {
			output = '';
			var day = event.strftime( '%D' );
			for ( var i = 0; i < day.length; i++ ) {
				output += '<span>' + day[i] + '</span>';
			}
			$timers.find( '.day' ).html( output );

			output = '';
			var hour = event.strftime( '%H' );
			for ( i = 0; i < hour.length; i++ ) {
				output += '<span>' + hour[i] + '</span>';
			}
			$timers.find( '.hour' ).html( output );

			output = '';
			var minu = event.strftime( '%M' );
			for ( i = 0; i < minu.length; i++ ) {
				output += '<span>' + minu[i] + '</span>';
			}
			$( this ).find( '.min' ).html( output );

			output = '';
			var secs = event.strftime( '%S' );
			for ( i = 0; i < secs.length; i++ ) {
				output += '<span>' + secs[i] + '</span>';
			}
			$timers.find( '.secs' ).html( output );
		} );
	} );

	/**
	 * Product carousel
	 */
	$( '.penshop-product-carousel' ).each( function() {
		var $carousel = $( this ),
			columns = parseInt( $carousel.data( 'columns' ), 10 ),
			autoplay = parseInt( $carousel.data( 'autoplay' ), 10 );

		autoplay = autoplay === 0 ? false : autoplay;

		$carousel.find( 'ul.products' ).addClass( 'owl-carousel' ).owlCarousel( {
			items          : columns,
			loop           : !!autoplay,
			autoplay       : !!autoplay,
			autoplayTimeout: autoplay,
			dots           : false,
			nav            : true,
			slideSpeed     : 300,
			dotsSpeed      : 500,
			navText        : ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
			responsive     : {
				0  : {
					items: 1
				},
				360: {
					items: 2
				},
				768: {
					items: 3
				},
				992: {
					items: columns
				}
			}
		} );
	} );

	/**
	 * Sliders carousel
	 */
	$( '.penshop-carousel' ).each( function() {
		var $carousel = $( this );
		var options = $.extend( {
			items          : 3,
			loop           : true,
			autoplay       : true,
			autoplayTimeout: 5000,
			autoplaySpeed  : 800,
			autoWidth      : true,
			margin         : 3,
			dots           : false,
			nav            : true,
			slideSpeed     : 800,
			dotsSpeed      : 800,
			speed          : 800,
			navSpeed       : 800,
			navText        : ['<i class="fa fa-angle-left" aria-hidden="true"></i>', '<i class="fa fa-angle-right" aria-hidden="true"></i>'],
			responsive     : {
				0  : {
					items    : 1,
					autoWidth: false,
					dots     : true,
					nav      : false
				},
				768: {
					items: 2
				},
				992: {
					items: 3
				}
			}
		}, $carousel.data( 'carousel_options' ) );

		if ( $carousel.data( 'full_height' ) ) {
			$( window ).on( 'resize', function() {
				$carousel.height( getFullHeight( $carousel ) );
			} );

			$carousel.height( getFullHeight( $carousel ) );
		}

		$carousel.addClass( 'owl-carousel' );

		$carousel.imagesLoaded( function() {
			$carousel.owlCarousel( options );
		} );
	} );

	/**
	 * Tabs
	 */
	$( '.penshop-tabs' ).on( 'click', '.tabs li', function() {
		var $tab = $( this ),
			index = $tab.data( 'target' ),
			$panels = $tab.closest( '.penshop-tabs' ).find( '.panels' ),
			$panel = $panels.find( '.panel[data-panel="' + index + '"]' );

		if ( $tab.hasClass( 'active' ) ) {
			return;
		}

		$tab.addClass( 'active' ).siblings( 'li.active' ).removeClass( 'active' );

		if ( $panel.length ) {
			$panel.addClass( 'active' ).siblings( '.panel.active' ).removeClass( 'active' );
		}
	} ).find( '.tabs li:first' ).trigger( 'click' );

	/**
	 * Product tabs
	 *
	 * Uses tab switching of .penshop-tabs.
	 * In this part, we only handle ajax request to load products dynamically
	 */
	$( '.penshop-product-tabs' ).on( 'click', '.tabs li', function() {
		var $tab = $( this ),
			atts = $tab.data( 'atts' ),
			index = $tab.data( 'target' ),
			$panels = $tab.parent().next( '.panels' ),
			$panel = $panels.find( '.panel[data-panel="' + index + '"]' );

		if ( $panel.length ) {
			return;
		}

		if ( !atts ) {
			return;
		}

		$panels.addClass( 'loading' );

		$.post( params.ajax_url, {
			action: 'penshop_load_products',
			nonce : params.shop_nonce,
			atts  : atts
		}, function( response ) {
			if ( !response.success ) {
				console.log( response.data );
				$panels.removeClass( 'loading' );
				return;
			}

			var $newPanel = $panels.children( '.panel' ).first().clone();

			$newPanel.html( response.data );
			$newPanel.attr( 'data-panel', index );
			$newPanel.addClass( 'active' );
			$newPanel.appendTo( $panels );
			$newPanel.siblings( '.panel.active' ).removeClass( 'active' );

			setTimeout( function() {
				$panels.removeClass( 'loading' );
			}, 700 );
		} );
	} );

	/**
	 * Video popup
	 */
	$( '.play-video' ).lightcase( {
		showTitle: false
	} );

	/**
	 * Google Map
	 */
	$( '.penshop-map' ).each( function() {
		var $map = $( this ),
			latitude = $map.data( 'lat' ),
			longitude = $map.data( 'lng' ),
			zoom = $map.data( 'zoom' ),
			marker_icon = $map.data( 'marker' ),
			info = $map.html();

		var mapOptions = {
			zoom             : zoom,
			// disableDefaultUI : true,
			scrollwheel      : false,
			navigationControl: true,
			mapTypeControl   : false,
			scaleControl     : false,
			draggable        : true,
			center           : new google.maps.LatLng( latitude, longitude ),
			mapTypeId        : google.maps.MapTypeId.ROADMAP
		};

		mapOptions.styles = [{
			"featureType": "water",
			"elementType": "geometry",
			"stylers"    : [{"color": "#e9e9e9"}, {"lightness": 17}]
		}, {
			"featureType": "landscape",
			"elementType": "geometry",
			"stylers"    : [{"color": "#f5f5f5"}, {"lightness": 20}]
		}, {
			"featureType": "road.highway",
			"elementType": "geometry.fill",
			"stylers"    : [{"color": "#ffffff"}, {"lightness": 17}]
		}, {
			"featureType": "road.highway",
			"elementType": "geometry.stroke",
			"stylers"    : [{"color": "#ffffff"}, {"lightness": 29}, {"weight": 0.2}]
		}, {
			"featureType": "road.arterial",
			"elementType": "geometry",
			"stylers"    : [{"color": "#ffffff"}, {"lightness": 18}]
		}, {
			"featureType": "road.local",
			"elementType": "geometry",
			"stylers"    : [{"color": "#ffffff"}, {"lightness": 16}]
		}, {
			"featureType": "poi",
			"elementType": "geometry",
			"stylers"    : [{"color": "#f5f5f5"}, {"lightness": 21}]
		}, {
			"featureType": "poi.park",
			"elementType": "geometry",
			"stylers"    : [{"color": "#dedede"}, {"lightness": 21}]
		}, {
			"elementType": "labels.text.stroke",
			"stylers"    : [{"visibility": "on"}, {"color": "#ffffff"}, {"lightness": 16}]
		}, {
			"elementType": "labels.text.fill",
			"stylers"    : [{"saturation": 36}, {"color": "#333333"}, {"lightness": 40}]
		}, {"elementType": "labels.icon", "stylers": [{"visibility": "off"}]}, {
			"featureType": "transit",
			"elementType": "geometry",
			"stylers"    : [{"color": "#f2f2f2"}, {"lightness": 19}]
		}, {
			"featureType": "administrative",
			"elementType": "geometry.fill",
			"stylers"    : [{"color": "#fefefe"}, {"lightness": 20}]
		}, {
			"featureType": "administrative",
			"elementType": "geometry.stroke",
			"stylers"    : [{"color": "#fefefe"}, {"lightness": 17}, {"weight": 1.2}]
		}];

		var map = new google.maps.Map( this, mapOptions );

		var marker = new google.maps.Marker( {
			position : new google.maps.LatLng( latitude, longitude ),
			map      : map,
			icon     : marker_icon,
			animation: google.maps.Animation.DROP
		} );

		if ( info ) {
			var infoWindow = new google.maps.InfoWindow( {
				content: '<div class="info_content">' + info + '</div>'
			} );

			marker.addListener( 'click', function() {
				infoWindow.open( map, marker );
			} );
		}
	} );

	/**
	 * Penshop slider
	 */
	$( '.penshop-slider' ).each( function() {
		var $slider = $( this ),
			$slides = $( '.penshop-slider__slides', $slider ),
			$swapper = $slider.children( '.penshop-slider__container' ),
			settings = $slider.data( 'settings' );

		if ( settings.width === 'fullwidth' || settings.width === 'fullscreen' ) {
			var sliderWidth = $slider.outerWidth(),
				windowWidth = $window.width();

			$swapper.width( windowWidth ).css( 'marginLeft', -(windowWidth - sliderWidth) / 2 );

			$window.on( 'resize', function() {
				$swapper.width( $window.width() ).css( 'marginLeft', -($window.width() - $slider.outerWidth()) / 2 );
			} );
		}

		var options = {
			items          : 1,
			autoplay       : '1' === settings.autoplay,
			autoplayTimeout: parseInt( settings.duration, 10 ),
			speed          : parseInt( settings.speed, 10 ),
			autoplaySpeed  : parseInt( settings.speed, 10 ),
			navSpeed       : parseInt( settings.speed, 10 ),
			dotsSpeed      : parseInt( settings.speed, 10 ),
			dots           : '1' === settings.dots,
			nav            : '1' === settings.nav,
			navText        : ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
			loop           : true
		};

		var animationEnd = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';

		$slides.on( 'initialized.owl.carousel translated.owl.carousel', function( event ) {
			var $slide = $( event.target ).find( '.owl-stage' ).children().eq( event.item.index );

			$slide.find( '.slide-layer' ).each( function() {
				var $layer = $( this ),
					animation = $layer.data( 'animation' );

				if ( ! animation ) {
					return;
				}

				$layer.removeClass( 'animated ' + animation ).addClass( 'visible' );
				$layer.css( 'animation-delay', $layer.data( 'animation-delay' ) + 's' );
				$layer.addClass( 'animated ' + animation ).one( animationEnd, function() {
					$layer.removeClass( 'animated ' + animation );
				} );
			} )
		} ).on( 'translated.owl.carousel', function( event ) {
			var $slide = $( event.target ).find( '.owl-stage' ).children().eq( event.item.index );

			$slide.siblings().each( function() {
				$( this ).find( '.slide-layer' ).removeClass( 'visible' );
			} )
		} );

		$slides.imagesLoaded( { background: '.penshop-slider__slide' }, function() {
			$slides.owlCarousel( options );
			$slider.addClass( 'initialized' );
		} );
	} );

	/**
	 * Calculate the height for element
	 *
	 * @param $el
	 */
	function getFullHeight( $el ) {
		var height = $( window ).height() - 1,
			offsetEl = $el.data( 'offset' );

		if ( offsetEl.length ) {
			offsetEl = offsetEl.split( ',' );

			for ( var i in offsetEl ) {
				if ( offsetEl[i].match( /^\d/ ) ) {
					height -= parseFloat( offsetEl[i] );
				} else {
					height -= $( offsetEl[i] ).outerHeight();
				}
			}
		}

		return height;
	}
} );
