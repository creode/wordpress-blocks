<?php
/**
 * Header block definition.
 *
 * @package Creode Blocks
 */

namespace Creode_Blocks;

/**
 * Header block definition.
 */
class Header_Block extends Block {

	use Trait_Menu_Integration;

	/**
	 * Singleton instance of this class.
	 *
	 * @var Block
	 */
	protected static $instance = null;

	/**
	 * @inheritdoc
	 */
	protected $icon = 'menu';

	/**
	 * {@inheritDoc}
	 */
	protected function name(): string {
		return 'creode-header';
	}

	/**
	 * {@inheritDoc}
	 */
	protected function label(): string {
		return 'Creode Header';
	}

	/**
	 * {@inheritDoc}
	 */
	protected function fields(): array {
		return array();
	}

	/**
	 * {@inheritDoc}
	 */
	protected function template(): string {
		return plugin_dir_path( __FILE__ ) . 'templates/header.php';
	}

	/**
	 * {@inheritDoc}
	 */
	protected function child_blocks(): array {
		return array(
			new Child_Block(
				'logo',
				'Logo',
				array(),
				plugin_dir_path( __FILE__ ) . 'templates/logo.php'
			),
			new Child_Block(
				'general',
				'General',
				array(),
				plugin_dir_path( __FILE__ ) . 'templates/general.php'
			),
			new Child_Block(
				'menu',
				'Menu',
				array(
					array(
						'key'     => 'field_header_menu',
						'label'   => 'Menu',
						'name'    => 'menu_id',
						'type'    => 'select',
						'choices' => $this->get_menu_choices(),
					),
				),
				plugin_dir_path( __FILE__ ) . 'templates/menu.php'
			),
		);
	}
}
