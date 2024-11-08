<?php
/**
 * Integrated Menu block definition.
 *
 * @package Creode Blocks
 */

namespace Creode_Blocks;

/**
 * Integrated Manu block definition.
 */
class Integrated_Menu_Block extends Block {

	use Trait_Menu_Integration;

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
		return 'integrated-menu';
	}

	/**
	 * {@inheritDoc}
	 */
	protected function label(): string {
		return 'Integrated Menu';
	}

	/**
	 * {@inheritDoc}
	 */
	protected function description(): string {
		return 'A block for integrating a menu. This block will ensure that a menu is referenced by menu location, not ID (as per core WordPress functionality). This block can be safely included within template files and pattern slugs can be matched on different environments to avoid hard-coded IDs.';
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
				'key'          => 'field_integrated_menu_block_menu_location',
				'label'        => 'Menu Location',
				'name'         => 'menu_location',
				'type'         => 'select',
				'choices'      => $this->get_menu_choices(),
				'instructions' => 'Select a menu location.',
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
