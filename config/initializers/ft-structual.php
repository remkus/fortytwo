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
	'site-section',
	'footer-widgets',
	'footer'
) );

add_action( 'genesis_header', 'fortytwo_inner_structural_wrap_open', 6 );
add_action( 'genesis_footer', 'fortytwo_inner_structural_wrap_open', 6 );
/**
 * Echo the extra opening structural wrap for header.
 *
 * @since 1.0
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
 *
 */
function fortytwo_add_widget_count_class( $id ) {

	//TODO: Want to add data attribute for widget order in sidebar data-widget-order='first'... 'second' etc
	global $wp_registered_sidebars;
	global $sidebars_widgets;

	$widget_count_class = ' col-lg-' . ( 12 / ( count ( $sidebars_widgets[$id] ) ) );

	$wp_registered_sidebars[$id]['before_widget'] = '<section id="%1$s" class="widget %2$s' . $widget_count_class . '"><div class="widget-wrap">';

}