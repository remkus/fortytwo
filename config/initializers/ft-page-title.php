<?php
/*
 * FortyTwo Insert Page Title: Adds the page title to all pages
 */

//* Reposition the breadcrumbs
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

//add_action( 'genesis_after_header', 'genesis_do_breadcrumbs' ); //TODO bring in modified breadcrumbs

add_action( 'genesis_after_header', 'fortytwo_insert_site_inner_header' );
/**
 * Insert header section for site-inner headings
 * @return [type] [description]
 * @TODO $ft_site_inner_header to be translated and possibly filterable
 */
function fortytwo_insert_site_inner_header() {
    if ( !is_front_page() ) {
        $ft_site_inner_header = <<<EOD
            <div class="site-inner-header">
                <div class="wrap">
                    <div class="col-wrap">
                        <h2>Page Title</h2>
                        <ul class="breadcrumb">
                            <li><a href="#">Home</a></li>
                            <li><a href="#">Library</a></li>
                            <li class="active">Data</li>
                        </ul>
                    </div>
                </div>
            </div>
EOD;
        echo $ft_site_inner_header;
    }
}