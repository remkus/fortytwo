<?php
/*
 * FotyTwo: Cleanup file
 *
 *
 * @since 1.0.0
 *
 */

function fortytwo_cleanup_unwanted_styles() {
    // Removes the Genesis responsive slider stylesheet
    wp_dequeue_style( 'slider_styles' );
    wp_deregister_style( 'slider_styles' );
}

add_action( 'wp_print_styles', 'fortytwo_cleanup_unwanted_styles', 100 );