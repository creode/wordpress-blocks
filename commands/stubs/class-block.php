<?php
/**
 * 
 */
use CreodeBlocks\Block;

class :BLOCK_CLASS_NAME extends Block {
	/**
	 * @inheritdoc
	 */
	protected function name() {
		return ':BLOCK_NAME';
	}

	/**
	 * @inheritdoc
	 */
	protected function label() {
		return ':BLOCK_LABEL';
	}

	/**
	 * @inheritdoc
	 */
	protected function fields() {
		return array();
	}

	/**
	 * @inheritdoc
	 */
	protected function template() {
		return :BLOCK_TEMPLATE;
	}
}
