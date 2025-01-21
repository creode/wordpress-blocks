<?php
/**
 * Class responsible for loading blocks from the active theme.
 *
 * @package Creode Blocks
 */

namespace Creode_Blocks;

/**
 * Class responsible for loading blocks from the active theme.
 */
class Block_Loader {

	/**
	 * Singleton instance of this class.
	 *
	 * @var Block_Loader|null
	 */
	protected static $instance = null;

	/**
	 * Set singleton instance of this class.
	 */
	public static function init(): void {
		if ( static::$instance ) {
			return;
		}

		static::$instance = new static();
	}

	/**
	 * Process entry point.
	 */
	private function __construct() {
		add_action(
			'init',
			function () {
				if ( ! apply_filters( 'creode_blocks_auto_load_blocks', true ) ) {
					return;
				}

				$blocks_directories = $this->get_blocks_directories();
				$this->initialize_blocks( $blocks_directories );
			},
			5
		);
	}

	/**
	 * Returns an array of directory paths that contain block directories.
	 *
	 * @return array An array of directory paths.
	 */
	private function get_blocks_directories(): array {
		$directories = array(
			get_stylesheet_directory() . '/blocks',
		);

		$parent_theme_directory = get_template_directory() . '/blocks';
		if ( $directories[0] !== $parent_theme_directory ) {
			array_push( $directories, $parent_theme_directory );
		}

		return apply_filters( 'creode_blocks_block_directories', $directories );
	}

	/**
	 * Load and initialize blocks from an array of directory paths.
	 *
	 * @param string[] $blocks_directories An array of directory paths.
	 */
	private function initialize_blocks( array $blocks_directories ) {
		$block_classes = array();

		foreach ( $blocks_directories as $blocks_directory ) {
			foreach ( scandir( $blocks_directory ) as $block_directory ) {
				if ( str_contains( $block_directory, '.' ) ) {
					continue;
				}
				if ( ! is_dir( $blocks_directory . '/' . $block_directory ) ) {
					continue;
				}

				$block_path = $blocks_directory . '/' . $block_directory . '/class-' . $block_directory . '.php';

				if ( ! is_file( $block_path ) ) {
					continue;
				}

				$block_class = implode(
					'_',
					array_map(
						function ( string $word ) {
							return ucfirst( $word );
						},
						explode(
							'-',
							$block_directory
						)
					)
				);

				require_once $block_path;

				if ( ! class_exists( $block_class ) ) {
					continue;
				}

				array_push( $block_classes, $block_class );
			}
		}

		$block_classes = apply_filters( 'creode_blocks_auto_initialize_block_classes', $block_classes );

		usort(
			$block_classes,
			function ( string $class_1, string $class_2 ) {
				$class_1 = str_replace( '_Block', '', $class_1 );
				$class_2 = str_replace( '_Block', '', $class_2 );
				return strcmp( $class_1, $class_2 );
			}
		);

		$block_classes = apply_filters( 'creode_blocks_auto_initialize_block_classes_sorted', $block_classes );

		foreach ( $block_classes as $block_class ) {
			if ( ! apply_filters( 'creode_blocks_auto_initialize_' . strtolower( $block_class ), true ) ) {
				continue;
			}

			$block_class::init();
		}
	}
}
