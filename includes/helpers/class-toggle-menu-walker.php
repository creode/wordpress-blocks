<?php
/**
 * Walker class to output a WordPress menu with accessible toggle buttons for sub-menus.
 *
 * Each sub-menu gets a unique ID (sub-menu-1, sub-menu-2, ...) and is initially hidden via
 * 'hidden' and 'aria-hidden="true"'. Toggle buttons, rendered next to parent links, use
 * ARIA roles and attributes for accessibility and reference the associated sub-menu by ID.
 *
 * @package Creode Blocks
 */

namespace Creode_Blocks;

use Walker_Nav_Menu;

/**
 * Custom Walker_Nav_Menu for accessible sub-menu toggles.
 *
 * @see Walker_Nav_Menu
 */
class Toggle_Menu_Walker extends Walker_Nav_Menu {

	/**
	 * Static counter to create unique submenu IDs.
	 *
	 * @var int
	 */
	protected static $submenu_count = 0;

	/**
	 * Stack to track pending submenu IDs for each depth.
	 * This ensures correct assignment in nested menus.
	 *
	 * @var array
	 */
	protected $pending_submenu_ids = array();

	/**
	 * Start the list before the child elements are added.
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param int    $depth  Depth of menu item. Used for padding.
	 * @param array  $args   An array of arguments. @see wp_nav_menu().
	 */
	public function start_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat( "\t", $depth );

		// Get the pending submenu ID for this level (assigned in start_el).
		$submenu_id = array_shift( $this->pending_submenu_ids );
		if ( ! $submenu_id ) {
			// Fallback to unique ID if something went wrong.
			self::$submenu_count++;
			$submenu_id = 'sub-menu-' . self::$submenu_count;
		}

		$output .= "\n$indent<ul id=\"" . esc_attr( $submenu_id ) . "\" class=\"sub-menu\" hidden aria-hidden=\"true\">\n";
	}

	/**
	 * Ends the list of after the elements are added.
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param int    $depth  Depth of menu item. Used for padding.
	 * @param array  $args   An array of arguments. @see wp_nav_menu().
	 */
	public function end_lvl( &$output, $depth = 0, $args = array() ) {
		$indent  = str_repeat( "\t", $depth );
		$output .= "$indent</ul>\n";
	}

	/**
	 * Start the element output.
	 *
	 * @param string        $output Passed by reference. Used to append additional content.
	 * @param object        $item   Menu item data object.
	 * @param int           $depth  Depth of menu item. Used for padding.
	 * @param stdClass|null $args   An array of arguments. @see wp_nav_menu().
	 * @param int           $id     Current item ID.
	 */
	public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		$classes   = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'menu-item-' . $item->ID;

		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

		$item_id = apply_filters( 'nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args, $depth );
		$item_id = $item_id ? ' id="' . esc_attr( $item_id ) . '"' : '';

		$output .= $indent . '<li' . $item_id . $class_names . '>';

		$atts           = array();
		$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
		$atts['target'] = ! empty( $item->target ) ? $item->target : '';
		$atts['rel']    = ! empty( $item->xfn ) ? $item->xfn : '';
		$atts['href']   = ! empty( $item->url ) ? $item->url : '';

		$atts       = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );
		$attributes = '';
		foreach ( $atts as $attr => $value ) {
			if ( ! empty( $value ) ) {
				$value       = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
				$attributes .= ' ' . $attr . '="' . $value . '"';
			}
		}

		// Prepare the menu item's title.
		$title = apply_filters( 'the_title', $item->title, $item->ID );

		$item_output  = $args->before;
		$item_output .= '<a' . $attributes . '>';
		$item_output .= $args->link_before . $title . $args->link_after;
		$item_output .= '</a>';

		// If the menu item has children, add the toggle button.
		if ( in_array( 'menu-item-has-children', $classes, true ) ) {
			++self::$submenu_count;

			$submenu_id                  = 'sub-menu-' . self::$submenu_count;
			$this->pending_submenu_ids[] = $submenu_id;

			$item_output .= '<button'
				. ' type="button"'
				. ' class="submenu-toggle"'
				. ' role="switch"'
				. ' aria-checked="false"'
				. ' aria-expanded="false"'
				. ' aria-controls="' . esc_attr( $submenu_id ) . '"'
				. '>'
				. '<span class="screen-reader-text">' . esc_html__( 'Toggle sub-menu', 'your-textdomain' ) . '</span>'
				. '</button>';
		}

		$item_output .= $args->after;

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}

	/**
	 * Ends the element output, if needed.
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $item   Page data object. Not used.
	 * @param int    $depth  Depth of page. Not Used.
	 * @param array  $args   An array of arguments. @see wp_nav_menu().
	 */
	public function end_el( &$output, $item, $depth = 0, $args = array() ) {
		$output .= "</li>\n";
	}
}
