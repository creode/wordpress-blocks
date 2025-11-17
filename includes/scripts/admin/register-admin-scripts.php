<?php
/**
 * Register admin scripts.
 *
 * @package Creode Blocks
 */

// Register admin scripts.
add_action(
	'enqueue_block_assets',
	function () {
		if ( ! is_admin() ) {
			return;
		}

		// Ensure all default scripts are registered.
		$wp_scripts = new WP_Scripts();
		wp_default_scripts( $wp_scripts );
		wp_default_packages_vendor( $wp_scripts );
		wp_default_packages_scripts( $wp_scripts );

		// Register libraries.
		wp_register_script(
			'match-height',
			'https://cdnjs.cloudflare.com/ajax/libs/jquery.matchHeight/0.7.2/jquery.matchHeight-min.js',
			array( 'jquery' ),
			'0.7.2',
			true
		);

		// Register block scripts.
		wp_register_script(
			'admin-helpers',
			plugin_dir_url( __FILE__ ) . 'admin-helpers.js',
			array( 'jquery' ),
			'1.0.0',
			true
		);
		wp_register_script(
			'admin-block',
			plugin_dir_url( __FILE__ ) . 'admin-block.js',
			array( 'jquery', 'admin-helpers' ),
			'1.0.0',
			true
		);
		wp_register_script(
			'admin-block-initializer',
			plugin_dir_url( __FILE__ ) . 'admin-block-initializer.js',
			array( 'jquery' ),
			'1.0.0',
			true
		);
	}
);
