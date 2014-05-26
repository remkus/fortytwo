/**!
 * FortyTwo Theme {@link http://forsitethemes/themes/fortytwo/}
 *
 * @author  Forsite Themes
 * @license GPL-2.0+
 */
(function( $ ) {
	'use strict';
	setTimeout( function() {
		$( '.nav-primary' ).affix( {
			offset: {
				top: function() {
					return ( this.top = $( '.site-header' ).outerHeight( true ) );
				}
			}
		} );
	}, 100 );
})( jQuery );
