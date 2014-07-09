<?php
/**
 * FortyTwo Theme
 *
 * @package FortyTwo
 * @author  Forsite Themes
 * @license GPL-2.0+
 * @link    http://forsitethemes/themes/fortytwo/
 */

add_action( 'genesis_setup', 'fortytwo_remove_default_breadcrumbs' );
/**
 * Remove the default location of breadcrumbs as it is added to the subheader area.
 *
 * Must run after Genesis has had a chance to add them in the first place.
 *
 * @since @@release
 */
function fortytwo_remove_default_breadcrumbs() {
	remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );
}

add_filter( 'genesis_breadcrumb_args', 'fortytwo_breadcrumb_args' );
/**
 * Modifying the default breadcrumb arguments.
 *
 * @since @@release
 *
 * @param array $args Existing breadcrumb arguments.
 *
 * @return array Amended breadcrumb arguments.
 */
function fortytwo_breadcrumb_args( $args ) {
	$args['sep']                     = ' / ';
	$args['list_sep']                = ', ';
	$args['heirarchial_attachments'] = true;
	$args['heirarchial_categories']  = true;
	$args['display']                 = true;
	$args['labels']['404']           = __( 'Not found', 'fortytwo' );
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

add_action( 'genesis_after_header', 'fortytwo_insert_site_subheader', 12 );
/**
 * Insert the site-subheader section.
 *
 * @since @@release
 */
function fortytwo_insert_site_subheader() {

	// Do nothing when we're on the front-page
	if ( is_front_page()  || ( is_home() && get_option( 'page_for_posts' ) && ! get_option( 'page_on_front' ) && ! get_queried_object() ) ) {
		return;
	}

	// Do nothing if on a page with a template assigned.
	if ( ! is_search() && ! is_404() && get_page_template_slug() ) {
		return;
	}

	// Remove single entry titles from article header
	if ( is_singular() ) {
		remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
	}

	// Remove search results page header
	if ( is_search() ) {
		remove_action( 'genesis_before_loop', 'genesis_do_search_title' );
	}

	// Remove WooCommerce archive title
	add_filter( 'woocommerce_show_page_title', '__return_false' );

	$site_subheader_title = apply_filters( 'fortytwo_site_subheader_title', '' );
	$site_subheader_widget = apply_filters( 'fortytwo_site_subheader_widget', false );
	$site_subheader_breadcrumbs = apply_filters( 'fortytwo_site_subheader_breadcrumbs', true );
	?>
	<div class="site-subheader">
		<div class="wrap">
			<div class="inner-wrap">
				<div class="site-subheader-title-area">
					<?php echo $site_subheader_title; ?>
				</div>
				<?php
				if ( $site_subheader_breadcrumbs ) {
				?>
				<div class="site-subheader-breadcrumbs">
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
 * Based on the type of page being viewed.
 *
 * @since @@release
 *
 * @param string $title Site subheader title (default is empty string).
 */
function fortytwo_do_site_subheader_title( $title ) {

	global $post;

	$title = $label = '';

	if (
		( function_exists( 'is_product' ) && is_product() ) ||
		( function_exists( 'is_shop' ) && is_shop() )
	) { // Special case for WooCommerce where label is preferred over title
		$label = __( 'Shop', 'fortytwo' );
	} elseif ( is_home() ) { // Static blog page
		$label = get_the_title( get_option( 'page_for_posts', true ) );
	} elseif ( is_singular() ) { // Post, Page, CPT entry or attachment
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
	} elseif ( is_archive() ) {
		if ( is_post_type_archive() ) {
			$label = post_type_archive_title( '', false );
		} elseif ( is_category() ) {
			$label = __( 'Articles by Category: ', 'fortytwo' ) . single_term_title( '', false );
		} elseif ( is_tag() ) {
			$label = __( 'Articles by Tag: ', 'fortytwo' ) . single_term_title( '', false );
		} elseif ( is_author() ) {
			$label = __( 'Articles by Author: ', 'fortytwo' ) . get_the_author_meta( 'display_name', $post->post_author );
		} elseif ( is_day() ) {
			$label = __( 'Articles by Day: ', 'fortytwo' ) . get_the_date();
		} elseif ( is_month() ) {
			$label = __( 'Articles by Month: ', 'fortytwo' ) . get_the_date( _x( 'F Y', 'monthly archives date format', 'fortytwo' ) );
		} elseif ( is_year() ) {
			$label = __( 'Articles by Year: ', 'fortytwo' ) . get_the_date( _x( 'Y', 'yearly archives date format', 'fortytwo' ) );
		}
	} elseif ( is_search() ) {
		$label = apply_filters( 'genesis_search_title_text', __( 'Search Results for: ', 'fortytwo' ) ) . get_search_query();
	} elseif ( is_404() ) {
		$label = __( 'Error 404 - page not found', 'fortytwo' );
	}

	if ( $title ) {
		return '<h1 class="site-subheader-title" itemprop="headline">' . $title . '</h1>';
	}

	return '<h1 class="site-subheader-title">' . $label . '</h1>';
}
