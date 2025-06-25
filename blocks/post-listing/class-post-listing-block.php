<?php
/**
 * Post Listing block definition.
 *
 * @package Creode Blocks
 */

namespace Creode_Blocks;

/**
 * Post Listing block class.
 */
class Post_Listing_Block extends Block {

	/**
	 * Singleton instance of this class.
	 *
	 * @var Post_Listing_Block|null
	 */
	protected static $instance = null;

	/**
	 * The blocks icon from https://developer.wordpress.org/resource/dashicons/ or an inline SVG.
	 *
	 * @var string
	 */
	protected $icon = 'list-view';

	/**
	 * {@inheritdoc}
	 */
	protected function name(): string {
		return 'post-listing';
	}

	/**
	 * {@inheritdoc}
	 */
	protected function label(): string {
		return 'Post Listing';
	}

	/**
	 * {@inheritdoc}
	 */
	protected function template(): string {
		return __DIR__ . '/templates/block.php';
	}

	/**
	 * {@inheritdoc}
	 */
	protected function child_blocks(): array {
		return array(
			new Child_Block(
				'inner',
				'Post Listing - Inner',
				array(),
				__DIR__ . '/templates/inner.php',
				array(
					new Child_Block(
						'sections',
						'Post Listing - Sections',
						array(),
						__DIR__ . '/templates/sections.php',
						array(
							new Child_Block(
								'section',
								'Post Listing - Section',
								array(),
								__DIR__ . '/templates/section.php',
								array(),
								'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" aria-hidden="true" focusable="false"><path d="M19 6H6c-1.1 0-2 .9-2 2v9c0 1.1.9 2 2 2h13c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2zM6 17.5c-.3 0-.5-.2-.5-.5V8c0-.3.2-.5.5-.5h3v10H6zm13.5-.5c0 .3-.2.5-.5.5h-3v-10h3c.3 0 .5.2.5.5v9z"></path></svg>'
							),
						),
						'<svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" width="24" height="24" aria-hidden="true" focusable="false"><path fill-rule="evenodd" clip-rule="evenodd" d="M15 7.5h-5v10h5v-10Zm1.5 0v10H19a.5.5 0 0 0 .5-.5V8a.5.5 0 0 0-.5-.5h-2.5ZM6 7.5h2.5v10H6a.5.5 0 0 1-.5-.5V8a.5.5 0 0 1 .5-.5ZM6 6h13a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2Z"></path></svg>'
					),
				),
				'list-view',
			),
		);
	}

	/**
	 * Returns the inner block template structure as an array.
	 *
	 * @return The inner block template structure as an array.
	 */
	public function get_inner_block_template(): array {
		return apply_filters(
			'creode_blocks_post_listing_inner_block_template',
			array(
				array(
					'core/query',
					array(),
					array(
						array(
							'acf/post-listing-inner',
							array(),
							$this->get_section_structure_block_template(),
						),
					),
				),
			)
		);
	}

	/**
	 * Returns the inner block section structure template as an array.
	 * Top-level blocks must be of type "acf/post-listing-inner-sections".
	 * Second-level blocks must be of type "acf/post-listing-inner-sections-section".
	 * Third-level blocks must conform to the allowed inner blocks provided by the "get_allowed_inner_blocks" function below.
	 *
	 * @return The inner block section structure template as an array.
	 */
	public function get_section_structure_block_template(): array {
		return apply_filters(
			'creode_blocks_post_listing_section_structure_template',
			array(
				array(
					'acf/post-listing-inner-sections',
					array(),
					array(
						array(
							'acf/post-listing-inner-sections-section',
							array(),
							array(
								array(
									'core/post-template',
									array(),
									array(
										array(
											'acf/integrated-pattern',
										),
									),
								),
								array(
									'core/query-no-results',
								),
							),
						),
					),
				),
				array(
					'acf/post-listing-inner-sections',
					array(),
					array(
						array(
							'acf/post-listing-inner-sections-section',
							array(),
							array(
								array(
									'core/query-pagination',
								),
							),
						),
					),
				),
			)
		);
	}

	/**
	 * Returns an array of blocks which are allowed to be nested within the "acf/post-listing-inner-sections-section" block.
	 *
	 * @return An array of allowed blocks.
	 */
	public function get_allowed_inner_blocks(): array {
		return apply_filters(
			'creode_blocks_post_listing_allowed_inner_blocks',
			array(
				'core/post-template',
				'core/query-no-results',
				'core/query-pagination',
			)
		);
	}
}
