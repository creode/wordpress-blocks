<?php
/**
 * Desktop Menu block class.
 *
 * @package Creode Blocks
 */

namespace Creode_Blocks;

/**
 * Desktop Menu block class.
 *
 * @wordpress-block-version 1.10.1
 */
class Desktop_Menu_Block extends Block {

	use Trait_Restrict_To_Site_Editor;
	use Trait_Menu_Integration;

	/**
	 * The blocks icon from https://developer.wordpress.org/resource/dashicons/ or an inline SVG.
	 *
	 * @var string
	 */
	protected $icon = '<svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" width="24" height="24" aria-hidden="true" focusable="false"><path d="M12 4c-4.4 0-8 3.6-8 8s3.6 8 8 8 8-3.6 8-8-3.6-8-8-8zm0 14.5c-3.6 0-6.5-2.9-6.5-6.5S8.4 5.5 12 5.5s6.5 2.9 6.5 6.5-2.9 6.5-6.5 6.5zM9 16l4.5-3L15 8.4l-4.5 3L9 16z"></path></svg>';

	/**
	 * {@inheritdoc}
	 */
	protected function name(): string {
		return 'desktop-menu';
	}

	/**
	 * {@inheritdoc}
	 */
	protected function label(): string {
		return 'Desktop Menu';
	}

	/**
	 * {@inheritdoc}
	 */
	protected function fields(): array {
		return array(
			array(
				'key'     => 'field_desktop_menu_block_menu_location',
				'name'    => 'menu_location',
				'label'   => 'Menu',
				'type'    => 'select',
				'choices' => $this->get_menu_choices(),
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
	 * Returns an array of menu render arguments.
	 *
	 * @link https://developer.wordpress.org/reference/functions/wp_nav_menu/ Full list of menu arguments.
	 * @return array An array of menu render arguments.
	 */
	public function get_menu_render_arguments(): array {
		return array();
	}
}
