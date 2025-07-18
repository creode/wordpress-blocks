<?php

class Rename_Files implements Runnable {
	/**
	 * Runs the renaming of the files.
	 *
	 * @return void
	 */
	public static function run() {
		$files = File::get_all_files_in_directory( Block_Details::get_instance()->get_block_folder_path() );

		// Loop through the files and apply placeholder renames.
		foreach ( $files as $file ) {
			// Skip if the file is a directory.
			if ( is_dir( $file ) ) {
				continue;
			}

			// Get the file name.
			$file_name = basename( $file );

			// Get the replacements.
			$replacements = Block_Replacements::get_replacements();

			// Replace the placeholders.
			$file_name = str_replace( array_keys( $replacements ), array_values( $replacements ), $file_name );

			// Rename the file, preserve the path from the $file attribute.
			rename( $file, dirname( $file ) . '/' . $file_name );
		}
	}
}
