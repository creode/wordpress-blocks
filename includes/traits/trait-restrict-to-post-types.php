<?php
/**
 * Trait for restricting a block to the editor of particular post types.
 *
 * @package Creode Blocks
 */

namespace Creode_Blocks;

/**
 * Trait for restricting a block to the editor of particular post types.
 */
trait Trait_Restrict_To_Post_Types {

	use Trait_Restrict_To_Editor_Context;

	/**
	 * Trait initialization function.
	 */
	protected function init_trait_restrict_to_post_types() {
		$this->restrict_to_post_editor();
		$this->restrict_to_post_types();
	}

	/**
	 * Restict the availibility of the block using this trait to posts of types proivided by the post_types function.
	 */
	protected function restrict_to_post_types() {
		add_action(
			'the_post',
			function () {
				$block_name        = 'acf/' . $this->get_name();
				$post_types        = $this->get_post_types();
				$current_post_type = get_post_type();

				if ( 'revision' === $current_post_type ) {
					$revision_post = get_post();
					if ( $revision_post->post_parent ) {
						$current_post_type = get_post_type( $revision_post->post_parent );
					}
				}

				if ( in_array( $current_post_type, $post_types, true ) ) {
					return;
				}

				add_filter(
					'allowed_block_types_all',
					function ( bool|array $allowed_block_types ) use ( $block_name ) {
						if ( ! $allowed_block_types ) {
							return $allowed_block_types;
						}

						return array_values(
							array_filter(
								$allowed_block_types,
								function ( string $allowed_block_type ) use ( $block_name ) {
									return $allowed_block_type !== $block_name;
								}
							)
						);
					}
				);
			}
		);
	}

	/**
	 * Get all post types that this block is allowed to be used on.
	 *
	 * @return string[] An array of post types.
	 */
	public function get_post_types(): array {
		return apply_filters(
			$this->get_name() . '_allowed_post_types',
			$this->post_types()
		);
	}

	/**
	 * Function to provide an array of post types that this block is allowed to be used on.
	 *
	 * @return string[] An array of post types.
	 */
	abstract protected function post_types(): array;
}
