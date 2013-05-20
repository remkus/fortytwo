<?php
/**
 * Markup related functions
 *
 * @category Genesis
 * @package  Admin
 * @author   StudioPress
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL-2.0+
 * @link     http://www.studiopress.com/themes/genesis
 **/

/**
 * Helper function to output markup conditionally.
 *
 * If the child theme supports HTML5, then this function will output the $html5_tag. Otherwise,
 * it will output the $xhtml_tag.
 *
 * @since 1.9.0
 *
 * @param array $args Array of arguments.
 */
function genesis_markup( $args = array() ) {

	$defaults = array(
		'html5'   => '',
		'xhtml'   => '',
		'context' => '',
		'echo'    => true,
	);
	
	$args = wp_parse_args( $args, $defaults );

	//* Short circuit filter
	$pre = apply_filters( 'genesis_markup_' . $args['context'], false, $args );
	if ( false !== $pre )
		return $pre;

	if ( ! $args['html5'] || ! $args['xhtml'] )
		return '';

	//* If HTML5, return HTML5 tag. Maybe add attributes. Else XHTML.
	if ( genesis_html5() ) {
		$tag = $args['context'] ? sprintf( $args['html5'], genesis_attr( $args['context'] ) ) : $args['html5'];
	}
	else {
		$tag = $args['xhtml'];
	}

	//* Contextual filter
	$tag = $args['context'] ? apply_filters( 'genesis_markup_' . $args['context'] . '_output', $tag ) : $tag;

	if ( $args['echo'] )
		echo $tag;
	else
		return $tag;

}

/**
 * Outputs contextual attributes on markup tags.
 *
 * This function accepts a `$context` parameter, which uses a filter to received attributes to be output.
 * It's used in `genesis_markup()` but can also be used directly within a tag.
 *
 * @since 2.0.0
 *
 * @param string $context The context, used to build filter to pull attributes.
 * @param boolean $echo Conditional to determine output or return.
 * @param array $attributes optional Manually pass attributes to merge and output.
 */
function genesis_attr( $context, $args = array() ) {

	$defaults = array(
		'attributes' => array( 'class' => esc_attr( $context ) ),
		'output'     => 'string',
	);

	$args = wp_parse_args( $args, $defaults );

	//* Contextual filter
	$attributes = apply_filters( 'genesis_attr_' . $context, $args['attributes'] );

	//* If output is array, return (ignore echo)
	if ( 'array' == $args['output'] )
		return $attributes;

	$output = '';

	//* Cycle through attributes, build tag attribute string
	foreach ( $attributes as $key => $value ) {

		if ( ! $value )
			continue;

		if ( $key == $value )
			$output .= esc_html( $key ) . ' ';
		else
			$output .= sprintf( '%s="%s" ', esc_html( $key ), esc_attr( $value ) );

	}

	$output = apply_filters( 'genesis_attr_' . $context . '_output', $output, $attributes );

	//* Return
	return trim( $output );

}

add_filter( 'genesis_attr_body', 'genesis_attributes_body' );
/**
 * 
 */
function genesis_attributes_body( $attributes ) {

	$attributes =  array(
		'class'     => join( ' ', get_body_class() ),
		'itemscope' => 'itemscope',
		'itemtype'  => 'http://schema.org/WebPage',
	);

	return $attributes;

}

add_filter( 'genesis_attr_site-header', 'genesis_attributes_header' );
/**
 * 
 */
function genesis_attributes_header( $attributes ) {

	$attributes['role']      = 'banner';
	$attributes['itemscope'] = 'itemscope';
	$attributes['itemtype']  = 'http://schema.org/WPHeader';

	return $attributes;

}

add_filter( 'genesis_attr_site-title', 'genesis_attributes_site_title' );
/**
 * 
 */
function genesis_attributes_site_title( $attributes ) {

	$attributes['itemprop'] = 'headline';

	return $attributes;

}

add_filter( 'genesis_attr_site-description', 'genesis_attributes_site_description' );
/**
 * 
 */
function genesis_attributes_site_description( $attributes ) {

	$attributes['itemprop'] = 'description';

	return $attributes;

}

add_filter( 'genesis_attr_nav-primary', 'genesis_attributes_nav_primary' );
/**
 * 
 */
function genesis_attributes_nav_primary( $attributes ) {

	$attributes['role']      = 'navigation';
	$attributes['itemscope'] = 'itemscope';
	$attributes['itemtype']  = 'http://schema.org/SiteNavigationElement';

	return $attributes;

}

add_filter( 'genesis_attr_nav-secondary', 'genesis_attributes_nav_secondary' );
/**
 * 
 */
function genesis_attributes_nav_secondary( $attributes ) {

	$attributes['role']      = 'navigation';
	$attributes['itemscope'] = 'itemscope';
	$attributes['itemtype']  = 'http://schema.org/SiteNavigationElement';

	return $attributes;

}

add_filter( 'genesis_attr_content', 'genesis_attributes_content' );
/**
 * 
 */
function genesis_attributes_content( $attributes ) {

	$attributes['role']     = 'main';
	$attributes['itemprop'] = 'mainContentOfPage';

	//** Blog microdata
	if ( is_singular( 'post' ) || is_archive() || is_home() || is_page_template( 'page_blog.php' ) ) {
		$attributes['itemscope'] = 'itemscope';
		$attributes['itemtype']  = 'http://schema.org/Blog';
	}

	//* Search results pages
	if ( is_search() ) {
		$attributes['itemscope'] = 'itemscope';
		$attributes['itemtype'] = 'http://schema.org/SearchResultsPage';
	}

	return $attributes;

}

add_filter( 'genesis_attr_entry', 'genesis_attributes_entry' );
/**
 * 
 */
function genesis_attributes_entry( $attributes ) {

	$attributes['class']     = join( ' ', get_post_class() );
	$attributes['itemscope'] = 'itemscope';
	$attributes['itemtype']  = 'http://schema.org/CreativeWork';

	//* Blog post microdata
	if ( is_singular( 'post' ) || is_archive() || is_home() || is_page_template( 'page_blog.php' ) ) {
		$attributes['itemprop']  = 'blogPost';
		$attributes['itemscope'] = 'itemscope';
		$attributes['itemtype']  = 'http://schema.org/BlogPosting';
	}

	//* Page microdata
	if ( is_singular( 'page' ) ) {
		//* To do: check for About/Contact/Profile page
	}

	//* Search page entry microdata
	if ( is_search() ) {

		global $post;

		if ( 'post' == $post->post_type ) {
			$attributes['itemprop']  = 'blogPost';
			$attributes['itemscope'] = 'itemscope';
			$attributes['itemtype']  = 'http://schema.org/BlogPosting';
		}
		//* To do: check for About/Contact/Profile page

	}

	return $attributes;

}

add_filter( 'genesis_attr_entry-image', 'genesis_attributes_entry_image' );
/**
 * 
 */
function genesis_attributes_entry_image( $attributes ) {

	$attributes['class']    = 'alignleft post-image entry-image';
	$attributes['itemprop'] = 'image';

	return $attributes;

}

add_filter( 'genesis_attr_entry-image-widget', 'genesis_attributes_entry_image_widget' );
/**
 * 
 */
function genesis_attributes_entry_image_widget( $attributes ) {

	global $post;

	$attributes['class']    = 'alignleft post-image entry-image attachment-' . $post->post_type;
	$attributes['itemprop'] = 'image';

	return $attributes;

}

add_filter( 'genesis_attr_entry-image-grid-loop', 'genesis_attributes_entry_image_grid_loop' );
/**
 * 
 */
function genesis_attributes_entry_image_grid_loop( $attributes ) {

	$attributes['itemprop'] = 'image';

	return $attributes;

}

add_filter( 'genesis_attr_entry-time', 'genesis_attributes_entry_time' );
/**
 * 
 */
function genesis_attributes_entry_time( $attributes ) {

	$attributes['itemprop'] = 'datePublished';
	$attributes['datetime'] = get_the_time( 'c' );

	return $attributes;

}

add_filter( 'genesis_attr_entry-title', 'genesis_attributes_entry_title' );
/**
 * 
 */
function genesis_attributes_entry_title( $attributes ) {

	$attributes['itemprop'] = 'headline';

	return $attributes;

}

add_filter( 'genesis_attr_entry-content', 'genesis_attributes_entry_content' );
/**
 * 
 */
function genesis_attributes_entry_content( $attributes ) {

	$attributes['itemprop'] = 'text';

	return $attributes;

}

add_filter( 'genesis_attr_entry-comments', 'genesis_attributes_entry_comments' );
/**
 * 
 */
function genesis_attributes_entry_comments( $attributes ) {

	$attributes['id'] = 'comments';

	return $attributes;

}

add_filter( 'genesis_attr_comment', 'genesis_attributes_comment' );
/**
 * 
 */
function genesis_attributes_comment( $attributes ) {

	$attributes['class']     = '';
	$attributes['itemprop']  = 'comment';
	$attributes['itemscope'] = 'itemscope';
	$attributes['itemtype']  = 'http://schema.org/UserComments';

	return $attributes;

}

add_filter( 'genesis_attr_comment-author', 'genesis_attributes_comment_author' );
/**
 * 
 */
function genesis_attributes_comment_author( $attributes ) {

	$attributes['itemprop']  = 'creator';
	$attributes['itemscope'] = 'itemscope';
	$attributes['itemtype']  = 'http://schema.org/Person';

	return $attributes;

}

add_filter( 'genesis_attr_author-box', 'genesis_attributes_author_box' );
/**
 * 
 */
function genesis_attributes_author_box( $attributes ) {

	$attributes['itemprop']  = 'author';
	$attributes['itemscope'] = 'itemscope';
	$attributes['itemtype']  = 'http://schema.org/Person';

	return $attributes;

}

add_filter( 'genesis_attr_sidebar-primary', 'genesis_attributes_sidebar_primary' );
/**
 * 
 */
function genesis_attributes_sidebar_primary( $attributes ) {

	$attributes['class']     = 'sidebar sidebar-primary widget-area';
	$attributes['role']      = 'complementary';
	$attributes['itemscope'] = 'itemscope';
	$attributes['itemtype']  = 'http://schema.org/WPSideBar';

	return $attributes;

}

add_filter( 'genesis_attr_sidebar-secondary', 'genesis_attributes_sidebar_secondary' );
/**
 * 
 */
function genesis_attributes_sidebar_secondary( $attributes ) {

	$attributes['class']     = 'sidebar sidebar-secondary widget-area';
	$attributes['role']      = 'complementary';
	$attributes['itemscope'] = 'itemscope';
	$attributes['itemtype']  = 'http://schema.org/WPSideBar';

	return $attributes;

}

add_filter( 'genesis_attr_site-footer', 'genesis_attributes_site_footer' );
/**
 * 
 */
function genesis_attributes_site_footer( $attributes ) {

	$attributes['role']      = 'contentinfo';
	$attributes['itemscope'] = 'itemscope';
	$attributes['itemtype']  = 'http://schema.org/WPFooter';

	return $attributes;

}
