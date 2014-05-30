<?php

require_once getenv( 'WP_TESTS_DIR' ) . '/includes/functions.php';

if ( version_compare( phpversion(), '5.3.0', '<' ) ) {
	die( 'FortyTwo Unit Tests require PHP 5.3 or higher.' );
}

define( 'THIS_THEME_DIR', basename( dirname( dirname( __FILE__ ) ) ) );

function _fortytwo_manually_load_theme() {
	register_theme_directory( dirname( dirname( dirname( __FILE__ ) ) ) );
	add_filter( 'stylesheet', '_fortytwo_override_stylesheet' );
	add_filter( 'template', '_fortytwo_override_template' );
}

function _fortytwo_override_stylesheet( $stylesheet ) {
	return wp_get_theme( THIS_THEME_DIR )->get_stylesheet();
}

function _fortytwo_override_template( $template ) {
	return wp_get_theme( THIS_THEME_DIR )->get_template();
}

tests_add_filter( 'setup_theme', '_fortytwo_manually_load_theme' );

require getenv( 'WP_TESTS_DIR' ) . '/includes/bootstrap.php';

class FortyTwo_TestCase extends WP_UnitTestCase {
	protected function set_post( $key, $value ) {
		$_POST[$key] = $_REQUEST[$key] = addslashes( $value );
	}

	protected function unset_post( $key ) {
		unset( $_POST[$key], $_REQUEST[$key] );
	}

	protected function assertContainsClass( $class, $string ) {
		$this->assertRegExp( '#class=([\'"])[^\\1]*' . $class . '[^\\1]*\\1#', $string );
	}

	protected function html( $html5_callback, $xhtml_callback ) {
		// First, test HTML5 mode
		add_theme_support( 'html5' );
		call_user_func( $html5_callback );
		// Now, test XHTML mode
		remove_theme_support( 'html5' );
		call_user_func( $xhtml_callback );
		// And leave it in HTML5 mode
		add_theme_support( 'html5' );
	}
}
