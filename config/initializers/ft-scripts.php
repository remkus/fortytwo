<?php
/*
 * FortyTwo Enqueue Scripts: Used to enqueue all extra files
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
	wp_enqueue_style( 'google-font-source-sans-pro', '//fonts.googleapis.com/css?family=Source+Sans+Pro:400,600,700', array(), PARENT_THEME_VERSION );
}

add_action( 'wp_enqueue_scripts', 'fortytwo_add_scripts', 100 );
/**
 * Load fortytwo required scripts
 * @return [type] [description]
 * @todo  These needs to be named bootstrap to prevent FST-PACK from also loading bootstrap
 * @todo  Need to change bootstrap.js for final version to minified
 * @todo  This code needs better documentation
 */
function fortytwo_add_scripts() {

	// Adding the fortytwo.js file
	wp_enqueue_script( 'fortytwo', CHILD_URL . '/assets/js/fortytwo.js', array() , '0.1.0', false );

	// Polyfill for srcset which is part of our responsive images solution
	wp_enqueue_script( 'srcset-polyfill', CHILD_URL . '/vendor/js/srcset.min.js', array() , '0.1.0', false );

	// Bootstrap js file
	wp_enqueue_script( 'bootstrap', CHILD_URL . '/vendor/bootstrap/dist/js/bootstrap.min.js', array( 'jquery' ), '3.0.0', true );

}
