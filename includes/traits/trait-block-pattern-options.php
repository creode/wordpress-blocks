<?php
/**
 * Trait for managing and rendering integrated block pattern references.
 *
 * @package Creode Blocks
 */

namespace Creode_Blocks;

/**
 * Trait for managing and rendering integrated block pattern references.
 */
trait Trait_Block_Pattern_Options {

	/**
	 * Returns all configured block patterns for use in ACF select fields.
	 *
	 * @return array
	 */
	protected function get_block_pattern_choices(): array {
		$choices = array(
			'' => 'None',
		);

		$block_posts = get_posts(
			array(
				'post_type'   => 'wp_block',
				'numberposts' => -1,
			)
		);

		foreach ( $block_posts as $block_post ) {
			$choices[ $block_post->post_name ] = $block_post->post_title;
		}

		return $choices;
	}

	/**
	 * Renders a block pattern by slug.
	 *
	 * @param string $block_pattern_slug The slug of the pattern to render.
	 */
	public static function render_block_pattern( string $block_pattern_slug ): void {
		$block_posts = get_posts(
			array(
				'post_type' => 'wp_block',
				'numberposts' => -1,
			)
		);

		foreach ( $block_posts as $block_post ) {
			if ( $block_post->post_name !== $block_pattern_slug ) {
				continue;
			}

			$block_pattern = parse_blocks( '<!-- wp:block {"ref":' . $block_post->ID . '} /-->' )[0];
			echo wp_kses_post( render_block( $block_pattern ) );
		}
	}

	/**
	 * Renders a block pattern in the context of a post.
	 *
	 * @param int    $post_id The id of the post.
	 * @param string $block_pattern_slug The slug of the pattern to render.
	 */
	public static function render_block_pattern_in_post_context( int $post_id, string $block_pattern_slug ): void {
		global $post;

		$post = get_post( $post_id, OBJECT );
		setup_postdata( $post );
		self::render_block_pattern( $block_pattern_slug );
		wp_reset_postdata();
	}
}
