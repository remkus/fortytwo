<?php
/**
 * FortyTwo Theme: Insert Page Title-  Adds the page title to all pages
 *
 * This file Adds and changes the Genesis structure
 *
 * @package FortyTwo\Structural
 * @author  Forsite Themes
 * @license GPL-2.0+
 * @link    http://forsitethemes/themes/fortytwo/
 */

/** Remove the default location of breadcrumbs as well call it when adding our subheader area */
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

add_filter( 'genesis_breadcrumb_args', 'fortytwo_breadcrumb_args' );
/**
 * Modifying the default breadcrumb
 * @todo  This code needs better documentation
 */
function fortytwo_breadcrumb_args( $args ) {

	$args['sep']                     = ' / ';
	$args['list_sep']                = ', ';
	$args['heirarchial_attachments'] = true;
	$args['heirarchial_categories']  = true;
	$args['display']                 = true;
	$args['labels']['404']           = __( 'Not found', 'fortytwo', 'fortytwo-dev' );
	$args['labels']['prefix']        = '';
	$args['labels']['author']        = '';
	$args['labels']['category']      = '';
	$args['labels']['tag']           = '';
	$args['labels']['date']          = '';
	$args['labels']['search']        = '';
	$args['labels']['tax']           = '';
	$args['labels']['post_type']     = '';

	return $args;
}

add_action( 'genesis_after_header', 'fortytwo_insert_site_subheader' );
/**
 * Insert the site-subheader section
 *
 * @todo  $ft_site_subheader to be translated and possibly filterable
 * @todo  page title and breadcrumbs should have our own do action
 * @todo  This code needs better documentation
 *
 */
function fortytwo_insert_site_subheader() {

	// Do nothing when we're on the front-page
	if ( is_front_page()  || ( is_home() && get_option( 'page_for_posts' ) && ! get_option( 'page_on_front' ) && ! get_queried_object() ) ) {
		return;
	}

	$site_subheader_title = apply_filters( 'fortytwo_site_subheader_title', '' );
	$site_subheader_widget = apply_filters( 'fortytwo_site_subheader_widget', false );
	$site_subheader_breadcrumbs = apply_filters( 'fortytwo_site_subheader_breadcrumbs', true );
	?>
	<div class="site-subheader">
		<div class="wrap">
			<div class="inner-wrap">
				<div class="subheader-title">
					<?php echo $site_subheader_title; ?>
				</div>
				<?php
				if ( $site_subheader_breadcrumbs ) {
				?>
				<div class="subheader-breadcrumbs">
					<?php
					if ( true === $site_subheader_breadcrumbs ) {
						genesis_do_breadcrumbs();
					} else {
						$site_subheader_breadcrumbs;
					}
					?>
				</div>
				<?php } ?>
			</div>
		</div>
	</div>
	<?php
}

add_filter( 'fortytwo_site_subheader_title', 'fortytwo_do_site_subheader_title' );
/**
 * Populate the site subheader title.
 *
 * We alter this based on the type of page being viewed
 */
function fortytwo_do_site_subheader_title( $title ) {

	global $post;

	$title = $label = '';

	if ( is_home() ) { // Static blog page
		$label = get_the_title( get_option( 'page_for_posts', true ) );
	} elseif ( is_singular() ) { // Post, Page, CPT entry or attachment
		if (
			( function_exists( 'is_product' ) && is_product() ) ||
			( function_exists( 'is_shop' ) && is_shop() )
		) { // Special case where label is preferred over title
			$label = __( 'Shop', 'fortytwo', 'fortytwo-dev' );
		} else {
			$title = get_the_title();
			if ( empty( $title ) ) { // No title, so fallback
				if ( is_attachment() ) {
					$mime_type = get_post_mime_type();
					$label = ucwords( substr( $mime_type, 0, strpos( $mime_type, '/' ) ) );
				} elseif ( is_singular( 'post' ) && $format = get_post_format() ) { // Post with post format
					$label = ucwords( $format );
				} else { // Post (no post format), Page, CPT entry
					$obj = get_post_type_object( get_post_type() );
					$label = $obj->labels->singular_name;
				}
			}
		}
	} elseif ( is_archive() ) {
		if ( is_post_type_archive() ) {
			$label = post_type_archive_title( '', false );
		} elseif ( is_category() ) {
			$label = __( 'Articles by Category: ', 'fortytwo', 'fortytwo-dev' ) . single_term_title( '', false );
		} elseif ( is_tag() ) {
			$label = __( 'Articles by Tag: ', 'fortytwo', 'fortytwo-dev' ) . single_term_title( '', false );
		} elseif ( is_author() ) {
			$label = __( 'Articles by Author: ', 'fortytwo', 'fortytwo-dev' ) . get_the_author_meta( 'display_name', $post->post_author );
		} elseif ( is_day() ) {
			$label = __( 'Articles by Day: ', 'fortytwo', 'fortytwo-dev' ) . get_the_date();
		} elseif ( is_month() ) {
			$label = __( 'Articles by Month: ', 'fortytwo', 'fortytwo-dev' ) . get_the_date( _x( 'F Y', 'monthly archives date format', 'fortytwo', 'fortytwo-dev' ) );
		} elseif ( is_year() ) {
			$label = __( 'Articles by Year: ', 'fortytwo', 'fortytwo-dev' ) . get_the_date( _x( 'Y', 'yearly archives date format', 'fortytwo', 'fortytwo-dev' ) );
		}
	} elseif ( is_search() ) {
		$label = __( 'Search Results for: ', 'fortytwo', 'fortytwo-dev' ) . get_search_query();
	} elseif ( is_404() ) {
		$label = __( 'Error 404 - page not found', 'fortytwo', 'fortytwo-dev' );
	}

	if ( $title ) {
		return '<h1 id="entry-title" itemprop="headline">' . $title . '</h1>';
	}

	return '<h1>' . $label . '</h1>';
}