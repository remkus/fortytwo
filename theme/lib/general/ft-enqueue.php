<?php
/**
 * FortyTwo Theme
 *
 * @package FortyTwo
 * @author  Forsite Themes
 * @license GPL-2.0+
 * @link    http://forsitethemes/themes/fortytwo/
 */

add_action( 'wp_enqueue_scripts', 'fortytwo_enqueue_fonts' );
/**
 * Enqueue fonts from Google Web Fonts.
 *
 * @since @@release
 */
function fortytwo_enqueue_fonts() {
	wp_enqueue_style( 'google-font-open-sans', '//fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,400,600,300,700|Droid+Serif:400,700,400italic,700italic', array(), CHILD_THEME_VERSION );
}

add_action( 'wp_enqueue_scripts', 'fortytwo_enqueue_scripts', 100 );
/**
 * Enqueue scripts.
 *
 * @since @@release
 *
 * @uses FORTYTWO_URL
 * @uses CHILD_THEME_VERSION
 */
function fortytwo_enqueue_scripts() {
	$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

	wp_enqueue_script( 'fortytwo', FORTYTWO_URL . "/js/fortytwo$suffix.js", array() , CHILD_THEME_VERSION, false );
	wp_enqueue_script( 'bootstrap', FORTYTWO_URL . '/js/bootstrap.min.js', array( 'jquery' ), '3.1.1', true );
}

add_action( 'wp_head', 'fortytwo_respond_ie_media_queries' );
/**
 * Load polyfill for min/max CSS3 media queries in IE 6-8
 *
 * @since @@release
 *
 * @uses FORTYTWO_URL
 *
 * @return null Return early if not IE or HTML5 not supported.
 */
function fortytwo_respond_ie_media_queries() {
	global $is_IE;

	if ( ! $is_IE || ! genesis_html5() ) {
		return;
	}

	echo '<!--[if lt IE 9]><script src="' . esc_url( FORTYTWO_URL ) . '/js/respond.min.js"></script><![endif]-->' . "\n";
}
