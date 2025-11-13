<?php
/**
 * Tabs block class.
 *
 * @package Creode Blocks
 */

namespace Creode_Blocks;

/**
 * Tabs block class.
 *
 * @wordpress-block-version 2.6.0
 */
class Tabs_Block extends Block {

	use Trait_Block_Pattern_Options;
	use Trait_Has_Reduce_Bottom_Space_Option;

	/**
	 * The blocks icon from https://developer.wordpress.org/resource/dashicons/ or an inline SVG.
	 *
	 * @var string
	 */
	protected $icon = 'table-row-after';

	/**
	 * {@inheritdoc}
	 */
	protected function name(): string {
		return 'tabs';
	}

	/**
	 * {@inheritdoc}
	 */
	protected function label(): string {
		return 'Tabs';
	}

	/**
	 * {@inheritdoc}
	 */
	protected function additional_attributes(): array {
		return array(
			'active_tab' => array(
				'type'    => 'number',
				'default' => 0,
			),
			'patterns' => array(
				'type'    => 'string',
				'default' => array(),
			),
		);
	}

	/**
	 * {@inheritdoc}
	 */
	protected function child_blocks(): array {
		return array(
			new Child_Block(
				'tab',
				'Tab',
				array(
					array(
						'key'     => 'field_tabs_block_pattern',
						'name'    => 'pattern',
						'label'   => 'Pattern',
						'type'    => 'select',
						'choices' => $this->get_block_pattern_choices(),
					),
				),
				__DIR__ . '/templates/tab.php',
				array(),
				'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" context="list-view" aria-hidden="true" focusable="false"><path d="M19 6H6c-1.1 0-2 .9-2 2v9c0 1.1.9 2 2 2h13c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2zM6 17.5c-.3 0-.5-.2-.5-.5V8c0-.3.2-.5.5-.5h3v10H6zm13.5-.5c0 .3-.2.5-.5.5h-3v-10h3c.3 0 .5.2.5.5v9z"></path></svg>',
				array(
					'mode'  => false,
					'color' => array(
						'text'       => false,
						'background' => true,
					),
				)
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
	protected function supports(): array {
		return array(
			'mode'  => false,
			'color' => array(
				'text'       => false,
				'background' => true,
			),
		);
	}

	/**
	 * {@inheritdoc}
	 */
	protected function admin_scripts(): array {
		return array(
			new Script(
				'tabs-block',
				plugin_dir_url( __FILE__ ) . 'assets/admin.js',
				array( 'jquery', 'admin-block-initializer', 'admin-block' ),
				'1.0.0'
			),
		);
	}

	/**
	 * {@inheritdoc}
	 */
	protected function scripts(): array {
		return array(
			new Script(
				'tabs-block',
				plugin_dir_url( __FILE__ ) . 'assets/tabs.js',
				array( 'jquery' ),
				'1.0.0'
			),
		);
	}
}
