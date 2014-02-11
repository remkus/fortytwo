<?php
/**
 * FortyTwo Theme: Structual related functions
 *
 * This file Adds and changes the Genesis structure
 *
 * @package FortyTwo\Structural
 * @author  Forsite Themes
 * @license GPL-2.0+
 * @link    http://forsitethemes/themes/fortytwo/
 */

// Activating the Genesis Structural Wraps FortyTwo needs
add_theme_support( 'genesis-structural-wraps', array(
	'header',
	'menu-primary',
	'menu-secondary',
	'site-inner',
	'footer-widgets',
	'footer'
) );

add_action( 'genesis_header', 'fortytwo_inner_structural_wrap_open', 6 );
add_action( 'genesis_footer', 'fortytwo_inner_structural_wrap_open', 6 );
/**
 * Echo the extra opening structural wrap for header.
 *
 * @since 1.0
 * @todo  remove xhtml references
 * @todo  This code needs better documentation
 *
 */
function fortytwo_inner_structural_wrap_open() {

	genesis_markup( array(
		'html5'   => '<div %s>',
		'xhtml'   => '<div id="inner-wrap">',
		'context' => 'inner-wrap',
	) );

}

add_action( 'genesis_header', 'fortytwo_inner_structural_wrap_close', 14 );
add_action( 'genesis_footer', 'fortytwo_inner_structural_wrap_close', 14 );
/**
 * Echo the extra closing structural wrap for header.
 *
 * @since 1.0
 * @todo  remove xhtml references
 * @todo  This code needs better documentation
 *
 */
function fortytwo_inner_structural_wrap_close() {

	genesis_markup( array(
		'html5' => '</div>',
		'xhtml' => '</div>',
	) );

}

add_filter( 'genesis_attr_content-sidebar-wrap', 'fortytwo_attributes_content_sidebar_wrap' );
/**
 * Add additional class attributes content-sidebar-wrap.
 *
 * @since 1.0
 * @todo  This code needs better documentation
 *
 */
function fortytwo_attributes_content_sidebar_wrap( $attributes ) {

	$attributes['class'] = 'content-sidebar-wrap inner-wrap';

	return $attributes;

}

/**
 * Relocates the Genesis alt sidebar in order to be part of the site-inner columns
 */
remove_action( 'genesis_after_content_sidebar_wrap', 'genesis_get_sidebar_alt' );
add_action( 'genesis_after_content', 'genesis_get_sidebar_alt' );

/**
 * Function calculates the number of widgets in a sidebar and then calculates
 * the number of columns each widget requires based on no. of widgets.
 *
 * We then alter the specific sidebar's before_widget value
 * @todo Want to add data attribute for widget order in sidebar data-widget-order='first'... 'second' etc
 * @todo  This code needs better documentation
 *
 */
function fortytwo_add_data_widget_attr( $id ) {

	global $sidebars_widgets;

	$data_widget_count = count ( $sidebars_widgets[$id] );

	return $data_widget_count;

}

add_filter( 'dynamic_sidebar_params', 'fortytwo_data_attribute_widget_count' );
/**
 * We hook in to the dynamic_sidebar_params in order to add a data-attriburte
 * indicating the position of the current widget in a sidebar area.
 *
 * @todo  This code needs better documentation
 *
 */
function fortytwo_data_attribute_widget_count( $params ) {

	global $wp_registered_widgets;
	global $sidebars_widgets;

	$data_widget_position = (array_search( $params[0]['widget_id'], $sidebars_widgets[$params[0]['id']] )) + 1;

	$classname_ = '';
	foreach ( (array) $wp_registered_widgets[$params[0]['widget_id']]['classname'] as $cn ) {
		if ( is_string( $cn ) )
			$classname_ .= '_' . $cn;
		elseif ( is_object( $cn ) )
			$classname_ .= '_' . get_class( $cn );
	}
	$classname_ = ltrim( $classname_, '_' );

	$params[0]['before_widget'] = sprintf('<section id="%1$s" class="widget %2$s" data-widget-position="%3$s"><div class="widget-wrap">', $params[0]['widget_id'], $classname_, $data_widget_position);

	return $params;
}

/**
 * We are using the genesis_markup_{context} filter to short circuit the genesis_markup() function
 *
 * This will be called from an add_filter() on templates where Genesis framework markup is not required
 *
 * @since 1.0
 * @todo  This code needs better documentation
 *
 */
function fortytwo_remove_genesis_markup () {
	return true;
}