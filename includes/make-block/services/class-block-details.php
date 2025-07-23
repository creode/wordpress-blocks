<?php

namespace Creode_Blocks\Make_Block\Services;

/**
 * Holds details about the block, like the name, slug, class name, path, etc.
 */
class Block_Details {
	/**
	 * The label of the block.
	 *
	 * @var string
	 */
	public $block_label;

	/**
	 * The path to the package.
	 *
	 * @var string
	 */
	public $package_path;

	/**
	 * Constructor.
	 *
	 * @param string $label The label of the block.
	 * @param string $package_path The path to the package.
	 */
	public function __construct( string $label, string $package_path ) {
		$this->block_label  = $label;
		$this->package_path = $package_path;
	}

	/**
	 * Gets a valid class name for the block.
	 *
	 * @throws \Exception If the block label is not set.
	 *
	 * @return string
	 */
	public function get_block_class_name(): string {
		// Convert to title case.
		$block_label = ucwords( $this->block_label );

		// Convert any spaces to dashes.
		$block_class_name = str_replace( ' ', '_', $block_label );

		// If it doesn't already end with _Block, add it.
		if ( ! str_ends_with( $block_class_name, '_Block' ) ) {
			$block_class_name .= '_Block';
		}

		// Run regex to strip anything out except for letters both upper and lowercase and dashes.
		return preg_replace( '/[^a-zA-Z0-9_]/', '', $block_class_name );
	}

	/**
	 * Gets a valid slug name for the block.
	 *
	 * @return string
	 */
	public function get_block_slug_name(): string {
		$block_class_name = $this->get_block_class_name();

		// Remove the _Block suffix.
		$block_class_name = str_replace( '_Block', '', $block_class_name );

		return strtolower( str_replace( '_', '-', $block_class_name ) );
	}

	/**
	 * Gets the name of the block folder.
	 *
	 * @return string
	 */
	public function get_block_folder_name(): string {
		return $this->get_block_slug_name();
	}

	/**
	 * Gets the path to the block folder.
	 *
	 * @return string
	 */
	public function get_block_folder_path(): string {
		// Apply a filter here to allow you to override the blocks path.
		$blocks_path = apply_filters( 'wordpress_blocks_new_block_path', $this->package_path );

		// Get the path to the block folder.
		return $blocks_path . '/' . $this->get_block_folder_name();
	}

	/**
	 * Gets the name of the theme.
	 *
	 * @return string
	 */
	public function get_package_name(): string {
		// TODO: Implement some logic to get the package name, either from a plugin or the theme.
		return basename( $this->get_block_folder_path() );
	}

	/**
	 * Gets the slug of the package.
	 *
	 * @return string
	 */
	public function get_package_slug(): string {
		return strtolower( str_replace( ' ', '-', $this->get_package_name() ) );
	}

	/**
	 * Gets the base class name for the block.
	 *
	 * @return string
	 */
	public function get_block_html_base_class(): string {
		return $this->get_block_slug_name();
	}

	/**
	 * Gets the default path to the block template.
	 *
	 * @return string
	 */
	public function get_block_template_path(): string {
		return "__DIR__ . '/templates/block.php'";
	}

	/**
	 * Gets the path to the stubs.
	 *
	 * @return string
	 */
	public function get_stubs_path(): string {
		return CREODE_BLOCKS_PLUGIN_FOLDER . 'includes/make-block/stubs';
	}

	/**
	 * Gets the relative path to the block class.
	 *
	 * @return string
	 */
	public function get_relative_block_class_path(): string {
		return '/' . $this->get_block_slug_name() . '/class-' . $this->get_block_class_file_name() . '.php';
	}

	/**
	 * Gets the path to the block class.
	 *
	 * @return string
	 */
	public function get_block_class_path(): string {
		return $this->get_block_folder_path() . '/class-' . $this->get_block_class_file_name() . '.php';
	}

	/**
	 * Gets the block class file name.
	 *
	 * @return string
	 */
	public function get_block_class_file_name(): string {
		$block_class_name = $this->get_block_class_name();

		// Convert to lowercase.
		$block_class_file_name = strtolower( str_replace( '_', '-', $block_class_name ) );

		return $block_class_file_name;
	}

	/**
	 * Determines the version of the block plugin.
	 *
	 * @return string
	 */
	public function get_block_plugin_version(): string {
		// Read it from the composer.lock file?
		$block_version = '1.0.0';
		if ( class_exists( '\Composer\InstalledVersions' ) ) {
			$block_version = \Composer\InstalledVersions::getPrettyVersion( 'creode/wordpress-blocks' );
		}

		return $block_version;
	}
}
