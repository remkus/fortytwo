<?php
/*
 * FotyTwo: Genesis blog page layout changes
 *
 * @since 1.0.0
 *
 */

//* HTML5 Hooks
// add_action( 'genesis_entry_header', 'genesis_do_post_format_image', 5 );
// add_action( 'genesis_entry_header', 'genesis_entry_header_markup_open', 5 );
// add_action( 'genesis_entry_header', 'genesis_entry_header_markup_close', 15 );
// add_action( 'genesis_entry_header', 'genesis_do_post_title' );

// add_action( 'genesis_entry_content', 'genesis_do_post_image' );
// add_action( 'genesis_entry_content', 'genesis_do_post_content' );
// add_action( 'genesis_entry_content', 'genesis_do_post_permalink' );
// add_action( 'genesis_entry_content', 'genesis_do_post_content_nav' );

// add_action( 'genesis_entry_header', 'genesis_post_info' );

// add_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_open', 5 );
// add_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_close', 15 );
// add_action( 'genesis_entry_footer', 'genesis_post_meta' );

// add_action( 'genesis_after_entry', 'genesis_do_author_box_single' );

//* Other
// add_action( 'genesis_loop_else', 'genesis_do_noposts' );
// add_action( 'genesis_after_endwhile', 'genesis_posts_nav' );

// Modify the blog page template, new FortyTwo layout

remove_action( 'genesis_entry_header', 'genesis_do_post_format_image', 5 );
remove_action( 'genesis_entry_content', 'genesis_do_post_image' );
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );

add_action( 'genesis_entry_header', 'fortytwo_do_post_image', 1 );
/**
 * Echo the post image on blog layout pages.
 *
 */
function fortytwo_do_post_image() {

	if ( ! is_singular() && genesis_get_option( 'content_archive_thumbnail' ) ) {
		$img = genesis_get_image( array(
			'format'  => 'html',
			'size'    => 'width=260&height=154&crop=1',
			'context' => 'archive',
			'attr'    => genesis_parse_attr( 'entry-image' )
		) );

		//TODO ln 63: class="pull-left" should be a dynamic value
		if ( !empty( $img ) )
			printf( '<a href="%s" title="%s" class="pull-left">%s</a>', get_permalink(), the_title_attribute( 'echo=0' ), $img );
	}

}

add_action( 'genesis_after_entry', 'fortytwo_add_entry_hr' );
/**
 * Add <hr> element after posts.
 *
 */
function fortytwo_add_entry_hr() {

    global $wp_query;
    if ( $wp_query->current_post +1 !== $wp_query->post_count ) {
        echo '<hr>';
    }

}

add_filter( 'genesis_post_info', 'fortytwo_post_info_filter' );
/**
 * Change the post info layout to use our label based style
 *
 * @since 1.0
 *
 */
function fortytwo_post_info_filter( $post_info ) {

    if ( ! is_page() ) {
        $post_info = '[post_date before="<i class=\'icon-time\'>&nbsp;" after="</i>"] [post_author_posts_link before="<i class=\'icon-user\'>&nbsp;" after="</i>"] [post_comments before="<i class=\'icon-comment\'>&nbsp;" after="</i>"] [post_categories before="<i class=\'icon-tag\'>&nbsp;" after="</i>"]'; //TODO need to add back the post edit link
        return $post_info;
    }

}

add_filter( 'get_the_content_more_link', 'fortytwo_read_more_ellipsis' );
/**
 * Changes the content more link
 *
 * @since 1.0
 *
 */
function fortytwo_read_more_ellipsis() {

	return '...';

}

add_filter( 'get_the_content_limit', 'fortytwo_read_more_link' );
/**
 * Alter the FortyTwo posts read more link
 *
 * @since 1.0
 *
 */
function fortytwo_read_more_link( $output ) {

	$output .= '<a class="btn" href="' . get_permalink() . '">Read More</a>';
    return $output;

}

add_filter( 'post_class', 'fortytwo_media_post_class' );
/**
 * Adds .media to article
 *
 * @since 1.0
 *
 */
function fortytwo_media_post_class( $classes ) {

    //* Add "media" to the post class array
    $classes[] = 'media';
    return $classes;

}

add_filter( 'wpthumb_post_image_path','fortytwo_add_srcset_images', 10, 3 );
/**
 * Adds additional sizes for our responsive images making use of srcset
 *
 * @since 1.0
 *
 */
function fortytwo_add_srcset_images( $path, $id ) {

	$args = 'width=420&height=300&crop=1';

	$srcset_image = new WP_Thumb( $path, $args );
	$srcset_image_args = $srcset_image->getArgs();
	$srcset_url = $srcset_image->returnImage();

	$defaults = array(
		'srcset' => array(
			'url'    => $srcset_url,
			'width'  => $srcset_image_args['width'],
			'height' => $srcset_image_args['height']
		)
	);

	$imgmeta = wp_get_attachment_metadata( $id );
	$imgmeta = wp_parse_args( $imgmeta, $defaults );
	wp_update_attachment_metadata( $id, $imgmeta );

	return $path;

}

add_filter( 'wp_get_attachment_image_attributes', 'fortytwo_add_srcset_attr', 10, 2 );
/**
 * Adds srcset attribute to the post image
 *
 * @since 1.0
 *
 */
function fortytwo_add_srcset_attr( $attr, $attachment ) {

	$imgmeta = wp_get_attachment_metadata( $attachment->ID );

	if ( isset( $imgmeta['srcset'] ) ) {
		$srcset = array(
			'srcset' => $imgmeta['srcset']['url'] . ' 800w'
		);

		$attr = wp_parse_args( $attr, $srcset );
	}

	return $attr;

}