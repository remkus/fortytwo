/**
 * Main fortytwo js file
 */
jQuery(document ).ready( function ($) {
	// Inside of this function, $() will work as an alias for jQuery()
	// and other libraries also using $ will not be accessible under this shortcut

	setTimeout( function () {
		var $navbar = $( '.nav-primary' )

		$navbar.affix( {
			offset: {
				top: function () {
					var offsetTop = $(".site-header").outerHeight();
					return ( this.top = offsetTop )
				}
			}
		} )


	}, 100 )

} );