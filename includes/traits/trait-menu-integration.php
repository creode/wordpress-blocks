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
	 * Returns all configured WordPress menus for use in ACF select fields.
	 *
	 * @return array
	 */
	protected function get_menu_choices(): array {
		$menus_choices = array(
			'' => 'None',
		);
		foreach ( wp_get_nav_menus() as $menu_term ) {
			$menus_choices[ $menu_term->term_id ] = $menu_term->name;
		}

		return $menus_choices;
	}

}
