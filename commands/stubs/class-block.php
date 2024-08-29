<?php
/**
 * :BLOCK_NAME
 */
use CreodeBlocks\Block;

class :BLOCK_CLASS_NAME extends Block {
	/**
	 * The blocks icon from https://developer.wordpress.org/resource/dashicons/
	 *
	 * @var string
	 */
	protected $icon = 'block-default';

	/**
	 * @inheritdoc
	 */
	protected function name(): string {
		return ':BLOCK_NAME';
	}

	/**
	 * @inheritdoc
	 */
	protected function label(): string {
		return ':BLOCK_LABEL';
	}

	/**
	 * @inheritdoc
	 */
	protected function fields(): array {
		return array();
	}

	/**
	 * @inheritdoc
	 */
	protected function template(): string {
		return :BLOCK_TEMPLATE;
	}
}
