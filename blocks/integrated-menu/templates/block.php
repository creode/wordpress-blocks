<?php
/**
 * Integrated Menu block template file.
 *
 * @package Creode Blocks
 */

$block = Creode_Blocks\Helpers::get_block_by_name( 'integrated-menu' );

if ( ! $block ) {
	return;
}

$menu_location = get_field( 'menu_location' );

if ( empty( $menu_location ) ) {
	echo 'Please select a menu location.';

	return;
}

$block->render_menu_by_location( $menu_location );
