<?php
/*
 * FortyTwo Insert Page Title: Adds the page title to all pages
 */

//* Reposition the breadcrumbs
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

//add_action( 'genesis_after_header', 'genesis_do_breadcrumbs' ); //TODO bring in modified breadcrumbs

add_action( 'genesis_after_header', 'fortytwo_insert_page_title' );
/**
 * Insert the Page Title on all pages except the home page
 * @return [type] [description]
 * @todo ft_page_title to be translated and possibly filterable
 */
function fortytwo_insert_page_title() {
    if ( !is_front_page() ) {
        $ft_page_title = <<<EOD
            <div class="page-title">
                <div class="wrap">
                    <div class="row">
                        <div class="col col-lg-6">
                            <h2>Page Title</h2>
                            <ul class="breadcrumb">
                                <li><a href="#">Home</a></li>
                                <li><a href="#">Library</a></li>
                                <li class="active">Data</li>
                            </ul>
                        </div>
                        <div class="col col-lg-6">

                        </div>
                    </div>

                </div>
            </div>
EOD;
        echo $ft_page_title;
    }
}