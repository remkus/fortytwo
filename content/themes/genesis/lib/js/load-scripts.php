<?php
/**
 * Controls the adding of scripts to the front-end and admin.
 *
 * @category Genesis
 * @package  Scripts-Styles
 * @author   StudioPress
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL-2.0+
 * @link     http://www.studiopress.com/themes/genesis
 */

add_action( 'wp_enqueue_scripts', 'genesis_load_scripts' );
/**
 * Enqueue the scripts used on the front-end of the site.
 *
 * Includes comment-reply, superfish and the superfish arguments.
 *
 * @since 0.2.0
 */
function genesis_load_scripts() {

	/** If a single post or page, threaded comments are enabled, and comments are open */
	if ( is_singular() && get_option( 'thread_comments' ) && comments_open() )
		wp_enqueue_script( 'comment-reply' );

	/** If superfish is enabled  */
	if ( apply_filters( 'genesis_superfish_enabled', false ) ) {
		$suffix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';
		wp_enqueue_script( 'superfish', GENESIS_JS_URL . "/menu/superfish$suffix.js", array( 'jquery' ), '1.4.8', true );
		wp_enqueue_script( 'superfish-args', apply_filters( 'genesis_superfish_args_uri', GENESIS_JS_URL . "/menu/superfish.args$suffix.js" ), array( 'superfish' ), PARENT_THEME_VERSION, true );
	}

}

add_action( 'wp_head', 'genesis_html5_ie_fix' );
/**
 * Load the html5 shiv for IE8 and below. Can't enqueue (with conditionals).
 *
 * @since 2.0.0
 */
function genesis_html5_ie_fix() {

	if ( ! current_theme_supports( 'genesis-html5' ) )
		return;

	echo '<!--[if lt IE 9]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->' . "\n";

}

add_action( 'admin_enqueue_scripts', 'genesis_load_admin_scripts' );
/**
 * Conditionally enqueues the scripts used in the admin.
 *
 * Includes Thickbox, theme preview and a Genesis script (actually enqueued
 * in genesis_load_admin_js()).
 *
 * @since 0.2.3
 *
 * @uses genesis_load_admin_js()
 * @uses genesis_is_menu_page()
 * @uses genesis_update_check()
 * @uses genesis_seo_disabled()
 *
 * @global WP_Post $post Post object.
 *
 * @param string $hook_suffix Admin page identifier.
 */
function genesis_load_admin_scripts( $hook_suffix ) {

	/** Only add thickbox/preview if there is an update to Genesis available */
	if ( genesis_update_check() ) {
		add_thickbox();
		wp_enqueue_script( 'theme-preview' );
		genesis_load_admin_js();
	}

	/** If we're on a Genesis admin screen */
	if ( genesis_is_menu_page( 'genesis' ) || genesis_is_menu_page( 'seo-settings' ) || genesis_is_menu_page( 'design-settings' ) )
		genesis_load_admin_js();

	global $post;

	/** If we're viewing an edit post page, make sure we need Genesis SEO JS */
	if ( 'post-new.php' == $hook_suffix || 'post.php' == $hook_suffix ) {
		if ( ! genesis_seo_disabled() && post_type_supports( $post->post_type, 'genesis-seo' ) )
			genesis_load_admin_js();
	}

}

/**
 * Enqueues the custom script used in the admin, and localizes several strings or
 * values used in the scripts.
 *
 * @since 1.8.0
 */
function genesis_load_admin_js() {

	$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
	wp_enqueue_script( 'genesis_admin_js', GENESIS_JS_URL . "/admin$suffix.js", array( 'jquery' ), PARENT_THEME_VERSION, true );

	$strings = array(
		'categoryChecklistToggle' => __( 'Select / Deselect All', 'genesis' ),
		'saveAlert'               => __('The changes you made will be lost if you navigate away from this page.', 'genesis'),
		'confirmUpgrade'          => __( 'Updating Genesis will overwrite the current installed version of Genesis. Are you sure you want to update?. "Cancel" to stop, "OK" to update.', 'genesis' ),
		'confirmReset'            => __( 'Are you sure you want to reset?', 'genesis' ),
	);

	wp_localize_script( 'genesis_admin_js', 'genesisL10n', $strings );

	$toggles = array(
		// Checkboxes - when checked, show extra settings
		'update'                    => array( '#genesis-settings\\[update\\]', '#genesis_update_notification_setting', '_checked' ),
		'content_archive_thumbnail' => array( '#genesis-settings\\[content_archive_thumbnail\\]', '#genesis_image_size', '_checked' ),
		// Checkboxed - when unchecked, show extra settings
		'semantic_headings'         => array( '#genesis-seo-settings\\[semantic_headings\\]', '#genesis_seo_h1_wrap', '_unchecked' ),
		// Select toggles
		'nav_extras'                => array( '#genesis-settings\\[nav_extras\\]', '#genesis_nav_extras_twitter', 'twitter' ),
		'content_archive'           => array( '#genesis-settings\\[content_archive\\]', '#genesis_content_limit_setting', 'full' ),

	);

	wp_localize_script( 'genesis_admin_js', 'genesis_toggles', apply_filters( 'genesis_toggles', $toggles ) );

}
