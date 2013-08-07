<?php
/*
 * FortyTwo Insert Page Title: Adds the page title to all pages
 */

//* Reposition the breadcrumbs
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

//add_action( 'genesis_after_header', 'genesis_do_breadcrumbs' ); //TODO bring in modified breadcrumbs

add_action( 'genesis_after_header', 'fortytwo_insert_site_subheader' );
/**
 * Insert subheader section for site-inner
 *
 * @return [type] [description]
 * @TODO $ft_site_subheader to be translated and possibly filterable
 */
function fortytwo_insert_site_subheader() {
	if ( !is_front_page() ) {
		$ft_site_subheader = <<<EOD
			<div class="site-subheader">
				<div class="outer-wrap">
					<div class="wrap">
						<div class="subheader-area">
							<h2>Page Title</h2>
							<ul class="breadcrumb">
								<li><a href="#">Home</a></li>
								<li><a href="#">Library</a></li>
								<li class="active">Data</li>
							</ul>
						</div>
						<aside class="widget-area subheader-widget-area">
							<section id="search-4" class="widget widget_search">
								<div class="widget-wrap">
									<form role="search" method="get" id="searchform" class="input-group" action="http://www.gitpress.dev/">
										<input type="text" value="" name="s" id="s">
										<span class="input-group-btn">
											<button class="btn btn-default" type="submit">Search</button>
										</span>
									</form>
								</div>
							</section>
						</aside>
					</div>
				</div>
			</div>
EOD;
		echo $ft_site_subheader;
	}
}