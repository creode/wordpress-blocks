<?php

/**
 * Handles the creation of new block files.
 */
class Create_New_Block_Files {
	/**
	 * Runs the creation of the new block files.
	 *
	 * @throws Exception If the block already exists.
	 */
	public static function run() {
		// Get the block folder path.
		$block_folder_path = Block_Details::get_instance()->get_block_folder_path();

		// Check if the block exists.
		if ( file_exists( $block_folder_path ) ) {
			throw new Exception( 'Block already exists.' );
		}

		// Create the block folder, if it doesn't exist.
		if ( ! file_exists( $block_folder_path ) ) {
			mkdir( $block_folder_path );
		}

		// Copy the stubs directory to the block folder.
		$source = CREODE_BLOCKS_PLUGIN_FOLDER . 'commands/stubs/block';
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
