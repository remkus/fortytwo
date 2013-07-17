<?php
/*
 * FotyTwo: Default Widgets
 *
 * This file modifies the WordPress default widgets to allow for our Bootstrap type
 * styling
 *
 * @since 1.0.0
 *
 */

add_filter( 'get_archives_link', 'fortytwo_modify_archives_link' );
/**
 * Filter to change the structure of the archive link
 *
 * @package FortyTwo
 * @since 1.0.0
 **/
function fortytwo_modify_archives_link( $link_html ) {

    preg_match ( "/href='(.+?)'/", $link_html, $url );
    preg_match ( "/\<\/a\>&nbsp;\((\d+)\)/", $link_html, $post_count );

    $requested = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];

    if ( ! empty( $url ) && strtolower( $requested ) == strtolower( $url[1] ) ) {
        $link_html = str_replace( '<li>', '<li class="current-list-item">', $link_html );
    }

    if ( ! empty( $post_count ) ) {
        $link_html = str_replace( $post_count[0], '<span class="badge">' . $post_count[1] . '</span></a>', $link_html );
    }

    $link_html = str_replace( '</a>', '</a><span class="icon icon-angle-right"></span>', $link_html );

    return $link_html;

}

/**
 * Modify HTML list of categories.
 *
 * @package FortyTwo
 * @since 1.0.0
 * @uses Walker_Category
 */
class FortyTwo_Walker_Category extends Walker_Category {

	function start_el( &$output, $category, $depth = 0, $args = array(), $id = 0 ) {
		extract($args);

		$cat_name = esc_attr( $category->name );
		$cat_name = apply_filters( 'list_cats', $cat_name, $category );
		$link = '<a href="' . esc_url( get_term_link($category) ) . '" ';
		if ( $use_desc_for_title == 0 || empty($category->description) )
			$link .= 'title="' . esc_attr( sprintf(__( 'View all posts filed under %s' ), $cat_name) ) . '"';
		else
			$link .= 'title="' . esc_attr( strip_tags( apply_filters( 'category_description', $category->description, $category ) ) ) . '"';
		$link .= '>';
		$link .= $cat_name;

        if ( !empty($show_count) )
            $link .= '<span class="badge">' . intval($category->count) . '</span>';

        $link .= '</a>';

        $link .= '<span class="icon icon-angle-right"></span>';

		if ( !empty($feed_image) || !empty($feed) ) {
			$link .= ' ';

			if ( empty($feed_image) )
				$link .= '(';

			$link .= '<a href="' . esc_url( get_term_feed_link( $category->term_id, $category->taxonomy, $feed_type ) ) . '"';

			if ( empty($feed) ) {
				$alt = ' alt="' . sprintf(__( 'Feed for all posts filed under %s' ), $cat_name ) . '"';
			} else {
				$title = ' title="' . $feed . '"';
				$alt = ' alt="' . $feed . '"';
				$name = $feed;
				$link .= $title;
			}

			$link .= '>';

			if ( empty($feed_image) )
				$link .= $name;
			else
				$link .= "<img src='$feed_image'$alt$title" . ' />';

			$link .= '</a>';

			if ( empty($feed_image) )
				$link .= ')';
		}

		if ( 'list' == $args['style'] ) {
			$output .= "\t<li";
			$class = 'cat-item cat-item-' . $category->term_id;
			if ( !empty($current_category) ) {
				$_current_category = get_term( $current_category, $category->taxonomy );
				if ( $category->term_id == $current_category )
					$class .=  ' current-cat';
				elseif ( $category->term_id == $_current_category->parent )
					$class .=  ' current-cat-parent';
			}
			$output .=  ' class="' . $class . '"';
			$output .= ">$link\n";
		} else {
			$output .= "\t$link<br />\n";
		}
	}

}

add_filter( 'widget_categories_args', 'fortytwo_modify_categories_walker_arg', 10, 1 );
/**
 * Filter to change wp_categories_list args to add our own walker
 *
 **/
function fortytwo_modify_categories_walker_arg( $cat_args ) {

    $FortyTwo_Walker_Category = new FortyTwo_Walker_Category();

    $cat_args['walker'] = $FortyTwo_Walker_Category;

    return $cat_args;

}