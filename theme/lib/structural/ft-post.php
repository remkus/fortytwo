<?php
/**
 * FortyTwo Theme
 *
 * @package FortyTwo
 * @author  Forsite Themes
 * @license GPL-2.0+
 * @link    http://forsitethemes/themes/fortytwo/
 */


add_filter( 'use_default_gallery_style', '__return_false' );
/**
 * Filter prevent inline css being generated for post gallery
 *
 * @since 1.0.0
 */


add_action( 'genesis_before_loop', 'fortytwo_modify_default_post_structure' );
/**
 * Initiate the custom modifications to default post structure
 *
 * @since 1.0.0
 */
function fortytwo_modify_default_post_structure() {

	// Remove post meta from default location
	remove_action( 'genesis_entry_footer', 'genesis_post_meta' );

	// Relocate post meta before title
	add_action( 'genesis_entry_header', 'genesis_post_meta', 8 );

	// Filter what post meta displays
	add_filter( 'genesis_post_meta', 'fortytwo_filter_post_meta' );

	// Filter what post info displays
	add_filter( 'genesis_post_info', 'fortytwo_filter_post_info' );

}

/**
 * Filter post meta to display categories only and remove before text
 *
 * @since 1.0.0
 */
function fortytwo_filter_post_meta( $post_meta ) {

	$post_meta = '[post_categories before=""]';
	return $post_meta;

}

/**
 * Filter post info
 *
 * @since 1.0.0
 */
function fortytwo_filter_post_info( $post_info ) {

	$post_info = '[post_date before="Date: "] [post_author_posts_link before="Author: "] [post_comments before="Comments: " more="(%)" one="(1)" zero="(0)"] [post_edit]';
	return $post_info;

}