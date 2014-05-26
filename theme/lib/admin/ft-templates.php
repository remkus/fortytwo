<?php
/**
 * FortyTwo Theme
 *
 * @package FortyTwo
 * @author  Forsite Themes
 * @license GPL-2.0+
 * @link    http://forsitethemes/themes/fortytwo/
 */

add_filter( 'theme_page_templates', 'ft_remove_page_templates' );
/**
 * Remove archive and blog page templates inherited from Genesis.
 *
 * This hides them from the Page Template dropdowns.
 *
 * @since @@release
 *
 * @param array $templates Existing templates filenames.
 *
 * @return array Amended template filenames.
 */
function ft_remove_page_templates( $templates ) {
	unset( $templates['page_blog.php'] );
	unset( $templates['page_archive.php'] );

	return $templates;
}
