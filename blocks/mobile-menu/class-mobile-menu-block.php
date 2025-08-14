<?php
/**
 * Mobile Menu block class.
 *
 * @package Creode Blocks
 */

namespace Creode_Blocks;

/**
 * Mobile Menu block class.
 *
 * @wordpress-block-version 1.10.1
 */
class Mobile_Menu_Block extends Block {

	use Trait_Restrict_To_Site_Editor;
	use Trait_Menu_Integration;

	/**
	 * The blocks icon from https://developer.wordpress.org/resource/dashicons/ or an inline SVG.
	 *
	 * @var string
	 */
	protected $icon = 'menu';

	/**
	 * {@inheritdoc}
	 */
	protected function name(): string {
		return 'mobile-menu';
	}

	/**
	 * {@inheritdoc}
	 */
	protected function label(): string {
		return 'Mobile Menu';
	}

	/**
	 * {@inheritdoc}
	 */
	protected function child_blocks(): array {
		return array(
			new Child_Block(
				'menu',
				'Menu',
				array(
					array(
						'key'     => 'field_mobile_menu_block_menu_location',
						'name'    => 'menu_location',
						'label'   => 'Menu',
						'type'    => 'select',
						'choices' => $this->get_menu_choices(),
					),
				),
				__DIR__ . '/templates/menu.php',
				array(),
				'menu'
			),
		);
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
	protected function use_default_wrapper_template(): bool {
		return false;
	}

	/**
	 * {@inheritdoc}
	 */
	protected function setup(): bool {
		$this->register_script();
		return parent::setup();
	}

	/**
	 * Registers the mobile-menu JavaScript file.
	 */
	protected function register_script() {
		add_action(
			'wp_enqueue_scripts',
			function () {
				wp_register_script(
					'mobile_menu',
					plugin_dir_url( __FILE__ ) . 'assets/mobile-menu.js',
					array(
						'jquery',
					),
					1,
					true
				);
			}
		);
	}
}
