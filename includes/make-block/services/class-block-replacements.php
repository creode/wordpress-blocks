<?php

namespace Creode_Blocks\Make_Block\Services;

/**
 * Handles the replacements for the block.
 */
class Block_Replacements {
	/**
	 * The class for holding the block details.
	 *
	 * @var Block_Details
	 */
	protected $block_details;

	/**
	 * Constructor.
	 *
	 * @param Block_Details $block_details The block details.
	 */
	public function __construct( Block_Details $block_details ) {
		$this->block_details = $block_details;
	}

	/**
	 * Gets the replacements.
	 *
	 * @return array
	 */
	public function get_replacements(): array {
		$replacements = array(
			// Block Details.
			':BLOCK_LABEL'           => $this->block_details->block_label,
			':BLOCK_SLUG'            => $this->block_details->get_block_slug_name(),
			':BLOCK_TEMPLATE'        => $this->block_details->get_block_template_path(),
			':BLOCK_CLASS_NAME'      => $this->block_details->get_block_class_name(),
			':BLOCK_FOLDER'          => $this->block_details->get_block_folder_name(),
			':BLOCK_FOLDER_PATH'     => $this->block_details->get_block_folder_path(),
			':BLOCK_HTML_BASE_CLASS' => $this->block_details->get_block_html_base_class(),
			':BLOCK_PLUGIN_VERSION'  => $this->block_details->get_block_plugin_version(),

			// Package Details.
			':PACKAGE_NAME' => $this->block_details->get_package_name(),
			':PACKAGE_SLUG' => $this->block_details->get_package_slug(),
		);

		// Allow other plugins/themes to add their own replacements or change existing ones.
		$replacements = apply_filters( 'wordpress_blocks_replacements', $replacements );

		return $replacements;
	}

	/**
	 * Replaces the placeholders in a string.
	 *
	 * @param string $string The string to replace the placeholders in.
	 *
	 * @return string
	 */
	public function replace_string( string $string ) {
		// Loop through all the replacements and replace the placeholders.
		foreach ( $this->get_replacements() as $placeholder => $replacement ) {
			$string = str_replace( $placeholder, $replacement, $string );
		}

		return $string;
	}
}
