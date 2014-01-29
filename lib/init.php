<?php
/**
 * FortyTwo Initializer File
 *
 * @todo  This code needs better documentation
 *
 */

/* Child theme (do not remove) */
define( 'CHILD_THEME_NAME', 'FortyTwo Theme' );
define( 'CHILD_THEME_URL', 'http://forsitethemes.com/themes/fortytwo' );
define( 'CHILD_THEME_VERSION', '1.0.0-RC4' );

define( 'FORTYTWO_DIR', CHILD_DIR );
define( 'FORTYTWO_URL', CHILD_URL );

define( 'FORTYTWO_LIB_DIR', CHILD_DIR . '/lib' );
define( 'FORTYTWO_LIB_URL', CHILD_URL . '/lib' );

define( 'FORTYTWO_WIDGETS_DIR', FORTYTWO_LIB_DIR . '/widgets' );
define( 'FORTYTWO_WIDGETS_URL', FORTYTWO_LIB_URL . '/widgets' );

/* Load Initializer Components */
require_once 'admin/ft-admin-style.php';
require_once 'admin/ft-layouts.php';

require_once 'general/ft-scripts.php';
require_once 'general/ft-widget-areas.php';
require_once 'general/ft-default-widgets.php';

require_once 'structural/ft-structural.php';
require_once 'structural/ft-nav.php';
require_once 'structural/ft-subheader.php';
require_once 'structural/ft-footer.php';


//Require all theme widgets
require_once FORTYTWO_WIDGETS_DIR . '/ft-responsive-slider/widget.php';
require_once FORTYTWO_WIDGETS_DIR . '/ft-featured-content/widget.php';
require_once FORTYTWO_WIDGETS_DIR . '/ft-jumbotron/widget.php';
require_once FORTYTWO_WIDGETS_DIR . '/ft-testimonials/widget.php';
require_once FORTYTWO_WIDGETS_DIR . '/ft-tabs-widget/widget.php';
require_once FORTYTWO_WIDGETS_DIR . '/ft-contact/widget.php';

//Require once to include WPThumb
require_once CHILD_DIR . '/vendor/wpthumb/wpthumb.php';
