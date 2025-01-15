<?php
/**
 * Trait for restricting a block to the site editor context.
 *
 * @package Creode Blocks
 */

namespace Creode_Blocks;

/**
 * Trait for restricting a block to the site editor context.
 */
trait Trait_Restrict_To_Site_Editor {

	use Trait_Restrict_To_Editor_Context;

	/**
	 * Trait initialization function.
	 */
	protected function init_trait_restrict_to_site_editor() {
		$this->restrict_to_site_editor();
	}
}
