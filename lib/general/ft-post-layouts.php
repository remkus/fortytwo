<?php

/**
 * FortyTwo Theme: Post Layouts
 *
 * This file modifies layouts of certain elements related to post layouts
 *
 * @package FortyTwo\General
 * @author  Forsite Themes
 * @license GPL-2.0+
 * @link    http://forsitethemes/themes/fortytwo/
 */

add_filter( 'use_default_gallery_style', '__return_false' );
/**
 * Filter prevent inline css being generated for post gallery
 *
 * @package FortyTwo
 * @since 1.0.0
 *
 * */