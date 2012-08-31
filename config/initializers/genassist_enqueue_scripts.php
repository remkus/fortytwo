<?php
/*
 * FortyTwo Enqueue Scripts: Used to enqueue all extra files
 */


/** Load fortytwo stylesheet to header */
add_action( 'wp_enqueue_scripts', 'fortytwo_add_stylesheets_javascripts', 100 );
function fortytwo_add_stylesheets_javascripts() {

    /* These needs to be named bootstrap to prevent FST-PACK from also loading bootstrap */
    wp_enqueue_style(  'bootstrap', CHILD_URL . '/theme/assets/stylesheets/fortytwo.css', array(), '1.0' );
    wp_enqueue_script( 'bootstrap', CHILD_URL . '/vendor/javascripts/bootstrap.min.js', array( 'jquery' ), '2.0.4', true );

}