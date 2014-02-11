<?php
/**
 * FortyTwo Theme: Enqueue Scripts: Used to enqueue all extra files
 *
 * This file modifies the WordPress default widgets to allow for our Bootstrap type
 * styling
 *
 * @package FortyTwo\General
 * @author  Forsite Themes
 * @license GPL-2.0+
 * @link    http://forsitethemes/themes/fortytwo/
 */

add_action( 'wp_enqueue_scripts', 'fortytwo_load_google_fonts' );
/**
 * Loading Google Fonts
 *
 * @return void
 */
function fortytwo_load_google_fonts() {
	wp_enqueue_style( 'google-font-open-sans', '//fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,400,600,300', array(), PARENT_THEME_VERSION );
	wp_enqueue_style( 'google-font-droid-serif', '//fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic', array(), PARENT_THEME_VERSION );
}

add_action( 'wp_enqueue_scripts', 'fortytwo_add_scripts', 100 );
/**
 * Load fortytwo required scripts
 *
 * @since 1.0.0
 *
 * @uses CHILD_URL
 * @uses CHILD_THEME_VERSION
 */
function fortytwo_add_scripts() {
	// Adding the fortytwo.js file
	wp_enqueue_script( 'fortytwo', CHILD_URL . '/assets/js/fortytwo.js', array() , CHILD_THEME_VERSION, false );

	// Bootstrap js file
	wp_enqueue_script( 'bootstrap', CHILD_URL . '/vendor/bootstrap/dist/js/bootstrap.min.js', array( 'jquery' ), '3.0.3', true );
}

add_action( 'wp_head', 'fortytwo_respond_ie_media_queries' );
/**
 * Load polyfill for min/max CSS3 media queries in IE 6-8
 *
 * @since 1.0.0
 *
 * @uses genesis_html5() Check for HTML5 support.
 *
 * @return Return early if not IE or HTML5 not supported.
 *
 */
function fortytwo_respond_ie_media_queries() {
	global $is_IE;

	if ( ! $is_IE || ! genesis_html5() )
		return;

	echo '<!--[if lt IE 9]><script src="' . CHILD_URL . '/vendor/js/respond.min.js"></script><![endif]-->' . "\n";

}
