/*global wp:false */

/**
 * Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Customizer preview reload changes asynchronously.
 */

(function( $, wp ) {
	'use strict';

	var api = wp.customize;

	api( 'blogname', function( value ) {
		value.bind(function( to ) {
			$( '.site-title a' ).text( to );
		});
	});

})( jQuery, wp );
