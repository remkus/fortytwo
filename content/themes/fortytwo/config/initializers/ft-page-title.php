<?php
/*
 * FortyTwo Insert Page Title: Adds the page title to all pages
 */


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
                    <section class="page-title-full">
                        <h2>Page Title</h2>
                    </section>
                </div>
            </div>
EOD;
        echo $ft_page_title;
    }
}