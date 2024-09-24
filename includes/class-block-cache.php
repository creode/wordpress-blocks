<?php

namespace Creode_Blocks;

class Block_Cache {
	/**
	 * Constructor for class.
	 */
	public function __construct() {
		$this->add_actions();
	}

	/**
	 * Clears block cache.
	 *
	 * @return void
	 */
	public function clear_block_cache(): void {
		self::clear();
	}

	/**
	 * Gets the block cache directory.
	 *
	 * @return string
	 */
	public static function get_directory(): string {
		return WP_CONTENT_DIR . '/cache/wp-blocks/';
	}

	/**
	 * Clears the block cache.
	 *
	 * @return void
	 */
	public static function clear(): void {
		// Clear the cache.
		require_once ABSPATH . 'wp-admin/includes/class-wp-filesystem-base.php';
		require_once ABSPATH . 'wp-admin/includes/class-wp-filesystem-direct.php';

		$file_system_direct = new \WP_Filesystem_Direct( false );
		$file_system_direct->rmdir( self::get_directory(), true );
	}

	/**
	 * Adds actions to class.
	 */
	protected function add_actions(): void {
		add_action( 'load-post.php', array( $this, 'clear_block_cache' ) );
		add_action( 'load-post-new.php', array( $this, 'clear_block_cache' ) );
		add_action( 'load-site-editor.php', array( $this, 'clear_block_cache' ) );
	}
}
