<?php

/**
 * FortyTwo Theme: Load Admin Styles
 *
 * We load admin styles that are used in widgets, settings etc.
 *
 * @package FortyTwo\Admin
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

	wp_enqueue_style( 'fortytwo_admin_css', FORTYTWO_LIB_URL . '/admin/admin-style.css', array(), CHILD_THEME_VERSION );

}
