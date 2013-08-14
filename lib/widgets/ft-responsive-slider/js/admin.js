jQuery(document).ready(function($) {

	

	// Array: selector of toggle element, selector of element to show/hide, checkable value for select || null
	var ft_responsive_slider_toggles = [
		['#ft_responsive_slider_settings\\[post_type\\]', '#ft-slider-taxonomy', 'page']
	];

	$.each( ft_responsive_slider_toggles, function( k, v ) {
		$( v[0] ).live( 'change', function() {
			ft_responsive_slider_toggle_settings( v[0], v[1], v[2] );
		});
		ft_responsive_slider_toggle_settings( v[0], v[1], v[2] ); // Check when page loads too.
	});

	function ft_responsive_slider_toggle_settings( selector, show_selector, check_value ) {
		if (
			( check_value === null && $( selector ).is( ':checked' ) ) ||
			( check_value !== null && $( selector ).val() !== check_value )
		) {
			$( show_selector ).slideDown( 'fast' );
		} else {
			$( show_selector ).slideUp( 'fast' );
		}
	}

	//This adds the slider to the settings in order to select no. columns
	var slider_excerpt_width = $( '#ft_responsive_slider_settings\\[slideshow_excerpt_width\\]' );
	var slider = $( '<div id="ft-slider-columns"></div>' ).insertAfter( slider_excerpt_width ).slider( {
		min: 1,
		max: 12,
		range: "max",
		value: slider_excerpt_width[ 0 ].value,
		slide: function ( event, ui ) {
			$( '#ft_responsive_slider_settings\\[slideshow_excerpt_width\\]' ).val( ui.value );
		}
	} );

});