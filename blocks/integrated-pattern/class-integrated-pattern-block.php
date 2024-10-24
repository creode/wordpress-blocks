<?php
/**
 * Integrated Pattern block definition.
 *
 * @package Creode Blocks
 */

namespace Creode_Blocks;

/**
 * Integrated Pattern block definition.
 */
class Integrated_Pattern_Block extends Block {

	use Trait_Block_Pattern_Options;

	/**
	 * Singleton instance of this class.
	 *
	 * @var Integrated_Pattern_Block
	 */
	protected static $instance = null;

	/**
	 * The block icon.
	 *
	 * @var string
	 */
	protected $icon = 'admin-links';

	/**
	 * {@inheritDoc}
	 */
	protected function name(): string {
		return 'integrated-pattern';
	}

	/**
	 * {@inheritDoc}
	 */
	protected function label(): string {
		return 'Integrated Pattern';
	}

	/**
	 * {@inheritDoc}
	 */
	protected function description(): string {
		return 'A block for integrating a pattern. This block will ensure that a pattern is referenced by slug, not ID (as per core WordPress functionality). This block can be safely included within template files and pattern slugs can be matched on different environments to avoid hard-coded IDs.';
	}

	/**
	 * {@inheritDoc}
	 */
	protected function category(): string {
		return 'creode-utilities';
	}

	/**
	 * {@inheritDoc}
	 */
	protected function fields(): array {
		return array(
			array(
				'key'          => 'field_integrated_pattern_block_pattern',
				'label'        => 'Block Pattern',
				'name'         => 'block_pattern',
				'type'         => 'select',
				'choices'      => $this->get_block_pattern_choices(),
				'instructions' => 'Select a pattern to show. <a href="/wp-admin/site-editor.php?postType=wp_block" target="_blank">Click here</a> to configure patterns.',
			),
		);
	}

	/**
	 * {@inheritDoc}
	 */
	protected function template(): string {
		return plugin_dir_path( __FILE__ ) . 'templates/block.php';
	}
}
