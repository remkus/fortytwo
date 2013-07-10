<?php
/*
 * FotyTwo: Default Widgets
 *
 * This file modifies the WordPress default widgets to allow for our Bootstrap type
 * styling
 *
 * @since 1.0.0
 *
 */

add_filter( 'widget_archives_args', 'fortytwo_modify_archives_args' );
/**
 * Filter to replace the arguments of the archive widget
 *
 **/
function fortytwo_modify_archives_args( $attr ) {

    $args = array(
        'before'          => '<span class="test">',
        'after'           => '</span>'
    );

    $attr = wp_parse_args( $attr, $args );

    return $attr;
}

add_filter( 'get_archives_link', 'fortytwo_modify_archives_link', 10, 6 );
/**
 * Filter to replace the arguments of the archive widget
 *
 **/
function fortytwo_modify_archives_link( $link_html ) {

    preg_match ( "/href='(.+?)'/", $link_html, $url );
    $requested = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];

    if ( $requested == $url[1] ) {
        $link_html = str_replace( '<li>', '<li class="current">', $link_html );
    }

    return $link_html;

}