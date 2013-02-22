<?php
/*
 * FortyTwo Enqueue Scripts: Used to enqueue all extra files
 */


/** Load fortytwo stylesheet to header */
add_action( 'wp_enqueue_scripts', 'fortytwo_add_scripts', 100 );
function fortytwo_add_scripts() {

    /* These needs to be named bootstrap to prevent FST-PACK from also loading bootstrap */
    wp_enqueue_script( 'bootstrap', CHILD_URL . '/vendor/frameworks/bootstrap/docs/assets/js/bootstrap.js', array( 'jquery' ), '3.0.0', true ); //Need to change for final version to minified

}