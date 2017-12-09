jQuery( document ).ready( function( $ ) {
	/**
	 * Slider width changes
	 */
	$( '#slider_settings_width' ).on( 'change', function() {
		var $el = $( this );

		if ( $el.val() !== 'fullscreen' ) {
			$el.closest( '.rwmb-field' ).next( '.rwmb-field' ).show();
		} else {
			$el.closest( '.rwmb-field' ).next( '.rwmb-field' ).hide();
		}
	} ).trigger( 'change' );

	/**
	 * Toggle slider auto play duration
	 */
	$( '#slider_settings_autoplay' ).on( 'change', function() {
		var $el = $( this );

		if ( $el.is( ':checked' ) ) {
			$el.closest( '.rwmb-field' ).next( '.rwmb-field' ).show();
		} else {
			$el.closest( '.rwmb-field' ).next( '.rwmb-field' ).hide();
		}
	} ).trigger( 'change' );

	/**
	 * Toggle slider nav color setting
	 */
	$( '#slider_settings_nav_color_scheme' ).on( 'change', function() {
		var $el = $( this );

		if ( $el.val() === 'custom' ) {
			$el.closest( '.rwmb-field' ).next( '.slider-nav-color' ).addClass( 'field-show' );
		} else {
			$el.closest( '.rwmb-field' ).next( '.slider-nav-color' ).removeClass( 'field-show' );
		}
	} ).trigger( 'change' );

	/**
	 * Layer type changes
	 */
	$( document.body ).on( 'change', '.slide-layer-type select', function() {
		var $el = $( this ),
			value = $el.val();

		if ( value === 'button' || value === 'button_underline' ) {
			$el.closest( '.rwmb-field' ).next( '.slide-layer-link' ).addClass( 'field-show' );
		} else {
			$el.closest( '.rwmb-field' ).next( '.slide-layer-link' ).removeClass( 'field-show' );
		}
	} );

	$( '.slide-layer-type select' ).trigger( 'change' );

	/**
	 * Layer color changes
	 */
	$( document.body ).on( 'change', '.slide-layer-color select', function() {
		var $el = $( this );

		if ( $el.val() === 'custom' ) {
			$el.closest( '.rwmb-field' ).next( '.slide-layer-custom-color' ).addClass( 'field-show' );
		} else {
			$el.closest( '.rwmb-field' ).next( '.slide-layer-custom-color' ).removeClass( 'field-show' );
		}
	} );

	$( '.slide-layer-color select' ).trigger( 'change' );

	/**
	 * Animation changes
	 */
	$( document.body ).on( 'change', '.slide-layer-animation select', function() {
		var $el = $( this ),
			animation = $el.val();

		if ( animation ) {
			$el.closest( '.rwmb-field' ).next( '.animation-preview' ).find( '.animation-sandbox' ).animateCss( animation );
		}
	} );
} );

/**
 * AnimateCss
 */
(function( $ ) {
	$.fn.extend( {
		animateCss: function( animationName ) {
			var animationEnd = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';
			this.addClass( 'animated ' + animationName ).one( animationEnd, function() {
				$( this ).removeClass( 'animated ' + animationName );
			} );
			return this;
		}
	} );
})( jQuery );