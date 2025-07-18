<?php

class Setup_Block_Include implements Runnable {
	/**
	 * Runs the setup of the block include.
	 *
	 * @return void
	 */
	public static function run() {
		// Add the block file to the all.php file in the block base folder.
		$blocks_directory_path = Block_Details::get_instance()->get_blocks_path();

		if ( ! file_exists( $blocks_directory_path . '/all.php' ) ) {
			$all_file_contents = file_get_contents( CREODE_BLOCKS_PLUGIN_FOLDER . 'commands/stubs/all.php' );

			$all_file_contents = Block_Replacements::replace_string( $all_file_contents );

			file_put_contents( $blocks_directory_path . '/all.php', $all_file_contents );
		}

		$block_class_name = Block_Details::get_instance()->get_block_class_name();
		$block_class_path = Block_Details::get_instance()->get_relative_block_class_path();

		file_put_contents( $blocks_directory_path . '/all.php', PHP_EOL . 'require_once __DIR__ . \'' . $block_class_path . '\';', FILE_APPEND );
		file_put_contents( $blocks_directory_path . '/all.php', PHP_EOL . $block_class_name . '::init();', FILE_APPEND );
		file_put_contents( $blocks_directory_path . '/all.php', PHP_EOL, FILE_APPEND );
	}
}
