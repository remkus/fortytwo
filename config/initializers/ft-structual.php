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

add_filter( 'genesis_structural_wrap-header', 'fortytwo_add_extra_structural_wrap', 10, 2 );
/**
 * Add a structural extra .wrap div so we can rename the original one later in the
 * process of adding structural wraps.
 *
 * @since 1.0
 *
 * @param string $output Existing attributes.
 * @param string $output_original
 *
 * @return string Wrap HTML with col-wrap.
 */
function fortytwo_add_extra_structural_wrap( $output, $original_output ) {

	switch ( $original_output ) {
		case 'open':
			$output = sprintf( '<div %s>', genesis_attr( 'extra-structural-wrap' ) );
			break;
		case 'close':
			$output = '</div>';
			break;
	}

	echo $output;
}


add_filter( 'genesis_attr_extra-structural-wrap', 'fortytwo_attributes_extra_structural_wrap' );
/**
 * Add attributes for extra structural wrap element.
 *
 * @since 1.0
 *
 * @param array $attributes Existing attributes.
 *
 * @return array Amended attributes.
 */
function fortytwo_attributes_extra_structural_wrap( $attributes ) {

	$attributes['class'] = 'wrap';

	return $attributes;

}


add_filter( 'genesis_attr_structural-wrap', 'fortytwo_rename_structural_wrap', 15 );
/**
 * Edit the default attribute value of the structural wrap.
 *
 * We have to execute this in what seems a reverse order due to the fact
 * that Genesis provides us a way to add structure before the current .wrap
 * and not after it. As we need .wrap before our .col-wrap we use the above
 * function fortytwo_add_extra_structural_wrap() to add an extra .wrap div
 * so we can rename the original one.
 *
 * @since 1.0
 *
 * @param array $attributes Existing attributes.
 *
 * @return array Amended attributes.
 */
function fortytwo_rename_structural_wrap( $attributes ) {

	$attributes['class'] = 'col-wrap';

	return $attributes;

}

