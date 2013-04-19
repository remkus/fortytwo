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
 * it will output the xHTML tag.
 *
 * @since 1.9.0
 *
 * @param string $html5_tag Markup to output if HTML5 is supported.
 * @param string $xhtml_tag Markup to output if HTML5 is not supported.
 * @param boolean $echo Conditional to determine output or return.
 */
function genesis_markup( array $args = array() ) {

	$defaults = array(
		'html5'   => '',
		'xhtml'   => '',
		'context' => '',
		'echo'    => true,
	);
	
	$args = wp_parse_args( $args, $defaults );

	//* Short circuit filter
	$pre = apply_filters( 'genesis_markup', false, $args );
	if ( false !== $pre )
		return $pre;

	if ( ! $args['html5'] || ! $args['xhtml'] )
		return;

	//* If HTML5, return HTML5 tag. Maybe add attributes. Else XHTML.
	if ( genesis_html5() ) {
		$tag = $args['context'] ? sprintf( $args['html5'], genesis_attr( $args['context'] ) ) : $args['html5'];
	}
	else {
		$tag = $args['xhtml'];
	}

	//* Contextual filter
	$tag = $args['context'] ? apply_filters( 'genesis_markup_' . $args['context'], $tag ) : $tag;

	if ( $args['echo'] )
		echo $tag;
	else
		return $tag;

}

function genesis_attr( $context, $echo = false ) {

	//* Use context as class by default
	$attributes = array(
		'class' => esc_attr( $context ),
	);

	//* Contextual filter
	$attributes = apply_filters( 'genesis_attr_' . $context, $attributes );

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

	//* Echo or return attribute string
	if ( $echo )
		echo trim( $output );
	else
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

	//* Search results pages
	if ( is_search() )
		$attributes['itemtype'] = 'http://schema.org/SearchResultsPage';

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

add_filter( 'genesis_attr_content', 'genesis_attributes_content' );
/**
 * 
 */
function genesis_attributes_content( $attributes ) {

	$attributes['role'] = 'main';

	//** Blog microdata
	if ( is_singular( 'post' ) || is_archive() || is_home() || is_page_template( 'page_blog.php' ) ) {
		$attributes['itemscope'] = 'itemscope';
		$attributes['itemtype']  = 'http://schema.org/Blog';
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

add_filter( 'genesis_attr_sidebar-primary', 'genesis_attributes_sidebar_primary' );
/**
 * 
 */
function genesis_attributes_sidebar_primary( $attributes ) {

	$attributes['class'] = 'sidebar sidebar-primary widget-area';
	$attributes['role']  = 'complimentary';

	return $attributes;

}

add_filter( 'genesis_attr_sidebar-secondary', 'genesis_attributes_sidebar_secondary' );
/**
 * 
 */
function genesis_attributes_sidebar_secondary( $attributes ) {

	$attributes['class'] = 'sidebar sidebar-secondary widget-area';
	$attributes['role']  = 'complimentary';

	return $attributes;

}

add_filter( 'genesis_attr_site-footer', 'genesis_attributes_site_footer' );
/**
 * 
 */
function genesis_attributes_site_footer( $attributes ) {

	$attributes['role']  = 'contentinfo';

	return $attributes;

}
