<?php
/*
 * FortyTwo: Load Admin Styles
 *
 * We load admin styles that are used in widgets, settings etc.
 *
 * @since 1.0.0
 *
 */

add_action( 'admin_print_styles', 'fortytwo_load_admin_styles' );
/**
 * Enqueue FortyTwo admin styles.
 *
 * @since 1.0.0
 *
 */
function fortytwo_load_admin_styles() {

	wp_enqueue_style( 'fortytwo_admin_css', FORTYTWO_LIB_URL . "/admin/css/admin-style.css", array(), CHILD_THEME_VERSION );

}
