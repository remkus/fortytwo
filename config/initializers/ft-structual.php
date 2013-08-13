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
	'site-section',
	'site-inner',
	'footer-widgets',
	'footer'
) );

add_filter( 'genesis_structural_wrap-header', 'fortytwo_add_extra_structural_wrap', 10, 2 );
add_filter( 'genesis_structural_wrap-site-section', 'fortytwo_add_extra_structural_wrap', 10, 2 );
add_filter( 'genesis_structural_wrap-site-inner', 'fortytwo_add_extra_structural_wrap', 10, 2 );
add_filter( 'genesis_structural_wrap-footer-widgets', 'fortytwo_add_extra_structural_wrap', 10, 2 );
add_filter( 'genesis_structural_wrap-footer', 'fortytwo_add_extra_structural_wrap', 10, 2 );
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

	$attributes['class'] = 'outer-wrap';

	return $attributes;

}

/**
 * Relocates the Genesis alt sidebar in order to be part of the site-inner columns
 */
remove_action( 'genesis_after_content_sidebar_wrap', 'genesis_get_sidebar_alt' );
add_action( 'genesis_after_content', 'genesis_get_sidebar_alt' );