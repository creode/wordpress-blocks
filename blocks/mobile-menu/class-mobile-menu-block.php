<?php
/**
 * Mobile Menu block class.
 *
 * @package Creode Blocks
 */

namespace Creode_Blocks;

use Walker_Nav_Menu;

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
				__DIR__ . '/templates/menu.php',
				array(
					array(
						'key'     => 'field_mobile_menu_block_menu_location',
						'name'    => 'menu_location',
						'label'   => 'Menu',
						'type'    => 'select',
						'choices' => $this->get_menu_choices(),
					),
				),
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
	private function register_script() {
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
				wp_localize_script(
					'mobile_menu',
					'mobileMenuConfig',
					array_merge(
						array(
							// When sub-menus are activated, ensure all external focusable elements are made non-focusable. Usefull when non-active menus/sub-menus are off screen. E.g. a slide-slide style menu format.
							'setFocusableStates'   => false,
							// If setFocusableStates is true, then makeParentLinksInert will also make inert any link that has a sub-menu. This means that the sub-menu can be activated and the parent link can be accessed from there.
							'makeParentLinksInert' => false,
						),
						$this->get_javascript_config()
					)
				);
			}
		);
	}

	/**
	 * Provides to overides to the default JavaScript config.
	 *
	 * @return array Overides to the default JavaScript config.
	 */
	protected function get_javascript_config(): array {
		return array();
	}

	/**
	 * Returns an array of menu render arguments.
	 *
	 * @link https://developer.wordpress.org/reference/functions/wp_nav_menu/ Full list of menu arguments.
	 * @return array An array of menu render arguments.
	 */
	public function get_menu_render_arguments(): array {
		return array();
	}

	/**
	 * Retrieve a menu walker instance.
	 *
	 * This method can be overridden to return:
	 * - Walker_Nav_Menu for a standard WordPress menu,
	 * - Toggle_Menu_Walker for menus with toggle buttons only,
	 * - Toggle_Menu_Walker_With_Parent_Links for menus with both toggle buttons and parent links (default).
	 *
	 * @return Walker_Nav_Menu Instance of the desired menu walker.
	 */
	public function get_menu_walker() {
		return new Walker_Nav_Menu();
	}
}

require_once __DIR__ . '/variations/class-side-slide-mobile-menu-block.php';
