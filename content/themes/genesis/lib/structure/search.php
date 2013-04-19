<?php
/**
 * Controls output elements in search form.
 *
 * @category   Genesis
 * @package    Structure
 * @subpackage Search
 * @author     StudioPress
 * @license    http://www.opensource.org/licenses/gpl-license.php GPL-2.0+
 * @link       http://www.studiopress.com/themes/genesis
 */

add_filter( 'get_search_form', 'genesis_search_form' );
/**
 * Replace the default search form with a Genesis-specific form.
 *
 * @since 0.2.0
 *
 * @return string HTML markup
 */
function genesis_search_form() {

	$search_text = get_search_query() ? esc_attr( apply_filters( 'the_search_query', get_search_query() ) ) : apply_filters( 'genesis_search_text', esc_attr__( 'Search this website', 'genesis' ) . '&#x02026;' );

	$button_text = apply_filters( 'genesis_search_button_text', esc_attr__( 'Search', 'genesis' ) );

	$onfocus = "onfocus=\"if (this.value == '$search_text') {this.value = '';}\"";
	$onblur  = "onblur=\"if (this.value == '') {this.value = '$search_text';}\"";
	
	/** Empty label, by default. Filterable. */
	$label = apply_filters( 'genesis_search_form_label', '' );

	$xhtml_form = sprintf( '<form method="get" class="searchform search-form" action="%s" role="search" >%s<input type="text" value="%s" name="s" class="s search-input" %s %s /><input type="submit" class="searchsubmit search-submit" value="%s" /></form>', home_url( '/' ), $label, esc_attr( $search_text ), $onfocus, $onblur, esc_attr( $button_text ) );

	$html5_form = sprintf( '<form method="get" class="search-form" action="%s" role="search">%s<input type="search" name="s" placeholder="%s" results="5" /><input type="submit" value="%s" /></form>', home_url( '/' ), $label, $search_text, esc_attr( $button_text ) );

	$form = genesis_html5() ? $html5_form : $xhtml_form;

	return apply_filters( 'genesis_search_form', $form, $search_text, $button_text, $label );

}
