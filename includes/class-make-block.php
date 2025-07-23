<?php

namespace Creode_Blocks;

use Creode_Blocks\Make_Block\Actions\{Create_New_Block_Files, Rename_Files, Replace_File_Contents, Setup_Block_Include, Setup_Scss_Include};
use Creode_Blocks\Make_Block\Services\Block_Details;
use Creode_Blocks\Make_Block\Services\Block_Replacements;

/**
 * Handles the creation of block files in desired location.
 */
class Make_Block {
	/**
	 * The label of the block.
	 *
	 * @var string
	 */
	protected $label;

	/**
	 * The slug of the theme.
	 *
	 * @var string
	 */
	protected $theme_slug;

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
	 * The class for creating new block files.
	 *
	 * @var Create_New_Block_Files
	 */
	public $create_new_block_files;

	/**
	 * The class for renaming files.
	 *
	 * @var Rename_Files
	 */
	public $rename_files;

	/**
	 * The class for replacing file contents.
	 *
	 * @var Replace_File_Contents
	 */
	public $replace_file_contents;

	/**
	 * The class for setting up the block include.
	 *
	 * @var Setup_Block_Include
	 */
	public $setup_block_include;

	/**
	 * Create the block.
	 *
	 * @param string $label The label of the block.
	 * @param string $theme_slug The slug of the theme.
	 */
	public function __construct( string $label, ?string $theme_slug = null ) {
		$this->label = $label;
		$this->theme_slug = $theme_slug;

		// Get the package path.
		$package_path = $this->get_package_path( $this->theme_slug );

		// Create a new block details and replacements classes.
		$this->block_details = new Block_Details( $this->label, $package_path );
		$this->block_replacements = new Block_Replacements( $this->block_details );

		// Call functionality to create the new block files.
		$this->create_new_block_files = new Create_New_Block_Files( $this->block_details );
		$this->rename_files           = new Rename_Files( $this->block_details, $this->block_replacements );
		$this->replace_file_contents  = new Replace_File_Contents( $this->block_details, $this->block_replacements );
		$this->setup_block_include    = new Setup_Block_Include( $this->block_details, $this->block_replacements );
	}

	/**
	 * Get the package path.
	 *
	 * @param string|null $theme_slug The slug of the theme.
	 *
	 * @return string
	 */
	protected function get_package_path( ?string $theme_slug ) {
		// TODO: Implement functionality for also using a plugin path.

		// If theme is not provided, use the current theme.
		if ( is_null( $theme_slug ) ) {
			$theme_base_path = get_stylesheet_directory();
		} else {
			$theme_base_path = get_theme_root() . '/' . $theme_slug;
		}

		return $theme_base_path . '/blocks';
	}
}
