<?php
/**
 * Trait for restricting a block to the post editor context.
 *
 * @package Creode Blocks
 */

namespace Creode_Blocks;

/**
 * Trait for restricting a block to the post editor context.
 */
trait Trait_Restrict_To_Post_Editor {

	use Trait_Restrict_To_Editor_Context;

	/**
	 * Trait initialization function.
	 */
	protected function init_trait_restrict_to_post_editor() {
		$this->restrict_to_post_editor();
	}
}
