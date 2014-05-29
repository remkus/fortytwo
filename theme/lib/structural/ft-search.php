<?php
/**
 * FortyTwo Theme
 *
 * @package FortyTwo
 * @author  Forsite Themes
 * @license GPL-2.0+
 * @link    http://forsitethemes/themes/fortytwo/
 */

remove_filter( 'get_search_form', 'genesis_search_form', 20 );
add_filter( 'get_search_form', 'fortytwo_search_form', 20 );

/**
 * Replace the default search form with a Genesis-specific accessible form.
 *
 * Applies the `genesis_search_text`, `genesis_search_button_text`, `genesis_search_form_label` and
 * `genesis_search_form` filters.
 *
 * @since @@release
 *
 * @link http://plugins.svn.wordpress.org/genesis-accessible/trunk/includes/forms.php
 *
 * @return string HTML markup for search form.
 */
function fortytwo_search_form() {
	if ( get_search_query() ) {
		$search_text = apply_filters( 'the_search_query', get_search_query() );
	} else {
		$search_text = apply_filters( 'genesis_search_text', __( 'Search this website&#x2026;', 'fortytwo' ) );
	}

	$button_text = apply_filters( 'genesis_search_button_text', esc_attr__( 'Search', 'fortytwo' ) );

	//* Generate ramdom id for the search field (n case there are more than one search form on the page)
	$id = uniqid( 'searchform-' );

	//* Empty label, by default. Filterable.
	$label = apply_filters( 'genesis_search_form_label', $search_text );
	$label = '<label for="' . $id . '" class="screen-reader-text">' . $label . "</label>";

	$value_or_placeholder = ( get_search_query() == '' ) ? 'placeholder' : 'value';

	$form = sprintf(
		'<form method="get" class="search-form" action="%s" role="search">
			%s<input type="search" name="s" id="%s" %s="%s" />
			<span class="search-button">
				<button class="btn" type="submit">%s</button>
			</span>
		</form>',
		home_url( '/' ),
		$label,
		$id,
		$value_or_placeholder,
		esc_attr( $search_text ),
		esc_attr( $button_text )
	);
	
	return apply_filters( 'genesis_search_form', $form, $search_text, $button_text, $label );

}