<?php

/**
 * Handles the replacements for the block.
 */
class Block_Replacements {
	/**
	 * Gets the replacements.
	 *
	 * @return array
	 */
	public static function get_replacements(): array {
		$replacements = array(
			// Block Details.
			':BLOCK_LABEL'           => Block_Details::get_instance()->block_label,
			':BLOCK_SLUG'            => Block_Details::get_instance()->get_block_slug_name(),
			':BLOCK_TEMPLATE'        => Block_Details::get_instance()->get_block_template_path(),
			':BLOCK_CLASS_NAME'      => Block_Details::get_instance()->get_block_class_name(),
			':BLOCK_FOLDER'          => Block_Details::get_instance()->get_block_folder_name(),
			':BLOCK_FOLDER_PATH'     => Block_Details::get_instance()->get_block_folder_path(),
			':BLOCK_HTML_BASE_CLASS' => Block_Details::get_instance()->get_block_html_base_class(),
			':BLOCK_PLUGIN_VERSION'  => Block_Details::get_instance()->get_block_plugin_version(),

			// Theme Details.
			':THEME_NAME'        => Block_Details::get_instance()->get_theme_name(),
			':THEME_SLUG'        => Block_Details::get_instance()->block_theme_slug,
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
	public static function replace_string( string $string ) {
		// Loop through all the replacements and replace the placeholders.
		foreach ( self::get_replacements() as $placeholder => $replacement ) {
			$string = str_replace( $placeholder, $replacement, $string );
		}

		return $string;
	}
}
