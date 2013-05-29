<?php
/**
 * Genesis Framework.
 *
 * WARNING: This file is part of the core Genesis framework. DO NOT edit this file under any circumstances.
 * Please do all modifications in the form of a child theme.
 *
 * @package Genesis\General
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/genesis/
 */

/**
 * Helper function for plugins to determine if Genesis is active and meets version requirements.
 *
 * @since 2.0.0
 *
 * @param string $version Optional. The minimum version to check against.
 *
 * @return boolean True if requirements met, false otherwise.
 */
function genesis_is_active( $version = PARENT_THEME_VERSION ) {

	return version_compare( PARENT_THEME_VERSION, (string) $version, '>=' );

}

/**
 * Helper function to enable the author box for ALL users.
 *
 * @since 1.4.1
 *
 * @param array $args Optional. Arguments for enabling author box. Default is
 * empty array
 */
function genesis_enable_author_box( $args = array() ) {

	$args = wp_parse_args( $args, array( 'type' => 'single' ) );

	if ( 'single' === $args['type'] )
		add_filter( 'get_the_author_genesis_author_box_single', '__return_true' );
	elseif ( 'archive' === $args['type'] )
		add_filter( 'get_the_author_genesis_author_box_archive', '__return_true' );

}

/**
 * Redirects the user to an admin page, and adds query args to the URL string
 * for alerts, etc.
 *
 * @since 1.6.0
 *
 * @param string $page Menu slug
 * @param array $query_args Optional. Associative array of query string
 * arguments (key => value). Default is an empty array
 * @return null Returns early if first argument is falsy
 */
function genesis_admin_redirect( $page, array $query_args = array() ) {

	if ( ! $page )
		return;

	$url = html_entity_decode( menu_page_url( $page, 0 ) );

	foreach ( (array) $query_args as $key => $value ) {
		if ( empty( $key ) && empty( $value ) ) {
			unset( $query_args[$key] );
		}
	}

	$url = add_query_arg( $query_args, $url );

	wp_redirect( esc_url_raw( $url ) );

}

/**
 * Return a specific value from the associative array passed as the second argument to <code>add_theme_support()</code>
 *
 * @param string $feature The theme feature.
 * @param string $arg The theme feature argument.
 * @param string $default Fallback if value is blank or doesn't exist.
 * @return mixed Returns $default if theme doesn't support $feature or $arg key doesn't exist.
 */
function genesis_get_theme_support_arg( $feature, $arg, $default = '' ) {

	$support = get_theme_support( $feature );

	if ( ! $support || ! isset( $support[0] ) || ! array_key_exists( $arg, (array) $support[0] ) )
		return $default;

	return $support[0][ $arg ];

}

/**
 * Detect plugin by constant, class or function existence.
 *
 * @since 1.6.0
 *
 * @param array $plugins Array of array for constants, classes and / or
 * functions to check for plugin existence.
 * @return boolean True if plugin exists or false if plugin constant, class or
 * function not detected.
 */
function genesis_detect_plugin( array $plugins ) {

	/** Check for classes */
	if ( isset( $plugins['classes'] ) ) {
		foreach ( $plugins['classes'] as $name ) {
			if ( class_exists( $name ) )
				return true;
		}
	}

	/** Check for functions */
	if ( isset( $plugins['functions'] ) ) {
		foreach ( $plugins['functions'] as $name ) {
			if ( function_exists( $name ) )
				return true;
		}
	}

	/** Check for constants */
	if ( isset( $plugins['constants'] ) ) {
		foreach ( $plugins['constants'] as $name ) {
			if ( defined( $name ) )
				return true;
		}
	}

	/** No class, function or constant found to exist */
	return false;

}

/**
 * Helper function used to check that we're targeting a specific Genesis admin page.
 *
 * The $pagehook argument is expected to be one of 'genesis', 'seo-settings' or
 * 'genesis-import-export' although others can be accepted.
 *
 * @since 1.8.0
 *
 * @global string $page_hook Page hook for current page
 * @param string $pagehook Page hook string to check
 * @return boolean Returns true if the global $page_hook matches given $pagehook. False otherwise
 */
function genesis_is_menu_page( $pagehook = '' ) {

	global $page_hook;

	if ( isset( $page_hook ) && $page_hook == $pagehook )
		return true;

	/* May be too early for $page_hook */
	if ( isset( $_REQUEST['page'] ) && $_REQUEST['page'] == $pagehook )
		return true;

	return false;

}

/**
 * Helper function to check whether we are currently viewing the site via the WordPress Customizer.
 *
 * @since 2.0.0
 *
 * @global $wp_customize
 * @return boolean Returns true if viewing page via Customizer, false otherwise.
 */
function genesis_is_customizer() {

	global $wp_customize;

	if ( isset( $wp_customize ) )
		return true;

	return false;

}

/**
 * Get the post_type from the global $post if supplied value is empty.
 *
 * @since 2.0.0
 *
 * @global WP_Post $post Post object.
 *
 * @param string $post_type_name Post type name.
 *
 * @return string
 */
function genesis_get_global_post_type_name( $post_type_name = '' ) {
	if ( ! $post_type_name ) {
		global $post;
		$post_type_name = $post->post_type;
	}
	return $post_type_name;
}

/**
 * Get list of custom post types which need an archive settings page.
 *
 * * Archive settings pages are added for CPTs that:
 *
 * * are public,
 * * are set to show the UI,
 * * have an archive enabled,
 * * support "genesis-cpt-archive-settings".
 *
 * This last item means that if you're using an archive template and don't want
 * Genesis interfering with it with these archive settings, then don't add the
 * support.
 *
 * The results are held in a static variable, since they won't change over the course of a request.
 *
 * @since 2.0.0
 *
 * @return array
 */
function genesis_get_cpt_archive_types() {
	static $genesis_cpt_archive_types;
	if ( $genesis_cpt_archive_types )
		return $genesis_cpt_archive_types;

	$args = apply_filters(
		'genesis_cpt_archives_args',
		array(
			'public'       => true,
			'show_ui'      => true,
			'show_in_menu' => true,
			'has_archive'  => true,
			'_builtin'     => false,
		)
	);

	$genesis_cpt_archive_types = get_post_types( $args, 'objects' );

	return $genesis_cpt_archive_types;
}

/**
 * Get list of custom post type names which need archive settings pages.
 *
 * @since 2.0.0
 *
 * @uses genesis_get_cpt_archive_types()
 *
 * @return array
 */
function genesis_get_cpt_archive_types_names() {
	foreach ( genesis_get_cpt_archive_types() as $post_type )
		$post_type_names[] = $post_type->name;

	return $post_type_names;
}

/**
 * Check if a post type should potentially support an archive setting page.
 *
 * @since 2.0.0
 *
 * @uses genesis_get_global_post_type_name()
 * @uses genesis_get_cpt_archive_types_names()
 *
 * @param string $post_type_name Post type name.
 *
 * @return bool
 */
function genesis_has_post_type_archive_support( $post_type_name = '' ) {
	$post_type_name = genesis_get_global_post_type_name( $post_type_name );

	return in_array( $post_type_name, genesis_get_cpt_archive_types_names() ) &&
		post_type_supports( $post_type_name, 'genesis-cpt-archives-settings' );
}

/**
 * Helper function to determine if HTML5 is activated by the child theme.
 *
 * @since 2.0.0
 *
 * @return bool Whether current child theme supports genesis-html5.
 */
function genesis_html5() {
	return current_theme_supports( 'genesis-html5' );
}

/**
 * Build links to install plugins.
 *
 * @since 2.0.0
 *
 * @param string $plugin_slug Plugin slug.
 * @param string $text        Plugin name.
 *
 * @return string              HTML markup for links.
 */
function genesis_plugin_install_link( $plugin_slug = '', $text = '' ) {

	if ( is_main_site() ) {
		$url = network_admin_url( 'plugin-install.php?tab=plugin-information&plugin=' . $plugin_slug . '&TB_iframe=true&width=600&height=550' );
	}
	else {
		$url = admin_url( 'plugin-install.php?tab=plugin-information&plugin=' . $plugin_slug . '&TB_iframe=true&width=600&height=550' );
	}

	$title_text = sprintf( __( 'Install %s', 'genesis' ), $text );

	return sprintf( '<a href="%s" class="thickbox" title="%s">%s</a>', esc_url( $url ), esc_attr( $title_text ), esc_html( $text ) );

}

/**
 * A list of Genesis contributors for the current development cycle.
 *
 * @since 2.0.0
 *
 * @return array List of contributors.
 */
function genesis_contributors() {

	return array(
		array(
			'name'     => 'Jared Atchison',
			'url'      => 'http://twitter.com/jaredatch',
			'gravatar' => 'http://0.gravatar.com/avatar/e341eca9e1a85dcae7127044301b4363?s=60',
		),
		array(
			'name'     => 'Chris Cochran',
			'url'      => 'http://twitter.com/tweetsfromchris',
			'gravatar' => 'http://0.gravatar.com/avatar/aa0bea067ea6bfb854387d73f595aa1c?s=60',
		),
		array(
			'name'     => 'Nick Croft',
			'url'      => 'http://twitter.com/nick_thegeek',
			'gravatar' => 'http://0.gravatar.com/avatar/3241d4eab93215b5487e162b87569e42?s=60',
		),
		array(
			'name'     => 'David Decker',
			'url'      => 'http://twitter.com/deckerweb',
			'gravatar' => 'http://0.gravatar.com/avatar/28d02f8d09fc32fccc0282efdc23a4e5?s=60',
		),
		array(
			'name'     => 'Bill Erickson',
			'url'      => 'http://twitter.com/billerickson',
			'gravatar' => 'http://0.gravatar.com/avatar/ae510affa31e5b946623bda4ff969b67?s=60',
		),
		array(
			'name'     => 'Thomas Griffin',
			'url'      => 'http://twitter.com/jthomasgriffin',
			'gravatar' => 'http://0.gravatar.com/avatar/fe4225114bfd1f8993c6d20d32227537?s=60',
		),
		array(
			'name'     => 'Gary Jones',
			'url'      => 'http://twitter.com/garyj',
			'gravatar' => 'http://0.gravatar.com/avatar/e70d4086e89c2e1e081870865be68485?s=60',
		),
		array(
			'name'     => 'Andrew Norcross',
			'url'      => 'http://twitter.com/norcross',
			'gravatar' => 'http://0.gravatar.com/avatar/26ab8f9b2c86b10e7968b882403b3bf8?s=60',
		),
		array(
			'name'     => 'Greg Rickaby',
			'url'      => 'http://twitter.com/GregRickaby',
			'gravatar' => 'http://0.gravatar.com/avatar/28af3e39c0a1fe4c31367c7e9a8bcac3?s=60',
		),
		array(
			'name'     => 'Rafal Tomal',
			'url'      => 'http://twitter.com/rafaltomal',
			'gravatar' => 'http://0.gravatar.com/avatar/c9f7b936cd19bd5aba8831ddea21f05d?s=60',
		),
		array(
			'name'     => 'Travis Smith',
			'url'      => 'http://twitter.com/wp_smith',
			'gravatar' => 'http://0.gravatar.com/avatar/7e673cdf99e6d7448f3cbaf1424c999c?s=60',
		),
		array(
			'name'     => 'Ade Walker',
			'url'      => 'http://www.studiograsshopper.ch/',
			'gravatar' => 'http://0.gravatar.com/avatar/0256aea37448743404a04ff8f254989b?s=60',
		),
	);

}
