<?php
/**
 * Trait for integrating with WordPress menus.
 *
 * @package Creode Blocks
 */

namespace Creode_Blocks;

/**
 * Trait for integrating with WordPress menus.
 */
trait Trait_Menu_Integration {

	/**
	 * Returns all WordPress menu locations for use in ACF select fields.
	 *
	 * @return array
	 */
	protected function get_menu_choices(): array {
		global $_wp_registered_nav_menus;

		return array_merge(
			array(
				'' => 'None',
			),
			$_wp_registered_nav_menus ? $_wp_registered_nav_menus : array()
		);
	}

	/**
	 * Renders a menu by menu location.
	 *
	 * @param string $location The menu location.
	 * @param array  $args (optional) An array of arguments for rendering the menu. Please see https://developer.wordpress.org/reference/functions/wp_nav_menu/ for a full list of arguments.
	 */
	public function render_menu_by_location( string $location, array $args = array() ): void {
		$menu_id = $this->get_menu_id_by_location( $location );

		if ( ! $menu_id ) {
			echo 'No menu found.';
			return;
		}

		wp_nav_menu(
			array_merge(
				array(
					'container' => '',
					'menu'      => $menu_id,
				),
				$args
			)
		);
	}

	/**
	 * Returns the ID of a menu assigned to a specified location.
	 *
	 * @param string $location The menu location.
	 * @return int|null The menu id. Null If menu cannot be found.
	 */
	public function get_menu_id_by_location( string $location ): int|null {
		foreach ( get_nav_menu_locations() as $loop_location => $loop_menu_id ) {
			if ( $loop_location !== $location ) {
				continue;
			}

			return $loop_menu_id;
		}

		return null;
	}
}
