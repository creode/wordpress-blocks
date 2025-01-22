<?php
/**
 * :BLOCK_LABEL block class.
 *
 * @package :THEME_SLUG
 */

use Creode_Blocks\Block;

/**
 * :BLOCK_LABEL block class.
 */
class :BLOCK_CLASS_NAME extends Block {

	/**
	 * Singleton instance of this class.
	 *
	 * @var :BLOCK_CLASS_NAME|null
	 */
	protected static $instance = null;

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
		return ':BLOCK_NAME';
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
