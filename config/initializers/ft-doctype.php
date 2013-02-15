<?php
/*
 * FotyTwo: run our own do doctype functions in order to add .bootstrap class to <html>
 *
 * @since 1.0.0
 *
 */

remove_action( 'genesis_doctype', 'genesis_do_doctype' );
add_action( 'genesis_doctype', 'fortytwo_do_doctype' );


function fortytwo_do_doctype() {

	if ( current_theme_supports( 'genesis-html5' ) )
        fortytwo_html5_doctype();
	else
        fortytwo_xhtml_doctype();

}

function fortytwo_xhtml_doctype() {

?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html class="bootstrap" xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes( 'xhtml' ) ?>>
        <head profile="http://gmpg.org/xfn/11">
            <meta http-equiv="Content-Type" content="<?php bloginfo( 'html_type' ) ?>; charset=<?php bloginfo( 'charset' ) ?>" />
<?php

}

function fortytwo_html5_doctype() {

?>
    <!DOCTYPE html>
    <html class="bootstrap" <?php language_attributes( 'html' ) ?>>
        <head>
            <meta charset="<?php bloginfo( 'charset' ) ?>" />
<?php

}