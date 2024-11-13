<?php
/**
 * Trait for restricting a block to a specific editor context.
 *
 * @package Creode Blocks
 */

namespace Creode_Blocks;

use WP_Block_Editor_Context;
use WP_Block_Type_Registry;
use WP_Block_Type;

/**
 * Trait for restricting a block to a specific editor context.
 */
trait Trait_Restrict_To_Editor_Context {

	/**
	 * Restrict block avalibility to the site editor only.
	 */
	protected function restrict_to_site_editor() {
		$this->restrict_to_editor_context( 'core/edit-site' );
	}

	/**
	 * Restrict block avalibility to the post editor only.
	 */
	protected function restrict_to_post_editor() {
		$this->restrict_to_editor_context( 'core/edit-post' );
	}

	/**
	 * Will ensure that the block is only availible within a specifield editor context.
	 *
	 * @param string $editor_context_name The name of the editor context. Please see: https://developer.wordpress.org/reference/classes/wp_block_editor_context/.
	 */
	protected function restrict_to_editor_context( string $editor_context_name ) {
		$block_name = 'acf/' . $this->name();

		add_filter(
			'allowed_block_types_all',
			function ( bool|array $allowed_block_types, WP_Block_Editor_Context $block_editor_context ) use ( $block_name, $editor_context_name ) {
				// If the current editor context is the allowed editor context no restrition is needed.
				if ( $block_editor_context->name === $editor_context_name ) {
					return $allowed_block_types;
				}

				// If $allowed_block_types is false, no further restruction can be made.
				if ( ! $allowed_block_types ) {
					return $allowed_block_types;
				}

				// If $allowed_block_types is true, we must retrieve all registered block types so a restriction can be made.
				if ( true === $allowed_block_types ) {
					$block_registry      = WP_Block_Type_Registry::get_instance();
					$allowed_block_types = array_values(
						array_map(
							function ( WP_Block_Type $block_type ) {
								return $block_type->name;
							},
							$block_registry->get_all_registered()
						)
					);
				}

				// Filter the allowed block types to ensure that the current block has been removed.
				return array_values(
					array_filter(
						$allowed_block_types,
						function ( string $block_type ) use ( $block_name ) {
							return $block_type !== $block_name;
						}
					)
				);
			},
			10,
			2
		);
	}
}
