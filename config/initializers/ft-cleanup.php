<?php
/*
 * FotyTwo: Cleanup file
 *
 *
 * @since 1.0.0
 *
 */

add_action( 'wp_print_styles', 'fortytwo_cleanup_unwanted_styles', 100 );
/**
 * Removes the Genesis responsive slider stylesheet
 * @return [type] [description]
 */
function fortytwo_cleanup_unwanted_styles() {

    wp_dequeue_style( 'slider_styles' );
    wp_deregister_style( 'slider_styles' );

}

add_action( 'init', 'fortytwo_cleanup_inline_styles', 100 );
/**
 * Removes the Genesis responsive slider inline css block
 * @return [type] [description]
 */
function fortytwo_cleanup_inline_styles() {

    remove_action( 'wp_head', 'genesis_responsive_slider_head', 1 );

}