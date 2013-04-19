<?php
/*
 WARNING: This file is part of the core Genesis framework. DO NOT edit
 this file under any circumstances. Please do all modifications
 in the form of a child theme.
 */

/**
 * Handles the footer structure.
 *
 * This file is a core Genesis file and should not be edited.
 *
 * @category Genesis
 * @package  Templates
 * @author   StudioPress
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     http://www.studiopress.com/themes/genesis
 */

genesis_structural_wrap( 'site-inner', 'close' );
echo '</div>'; //** end .site-inner or #inner

do_action( 'genesis_before_footer' );
do_action( 'genesis_footer' );
do_action( 'genesis_after_footer' );

echo '</div>'; //** end .site-container or #wrap

do_action( 'genesis_after' );
wp_footer(); /** we need this for plugins */
?>
</body>
</html>
