<?php
/**
 * FortyTwo Theme
 *
 * @package FortyTwo
 * @author  Forsite Themes
 * @license GPL-2.0+
 * @link    http://forsitethemes/themes/fortytwo/
 */

add_filter( 'genesis_do_nav', 'fortytwo_do_nav', 10, 3 );

/**
 * FortyTwo Navigation Amendmennts
 * @return [type] [description]
 * @todo  This code needs better documentation
 *
 */
function fortytwo_do_nav( $nav_output, $nav, $args ) {

	// Setting our $defaults which is enabling our custom walker to be used
	$defaults = array(
		'walker' => new FortyTwo_Walker_Nav_Menu()
	);

	// We merge $args with our $defaults
	$args = wp_parse_args( $args, $defaults );

	// Load the navigation arguments
	$nav = wp_nav_menu( $args );

	// Get the Genesis attributes for navigation
	$nav_attr = genesis_attr( 'nav-primary' );

	// Get the blog name and url to be used for our .nav-brand
	$nav_brand     = esc_attr( get_bloginfo( 'name' ) );
	$nav_brand_url = trailingslashit( home_url() );

	$nav_output = <<<EOD
		<nav class="nav-primary" {$nav_attr}>
			<div class="wrap">
				<div class="inner-wrap">
					<div class="nav-primary-header">
						<button type="button" class="nav-toggle" data-toggle="collapse" data-target=".nav-primary-collapse">
							<span class="sr-only">Toggle Navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<a class="nav-title" href="{$nav_brand_url}">{$nav_brand}</a>
					</div>
					<div class="collapse nav-collapse nav-primary-collapse">
					  {$nav}
					</div>
				</div>
			</div>
		</nav>
EOD;

	return $nav_output;
}

/**
 * Custom navigation walker.
 *
 * @package FortyTwo
 * @author  Forsite Themes
 * */
class FortyTwo_Walker_Nav_Menu extends Walker_Nav_Menu {
	/**
	 * Start the element output.
	 *
	 * @see Walker::start_el()
	 *
	 * @since @@release
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $item   Menu item data object.
	 * @param int    $depth  Depth of menu item. Used for padding.
	 * @param array  $args   An array of arguments. {@see wp_nav_menu()}
	 * @param int    $id     Current item ID.
	 */
	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		$classes = empty( $item->classes ) ? array() : (array) $item->classes;

		// Depth dependent class
		$classes[] = ( $depth >= 1 && $args->has_children ) ? 'dropdown-submenu' : 'dropdown';

		/** This filter is documented in wp-includes/nav-menu-template.php */
		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

		/** This filter is documented in wp-includes/nav-menu-template.php */
		$id = apply_filters( 'nav_menu_item_id', 'nav-menu-item-'. $item->ID, $item, $args );
		$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

		$output .= $indent . '<li' . $id . $class_names .'>';

		$atts = array();
		$atts['title']        = ! empty( $item->attr_title ) ? $item->attr_title : '';
		$atts['target']       = ! empty( $item->target )     ? $item->target     : '';
		$atts['rel']          = ! empty( $item->xfn )        ? $item->xfn        : '';
		$atts['href']         = ! empty( $item->url )        ? $item->url        : '';
		$atts['class']        = ( $depth < 1 && $args->has_children ) ? 'dropdown-toggle' : '';
		$atts['data-toggle']  = ( $depth < 1 && $args->has_children ) ? 'dropdown' : '';

		/** This filter is documented in wp-includes/nav-menu-template.php */
		$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args );

		$attributes = '';
		foreach ( $atts as $attr => $value ) {
			if ( ! empty( $value ) ) {
				$value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
				$attributes .= ' ' . $attr . '="' . $value . '"';
			}
		}

		$item_output  = $args->before;
		$item_output .= '<a' . $attributes . '>';
		$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
		$item_output .= ( $depth == 0 && $args->has_children ) ? ' <b class="caret"></b>' : '';
		$item_output .= '</a>';
		$item_output .= $args->after;

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}

	/**
	 * Traverse elements to create list from elements.
	 *
	 * Display one element if the element doesn't have any children otherwise,
	 * display the element and its children. Will only traverse up to the max
	 * depth and no ignore elements under that depth. It is possible to set the
	 * max depth to include all depths, see walk() method.
	 *
	 * This method should not be called directly, use the walk() method instead.
	 *
	 * For this theme, the has_children property is set and the parent method
	 * handles the rest of the details.
	 *
	 * @since @@release
	 *
	 * @param object $element           Data object.
	 * @param array  $children_elements List of elements to continue traversing.
	 * @param int    $max_depth         Max depth to traverse.
	 * @param int    $depth             Depth of current element.
	 * @param array  $args              An array of arguments.
	 * @param string $output            Passed by reference. Used to append additional content.
	 * 
	 * @return null Null on failure with no changes to parameters.
	 */
	function display_element( $element, &$children_elements, $max_depth, $depth = 0, $args, &$output ) {
		if ( ! $element ) {
			return;
		}

		$id_field = $this->db_fields['id'];

		if ( is_object( $args[0] ) ) {
			$args[0]->has_children = ! empty( $children_elements[ $element->$id_field ] );
		}

		parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
	}
}