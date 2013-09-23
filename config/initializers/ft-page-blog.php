<?php
/*
 * FotyTwo: Genesis blog page layout changes
 *
 * @since 1.0.0
 *
 */

// Modify the blog page template, new FortyTwo layout
remove_action( 'genesis_entry_header', 'genesis_do_post_format_image', 4 );
remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );
remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_open', 5 );
remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_close', 15 );
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );

add_action( 'genesis_entry_header', 'fortytwo_do_post_image', 4 );

/**
 * Echo the post image on blog layout pages.
 * @todo  This code needs better documentation
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

		if ( !empty( $img ) )
			printf( '<a href="%s" title="%s" class="aligncustom">%s</a>', get_permalink(), the_title_attribute( 'echo=0' ), $img );
	}

}

add_filter( 'genesis_post_info', 'fortytwo_post_info_filter' );
/**
 * Change the post info layout to use our label based style
 *
 * @since 1.0
 * @todo  This code needs better documentation
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
 * @todo  This code needs better documentation
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
 * @todo  This code needs better documentation
 *
 */
function fortytwo_read_more_link( $output ) {

	$output .= '<a class="btn" href="' . get_permalink() . '">'. __( 'Read More', 'fortytwo' ) . '</a>';
    return $output;

}

add_filter( 'post_class', 'fortytwo_media_post_class' );
/**
 * Adds .media to article
 *
 * @since 1.0
 * @todo  This code needs better documentation
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
 * @todo  This code needs better documentation
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
 * @todo  This code needs better documentation
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

/**
 * Use built-in wpthumb filter to create images based on added image sizes
 *
 * @since 1.0
 * @todo  This code needs better documentation
 *
 */
add_filter( 'wpthumb_create_args_from_size', function( $size ) {

	if ( $size === 'thumbnail-bw' )
		return array( 'width' => get_option( 'thumbnail_size_w' ), 'height' => get_option( 'thumbnail_size_h' ), 'greyscale' => true );

	return $size;

} );