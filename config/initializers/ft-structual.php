<?php
/*
 * FotyTwo: Structual realted functions
 *
 *
 * @since 1.0.0
 *
 */

add_theme_support( 'genesis-structural-wraps', array(
	'header',
	'menu-primary',
	'menu-secondary',
	'site-inner',
	'footer-widgets',
	'footer'
) );

//add_filter( 'genesis_structural_wrap-header', 'fortytwo_add_col_wrap', 10, 2 );
/**
 * Add a structural wrap that acts as a row for columns inside the Genesis <div class="wrap">.
 *
 * @since 1.0
 *
 * @param string $output Existing attributes.
 * @param string $output_original
 *
 * @return string Wrap HTML with col-wrap.
 */
function fortytwo_add_col_wrap( $output, $original_output ) {

	switch ( $original_output ) {
		case 'open':
			$output .= sprintf( '<div %s>', genesis_attr( 'structural-wrap' ) );
			break;
		case 'close':
			$output .= '</div>';
			break;
	}

	echo $output;
}


//add_filter( 'genesis_attr_structural-col-wrap', 'fortytwo_attributes_structural_col_wrap' );
/**
 * Add attributes for structural column wrap element.
 *
 * @since 1.0
 *
 * @param array $attributes Existing attributes.
 *
 * @return array Amended attributes.
 */
function fortytwo_attributes_structural_col_wrap( $attributes ) {

	$attributes['class'] = 'col-wrap';

	return $attributes;

}


add_filter( 'genesis_attr_structural-wrap', 'fortytwo_reapply_structural_wrap', 15 );
/**
 * Add attributes for structural column wrap element.
 *
 * @since 1.0
 *
 * @param array $attributes Existing attributes.
 *
 * @return array Amended attributes.
 */
function fortytwo_reapply_structural_wrap( $output, $attributes, $context ) {

	$attributes['class'] = 'col-wrap';

	return $attributes;

}

