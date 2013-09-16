<?php
/*
 * FortyTwo Insert Page Title: Adds the page title to all pages
 */

// TODO: $ft_site_subheader to be translated and possibly filterable
// TODO: page title and breadcrumbs should have our own do action

// Remove the default location of breadcrumbs as well call it when adding our subheader area
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

add_filter( 'genesis_breadcrumb_args', 'fortytwo_breadcrumb_args' );
/**
 * Modifying the default breadcrumb
 *
 */
function fortytwo_breadcrumb_args( $args ) {

	$args['sep'] = ' / ';
	$args['list_sep'] = ', '; // Genesis 1.5 and later
	$args['heirarchial_attachments'] = true; // Genesis 1.5 and later
	$args['heirarchial_categories'] = true; // Genesis 1.5 and later
	$args['display'] = true;
	$args['labels']['prefix'] = '';
	$args['labels']['author'] = '';
	$args['labels']['category'] = ''; // Genesis 1.6 and later
	$args['labels']['tag'] = '';
	$args['labels']['date'] = '';
	$args['labels']['search'] = '';
	$args['labels']['tax'] = '';
	$args['labels']['post_type'] = '';

	return $args;
}

add_action( 'genesis_after_header', 'fortytwo_insert_site_subheader' );
/**
 * Insert subheader section for site-inner
 *
 */
function fortytwo_insert_site_subheader( $ft_subheader_attr = array() ) {
	if ( !is_front_page() ) {

		global $post;

		if ( ! is_page_template( 'page_blog.php' ) ) {
			remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_open', 5 );
			remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_close', 15 );
			remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
		}

		$ft_subheader_attr = array(
			'title'       => $post->post_title, //apply_filters( 'ft_subheader_title', $ft_subheader_attr ),
			'breadcrumbs' => true,
			'widget'      => false
		);

		$ft_site_subheader = <<<EOD
			<div class="site-subheader">
				<div class="wrap">
					<div class="inner-wrap">
						<div class="subheader-area">
							<header class="entry-header">
								<h1 class="entry-title" itemprop="headline">{$ft_subheader_attr['title']}</h1>
							</header>
EOD;
		echo $ft_site_subheader;

							if ( $ft_subheader_attr['breadcrumbs'] )
								genesis_do_breadcrumbs();

		$ft_site_subheader = <<<EOD
						</div>
					</div>
				</div>
			</div>
EOD;
		echo $ft_site_subheader;
	}
}