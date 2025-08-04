<?php

namespace Creode_Blocks\Make_Block\Actions;

use Creode_Blocks\Make_Block\Services\Block_Details;
use Creode_Blocks\Make_Block\Services\Block_Options;

/**
 * Handles the creation of new block files.
 */
class Create_New_Block_Files {
	/**
	 * Constructor for the class.
	 *
	 * @param Block_Details $block_details The block details.
	 * @param boolean       $no_scss The no scss flag.
	 */
	public function __construct( protected Block_Details $block_details, protected Block_Options $block_options ) {
		$this->handle();
	}

	/**
	 * Runs the creation of the new block files.
	 *
	 * @throws \Exception If the block already exists.
	 */
	protected function handle() {
		// Get the block folder path.
		$block_folder_path = $this->block_details->get_block_folder_path();

		// Check if the block exists.
		if ( file_exists( $block_folder_path ) ) {
			throw new \Exception( 'Block already exists.' );
		}

		// Create the block folder, if it doesn't exist.
		if ( ! file_exists( $block_folder_path ) ) {
			// phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_mkdir
			mkdir( $block_folder_path );
		}

		// Copy the stubs directory to the block folder.
		$source      = $this->block_details->get_stubs_path() . '/block';
		$destination = $block_folder_path;

		// Recursively copy the stubs directory to the block folder.
		self::recursive_copy( $source, $destination, $this->block_options );
	}

	/**
	 * Recursively copy the stubs directory to the block folder.
	 *
	 * @param string $source The source directory.
	 * @param string $destination The destination directory.
	 * @return void
	 */
	protected static function recursive_copy( $source, $destination, Block_Options $block_options ) {
		$dir = opendir( $source );
		@mkdir( $destination );

		while ( false !== ( $file = readdir( $dir ) ) ) {
			if ( '.' !== $file && '..' !== $file ) {
				if ( is_dir( $source . '/' . $file ) ) {
					self::recursive_copy( $source . '/' . $file, $destination . '/' . $file, $block_options );
				} else {
					self::copy_file( $source . '/' . $file, $destination . '/' . $file, $block_options );
				}
			}
		}

		closedir( $dir );
	}

	/**
	 * Copy a file to the destination.
	 *
	 * @param string $source The source file.
	 * @param string $destination The destination file.
	 * @return void
	 */
	protected static function copy_file( $source, $destination, Block_Options $block_options ) {
		// If the file is a scss file and the no scss flag is set, skip the file.
		if ( str_ends_with( $source, '.scss' ) && ! $block_options->get_scss() ) {
			return;
		}

		copy( $source, $destination );
	}
}
