<?php
/**
 * FortyTwo Theme
 *
 * @package FortyTwo
 * @author  Forsite Themes
 * @license GPL-2.0+
 * @link    http://forsitethemes/themes/fortytwo/
 */

add_action( 'admin_print_styles', 'fortytwo_load_admin_styles' );
/**
 * Enqueue FortyTwo admin styles.
 *
 * @since 1.0.0
 *
 */
function fortytwo_load_admin_styles() {

	wp_enqueue_style( 'fortytwo_admin_css', CHILD_URL . '/admin-style.css', array(), CHILD_THEME_VERSION );

}
