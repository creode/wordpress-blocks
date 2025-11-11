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
			'admin-block',
			plugin_dir_url( __FILE__ ) . 'admin-block.js',
			array( 'jquery' ),
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
