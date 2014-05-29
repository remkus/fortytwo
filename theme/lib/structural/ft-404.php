<?php
/**
 * FortyTwo Theme
 *
 * @package FortyTwo
 * @author  Forsite Themes
 * @license GPL-2.0+
 * @link    http://forsitethemes/themes/fortytwo/
 */

add_action( 'genesis_loop', 'fortytwo_remove_404_loop', 8 );
/**
 * Remove Genesis 404 loop.
 *
 * @since @@release
 */
function fortytwo_remove_404_loop() {
	remove_action( 'genesis_loop', 'genesis_404' );
}

add_action( 'genesis_loop', 'fortytwo_404' );
/**
 * Echo content for page not found.
 *
 * @since @@release
 */
function fortytwo_404() {
	echo '<article class="entry"><div class="entry-content">';
	echo '<p>' . sprintf( __( 'The page you are looking for no longer exists. Perhaps you can return back to the site\'s <a href="%s">homepage</a> and see if you can find what you are looking for. Or, you can try finding it by using the search form below.', 'fortytwo' ), home_url() ) . '</p>';
	echo '<p>' . get_search_form() . '</p>';
	echo '</div></article>';
}
