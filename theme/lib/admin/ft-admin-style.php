<?php
/**
 * FortyTwo Theme
 *
 * @package FortyTwo
 * @author  Forsite Themes
 * @license GPL-2.0+
 * @link    http://forsitethemes/themes/fortytwo/
 */

add_action( 'admin_enqueue_scripts', 'fortytwo_enqueue_admin_styles' );
/**
 * Enqueue FortyTwo admin styles.
 *
 * @since @@release
 */
function fortytwo_enqueue_admin_styles() {
	wp_enqueue_style( 'fortytwo_admin_css', FORTYTWO_URL . '/admin-style.css', array(), CHILD_THEME_VERSION );
}
