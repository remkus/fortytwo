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
	wp_enqueue_style( 'google-font-open-sans', '//fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,400,600,300|Droid+Serif:400,700,400italic,700italic', array(), CHILD_THEME_VERSION );
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
	wp_enqueue_script( 'fortytwo', FORTYTWO_URL . '/js/fortytwo.js', array() , CHILD_THEME_VERSION, false );

	// Bootstrap js file
	wp_enqueue_script( 'bootstrap', FORTYTWO_URL . '/js/bootstrap.min.js', array( 'jquery' ), '3.1.1', true );
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

	if ( ! $is_IE || ! genesis_html5() ) {
		return;
	}

	echo '<!--[if lt IE 9]><script src="' . esc_url( FORTYTWO_URL ) . '/js/respond.min.js"></script><![endif]-->' . "\n";

}
