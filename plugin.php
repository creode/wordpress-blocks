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
require_once plugin_dir_path( __FILE__ ) . 'includes/class-block-cache.php';

if ( defined( 'WP_CLI' ) && WP_CLI ) {
	// Helpers.
	require_once plugin_dir_path( __FILE__ ) . 'commands/helpers/class-block-details.php';
	require_once plugin_dir_path( __FILE__ ) . 'commands/helpers/class-block-replacements.php';

	// Actions.
	require_once plugin_dir_path( __FILE__ ) . 'commands/actions/interface-runnable.php';
	require_once plugin_dir_path( __FILE__ ) . 'commands/actions/class-create-new-block-files.php';
	require_once plugin_dir_path( __FILE__ ) . 'commands/actions/class-rename-files.php';
	require_once plugin_dir_path( __FILE__ ) . 'commands/actions/class-replace-file-contents.php';
	require_once plugin_dir_path( __FILE__ ) . 'commands/actions/class-setup-block-include.php';
	require_once plugin_dir_path( __FILE__ ) . 'commands/actions/class-setup-scss-include.php';

	// Services.
	require_once plugin_dir_path( __FILE__ ) . 'commands/services/class-make-block.php';

	// Commands.
	require_once plugin_dir_path( __FILE__ ) . 'commands/class-make-block-command.php';

	WP_CLI::add_command( 'make-block', 'Make_Block_Command' );
}

new Creode_Blocks\Block_Cache();
