<?php
/**
 * Register admin scripts.
 *
 * @package Creode Blocks
 */

// Register admin scripts.
add_action(
	'admin_enqueue_scripts',
	function () {
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
