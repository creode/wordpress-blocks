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
	protected function fields(): array {
		$fields = array();

		$fields = array_merge( $fields, $this->get_sort_overide_fields() );

		return $fields;
	}

	/**
	 * Returns an ACF fields array for providing sort option overides.
	 *
	 * @return array The sort fields array.
	 */
	protected function get_sort_overide_fields(): array {
		$fields = array(
			array(
				'key'          => 'field_post_listing_sort_by',
				'name'         => 'sort_by',
				'label'        => 'Sort By (Override)',
				'instructions' => 'Select how you want to sort the posts. This will override the sort order set in the query block settings.',
				'type'         => 'select',
				'choices'      => array(
					''          => 'No override',
					'metafield' => 'Metafield',
				),
			),
		);

		$fields = array_merge( $fields, $this->get_metafield_sort_fields() );

		return $fields;
	}

	/**
	 * Returns an ACF fields array for providing metafield sort options.
	 *
	 * @return array The metafield sort fields array.
	 */
	protected function get_metafield_sort_fields(): array {
		$fields            = array();
		$metafields        = $this->get_metafield_sort_options();
		$conditional_logic = array(
			array(
				'field'    => 'field_post_listing_sort_by',
				'operator' => '==',
				'value'    => 'metafield',
			),
		);

		if ( ! empty( $metafields ) ) {
			$fields = array_merge(
				$fields,
				array(
					array(
						'key'               => 'field_post_listing_metafield_sort_by',
						'name'              => 'metafield_sort_by',
						'label'             => 'Metafield Sort By',
						'instructions'      => 'Select the metafield to sort the posts by.',
						'type'              => 'select',
						'choices'           => $metafields,
						'conditional_logic' => $conditional_logic,
					),
					array(
						'key'               => 'field_post_listing_metafield_sort_order',
						'name'              => 'metafield_sort_order',
						'label'             => 'Metafield Sort Order',
						'instructions'      => 'Select the direction to sort the posts by.',
						'type'              => 'select',
						'default_value'     => 'DESC',
						'conditional_logic' => $conditional_logic,
						'choices'           => array(
							'ASC'  => 'Ascending',
							'DESC' => 'Descending',
						),
					),
				)
			);
		} else {
			array_push(
				$fields,
				array(
					'key'               => 'field_post_listing_metafield_sort_message',
					'type'              => 'message',
					'message'           => 'No sortable metafields found. Please contact the theme developer if you need to sort by a metafield.',
					'conditional_logic' => $conditional_logic,
				)
			);
		}

		return $fields;
	}

	/**
	 * Returns a keyed array of metafield sort options. Keys are the metafield names and values are the metafield labels.
	 *
	 * @return array The metafield sort options array.
	 */
	protected function get_metafield_sort_options(): array {
		return array();
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

	/**
	 * {@inheritdoc}
	 */
	protected function setup(): bool {
		$this->modify_query_args();
		return parent::setup();
	}

	/**
	 * Modifies the query args based on the block settings.
	 */
	protected function modify_query_args(): void {
		add_filter(
			'query_loop_block_query_vars',
			function ( $query_args, $block ) {
				if ( isset( $block->attributes['dynamic_context'] ) ) {
					$query_args = $this->modify_query_args_based_on_dynamic_context( $query_args, $block->attributes['dynamic_context'] );
				}

				return $query_args;
			},
			10,
			2
		);
	}

	/**
	 * Modifies the query args based on the block's dynamic context.
	 *
	 * @param array $query_args The query args.
	 * @param array $dynamic_context The block's dynamic context.
	 * @return array The modified query args.
	 */
	protected function modify_query_args_based_on_dynamic_context( $query_args, $dynamic_context ): array {
		if ( isset( $dynamic_context['creode_blocks_sort_by'] ) ) {
			switch ( $dynamic_context['creode_blocks_sort_by'] ) {
				case 'metafield':
					$query_args['meta_key'] = $dynamic_context['sort_meta_key'];
					$query_args['orderby']  = 'meta_value';
					$query_args['order']    = $dynamic_context['sort_meta_order'];
					break;
			}
		}

		return $query_args;
	}
}
