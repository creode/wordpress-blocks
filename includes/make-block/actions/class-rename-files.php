<?php

namespace Creode_Blocks\Make_Block\Actions;

use Creode_Blocks\Make_Block\Services\Block_Details;
use Creode_Blocks\Make_Block\Services\Block_Replacements;
use Creode_Blocks\Make_Block\Services\File;

/**
 * Handles the renaming of the files.
 */
class Rename_Files {
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
	 * @param Block_Details $block_details
	 * @param Block_Replacements $block_replacements
	 */
	public function __construct( Block_Details $block_details, Block_Replacements $block_replacements ) {
		$this->block_details      = $block_details;
		$this->block_replacements = $block_replacements;

		$this->handle();
	}

	/**
	 * Runs the renaming of the files.
	 */
	protected function handle() {
		// Get files and loop through them, applying placeholder renames.
		$files = File::get_all_files_in_directory( $this->block_details->get_block_folder_path() );
		foreach ( $files as $file ) {
			// Skip if the file is a directory.
			if ( is_dir( $file ) ) {
				continue;
			}

			// Get the file name.
			$file_name = basename( $file );

			// Get the replacements.
			$replacements = $this->block_replacements->get_replacements();

			// Replace the placeholders.
			$file_name = str_replace( array_keys( $replacements ), array_values( $replacements ), $file_name );

			// Rename the file, preserve the path from the $file attribute.
			rename( $file, dirname( $file ) . '/' . $file_name );
		}
	}
}
