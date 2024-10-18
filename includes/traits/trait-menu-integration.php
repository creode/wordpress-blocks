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
	 */
	public function render_menu_by_location( string $location ): void {
		$menu_id = null;

		foreach ( get_nav_menu_locations() as $loop_location => $loop_menu_id ) {
			if ( $loop_location !== $location ) {
				continue;
			}

			$menu_id = $loop_menu_id;
		}

		if ( ! $menu_id ) {
			return;
		}

		wp_nav_menu(
			array(
				'container' => '',
				'menu'      => $menu_id,
			)
		);
	}
}
