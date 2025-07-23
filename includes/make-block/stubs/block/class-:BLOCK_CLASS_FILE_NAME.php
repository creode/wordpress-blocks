<?php
/**
 * :BLOCK_LABEL block class.
 *
 * @package :PACKAGE_NAME
 */

use Creode_Blocks\Block;

/**
 * :BLOCK_LABEL block class.
 *
 * @wordpress-block-version :BLOCK_PLUGIN_VERSION
 */
class :BLOCK_CLASS_NAME extends Block {

	/**
	 * The blocks icon from https://developer.wordpress.org/resource/dashicons/ or an inline SVG.
	 *
	 * @var string
	 */
	protected $icon = 'block-default';

	/**
	 * {@inheritdoc}
	 */
	protected function name(): string {
		return ':BLOCK_SLUG';
	}

	/**
	 * {@inheritdoc}
	 */
	protected function label(): string {
		return ':BLOCK_LABEL';
	}

	/**
	 * {@inheritdoc}
	 */
	protected function fields(): array {
		return array();
	}

	/**
	 * {@inheritdoc}
	 */
	protected function child_blocks(): array {
		return array();
	}

	/**
	 * {@inheritdoc}
	 */
	protected function template(): string {
		return :BLOCK_TEMPLATE;
	}

	/**
	 * {@inheritdoc}
	 */
	protected function supports(): array {
		return array(
			'mode'  => false,
			'color' => array(
				'text'       => true,
				'background' => true,
			),
		);
	}
}
