<?php
/**
 * Abstract class to extend for each block.
 *
 * @package Creode Blocks
 */

namespace CreodeBlocks;

/**
 * Abstract class to extend for each block.
 */
abstract class Block {
	/**
	 * The blocks icon from https://developer.wordpress.org/resource/dashicons/
	 *
	 * @var string
	 */
	protected $icon = 'block-default';

	/**
	 * Determines if this block provides any context to children.
	 *
	 * @var boolean
	 */
	protected $provides_context = false;

	/**
	 * Function for fully registering the block and all associated functionality.
	 */
	public function __construct() {
		$this->register_acf_block();
		$this->register_acf_fields();

		foreach ( $this->child_blocks() as $child_block ) {
			$this->register_child_block( 'acf/' . $this->name(), $child_block, $this->name() );
		}
	}

	/**
	 * Function for providing the block's name.
	 *
	 * @return string The block's name (must be hyphen separated).
	 */
	abstract protected function name(): string;

	/**
	 * Function for providing the block's label to be used within the WordPress UI.
	 *
	 * @return string The block's label.
	 */
	abstract protected function label(): string;

	/**
	 * Function for providing fields array.
	 *
	 * @return array An array of field definitions in ACF format. Please see: https://www.advancedcustomfields.com/resources/register-fields-via-php/.
	 */
	abstract protected function fields(): array;

	/**
	 * Function for providing a path to the render template.
	 *
	 * @return string The path to the render template.
	 */
	abstract protected function template(): string;

	/**
	 * Function for providing the block's category.
	 *
	 * @return string The block's category.
	 */
	protected function category(): string {
		return 'common';
	}

	/**
	 * Function for providing the child blocks
	 *
	 * @return ChildBlock[] Array of child blocks.
	 */
	protected function child_blocks(): array {
		return array();
	}

	/**
	 * Provide additonal support options for the block.
	 *
	 * https://developer.wordpress.org/block-editor/getting-started/fundamentals/block-json/#using-block-supports-to-enable-settings-and-styles
	 *
	 * @return array
	 */
	protected function supports(): array {
		return array();
	}

	/**
	 * Provides the capability of defining a default style object.
	 *
	 * https://developer.wordpress.org/block-editor/reference-guides/block-api/block-supports/#color-background
	 *
	 * @return array
	 */
	protected function default_style(): array {
		return array();
	}

	/**
	 * Function to register the block with ACF.
	 */
	protected function register_acf_block(): void {
		$this->register_block_type(
			array(
				'name'       => 'acf/' . $this->name(),
				'title'      => $this->label(),
				'category'   => $this->category(),
				'icon'       => $this->icon,
				'render'     => $this->template(),
				'textdomain' => 'wordpress-blocks',
				'supports'   => $this->supports(),
				'providesContext' => $this->provides_context,
			)
		);
	}

	/**
	 * Registers the block type using the provided block data.
	 *
	 * @param array $block_data 
	 *
	 * @return void
	 */
	protected function register_block_type( array $block_data ): void {
		$wp_filesystem = $this->get_filesystem();
		if ( ! $wp_filesystem ) {
			throw new \Exception( 'Cannot cache block. Could not get filesystem.' );
		}

		$cache_folder = WP_CONTENT_DIR . '/cache/wp-blocks';
		$block_folder = $cache_folder . '/' . str_replace( '/', '-', $block_data['name'] );
		$cache_file   = $block_folder . '/block.json';

		// Check if the blocks cache folder exists.
		if ( $wp_filesystem->exists( $cache_file ) ) {
			register_block_type( $block_folder );
			return;
		}

		// Check if the cache root folder exists.
		if ( ! $wp_filesystem->exists( WP_CONTENT_DIR . '/cache' ) ) {
			$wp_filesystem->mkdir( WP_CONTENT_DIR . '/cache' );
		}

		// Create cache folder.
		if ( ! $wp_filesystem->exists( $cache_folder ) ) {
			$wp_filesystem->mkdir( $cache_folder );
		}

		// Create block folder.
		if ( ! $wp_filesystem->exists( $block_folder ) ) {
			$wp_filesystem->mkdir( $block_folder );
		}

		// Attach block schema to block data. NOTE: ACF Currently only supports version 2.
		$block_data['$schema']    = 'https://schemas.wp.org/trunk/block.json';
		$block_data['apiVersion'] = 2;

		// Setup ACF Configuration for block.
		$block_data['acf'] = array(
			'mode'           => 'preview',
			'renderTemplate' => $block_data['render'],
		);

		// Remove support functionality if it is empty.
		if ( empty( $block_data['supports'] ) ) {
			unset( $block_data['supports'] );
		}

		// Handle context.
		if ( ! empty( $block_data['usesContext'] ) && $block_data['usesContext'] ) {
			$block_data['usesContext'] = $block_data['usesContext'];
		} else {
			unset( $block_data['usesContext'] );
		}

		if ( ! empty( $block_data['providesContext'] ) && $block_data['providesContext'] ) {
			$block_data['providesContext'] = array( $block_data['name'] => 'data' );
		} else {
			unset( $block_data['providesContext'] );
		}

		// Ensure that the attribute array is availible.
		if ( ! isset( $block_data['attributes'] ) ) {
			$block_data['attributes'] = array();
		}

		// Add default style object.
		$default_style = $this->default_style();
		if ( ! empty( $default_style ) ) {
			if ( ! isset( $block_data['attributes']['style'] ) ) {
				$block_data['attributes']['style'] = array(
					'type' => 'object',
				);
			}

			$block_data['attributes']['style']['default'] = $default_style;
		}

		// Remove render key from block data as we no longer need it.
		unset( $block_data['render'] );

		// Save the block contents to cache file.
		$wp_filesystem->put_contents( $cache_file, wp_json_encode( $block_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES ) );

		register_block_type( $block_folder );
	}

	/**
	 * Function to register the block's fields with ACF.
	 */
	protected function register_acf_fields(): void {
		if ( ! function_exists( 'acf_add_local_field_group' ) ) {
			return;
		}

		acf_add_local_field_group(
			array(
				'key'      => 'group_' . $this->name() . '_block',
				'title'    => $this->label(),
				'fields'   => $this->fields(),
				'location' => array(
					array(
						array(
							'param'    => 'block',
							'operator' => '==',
							'value'    => 'acf/' . $this->name(),
						),
					),
				),
			)
		);
	}

	/**
	 * Function for fully registering child blocks.
	 *
	 * @param string     $parent_block The parent block name.
	 * @param ChildBlock $child_block The child block to register.
	 */
	protected function register_child_block( string $parent_block, ChildBlock $child_block ): void {
		if ( ! function_exists( 'acf_register_block_type' ) ) {
			return;
		}

		$this->register_block_type(
			array(
				'name'       => $parent_block . '-' . $child_block->name,
				'title'      => $child_block->label,
				'render'     => $child_block->template,
				'category'   => $this->category(),
				'icon'       => $child_block->icon,
				'parent'     => array(
					$parent_block,
				),
				'textdomain' => 'wordpress-blocks',
				'supports'   => $child_block->supports,
				'usesContext' => $this->provides_context ? array( $parent_block ) : false,
			)
		);

		// Register relationship so that it can be referenced in other functions.
		add_filter(
			'creode_blocks_parent_child_relationship',
			function ( array $blocks ) use ( $parent_block, $child_block ) {
				if ( empty( $blocks[ $parent_block ] ) ) {
					$blocks[ $parent_block ] = array();
				}
				array_push( $blocks[ $parent_block ], $parent_block . '-' . $child_block->name );

				return $blocks;
			}
		);

		// Register block fields.
		if ( function_exists( 'acf_add_local_field_group' ) ) {
			acf_add_local_field_group(
				array(
					'key'      => 'group_' . $parent_block . '-' . $child_block->name . '_block',
					'title'    => $child_block->label,
					'fields'   => $child_block->fields,
					'location' => array(
						array(
							array(
								'param'    => 'block',
								'operator' => '==',
								'value'    => $parent_block . '-' . $child_block->name,
							),
						),
					),
				)
			);
		}

		// Register grandchild blocks.
		foreach ( $child_block->child_blocks as $grand_child_block ) {
			$this->register_child_block(
				$parent_block . '-' . $child_block->name,
				$grand_child_block
			);
		}
	}

	/**
	 * Function for retrieving an array of child block names for a specified parent block.
	 * Useful when a parent block should not allow any nested blocks apart from their own child blocks.
	 * If this is the case, JSON encode the output this function and echo the result into the allowedBlocks attribute of the InnerBlocks element.
	 *
	 * @param string $parent_block_name The parent block name.
	 * @return array|null An array of child block names, null if parent or child blocks cannot be found.
	 */
	public static function get_child_block_names( $parent_block_name ) {
		$parent_child_relationship = apply_filters( 'creode_blocks_parent_child_relationship', array() );

		if ( empty( $parent_child_relationship[ $parent_block_name ] ) ) {
			return null;
		}

		return $parent_child_relationship[ $parent_block_name ];
	}

	/**
	 * Attempts to get the WordPress filesystem.
	 *
	 * @return \WP_Filesystem_Base The WordPress filesystem.
	 */
	private function get_filesystem() {
		global $wp_filesystem;

		// If the filesystem is already initialised, return it.
		if ( $wp_filesystem ) {
			return $wp_filesystem;
		}

		require_once ABSPATH . '/wp-admin/includes/file.php';

		// Check if credentials are needed.
		if ( ! WP_Filesystem() ) {
			return false;
		}
	
		return $wp_filesystem;
	}
}
