<?php
/** Start the engine */
require_once TEMPLATEPATH . '/lib/init.php';

/** Localization */
load_child_theme_textdomain( 'fortytwo', get_stylesheet_directory() . '/lib/languages' );

/** Add FortyTwo Turbos */
require_once 'config/initializers/init.php';

/**
 * Activates FortyTwo theme features.
 */
add_theme_support( 'html5' );
add_theme_support( 'genesis-responsive-viewport' );

/** Customize the default footer */
remove_action( 'genesis_footer', 'genesis_do_footer' );

add_action( 'genesis_footer', 'fortytwo_custom_footer' );

function fortytwo_custom_footer() {

	$footer_output = <<<EOD
		<div class="copyright-area">
			<span>&copy; Copyright 2012 <a href="http://mydomain.com/">My Domain</a> &middot; All Rights Reserved &middot; Powered by <a href="http://wordpress.org/">WordPress</a> &middot; <a href="http://mydomain.com/wp-admin">Admin</a></span>
		</div>
EOD;

	echo $footer_output;

}
