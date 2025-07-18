<?php

/**
 * Handles the creation of block files in desired location.
 */
class Make_Block {
	/**
	 * Create the block.
	 */
	public static function run() {
		Create_New_Block_Files::run();
		Rename_Files::run();
		Replace_File_Contents::run();
		Setup_Block_Include::run();
		Setup_Scss_Include::run();
	}
}
