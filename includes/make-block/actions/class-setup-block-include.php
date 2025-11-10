<?php

namespace Creode_Blocks\Make_Block\Actions;

use Creode_Blocks\Make_Block\Services\Block_Details;
use Creode_Blocks\Make_Block\Services\Block_Replacements;

/**
 * Handles the creation and editing of the block include file.
 */
class Setup_Block_Include {
	/**
	 * The class for holding the block details.
	 *
	 * @var Block_Details
	 */
	protected $block_details;

	/**
	 * The class for holding the block replacements.
	 *
	 * @var Block_Replacements
	 */
	protected $block_replacements;

	/**
	 * Constructor.
	 *
	 * @param Block_Details $block_details The block details.
	 * @param Block_Replacements $block_replacements The block replacements.
	 */
	public function __construct( Block_Details $block_details, Block_Replacements $block_replacements ) {
		$this->block_details = $block_details;
		$this->block_replacements = $block_replacements;

		$this->handle();
	}

	/**
	 * Sets up the blocks include file.
	 */
	protected function handle() {
		// Add the block file to the all.php file in the block base folder.
		$blocks_directory_path = $this->block_details->package_path;

		if ( ! file_exists( $blocks_directory_path . '/all.php' ) ) {
			$all_file_contents = file_get_contents( $this->block_details->get_stubs_path() . '/all.php' );

			$all_file_contents = $this->block_replacements->replace_string( $all_file_contents );

			file_put_contents( $blocks_directory_path . '/all.php', $all_file_contents );
		}

		$block_class_name = $this->block_details->get_block_class_name();
		$block_class_path = $this->block_details->get_relative_block_class_path();

		file_put_contents( $blocks_directory_path . '/all.php', PHP_EOL . 'require_once __DIR__ . \'' . $block_class_path . '\';', FILE_APPEND );
		file_put_contents( $blocks_directory_path . '/all.php', PHP_EOL . $block_class_name . '::init();', FILE_APPEND );
		file_put_contents( $blocks_directory_path . '/all.php', PHP_EOL, FILE_APPEND );
	}
}
