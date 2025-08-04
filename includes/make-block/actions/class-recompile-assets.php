<?php
/**
 * Handles the recompilation of assets.
 *
 * @package Creode Blocks
 */

namespace Creode_Blocks\Make_Block\Actions;

use Creode_Theme\Asset_Builder;
use Creode_Theme\Command_Message_Handler;

/**
 * Handles the recompilation of assets.
 */
class Recompile_Assets {
	/**
	 * Constructor for class.
	 *
	 * @param string $theme_slug The slug of the theme.
	 */
	public function __construct( protected string $theme_slug ) {
		$this->handle();
	}

	/**
	 * Delegates the asset recompilation to the theme modifier.
	 */
	protected function handle() {
		// Check if a class exists in theme.
		if ( ! class_exists( 'Creode_Theme\Asset_Builder' ) ) {
			return;
		}

		new Asset_Builder( $this->theme_slug, new Command_Message_Handler() );
	}
}
