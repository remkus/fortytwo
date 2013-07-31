<?php
/*
 * FortyTwo Enqueue Scripts: Used to enqueue all extra files
 */



add_action( 'wp_enqueue_scripts', 'fortytwo_add_scripts', 100 );
/**
 * Load fortytwo stylesheet to header
 * @return [type] [description]
 * @todo  These needs to be named bootstrap to prevent FST-PACK from also loading bootstrap
 * @todo  Need to change bootstrap.js for final version to minified
 */
function fortytwo_add_scripts() {

	wp_enqueue_script( 'srcset-polyfill', CHILD_URL . '/vendor/js/srcset.min.js', array() , '0.1.0', false );
	wp_enqueue_script( 'bootstrap', CHILD_URL . '/vendor/frameworks/bootstrap/docs/assets/js/bootstrap.js', array( 'jquery' ), '3.0.0', true );
	wp_enqueue_script( 'holderjs', CHILD_URL . '/vendor/js/holder.js', array() , '1.9.0', true );

}
