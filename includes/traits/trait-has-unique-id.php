<?php
/**
 * Trait for allowing a block to retrieve a unique ID string for its particular rendering.
 *
 * @package Creode Blocks
 */

namespace Creode_Blocks;

/**
 * Trait for allowing a block to retrieve a unique ID string for its particular rendering.
 */
trait Trait_Has_Unique_Id {

	/**
	 * Get a unique ID string.
	 * This will never output the same string twice in a single WordPress execution.
	 * Please note, this functionality is only applicable to front end output because editors use multiple WordPress executions.
	 *
	 * @return string A unique ID.
	 */
	public function get_unique_id(): string {
		$block_name = $this->name();
		$iterator   = apply_filters( $block_name . '_iterator', 0 );

		add_filter(
			$block_name . '_iterator',
			function ( int $iterator ) {
				return $iterator + 1;
			}
		);

		return $block_name . '-' . $iterator;
	}
}
