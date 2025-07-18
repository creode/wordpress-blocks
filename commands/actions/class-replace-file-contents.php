<?php

/**
 * Handles the replacement of file contents.
 */
class Replace_File_Contents implements Runnable {
	/**
	 * Runs the replacements.
	 *
	 * @return void
	 */
	public static function run() {
		$files = File::get_all_files_in_directory( Block_Details::get_instance()->get_block_folder_path() );

		// Loop through the files and replace the contents.
		foreach ( $files as $file ) {
			// Skip if the file is a directory.
			if ( is_dir( $file ) ) {
				continue;
			}

			// Get the contents of the file.
			$file_contents = file_get_contents( $file );

			// Get the replacements.
			$replacements = Block_Replacements::get_replacements();

			// Replace the contents.
			$file_contents = str_replace( array_keys( $replacements ), array_values( $replacements ), $file_contents );

			// Write the contents back to the file.
			file_put_contents( $file, $file_contents );
		}
	}
}
