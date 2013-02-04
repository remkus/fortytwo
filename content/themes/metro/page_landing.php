<?php
/**
 * This file adds the Landing template to the Metro Theme.
 *
 * @author StudioPress
 * @package Generate
 * @subpackage Customizations
 */

/*
Template Name: Landing
*/

// Add custom body class to the head
add_filter( 'body_class', 'metro_add_body_class' );
function metro_add_body_class( $classes ) {
   $classes[] = 'metro-landing';
   return $classes;
}

// Remove header, navigation, breadcrumbs, footer widgets, footer 
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );
remove_action( 'genesis_header', 'genesis_header_markup_open', 5 );
remove_action( 'genesis_header', 'genesis_do_header' );
remove_action( 'genesis_header', 'genesis_header_markup_close', 15 );
remove_action( 'genesis_after_header', 'genesis_do_nav' );
remove_action( 'genesis_before', 'genesis_do_subnav' );
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );
remove_action( 'genesis_after', 'genesis_footer_widget_areas' );
remove_action( 'genesis_after', 'genesis_footer_markup_open', 11 );
remove_action( 'genesis_after', 'genesis_do_footer', 12 );
remove_action( 'genesis_after', 'genesis_footer_markup_close', 13 );

genesis();