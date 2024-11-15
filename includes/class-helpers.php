<?php
/**
 * Global helper functions
 *
 * @package Creode Blocks
 */

namespace Creode_Blocks;

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
		$blocks = apply_filters( 'creode_block_instances', array() );

		return isset( $blocks[ $name ] ) ? $blocks[ $name ] : null;
	}

	/**
	 * Renders and sanitizes a content string of blocks.
	 *
	 * @param string $content The content string.
	 */
	public static function render_blocks( string $content ) {
		// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo preg_replace( '/<script.*?>(.*)?<\/script>/im', '', str_replace( PHP_EOL, '', do_blocks( $content ) ) );
	}

	/**
	 * Renders a content string (of blocks) in the context of a post.
	 *
	 * @param string $content The content string.
	 * @param int    $post_id The ID of the context post.
	 */
	public static function render_blocks_in_post_context( string $content, int $post_id ) {
		global $post;

		$post_id = apply_filters( 'wpml_object_id', $post_id, 'post' );

		// phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
		$post = get_post( $post_id, OBJECT );
		setup_postdata( $post );
		self::render_blocks( $content );
		wp_reset_postdata();
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
}
