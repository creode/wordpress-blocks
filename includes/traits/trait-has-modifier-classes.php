<?php
/**
 * Trait for managing block modifier classes.
 *
 * @package Creode Blocks
 */

namespace Creode_Blocks;

/**
 * Trait for managing block modifier classes.
 */
trait Trait_Has_Modifier_Classes {

	/**
	 * Returns a string of additional classes to be added to block wrappers.
	 *
	 * @param string $base_class The base class that modifiers should be appended to.
	 * @return string A string of additional classes.
	 */
	public function get_modifier_class_string( string $base_class = 'example-block__wrapper' ): string {
		return implode(
			' ',
			array_map(
				function ( string $modifier_class ) use ( $base_class ) {
					return $base_class . '--' . $modifier_class;
				},
				$this->modifier_classes()
			)
		);
	}

	/**
	 * Returns an array of single terms (no prefix) to be converted to modifier classes.
	 *
	 * @return array An array of terms.
	 */
	abstract protected function modifier_classes(): array;
}
