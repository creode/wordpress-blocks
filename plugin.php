<?php
/**
 * Creode Blocks MU plugin.
 *
 * @package Creode Blocks
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

define( 'CREODE_BLOCKS_PLUGIN_FOLDER', plugin_dir_path( __FILE__ ) );

require_once plugin_dir_path( __FILE__ ) . 'includes/class-helpers.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/traits/all.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/class-child-block.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/class-block.php';
require_once plugin_dir_path( __FILE__ ) . 'blocks/all.php';
require_once plugin_dir_path( __FILE__ ) . 'commands/class-make-block-command.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/class-block-cache.php';

if ( defined( 'WP_CLI' ) && WP_CLI ) {
	WP_CLI::add_command( 'make-block', 'Make_Block_Command' );
}

new Creode_Blocks\Block_Cache();
