<?php
/**
 * Side-slide mobile Menu block class.
 *
 * @package Creode Blocks
 */

namespace Creode_Blocks;

/**
 * Mobile Menu block class.
 *
 * @wordpress-block-version 1.10.1
 */
class Side_Slide_Mobile_Menu_Block extends Mobile_Menu_Block {

	/**
	 * {@inheritdoc}
	 */
	public function get_menu_walker() {
		return new Toggle_Menu_Walker_With_Parent_Links();
	}

	/**
	 * {@inheritdoc}
	 */
	protected function get_javascript_config(): array {
		return array(
			'setFocusableStates'   => true,
			'makeParentLinksInert' => true,
		);
	}
}
