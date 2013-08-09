<?php
/*
 * FortyTwo Initializer File
 */

/* Child theme (do not remove) */
define( 'CHILD_THEME_NAME', 'FortyTwo Theme' );
define( 'CHILD_THEME_URL', 'http://forsitethemes.com/themes/fortytwo' );
define( 'CHILD_THEME_VERSION', filemtime( get_stylesheet_directory() . '/style.css' ) );

define( 'FORTYTWO_DIR', CHILD_DIR );
define( 'FORTYTWO_URL', CHILD_URL );

define( 'FORTYTWO_LIB_DIR', CHILD_DIR . '/lib' );
define( 'FORTYTWO_LIB_URL', CHILD_URL . '/lib' );
define( 'FORTYTWO_WIDGETS_DIR', FORTYTWO_LIB_DIR . '/widgets' );
define( 'FORTYTWO_WIDGETS_URL', FORTYTWO_LIB_URL . '/widgets' );

/* Load Initializer Components */
require_once 'ft-cleanup.php';

require_once 'ft-scripts.php';

require_once 'ft-structual.php';

require_once 'ft-nav.php';

require_once 'ft-page-title.php';

require_once 'ft-default-widgets.php';

require_once 'ft-slider.php';

require_once 'ft-page-blog.php';

//Require all theme widgets
require_once FORTYTWO_WIDGETS_DIR . '/ft-responsive-slider/widget.php';
require_once FORTYTWO_WIDGETS_DIR . '/ft-featured-page/widget.php';
require_once FORTYTWO_WIDGETS_DIR . '/ft-jumbotron/widget.php';
require_once FORTYTWO_WIDGETS_DIR . '/ft-testimonials/widget.php';
require_once FORTYTWO_WIDGETS_DIR . '/ft-tabs-widget/widget.php';
require_once FORTYTWO_WIDGETS_DIR . '/ft-contact/widget.php';

//Require once to include WPThumb
require_once CHILD_DIR . '/vendor/wpthumb/wpthumb.php';
