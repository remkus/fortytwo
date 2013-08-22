<?php
/*
 * FortyTwo Insert Page Title: Adds the page title to all pages
 */

//* Reposition the breadcrumbs
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

add_filter( 'genesis_breadcrumb_args', 'fortytwo_breadcrumb_args' );
/**
 * Modifying the default breadcrumb
 *
 */
function fortytwo_breadcrumb_args( $args ) {

	$args['home'] = 'Home';
	$args['sep'] = ' / ';
	$args['list_sep'] = ', '; // Genesis 1.5 and later
	$args['prefix'] = '<div class="breadcrumb">';
	$args['suffix'] = '</div>';
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
	$args['labels']['404'] = 'Not found: '; // Genesis 1.5 and later

	return $args;
}

add_action( 'genesis_after_header', 'fortytwo_insert_site_subheader' );
/**
 * Insert subheader section for site-inner TODO $ft_site_subheader to be translated and possibly filterable
 *
 */
function fortytwo_insert_site_subheader( $ft_subheader_attr = array() ) {
	if ( !is_front_page() ) {

		global $post;

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
							<h2>{$ft_subheader_attr['title']}</h2>
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