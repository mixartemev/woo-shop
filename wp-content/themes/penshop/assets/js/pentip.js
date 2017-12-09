;(function ( $ ) {
	'use strict';

	$.fn.penTip = function () {
		return this.each( function () {
			var $el = $( this ),
				tip = new Tip( $el.data( 'tip' ) );

			$el.append( tip.generate() ).addClass( 'pentipped' );

			$el.on( 'mouseenter', function () {
					tip.show();
				} )
				.on( 'mouseleave', function () {
					tip.hide();
				} );
		} );
	};

	function Tip( text ) {
		this.content = text;
		this.shown = false;
	}

	Tip.prototype = {
		generate: function () {
			// The generate method returns either a previously generated element
			// stored in the tip variable, or generates it and saves it in tip for
			// later use, after which returns it.
			return this.tip || (this.tip = $( '<span class="pentip">' + this.content + '</span>' ));
		},
		show    : function () {
			if ( this.shown ) {
				return;
			}

			this.tip.stop(true, true).fadeIn( 500 );
			this.shown = true;
		},
		hide    : function () {
			this.tip.hide();
			this.shown = false;
		}
	}
})( jQuery );