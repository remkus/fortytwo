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

	function ft_responsive_slider_checklist_toggle() {
		$('<p><span id="ft-category-checklist-toggle" class="button">' + ft_responsive_slider_toggle_settings.category_checklist_toggle + '</span></p>').insertBefore('ul.categorychecklist');

		$('#ft-category-checklist-toggle').live('click.ft', function (event) {
			var $this = $(this),
				checkboxes = $this.parent().next().find(':checkbox');

			if ($this.data('clicked')) {
				checkboxes.attr('checked', false);
				$this.data('clicked', false);
			} else {
				checkboxes.attr('checked', true);
				$this.data('clicked', true);
			}
		});
	}
	ft_responsive_slider_checklist_toggle();
	
	$('.ft-layout-selector input[type="radio"]').change(function() {
	    var tmp=$(this).attr('name');
	    $('input[name="'+tmp+'"]').parent("label").removeClass("selected");
	    $(this).parent("label").toggleClass("selected", this.selected);      
	});

//	$( function () {
		$( "#slider" ).slider( {
			value: 100,
			min: 0,
			max: 500,
			step: 50,
			slide: function ( event, ui ) {
				$( "#ft_responsive_slider_settings[slideshow_excerpt_width]" ).val( "$" + ui.value );
			}
		} );
		$( '#ft_responsive_slider_settings[slideshow_excerpt_width]' ).val( $( '#slider' ).slider( 'value' ) );
//	} );

});