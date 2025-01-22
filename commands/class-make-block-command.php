<?php
/**
 * Make Command class.
 *
 * @package Creode Blocks
 */

/**
 * Command in WP_CLI to make a new block.
 */
class Make_Block_Command {
	/**
	 * Creates a new block class within your theme.
	 *
	 * ## OPTIONS
	 *
	 * <name>
	 * : The name of the block to create e.g. "Creode Footer".
	 *
	 * [--theme=<active-theme>]
	 * : The slug of the theme to create the block in.
	 *
	 * ## EXAMPLES
	 *
	 * wp make-block "Creode Footer" --theme=creode
	 *
	 * @when after_wp_load
	 *
	 * @param array $args List of arguments.
	 * @param array $optional_args List of optional arguments.
	 */
	public function __invoke( $args, $optional_args ) {
		$theme = ! empty( $optional_args['theme'] ) ? $optional_args['theme'] : null;
		$theme_base_path = $this->get_theme_base_path( $theme );

		$block_label = $args[0];

		$block_class_name  = $this->generate_block_class_name( $block_label );
		$block_slug_name   = $this->generate_block_slug_name( $block_label );
		$block_folder_path = $this->create_block_folder_structure( $theme_base_path, $block_slug_name );
		$theme_slug        = $this->get_theme_slug( $theme );

		$this->make_block_class( $block_slug_name, $block_label, $block_class_name, $block_folder_path, $theme_slug );
		$this->make_block_template( $block_slug_name, $block_label, $block_class_name, $block_folder_path );
		$this->add_block_to_loader_file( $block_class_name, "/$block_slug_name/class-$block_slug_name.php", $theme );

		// Tell the user to require the block to the themes file and provide location.
		WP_CLI::success( 'Block created successfully.' );
	}

	/**
	 * Generates a valid class name for the block.
	 *
	 * @param string $block_label
	 *
	 * @return string
	 */
	protected function generate_block_class_name( $block_label ) {
		// Convert to title case.
		$block_label = ucwords( $block_label );

		// Convert any spaces to dashes.
		$block_class_name = str_replace( ' ', '_', $block_label );

		// Run regex to strip anything out except for letters both upper and lowercase and dashes.
		return preg_replace( '/[^a-zA-Z0-9_]/', '', $block_class_name ) . '_Block';
	}

	/**
	 * Generates block slug name based on it's class name.
	 *
	 * @param string $block_class_name
	 *
	 * @return string
	 */
	protected function generate_block_slug_name( $block_label ) {
		$block_class_name = $this->generate_block_class_name( $block_label );
		return strtolower( str_replace( '_', '-', $block_class_name ) );
	}

	/**
	 * Main functionality for creating and saving the block class.
	 *
	 * @param string $block_slug_name The slug of the block.
	 * @param string $block_label The label of the block.
	 * @param string $block_class_name The class name of the block.
	 * @param string $block_folder_path The path to the block folder.
	 * @param string $theme_slug The slug of the theme.
	 *
	 * @return void
	 */
	protected function make_block_class( $block_slug_name, $block_label, $block_class_name, $block_folder_path, $theme_slug ) {
		// Load the contents of the stub file.
		$block_class_stub = file_get_contents( CREODE_BLOCKS_PLUGIN_FOLDER . 'commands/stubs/class-block.php' );

		// Replace the placeholders in the stub file.
		$block_class_stub = $this->replace_stub_placeholders(
			$block_class_stub,
			array(
				':BLOCK_NAME'       => $block_slug_name,
				':BLOCK_LABEL'      => $block_label,
				':BLOCK_TEMPLATE'   => "__DIR__ . '/templates/block.php'",
				':BLOCK_CLASS_NAME' => $block_class_name,
				':THEME_SLUG'       => $theme_slug,
			)
		);

		// Setup block class filepath.
		$block_class_file_path = $block_folder_path . '/class-' . $block_slug_name . '.php';

		// Write the stub file to the block class file.
		file_put_contents( $block_class_file_path, $block_class_stub );
	}

	/**
	 * Takes an array of replacements and replaces them in the stub.
	 *
	 * @param string $stub The stub file contents.
	 * @param array  $replacements An array of placeholders and their replacements.
	 *
	 * @return string
	 */
	protected function replace_stub_placeholders( $stub, $replacements ) {
		foreach ( $replacements as $key => $value ) {
			$stub = str_replace( $key, $value, $stub );
		}

		return $stub;
	}

	/**
	 * Gets the theme slug.
	 *
	 * @param string $theme Optional slug of the theme.
	 *
	 * @return string
	 */
	private function get_theme_slug( ?string $theme ): string {
		$theme_slug = $theme;
		if ( is_null( $theme_slug ) ) {
			$theme_slug = get_stylesheet();
		}

		return $theme_slug;
	}

	/**
	 * Get the base path of the theme.
	 *
	 * @param string|null $theme Optional slug of the theme.
	 *
	 * @return string Path to theme.
	 */
	private function get_theme_base_path( ?string $theme = null ) {
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
	 * Creates block folder structure.
	 *
	 * @param string $theme_base_path Path to theme.
	 * @param string $block_folder_name Block folder name.
	 *
	 * @return string Path to folder where the block will go.
	 */
	private function create_block_folder_structure( string $theme_base_path, string $block_folder_name ) {
		// Create blocks folder.
		$blocks_folder = $theme_base_path . '/blocks';
		if ( ! file_exists( $blocks_folder ) ) {
			mkdir( $blocks_folder );
		}

		// Create block folder.
		$block_folder = $blocks_folder . '/' . $block_folder_name;
		if ( file_exists( $block_folder ) ) {
			WP_CLI::error( "Block \"$block_folder_name\" already exists." );
		}

		mkdir( $block_folder );

		// Create templates folder.
		$templates_folder = $block_folder . '/templates';
		if ( ! file_exists( $templates_folder ) ) {
			mkdir( $templates_folder );
		}

		return $block_folder;
	}

	/**
	 * Generates a basic block template file.
	 *
	 * @param string $block_slug_name The slug of the block.
	 * @param string $block_label The label of the block.
	 * @param string $block_class_name The class name of the block.
	 * @param string $block_folder_path The path to the block folder.
	 */
	private function make_block_template( string $block_slug_name, string $block_label, string $block_class_name, string $block_folder_path ) {
		$theme                 = wp_get_theme();
		$block_html_base_class = $block_slug_name;

		// Remove suffix from block base class.
		if ( '-block' === substr( $block_html_base_class, -6 ) ) {
			$block_html_base_class = substr( $block_html_base_class, 0, -6 );
		}

		// Load the content of the stub file.
		$content = file_get_contents( CREODE_BLOCKS_PLUGIN_FOLDER . 'commands/stubs/templates/block.php' );

		// Replace placeholders.
		$content = $this->replace_stub_placeholders(
			$content,
			array(
				':THEME_NAME'            => $theme->get( 'Name' ),
				':BLOCK_NAME'            => $block_slug_name,
				':BLOCK_LABEL'           => $block_label,
				':BLOCK_CLASS'           => $block_class_name,
				':BLOCK_HTML_BASE_CLASS' => $block_html_base_class,
			)
		);

		// Write the content to the template file.
		file_put_contents( $block_folder_path . '/templates/block.php', $content );
	}

	/**
	 * Adds code to load and initialize a block within the theme.
	 *
	 * @param string      $block_class_name The block class name.
	 * @param string      $block_class_path A relative path (from the blocks directory) to the block class file.
	 * @param string|null $theme Optional slug of the theme.
	 */
	private function add_block_to_loader_file( string $block_class_name, string $block_class_path, ?string $theme = null ) {
		$blocks_directory_path = $this->get_theme_base_path( $theme ) . '/blocks';

		if ( ! file_exists( $blocks_directory_path . '/all.php' ) ) {
			$theme             = wp_get_theme();
			$all_file_contents = file_get_contents( CREODE_BLOCKS_PLUGIN_FOLDER . 'commands/stubs/all.php' );

			$all_file_contents = $this->replace_stub_placeholders(
				$all_file_contents,
				array(
					':THEME_NAME' => $theme->get( 'Name' ),
				)
			);

			file_put_contents( $blocks_directory_path . '/all.php', $all_file_contents );
		}

		file_put_contents( $blocks_directory_path . '/all.php', PHP_EOL . 'require_once __DIR__ . \'' . $block_class_path . '\';', FILE_APPEND );
		file_put_contents( $blocks_directory_path . '/all.php', PHP_EOL . $block_class_name . '::init();', FILE_APPEND );
		file_put_contents( $blocks_directory_path . '/all.php', PHP_EOL, FILE_APPEND );
	}
}
