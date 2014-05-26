<?php
/**
 * FortyTwo Theme
 *
 * This file fires the whole FortyTwo Theme. The answer to the answer.
 *
 * @package FortyTwo\Widgets
 * @author  Forsite Themes
 * @license GPL-2.0+
 * @link    http://forsitethemes/themes/fortytwo/
 */

define( 'CHILD_THEME_NAME', 'FortyTwo Theme' );
define( 'CHILD_THEME_URL', 'http://forsitethemes.com/themes/fortytwo' );
define( 'CHILD_THEME_VERSION', '0.8.0' );

define( 'FORTYTWO_DIR', get_stylesheet_directory() );
define( 'FORTYTWO_URL', get_stylesheet_directory_uri() );

define( 'FORTYTWO_LIB_DIR', FORTYTWO_DIR . '/lib' );
define( 'FORTYTWO_LIB_URL', FORTYTWO_URL . '/lib' );

define( 'FORTYTWO_WIDGETS_DIR', FORTYTWO_LIB_DIR . '/widgets' );
define( 'FORTYTWO_WIDGETS_URL', FORTYTWO_LIB_URL . '/widgets' );

// Load components
require_once 'admin/ft-admin-style.php';
require_once 'admin/ft-layouts.php';
require_once 'admin/ft-templates.php';

require_once 'general/ft-default-widgets.php';
require_once 'general/ft-enqueue.php';
require_once 'general/ft-widget-areas.php';

require_once 'structural/ft-structural.php';
require_once 'structural/ft-post.php';
require_once 'structural/ft-nav.php';
require_once 'structural/ft-subheader.php';
require_once 'structural/ft-footer.php';

add_action( 'widgets_init', 'ft_widgets_require', 5 );
/**
 * Require theme widget files.
 *
 * @since @@release
 *
 * @return null Return early if no theme widgets supported.
 */
function ft_widgets_require() {
	if ( ! $widgets = get_theme_support( 'fortytwo-widgets' ) ) {
		return;
	}

	require_once FORTYTWO_WIDGETS_DIR . '/ft-widget.php';

	foreach ( $widgets[0] as $widget ) {
		$file = trailingslashit( FORTYTWO_WIDGETS_DIR ) . $widget . '/widget.php';
		if ( is_readable( $file ) ) {
			require_once $file;
		}
	}

	if ( current_theme_supports( 'fortytwo-widgets', 'ft-responsive-slider' ) ) {
		require_once FORTYTWO_LIB_DIR . '/wpthumb/wpthumb.php';
	}
}
