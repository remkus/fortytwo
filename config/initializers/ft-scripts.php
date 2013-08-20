<?php
/*
 * FortyTwo Enqueue Scripts: Used to enqueue all extra files
 */



add_action( 'wp_enqueue_scripts', 'fortytwo_add_scripts', 100 );
/**
 * Load fortytwo required scripts
 * @return [type] [description]
 * @todo  These needs to be named bootstrap to prevent FST-PACK from also loading bootstrap
 * @todo  Need to change bootstrap.js for final version to minified
 */
function fortytwo_add_scripts() {

	// Adding the fortytwo.js file
	wp_enqueue_script( 'fortytwo', CHILD_URL . '/assets/js/fortytwo.js', array() , '0.1.0', false );

	// Polyfill for srcset which is part of our responsive images solution
	wp_enqueue_script( 'srcset-polyfill', CHILD_URL . '/vendor/js/srcset.min.js', array() , '0.1.0', false );

	// Bootstrap js file
	wp_enqueue_script( 'bootstrap', CHILD_URL . '/vendor/bootstrap/dist/js/bootstrap.min.js', array( 'jquery' ), '3.0.0', true );

}
