<?php
/**
 * Global helper functions
 *
 * @package Creode Blocks
 */

namespace Creode_Blocks;

use WP_Block;

/**
 * Global helper functions
 */
class Helpers {

	/**
	 * Gets the single block instance by block name.
	 *
	 * @param string $name The block name.
	 * @return Block|null Block instance or null if it cannot be found.
	 */
	public static function get_block_by_name( string $name ): Block|null {
		foreach ( Block::get_instances() as $block ) {
			if ( $block->get_name() !== $name ) {
				continue;
			}

			return $block;
		}

		return null;
	}

	/**
	 * Renders and sanitizes a content string of blocks.
	 *
	 * @param string|array $content $content The content string, or array of block structures.
	 */
	public static function render_blocks( string|array $content ) {
		$output = '';
		if ( is_array( $content ) ) {
			foreach ( $content as $block ) {
				$output .= render_block( $block );
			}
		} elseif ( is_string( $content ) ) {
			$output = do_blocks( $content );
		}

		// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo preg_replace( '/<script.*?>(.*)?<\/script>/im', '', str_replace( PHP_EOL, '', $output ) );
	}

	/**
	 * Renders a content string (of blocks) in the context of a post.
	 *
	 * @param string|array $content The content string, or array of block structures.
	 * @param int          $post_id The ID of the context post.
	 */
	public static function render_blocks_in_post_context( string|array $content, int $post_id ) {
		global $post;

		$post_id = apply_filters( 'wpml_object_id', $post_id, 'post' );

		// phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
		$post = get_post( $post_id, OBJECT );
		setup_postdata( $post );
		self::render_blocks( $content );
		wp_reset_postdata();
	}

	/**
	 * Renders inner blocks within the context of a post.
	 *
	 * @param WP_Block $wp_block The block whose inner blocks should be rendered. Available within render templates.
	 * @param int      $post_id The ID of the context post.
	 */
	public static function render_inner_blocks_in_post_context( WP_Block $wp_block, int $post_id ) {
		if ( empty( $wp_block->parsed_block ) ) {
			return;
		}
		if ( empty( $wp_block->parsed_block['innerBlocks'] ) ) {
			return;
		}
		self::render_blocks_in_post_context( $wp_block->parsed_block['innerBlocks'], $post_id );
	}

	/**
	 * Sets the ACF block mode.
	 *
	 * @param string $block_name The full block name including vendor prefix.
	 * @param string $mode The ACF block mode.
	 */
	public static function set_acf_block_mode( string $block_name, string $mode = 'preview' ) {
		add_filter(
			$block_name . '_acf_block_mode',
			function () use ( $mode ) {
				return $mode;
			}
		);
	}

	/**
	 * Sets the default category for new blocks. Must be called before blocks are initialized.
	 *
	 * @param string $category The default category for new blocks.
	 */
	public static function set_default_block_category( string $category ) {
		add_filter(
			'creode_blocks_default_category',
			function () use ( $category ) {
				return $category;
			}
		);
	}

	/**
	 * Adds dynamic context to blocks.
	 * This will add an attribute called dynamic_context to all nested blocks.
	 *
	 * @param array $blocks An array of block structures to add dynamic context to.
	 * @param array $dynamic_context The dynamic context to add to the blocks.
	 */
	public static function add_dynamic_context_to_blocks( array &$blocks, $dynamic_context = array() ): void {
		foreach ( $blocks as &$block ) {
			if ( isset( $block['attrs'] ) ) {
				$block['attrs']['dynamic_context'] = $dynamic_context;
			}
			if ( isset( $block['innerBlocks'] ) ) {
				self::add_dynamic_context_to_blocks( $block['innerBlocks'], $dynamic_context );
			}
		}
	}

	/**
	 * Renders blocks with dynamic context.
	 * This will add an attribute called dynamic_context to all nested blocks.
	 *
	 * @param array $blocks An array of block structures to render.
	 * @param array $dynamic_context The dynamic context to add to the blocks.
	 */
	public static function render_blocks_with_dynamic_context( array $blocks, $dynamic_context = array() ) {
		self::add_dynamic_context_to_blocks( $blocks, $dynamic_context );
		self::render_blocks( $blocks );
	}

	/**
	 * Targets a child block by path from existing child blocks and replaces it with a new one provided.
	 *
	 * @param Child_Block[] $existing_child_blocks An array of existing child blocks to search in.
	 * @param string        $path A "/" separated path to block for example "table/row/cell".
	 * @param Child_Block   $new_child_block Child block to replace.
	 * @return Child_Block[] Array of amended child blocks.
	 */
	public static function replace_child_block_by_path( array $existing_child_blocks, string $path, Child_Block $new_child_block ): array {
		// Parse and validate path segments.
		$path_segments = array_values( array_filter( explode( '/', $path ) ) );
		if ( empty( $path_segments ) ) {
			return $existing_child_blocks;
		}

		$current_segment = array_shift( $path_segments );
		$remaining_path  = ! empty( $path_segments ) ? implode( '/', $path_segments ) : '';

		// Find and replace the matching child block.
		foreach ( $existing_child_blocks as $index => $child_block ) {
			if ( $child_block->name !== $current_segment ) {
				continue;
			}

			// If there's a remaining path, recursively replace in child blocks.
			if ( ! empty( $remaining_path ) ) {
				$updated_child_blocks = self::replace_child_block_by_path(
					$child_block->child_blocks,
					$remaining_path,
					$new_child_block
				);
				$child_block->set_child_blocks( $updated_child_blocks );
			} else {
				// Replace the block at this level.
				$existing_child_blocks[ $index ] = $new_child_block;
			}

			// We've processed the block we need to, therefore
			// just break out of the loop, no need to process anything else.
			break;
		}

		return $existing_child_blocks;
	}
}
