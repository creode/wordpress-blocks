<?php
/**
 * Trait for providing CSS variables to blocks.
 *
 * @package Creode Blocks
 */

namespace Creode_Blocks;

/**
 * Trait for providing CSS variables to blocks.
 */
trait Trait_Has_CSS_Variables {

	/**
	 * Returns a keyed array of CSS variables.
	 * Where the key is the CSS variable name and the value is the CSS variable value.
	 *
	 * @return array
	 */
	protected function css_variables(): array {
		return array();
	}

	/**
	 * Returns a string of CSS variables to be used by a block wrapper's style attribute.
	 *
	 * @return string
	 */
	public function get_css_variable_string(): string {
		$string = ' ';
		foreach ( $this->css_variables() as $name => $value ) {
			$string .= '--' . $name . ': ' . $value . '; ';
		}

		return $string;
	}
}
