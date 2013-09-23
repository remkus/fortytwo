<?php
/*
 * FotyTwo: overrides primary Genesis menu generation to conform to
 *            structure required for bootstrap menus
 *
 * Output can be filtered via 'genesis_do_nav'.
 *
 * @since 1.0.0
 *
 * @uses genesis_get_option() Get theme setting value
 * @uses genesis_nav() Use old-style Genesis Pages or Categories menu
 * @uses genesis_structural_wrap() Adds optional internal wrap divs
 */

// Modify the display of the front-end menu
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_after_header', 'fortytwo_do_nav' );

/**
 * [fortytwo_do_nav description]
 * @return [type] [description]
 * @todo  This code needs better documentation
 *
 */
function fortytwo_do_nav() {

	/** Do nothing if menu not supported */
	if ( !genesis_nav_menu_supported( 'primary' ) )
		return;

	/** If menu is assigned to theme location, output */
	if ( has_nav_menu( 'primary' ) ) {

		$nav_brand =  esc_attr( get_bloginfo('name') );
		$nav_brand_url = trailingslashit( home_url() );

		$args = array(
			'theme_location' => 'primary',
			'container' => '',
			'menu_class' => 'menu genesis-nav-menu menu-primary nav navbar-nav',
			'echo' => 0,
			'walker' => new FortyTwo_Walker_Nav_Menu()
		);
		// load the navigation arguments
		$nav = wp_nav_menu( $args );

		// Get the Genesis attributes for navigation
		$nav_attr = genesis_attr( 'nav-primary' );

		$nav_output = <<<EOD
			<nav class="nav-primary" {$nav_attr}>
				<div class="wrap">
					<div class="inner-wrap">
						<div class="nav-primary-header">
							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".nav-primary-collapse">
								<span class="sr-only">Toggle Navigation</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
							<a class="navbar-brand" href="{$nav_brand_url}">{$nav_brand}</a>
						</div>
						<div class="collapse navbar-collapse nav-primary-collapse">
						  {$nav}
						</div>
					</div>
				</div>
			</nav>
EOD;

		// re-applying the default filters
		echo apply_filters( 'genesis_do_nav', $nav_output, $nav, $args );

	}

}

/**
 * Custom Walker to change submenu class items from default "sub-menu" to "dropdown-menu"
 * @todo  This code needs better documentation
 *
 */
class FortyTwo_Walker_Nav_Menu extends Walker_Nav_Menu {

	/**
	 * replacing the class with our version
	 * @param  [type]  $output [description]
	 * @param  integer $depth  [description]
	 * @param  array   $args   [description]
	 * @return [type]          [description]
	 * @todo  This code needs better documentation
	 *
	 */
	function start_lvl( &$output, $depth = 0, $args = array() ) {

		// depth dependent classes
		$indent = ( $depth > 0 ? str_repeat( "\t", $depth ) : '' ); // code indent
		$classes = array(
			'dropdown-menu'
		);
		$class_names = implode( ' ', $classes );

		// build html
		$output .= "\n" . $indent . '<ul class="' . $class_names . '">' . "\n";
	}

	/**
	 * building the HTML output
	 * @param  [type]  $output [description]
	 * @param  [type]  $item   [description]
	 * @param  integer $depth  [description]
	 * @param  array   $args   [description]
	 * @param  integer $id     [description]
	 * @return [type]          [description]
	 * @todo  This code needs better documentation
	 *
	 */
	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		global $wp_query;

		$indent = ( $depth > 0 ? str_repeat( "\t", $depth ) : '' ); // code indent

		$classes = empty( $item->classes ) ? array() : (array)$item->classes;

		// depth dependent classes
		$depth_classes = array(
			( $depth >= 1 && $args->has_children ? 'dropdown-submenu' : 'dropdown' )
		);
		$depth_class_names = esc_attr( implode( ' ', $depth_classes ) );

		// passed classes
		$classes = empty( $item->classes ) ? array() : (array)$item->classes;

		if ( $custom_classes = get_post_meta( $item->ID, '_menu_item_classes', true ) ) {
			foreach ( $custom_classes as $custom_class ) {
				$classes[] = $custom_class;
			}
		}

		$class_names = esc_attr( implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) ) );

		// build html
		$output .= $indent . '<li id="nav-menu-item-' . sanitize_title( $item->title ) . '" class="' . $depth_class_names . ' ' . $class_names . '">';

		$attributes = !empty( $item->attr_title ) ? ' title="' . esc_attr( $item->attr_title ) . '"' : '';
		$attributes .= !empty( $item->target ) ? ' target="' . esc_attr( $item->target ) . '"' : '';
		$attributes .= !empty( $item->xfn ) ? ' rel="' . esc_attr( $item->xfn ) . '"' : '';
		$attributes .= !empty( $item->url ) ? ' href="' . esc_attr( $item->url ) . '"' : '';
		$attributes .= ( $depth < 1 && $args->has_children ) ? ' class="dropdown-toggle" data-toggle="dropdown"' : '';

		$item_output = $args->before;
		$item_output .= '<a' . $attributes . '>';
		$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
		$item_output .= ( $depth == 0 && $args->has_children ) ? ' <b class="caret"></b>' : '';
		$item_output .= '</a>';
		$item_output .= $args->after;

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}

	/**
	 * [display_element description]
	 * @param  [type]  $element           [description]
	 * @param  [type]  $children_elements [description]
	 * @param  [type]  $max_depth         [description]
	 * @param  integer $depth             [description]
	 * @param  [type]  $args              [description]
	 * @param  [type]  $output            [description]
	 * @return [type]                     [description]
	 * @todo  This code needs better documentation
	 *
	 */
	function display_element( $element, &$children_elements, $max_depth, $depth = 0, $args, &$output ) {
		if ( !$element ) {
			return;
		}

		$id_field = $this->db_fields['id'];

		if ( is_array( $args[0] ) ) {
			$args[0]['has_children'] = !empty( $children_elements[$element->$id_field] );
		} elseif ( is_object( $args[0] ) ) {
			$args[0]->has_children = !empty( $children_elements[$element->$id_field] );
		}

		$cb_args = array_merge( array( &$output, $element, $depth ), $args );
		call_user_func_array( array( &$this, 'start_el' ), $cb_args );

		$id = $element->$id_field;

		if ( ( $max_depth == 0 || $max_depth > $depth + 1 ) && isset( $children_elements[$id] ) ) {
			foreach ( $children_elements[$id] as $child ) {
				if ( !isset( $newlevel ) ) {
					$newlevel = true;
					$cb_args = array_merge( array( &$output, $depth ), $args );
					call_user_func_array( array( &$this, 'start_lvl' ), $cb_args );
				}
				$this->display_element( $child, $children_elements, $max_depth, $depth + 1, $args, $output );
			}
			unset( $children_elements[$id] );
		}

		if ( isset( $newlevel ) && $newlevel ) {
			$cb_args = array_merge( array( &$output, $depth ), $args );
			call_user_func_array( array( &$this, 'end_lvl' ), $cb_args );
		}

		$cb_args = array_merge( array( &$output, $element, $depth ), $args );
		call_user_func_array( array( &$this, 'end_el' ), $cb_args );
	}
}