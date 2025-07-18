<?php

/**
 * Holds details about the block, like the name, slug, class name, path, etc.
 */
class Block_Details {
	/**
	 * The instance of the class.
	 *
	 * @var static
	 */
	private static $instance = null;

	/**
	 * The label of the block.
	 *
	 * @var string
	 */
	public $block_label;

	/**
	 * The slug of the theme.
	 *
	 * @var string|null
	 */
	public $block_theme_slug = null;

	/**
	 * Private constructor to prevent direct instantiation.
	 */
	private function __construct() {
		// Private constructor to prevent direct instantiation.
	}

	/**
	 * Get the instance of the class.
	 *
	 * @return Block_Details
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Gets a valid class name for the block.
	 *
	 * @throws Exception If the block label is not set.
	 *
	 * @return string
	 */
	public function get_block_class_name(): string {
		// Check the block label is valid.
		if ( empty( $this->block_label ) ) {
			throw new Exception( 'Block label is required.' );
		}

		// Convert to title case.
		$block_label = ucwords( $this->block_label );

		// Convert any spaces to dashes.
		$block_class_name = str_replace( ' ', '_', $block_label );

		// TODO: We might want to adjust this.

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
		// Get the path to the block folder.
		$blocks_path = $this->get_blocks_path();

		// Apply a filter here to allow you to override the blocks path.
		$blocks_path = apply_filters( 'wordpress_blocks_new_block_path', $blocks_path );

		// Get the path to the block folder.
		return $blocks_path . '/' . $this->get_block_folder_name();
	}

	/**
	 * Gets the path to the blocks folder.
	 *
	 * @return string
	 */
	public function get_blocks_path(): string {
		// Get the path to the theme.
		$theme_path = $this->get_theme_base_path( $this->block_theme_slug );

		// Get the path to the blocks folder.
		return $theme_path . '/' . $this->block_theme_slug . '/blocks';
	}

	/**
	 * Gets the name of the theme.
	 *
	 * @return string
	 */
	public function get_theme_name(): string {
		return wp_get_theme()->get( 'Name' );
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
	 * Gets the relative path to the block class.
	 *
	 * @return string
	 */
	public function get_relative_block_class_path(): string {
		return '/' . $this->get_block_slug_name() . '/class-' . $this->get_block_slug_name() . '.php';
	}

	/**
	 * Gets the path to the block class.
	 *
	 * @return string
	 */
	public function get_block_class_path(): string {
		return $this->get_block_folder_path() . '/class-' . $this->get_block_slug_name() . '.php';
	}

	/**
	 * Gets the base path of the theme.
	 *
	 * @param string|null $theme Optional slug of the theme.
	 *
	 * @return string Path to theme.
	 */
	protected function get_theme_base_path( ?string $theme = null ) {
		if ( is_null( $theme ) ) {
			$theme_base_path = get_stylesheet_directory();
		} else {
			$theme_base_path = get_theme_root() . '/' . $theme;
		}

		if ( ! file_exists( $theme_base_path ) ) {
			WP_CLI::error( 'Theme does not exist.' );
		}

		return $theme_base_path;
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
