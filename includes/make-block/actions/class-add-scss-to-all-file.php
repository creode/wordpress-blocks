<?php

namespace Creode_Blocks\Make_Block\Actions;

use Creode_Theme\All_Blocks_Scss_File_Generator;
use Creode_Theme\Command_Message_Handler;

/**
 * Handles the addition of SCSS to the all file.
 */
class Add_Scss_To_All_File {
	/**
	 * Constructor for class.
	 *
	 * @param string $theme_slug The slug of the theme.
	 */
	public function __construct( protected string $theme_slug ) {
		$this->handle();
	}

	/**
	 * Delegates the SCSS generation to the theme modifier.
	 *
	 * @throws Exception If the block already exists.
	 */
	protected function handle() {
		// Check if a class exists in theme.
		if ( ! class_exists( 'Creode_Theme\All_Blocks_Scss_File_Generator' ) ) {
			return;
		}

		// Create a new instance of the All Blocks SCSS File Generator.
		new All_Blocks_Scss_File_Generator( $this->theme_slug, new Command_Message_Handler() );
	}
}
