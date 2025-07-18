<?php

class File {
	/**
	 * Gets all the files in a directory recursively.
	 *
	 * @param string $base_path The base path to the directory.
	 *
	 * @return array
	 */
	public static function get_all_files_in_directory( string $base_path ) {
		$directory = new RecursiveDirectoryIterator( $base_path );
		$iterator  = new RecursiveIteratorIterator( $directory );
		$files     = array();

		foreach ( $iterator as $file ) {
			if ( ! $file->isFile() ) {
				continue;
			}

			$files[] = $file->getPathname();
		}

		return $files;
	}
}
