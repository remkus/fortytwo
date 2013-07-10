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

add_filter( 'get_archives_link', 'fortytwo_modify_archives_link' );
/**
 * Filter to change the structure of the archive link
 *
 **/
function fortytwo_modify_archives_link( $link_html ) {

    preg_match ( "/href='(.+?)'/", $link_html, $url );
    preg_match ( "/\<\/a\>&nbsp;\((\d+)\)/", $link_html, $post_count );

    $requested = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];

    if ( ! empty( $url )&& $requested == $url[1] ) {
        $link_html = str_replace( '<li>', '<li class="archive-list-item current">', $link_html );
    } else {
        $link_html = str_replace( '<li>', '<li class="archive-list-item">', $link_html );
    }

    if ( empty( $post_count ) ) {
        $link_html = str_replace( '</a>', '</a><span class="icon icon-angle-right"></span>', $link_html );
    } else {
        $link_html = str_replace( $post_count[0], '</span><span class="badge">' . $post_count[1] . '</span></a><span class="icon icon-angle-right">', $link_html );
    }

    return $link_html;

}