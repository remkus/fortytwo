<?php
/**
 * FortyTwo Theme
 *
 * @package FortyTwo
 * @author  Forsite Themes
 * @license GPL-2.0+
 * @link    http://forsitethemes/themes/fortytwo/
 */


// Filter prevent inline css being generated for post gallery
add_filter( 'use_default_gallery_style', '__return_false' );

add_action( 'genesis_before_loop', 'fortytwo_modify_default_post_structure' );
/**
 * Initiate the custom modifications to default post structure.
 *
 * @since @@release
 */
function fortytwo_modify_default_post_structure() {
	// Relocate post meta before title
	remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
	add_action( 'genesis_entry_header', 'genesis_post_meta', 8 );

	// Filter what post meta displays
	add_filter( 'genesis_post_meta', 'fortytwo_filter_post_meta' );

	// Filter what post info displays
	add_filter( 'genesis_post_info', 'fortytwo_filter_post_info' );
}

/**
 * Filter post meta to display categories only and remove before text.
 *
 * @since @@release
 *
 * @param string $post_meta Existing post meta content.
 *
 * @return string Amended post meta content.
 */
function fortytwo_filter_post_meta( $post_meta ) {
	return '[post_categories before=""]';
}

/**
 * Filter post info.
 *
 * @since @@release
 *
 * @param string $post_meta Existing post info content.
 *
 * @return string Amended post info content.
 */
function fortytwo_filter_post_info( $post_info ) {
	return '[post_date before="Date: "] [post_author_posts_link before="Author: "] [post_comments before="Comments: " more="(%)" one="(1)" zero="(0)"] [post_edit]';
}
