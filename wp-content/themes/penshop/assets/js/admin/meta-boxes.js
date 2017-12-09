jQuery( document ).ready( function ( $ ) {
	"use strict";

	// Toggle "Display Settings" for page template
	$( '#page_template' ).on( 'change', function () {
		if ( $( this ).val() == 'templates/homepage.php' ) {
			$( '#display-settings' ).hide();
		} else {
			$( '#display-settings' ).show();
		}
	} ).trigger( 'change' );

	// Toggle header fields
	$( '#header_color_scheme' ).on( 'change', function () {
		var $el = $( this );

		if ( 'transparent' === $el.val() || '' === $el.val() ) {
			$( '.rwmb-field.header_text_color' ).show();
		} else {
			$( '.rwmb-field.header_text_color' ).hide();
		}
	} ).trigger( 'change' );

	// Toggle page header fields
	$( '#hide_page_header' ).on( 'change', function () {
		var $el = $( this );

		if ( $el.is( ':checked' ) ) {
			$( '.rwmb-field.page-header-field' ).hide();
			$( '.rwmb-field.hide-page-title' ).show();
		} else {
			$( '.rwmb-field.page-header-field' ).show();
			$( '.rwmb-field.hide-page-title' ).hide();

			$( '#page_header_image_position' ).trigger( 'change' );
			$( '#page_header_image_mobile_position' ).trigger( 'change' );
			$( '#page_header_custom_spacing' ).trigger( 'change' );
		}
	} ).trigger( 'change' );

	// Toggle image position fields
	$( '#page_header_image_position' ).on( 'change', function() {
		var $el = $( this );

		if ( 'custom' === $el.val() ) {
			$( '.rwmb-field.page-header-position-desktop' ).show();
		} else {
			$( '.rwmb-field.page-header-position-desktop' ).hide();
		}
	} ).trigger( 'change' );

	$( '#page_header_image_mobile_position' ).on( 'change', function() {
		var $el = $( this );

		if ( 'custom' === $el.val() ) {
			$( '.rwmb-field.page-header-position-mobile' ).show();
		} else {
			$( '.rwmb-field.page-header-position-mobile' ).hide();
		}
	} ).trigger( 'change' );

	// Toggle spacing fields
	$( '#page_header_custom_spacing' ).on( 'change', function() {
		if ( $( this ).is( ':checked' ) ) {
			$( '.rwmb-field.page-header-spacing' ).show();
		} else {
			$( '.rwmb-field.page-header-spacing' ).hide();
		}
	} ).trigger( 'change' );

	// Toggle layout settings
	$( '#custom_layout' ).on( 'change', function () {
		if ( $( this ).is( ':checked' ) ) {
			$( '.rwmb-field.custom-layout' ).show();
		}
		else {
			$( '.rwmb-field.custom-layout' ).hide();
		}
	} ).trigger( 'change' );
} );
