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

	/** do nothing when we're not on the front-page */
	if ( ! is_front_page() ) {

		global $post;

		$subheader_title = ( $post === null ? '' : $post->post_title);

		$ft_subheader_attr = apply_filters( 'fortytwo_site_subheader_attr', array(
			'title'       => $subheader_title,
			'breadcrumbs' => true,
			'widget'      => false,
		));
		?>

		<div class="site-subheader">
			<div class="wrap">
				<div class="inner-wrap">
					<div class="subheader-title">
						<h1><?php esc_attr_e( $ft_subheader_attr['title'], 'fortytwo' ); ?></h1>
					</div>
					<div class="subheader-breadcrumbs">
						<?php if ( $ft_subheader_attr['breadcrumbs'] ) {
							genesis_do_breadcrumbs();
						} ?>
					</div>
				</div>
			</div>
		</div>

	<?php
	}
}

add_filter( 'fortytwo_site_subheader_attr', 'fortytwo_custom_site_subheader_title' );
/**
 * We are altering the title attribute of the site subheader using the fortytwo_site_subheader_attr filter
 *
 * We alter this based on the type of page being viewed
 *
 * @todo  This code needs better documentation
 *
 */
function fortytwo_custom_site_subheader_title( $ft_subheader_attr ) {

	global $post;

	if ( is_404() ) {
		$ft_subheader_attr['title'] = __( 'Error 404 - page not found', 'fortytwo' );
		return $ft_subheader_attr;
	}

	if ( is_product() || is_shop() ) {
		$ft_subheader_attr['title'] = __( 'Shop', 'fortytwo' );
		return $ft_subheader_attr;
	}

	if ( is_attachment() ) {
		$ft_subheader_attr['title'] = __( ucwords( $post->post_type ), 'fortytwo' );
		return $ft_subheader_attr;
	}

	if ( is_category() ) {
		$ft_subheader_attr['title'] = __( 'Articles by Category: ', 'fortytwo' ) . single_term_title( '', false );
		return $ft_subheader_attr;
	}

	if ( is_tag() ) {
		$ft_subheader_attr['title'] = __( 'Articles by Tag: ', 'fortytwo' ) . single_term_title( '', false );
		return $ft_subheader_attr;
	}

	if ( is_author() ) {
		$ft_subheader_attr['title'] = __( 'Articles by Author: ', 'fortytwo' ) . get_the_author_meta( 'display_name', $post->post_author );
		return $ft_subheader_attr;
	}

	if ( is_day() ) {
		$ft_subheader_attr['title'] = __( 'Articles by Day: ', 'fortytwo' ) . get_the_date();
		return $ft_subheader_attr;
	} elseif ( is_month() ) {
		$ft_subheader_attr['title'] = __( 'Articles by Month: ', 'fortytwo' ) . get_the_date( _x( 'F Y', 'monthly archives date format', 'fortytwo' ) );
		return $ft_subheader_attr;
	} elseif ( is_year() ) {
		$ft_subheader_attr['title'] = __( 'Articles by Year: ', 'fortytwo' ) . get_the_date( _x( 'Y', 'yearly archives date format', 'fortytwo' ) );
		return $ft_subheader_attr;
	}

	if ( is_archive() ) {
		$ft_subheader_attr['title'] = __( 'Archive: ', 'fortytwo' ) . single_term_title( '', false );
		return $ft_subheader_attr;
	}

	if ( is_single() ) {
		$ft_subheader_attr['title'] = __( ucwords( $post->post_type ), 'fortytwo' );
		return $ft_subheader_attr;
	}

	return $ft_subheader_attr;
}