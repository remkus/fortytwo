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
add_action( 'genesis_after_entry', 'fortytwo_add_entry_hr' );


/**
 * Echo the post image on blog layout pages.
 *
 */
function fortytwo_do_post_image()
{

	if ( !is_singular() && genesis_get_option( 'content_archive_thumbnail' ) ) {

		$img = genesis_get_image( array(
			'format' => 'html',
			'size' => 'width=260&height=154&crop=1&crop_from_position=center,left',
			'context' => 'archive',
			'attr' => array_merge( genesis_parse_attr( 'entry-image' ), array(
					'srcset' => 'large.png 600w 200h 1x, large_2x-res.png 600w 200h 2x, mobile-icon.png 200w 200h'
				))
		) );

		//TODO ln 63: class="pull-left" should be a dynamic value
		if ( !empty( $img ) ) {
			printf( '<a href="%s" title="%s" class="pull-left">%s</a>', get_permalink(), the_title_attribute( 'echo=0' ), $img );
		}
	}

}

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