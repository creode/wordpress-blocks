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

require_once plugin_dir_path( __FILE__ ) . 'includes/helpers/all.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/class-helpers.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/traits/all.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/class-script.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/class-child-block.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/class-block.php';
require_once plugin_dir_path( __FILE__ ) . 'blocks/all.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/class-block-cache.php';

if ( defined( 'WP_CLI' ) && WP_CLI ) {
	// Actions.
	require_once plugin_dir_path( __FILE__ ) . 'includes/make-block/actions/class-create-new-block-files.php';
	require_once plugin_dir_path( __FILE__ ) . 'includes/make-block/actions/class-rename-files.php';
	require_once plugin_dir_path( __FILE__ ) . 'includes/make-block/actions/class-replace-file-contents.php';
	require_once plugin_dir_path( __FILE__ ) . 'includes/make-block/actions/class-setup-block-include.php';
	require_once plugin_dir_path( __FILE__ ) . 'includes/make-block/actions/class-add-scss-to-all-file.php';
	require_once plugin_dir_path( __FILE__ ) . 'includes/make-block/actions/class-recompile-assets.php';

	// Services.
	require_once plugin_dir_path( __FILE__ ) . 'includes/make-block/services/class-block-details.php';
	require_once plugin_dir_path( __FILE__ ) . 'includes/make-block/services/class-block-replacements.php';
	require_once plugin_dir_path( __FILE__ ) . 'includes/make-block/services/class-block-options.php';
	require_once plugin_dir_path( __FILE__ ) . 'includes/make-block/services/class-file.php';

	require_once plugin_dir_path( __FILE__ ) . 'includes/class-make-block.php';

	// Commands.
	require_once plugin_dir_path( __FILE__ ) . 'commands/class-make-block-command.php';

	WP_CLI::add_command( 'make-block', 'Make_Block_Command' );
}

new Creode_Blocks\Block_Cache();
