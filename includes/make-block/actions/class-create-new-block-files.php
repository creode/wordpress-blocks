<?php

namespace Creode_Blocks\Make_Block\Actions;

use Creode_Blocks\Make_Block\Services\Block_Details;

/**
 * Handles the creation of new block files.
 */
class Create_New_Block_Files {
	/**
	 * The class for holding the block details.
	 *
	 * @var Block_Details
	 */
	protected $block_details;

	public function __construct( Block_Details $block_details ) {
		$this->block_details = $block_details;

		$this->handle();
	}

	/**
	 * Runs the creation of the new block files.
	 *
	 * @throws Exception If the block already exists.
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
			mkdir( $block_folder_path );
		}

		// Copy the stubs directory to the block folder.
		$source = $this->block_details->get_stubs_path() . '/block';
		$destination = $block_folder_path;

		// Recursively copy the stubs directory to the block folder.
		self::recursive_copy( $source, $destination );
	}

	/**
	 * Recursively copy the stubs directory to the block folder.
	 *
	 * @param string $source The source directory.
	 * @param string $destination The destination directory.
	 * @return void
	 */
	protected static function recursive_copy( $source, $destination ) {
		$dir = opendir( $source );
		@mkdir( $destination );

		while ( false !== ( $file = readdir( $dir ) ) ) {
			if ( '.' !== $file && '..' !== $file ) {
				if ( is_dir( $source . '/' . $file ) ) {
					self::recursive_copy( $source . '/' . $file, $destination . '/' . $file );
				} else {
					copy( $source . '/' . $file, $destination . '/' . $file );
				}
			}
		}

		closedir( $dir );
	}
}
