<?php
/**
 * Make Command class.
 *
 * @package Creode Blocks
 */

/**
 * Command in WP_CLI to make a new block.
 */
class Make_Block_Command {
	/**
	 * Creates a new block class within your theme.
	 *
	 * ## OPTIONS
	 *
	 * <name>
	 * : The name of the block to create e.g. "Creode Footer".
	 *
	 * [--theme=<active-theme>]
	 * : The slug of the theme to create the block in.
	 *
	 * ## EXAMPLES
	 *
	 * wp make-block "Creode Footer" --theme=creode
	 *
	 * @when after_wp_load
	 *
	 * @param array $args List of arguments.
	 * @param array $optional_args List of optional arguments.
	 */
	public function __invoke( $args, $optional_args ) {
		// Set the block label.
		Block_Details::get_instance()->block_label = $args[0];

		// Set the theme slug.
		Block_Details::get_instance()->block_theme_slug = $optional_args['theme'] ?? null;

		try {
			// Create the block.
			Make_Block::run();
		} catch ( Exception $e ) {
			WP_CLI::error( $e->getMessage() );
		}

		WP_CLI::success( 'Block created successfully.' );
	}
}
