<?php
/**
 * Enqueue admin styles.
 *
 * @package Creode Blocks
 */

// Enqueue admin styles.
add_action(
	'enqueue_block_assets',
	function () {
		if ( ! is_admin() ) {
			return;
		}

		wp_enqueue_style( 'creode-blocks-admin-block-pattern-link', plugin_dir_url( __FILE__ ) . '/block-pattern-link.css', array(), '1' );
	}
);
