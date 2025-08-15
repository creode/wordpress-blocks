<?php
/**
 * Walker class to output a WordPress menu with accessible toggle buttons for sub-menus and parent links in sub-menus.
 *
 * @package Creode Blocks
 */

namespace Creode_Blocks;

/**
 * Extension of Toggle_Menu_Walker to add parent links to sub-menus.
 */
class Toggle_Menu_Walker_With_Parent_Links extends Toggle_Menu_Walker {

	/**
	 * Stack to track parent items by depth.
	 *
	 * @var array
	 */
	protected $parent_stack = array();

	/**
	 * Start the element output.
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $item   Menu item data object.
	 * @param int    $depth  Depth of menu item. Used for padding.
	 * @param array  $args   An array of arguments. @see wp_nav_menu().
	 * @param int    $id     Current item ID.
	 */
	public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		// Push the current item to the parent stack for the next level.
		$this->parent_stack[ $depth ] = $item;
		parent::start_el( $output, $item, $depth, $args, $id );
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
		parent::end_el( $output, $item, $depth, $args );
		unset( $this->parent_stack[ $depth ] );
	}

	/**
	 * Returns the opening markup for a submenu <ul> and injects a parent-link <li>.
	 *
	 * @param string $submenu_id The unique ID for the submenu <ul>.
	 * @param int    $depth      Menu depth.
	 * @param array  $args       Menu arguments.
	 * @return string            The markup for the opening <ul> with parent link.
	 */
	protected function get_submenu_open_markup( $submenu_id, $depth, $args ) {
		$indent = str_repeat( "\t", $depth );
		$output = "\n$indent<ul id=\"" . esc_attr( $submenu_id ) . "\" class=\"sub-menu\" hidden aria-hidden=\"true\">\n";

		// Add parent link as first <li> in the submenu.
		if ( isset( $this->parent_stack[ $depth ] ) ) {
			$parent = $this->parent_stack[ $depth ];
			if ( $parent && ! empty( $parent->url ) ) {
				$title   = apply_filters( 'the_title', $parent->title, $parent->ID );
				$output .= $indent . "\t" . '<li class="menu-item menu-item-parent-link">';
				$output .= '<a href="' . esc_url( $parent->url ) . '">' . esc_html( $title ) . '</a>';
				$output .= "</li>\n";
			}
		}
		return $output;
	}
}
