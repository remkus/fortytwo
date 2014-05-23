/**
 * Main fortytwo js file
 */
(function ($) {
	'use strict';
	setTimeout( function () {
		var $navbar = $( '.nav-primary' );

		$navbar.affix( {
			offset: {
				top: function () {
					return ( this.top = $( '.site-header' ).outerHeight(true) );
				}
			}
		} );
	}, 100 );
}( jQuery ) );
