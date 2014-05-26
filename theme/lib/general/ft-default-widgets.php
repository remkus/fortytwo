<?php
/**
 * FortyTwo Theme
 *
 * @package FortyTwo
 * @author  Forsite Themes
 * @license GPL-2.0+
 * @link    http://forsitethemes/themes/fortytwo/
 */

add_filter( 'get_archives_link', 'fortytwo_modify_archives_link' );
/**
 * Change the structure of the archive link.
 *
 * @since @@release
 *
 * @param string $link_html Existing link markup.
 *
 * @return string Amended link markup.
 */
function fortytwo_modify_archives_link( $link_html ) {
	preg_match( "/href='(.+?)'/", $link_html, $url );
	preg_match( '/\<\/a\>&nbsp;\((\d+)\)/', $link_html, $post_count );

	$requested = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];

	if ( ! empty( $url ) && strtolower( $requested ) == strtolower( $url[1] ) ) {
		$link_html = str_replace( '<li>', '<li class="current-list-item">', $link_html );
	}

	if ( ! empty( $post_count ) ) {
		$link_html = str_replace( $post_count[0], '<span class="badge">' . $post_count[1] . '</span></a>', $link_html );
	}

	return $link_html;
}

/**
 * Modify HTML list of categories.
 *
 * @package FortyTwo
 * @author  Forsite Themes
 *
 * @since @@release
 */
class FortyTwo_Walker_Category extends Walker_Category {
	/**
	 * Start the element output.
	 *
	 * @see Walker::start_el()
	 *
	 * @since @@release
	 *
	 * @param string $output   Passed by reference. Used to append additional content.
	 * @param object $category Category data object.
	 * @param int    $depth    Depth of category in reference to parents. Default 0.
	 * @param array  $args     An array of arguments {@see wp_list_categories()}.
	 * @param int    $id       ID of the current category.
	 */
	function start_el( &$output, $category, $depth = 0, $args = array(), $id = 0 ) {
		/** This filter is documented in wp-includes/category-template.php */
		$cat_name = apply_filters(
			'list_cats',
			esc_attr( $category->name ),
			$category
		);

		$link = '<a href="' . esc_url( get_term_link( $category ) ) . '" ';
		if ( $args['use_desc_for_title'] == 0 || empty( $category->description ) ) {
			$link .= '';
		} else {
			/** This filter is documented in wp-includes/category-template.php */
			$link .= 'title="' . esc_attr( strip_tags( apply_filters( 'category_description', $category->description, $category ) ) ) . '"';
		}

		$link .= '>';
		$link .= $cat_name;
		if ( ! empty( $args['show_count'] ) ) {
			$link .= '<span class="badge">' . intval( $category->count ) . '</span>';
		}
		$link .= '</a>';

		if ( ! empty( $args['feed_image'] ) || ! empty( $args['feed'] ) ) {
			$link .= ' ';

			if ( empty( $args['feed_image'] ) ) {
				$link .= '(';
			}

			$link .= '<a href="' . esc_url( get_term_feed_link( $category->term_id, $category->taxonomy, $args['feed_type'] ) ) . '"';

			if ( empty( $args['feed'] ) ) {
				$alt = ' alt="' . esc_attr( sprintf( __( 'Feed for all posts filed under %s', 'fortytwo' ), $cat_name ) ) . '"';
			} else {
				$alt = ' alt="' . esc_attr( $args['feed'] ) . '"';
				$name = $args['feed'];
				$link .= empty( $args['title'] ) ? '' : $args['title'];
			}

			$link .= '>';

			if ( empty( $args['feed_image'] ) ) {
				$link .= $name;
			} else {
				$link .= "<img src='" . esc_url( $args['feed_image'] ) . "'$alt" . ' />';
			}
			$link .= '</a>';

			if ( empty( $args['feed_image'] ) ) {
				$link .= ')';
			}
		}

		if ( 'list' == $args['style'] ) {
			$output .= "\t<li";
			$class = 'cat-item cat-item-' . $category->term_id;
			if ( ! empty( $args['current_category'] ) ) {
				$_current_category = get_term( $args['current_category'], $category->taxonomy );
				if ( $category->term_id == $args['current_category'] ) {
					$class .=  ' current-cat';
				} elseif ( $category->term_id == $_current_category->parent ) {
					$class .=  ' current-cat-parent';
				}
			}
			$output .=  ' class="' . $class . '"';
			$output .= ">$link\n";
		} else {
			$output .= "\t$link<br />\n";
		}
	}
}

add_filter( 'widget_categories_args', 'fortytwo_modify_widget_categories_args', 10, 1 );
/**
 * Change widget_categories_args to use the FortyTwo custom walker.
 *
 * @since @@release
 *
 * @param array $cat_args Existing categories widget arguments.
 *
 * @return array Amended categories widget arguments.
 */
function fortytwo_modify_widget_categories_args( $cat_args ) {
	$cat_args['walker'] = new FortyTwo_Walker_Category();

	return $cat_args;
}

add_filter( 'get_search_form', 'fortytwo_search_form' );
/**
 * Modify default search form.
 *
 * @since @@release
 *
 * @param string $form Existing form markup.
 *
 * @return string Amended form markup.
 */
function fortytwo_search_form( $form ) {
	$form_action = home_url( '/' );
	// get the search query
	$search_query = get_search_query();

	$form = <<<EOD
        <form method="get" id="searchform" class="search-form" action="{$form_action}" role="search">
            <input type="text" value="{$search_query}" class="search-text" name="s" id="s" />
            <span class="search-button">
                <button class="btn" type="submit">Search</button>
            </span>
        </form>
EOD;

	return $form;
}

add_filter( 'widget_tag_cloud_args', 'fortytwo_tag_cloud_list_format' );
/**
 * Modify default tag cloud to display as a list.
 *
 * @since @@release
 *
 * @param array $args Existing tag cloud arguments.
 *
 * @return array Amended tag cloud arguments.
 */
function fortytwo_tag_cloud_list_format( $args ) {
	$defaults = array(
		'format'   => 'list',
		'unit'     => '%',
		'smallest' => 100,
		'largest'  => 100,
	);

	$args = wp_parse_args( $args, $defaults );

	return $args;
}
