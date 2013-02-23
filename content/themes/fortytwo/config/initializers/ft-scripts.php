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

	wp_enqueue_script( 'bootstrap', CHILD_URL . '/vendor/frameworks/bootstrap/docs/assets/js/bootstrap.js', array( 'jquery' ), '3.0.0', true );

}
